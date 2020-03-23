<?php

use Mezzio\Router\RouterInterface;
use Mezzio\Router\ZendRouter;

return [
    'dependencies' => [
        'invokables' => [
            RouterInterface::class => ZendRouter::class,
        ],
    ],
];
