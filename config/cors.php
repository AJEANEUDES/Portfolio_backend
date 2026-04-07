<?php

return [
    'paths' => ['api/*'],
    'allowed_methods' => ['GET', 'POST', 'OPTIONS'],
    'allowed_origins' => [
        'http://localhost:3000',        // Next.js en développement
        // Ajouter ton domaine production ici plus tard
        // 'https://tondomaine.com',
    ],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['Content-Type', 'Accept', 'Accept-Language', 'Authorization', 'X-Requested-With'],
    'exposed_headers' => [],
    'max_age' => 86400,                 // 24h de cache preflight
    'supports_credentials' => false,
];