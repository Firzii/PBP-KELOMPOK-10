// app/Http/Kernel.php
protected $routeMiddleware = [
    // ...
    'auth.session' => \App\Http\Middleware\SessionAuth::class,
];
