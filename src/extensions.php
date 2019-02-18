<?php
return [
    'middlewares' => [
        'web' => [
            Falgun\Http\MiddleWare\Session::class,
            Falgun\Http\MiddleWare\CleanPost::class,
            Falgun\Http\MiddleWare\CSRF::class
        ]
    ]
];
