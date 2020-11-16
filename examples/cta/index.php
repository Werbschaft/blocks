<?php

Kirby::plugin('getkirby/cta-block', [
    'snippets' => [
        'blocks/cta' => __DIR__ . '/snippet.php',
    ],
    'blueprints' => [
        'blocks/cta' => __DIR__ . '/blueprint.yaml'
    ]
]);
