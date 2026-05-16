<?php

namespace App\Services;

use App\Models\Media;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

class GeminiBannerService
{
    public function isConfigured(): bool
    {
        return !empty(config('gemini.api_key'));
    }

    /**
     * @return array{media_id: int, url: string, original_name: string}
     */
    public function generate(string $prompt, string $aspectRatio = '9:16'): array
    {
        $apiKey = config('gemini.api_key');
        if (!$apiKey) {
            throw new RuntimeException('Gemini API key is not configured. Add GEMINI_API_KEY to your .env file.');
        }

        $models = config('gemini.image_models', ['imagen-4.0-generate-001', 'imagen-4.0-fast-generate-001']);
        $fullPrompt = $this->buildPrompt($prompt);
        $lastError = 'Unable to generate image.';

        foreach ($models as $model) {
            $response = Http::timeout((int) config('gemini.timeout', 120))
                ->withHeaders(['x-goog-api-key' => $apiKey])
                ->post(
                    "https://generativelanguage.googleapis.com/v1beta/models/{$model}:predict",
                    [
                        'instances' => [
                            ['prompt' => $fullPrompt],
                        ],
                        'parameters' => [
                            'sampleCount' => 1,
                            'aspectRatio' => $aspectRatio,
                        ],
                    ]
                );

            if ($response->successful()) {
                return $this->storeFromResponse($response, $prompt);
            }

            $lastError = $this->parseError($response);

            if (!in_array($response->status(), [404, 400, 403], true)) {
                break;
            }
        }

        throw new RuntimeException($lastError);
    }

    protected function buildPrompt(string $userPrompt): string
    {
        return 'Professional travel promotional banner for a Sri Lanka tourism website. '
            . trim($userPrompt)
            . '. Photorealistic, vibrant, high-end marketing quality, suitable for a full-screen mobile popup. '
            . 'No borders, no frames, no logos, no text unless explicitly requested in the prompt.';
    }

    /**
     * @return array{media_id: int, url: string, original_name: string}
     */
    protected function storeFromResponse(Response $response, string $prompt): array
    {
        $predictions = $response->json('predictions');

        if (empty($predictions[0]['bytesBase64Encoded'])) {
            throw new RuntimeException('Gemini returned no image data.');
        }

        $bytes = base64_decode($predictions[0]['bytesBase64Encoded'], true);
        if ($bytes === false) {
            throw new RuntimeException('Failed to decode generated image.');
        }

        $mime = $predictions[0]['mimeType'] ?? 'image/png';
        $extension = str_contains($mime, 'jpeg') ? 'jpg' : 'png';

        return $this->storeAsMedia($bytes, $extension, $prompt);
    }

    /**
     * @return array{media_id: int, url: string, original_name: string}
     */
    protected function storeAsMedia(string $bytes, string $extension, string $prompt): array
    {
        $filename = Str::uuid() . '.' . $extension;
        $path = 'promo-banners/' . $filename;

        Storage::disk('public')->put($path, $bytes);

        $media = Media::create([
            'filename' => $filename,
            'original_name' => 'ai-promo-' . Str::slug(Str::limit($prompt, 36)) . '.' . $extension,
            'path' => $path,
            'mime_type' => $extension === 'jpg' ? 'image/jpeg' : 'image/png',
            'size' => strlen($bytes),
            'title' => Str::limit($prompt, 255),
            'alt_text' => 'AI generated promo banner',
            'folder' => 'promo-banners',
            'is_active' => true,
        ]);

        return [
            'media_id' => $media->id,
            'url' => $media->url,
            'original_name' => $media->original_name,
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
