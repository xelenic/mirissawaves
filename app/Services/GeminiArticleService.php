<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class GeminiArticleService
{
    public function isConfigured(): bool
    {
        return !empty(config('gemini.api_key'));
    }

    /**
     * @return array{
     *     title: string,
     *     excerpt: string,
     *     content: string,
     *     meta_title: string,
     *     meta_description: string,
     *     tags: string
     * }
     */
    public function generate(string $topic, ?string $categoryName = null, string $tone = 'informative'): array
    {
        $apiKey = config('gemini.api_key');
        if (!$apiKey) {
            throw new RuntimeException('Gemini API key is not configured. Add GEMINI_API_KEY to your .env file.');
        }

        $models = config('gemini.text_models', ['gemini-2.5-flash', 'gemini-2.0-flash', 'gemini-flash-latest']);
        $lastError = 'Unable to generate article.';

        foreach ($models as $model) {
            $response = Http::timeout((int) config('gemini.timeout', 120))
                ->withHeaders(['x-goog-api-key' => $apiKey])
                ->post(
                    "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent",
                    [
                        'contents' => [
                            [
                                'parts' => [
                                    ['text' => $this->buildPrompt($topic, $categoryName, $tone)],
                                ],
                            ],
                        ],
                        'generationConfig' => [
                            'temperature' => 0.75,
                            'maxOutputTokens' => 8192,
                            'responseMimeType' => 'application/json',
                            'responseSchema' => [
                                'type' => 'object',
                                'properties' => [
                                    'title' => ['type' => 'string'],
                                    'excerpt' => ['type' => 'string'],
                                    'content' => ['type' => 'string'],
                                    'meta_title' => ['type' => 'string'],
                                    'meta_description' => ['type' => 'string'],
                                    'tags' => [
                                        'type' => 'array',
                                        'items' => ['type' => 'string'],
                                    ],
                                ],
                                'required' => [
                                    'title',
                                    'excerpt',
                                    'content',
                                    'meta_title',
                                    'meta_description',
                                    'tags',
                                ],
                            ],
                        ],
                    ]
                );

            if ($response->successful()) {
                return $this->parseArticleResponse($response);
            }

            $lastError = $this->parseError($response);

            if (!in_array($response->status(), [404, 400, 403], true)) {
                break;
            }
        }

        throw new RuntimeException($lastError);
    }

    protected function buildPrompt(string $topic, ?string $categoryName, string $tone): string
    {
        $categoryLine = $categoryName
            ? "Blog category: {$categoryName}."
            : 'Choose an angle suitable for Sri Lanka travel tourism.';

        return <<<PROMPT
You are an expert travel writer for "Mirissawaves", a Sri Lanka tours and transfers company based in Mirissa.

Write a complete blog article about: {$topic}

{$categoryLine}
Tone: {$tone}.

Requirements:
- Audience: international travelers planning trips to Sri Lanka
- Mention Mirissa, wildlife, culture, beaches, or tours where natural
- content must be valid HTML only (use <p>, <h3>, <ul>, <li>, <strong> — no <html> or <body>)
- 4–6 sections with <h3> headings, 600–900 words total
- excerpt: max 160 characters, compelling summary
- meta_title: max 60 characters
- meta_description: max 155 characters
- tags: 4–6 lowercase keywords relevant to Sri Lanka travel

Return JSON matching the schema exactly.
PROMPT;
    }

    /**
     * @return array{
     *     title: string,
     *     excerpt: string,
     *     content: string,
     *     meta_title: string,
     *     meta_description: string,
     *     tags: string
     * }
     */
    protected function parseArticleResponse(Response $response): array
    {
        $text = $response->json('candidates.0.content.parts.0.text');

        if (!is_string($text) || trim($text) === '') {
            throw new RuntimeException('Gemini returned an empty response.');
        }

        $data = json_decode($text, true);

        if (!is_array($data)) {
            throw new RuntimeException('Failed to parse generated article JSON.');
        }

        foreach (['title', 'excerpt', 'content', 'meta_title', 'meta_description'] as $field) {
            if (empty($data[$field]) || !is_string($data[$field])) {
                throw new RuntimeException("Generated article is missing field: {$field}");
            }
        }

        $tags = $data['tags'] ?? [];
        if (is_string($tags)) {
            $tags = array_map('trim', explode(',', $tags));
        }
        if (!is_array($tags)) {
            $tags = [];
        }

        return [
            'title' => trim($data['title']),
            'excerpt' => trim($data['excerpt']),
            'content' => trim($data['content']),
            'meta_title' => trim($data['meta_title']),
            'meta_description' => trim($data['meta_description']),
            'tags' => implode(', ', array_filter(array_map('trim', $tags))),
        ];
    }

    protected function parseError(Response $response): string
    {
        $message = $response->json('error.message');

        if (is_string($message) && $message !== '') {
            return $message;
        }

        return 'Gemini API request failed (HTTP ' . $response->status() . ').';
    }
}
