<?php

return [

    'api_key' => env('GEMINI_API_KEY'),

    /*
    | Imagen models (Gemini API). First model is tried, then fallbacks.
    */
    'image_models' => array_filter(array_map('trim', explode(',', env('GEMINI_IMAGE_MODELS', 'imagen-4.0-generate-001,imagen-4.0-fast-generate-001')))),

    'text_models' => array_filter(array_map('trim', explode(',', env('GEMINI_TEXT_MODELS', 'gemini-2.5-flash,gemini-2.0-flash,gemini-flash-latest')))),

    'timeout' => (int) env('GEMINI_TIMEOUT', 120),

];
