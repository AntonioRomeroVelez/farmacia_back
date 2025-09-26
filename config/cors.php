<?php

return [

    'paths' => ['api/*'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['https://farmacio-front.vercel.app/'], // o tu dominio frontend
    'allowed_headers' => ['*'],
    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];
