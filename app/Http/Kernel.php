<?php

protected $middleware = [
    // Outros middlewares globais
    \App\Http\Middleware\CheckAuthenticated::class,
];

protected $routeMiddleware = [
    // Outros middlewares
    'auth.check' => \App\Http\Middleware\CheckAuthenticated::class,
];