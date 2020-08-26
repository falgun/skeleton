<?php
return [
    'web' => [
        \Falgun\Middlewares\StartSessionMiddleware::class,
        \Falgun\Middlewares\CheckCsrfTokenMiddleware::class,
    ]
];
