<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/

$app = new Illuminate\Foundation\Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);

/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
|
| Next, we need to bind some important interfaces into the container so
| we will be able to resolve them when needed. The kernels serve the
| incoming requests to this application from both the web and CLI.
|
*/

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);


if ( ! defined("HTTP_RESPONSE_OK")) {
    define("HTTP_RESPONSE_OK", 200); // https://en.wikipedia.org/wiki/List_of_HTTP_status_codes
}
if ( ! defined("HTTP_RESPONSE_OK_RESOURCE_CREATED")) {
    define("HTTP_RESPONSE_OK_RESOURCE_CREATED", 201);
}
if ( ! defined("HTTP_RESPONSE_OK_RESOURCE_DELETED")) {
    define("HTTP_RESPONSE_OK_RESOURCE_DELETED", 204);
}
if ( ! defined("HTTP_RESPONSE_OK_RESOURCE_UPDATED")) {
    define("HTTP_RESPONSE_OK_RESOURCE_UPDATED", 205);
}
if ( ! defined("HTTP_RESPONSE_NOT_FOUND")) {
    define("HTTP_RESPONSE_NOT_FOUND", 404);
}
if ( ! defined("HTTP_RESPONSE_BAD_REQUEST")) {
    define("HTTP_RESPONSE_BAD_REQUEST", 400);
}
if ( ! defined("HTTP_RESPONSE_UNPROCESSABLE_ENTITY")) {
    define("HTTP_RESPONSE_UNPROCESSABLE_ENTITY", 422);
}
if ( ! defined("HTTP_RESPONSE_INTERNAL_SERVER_ERROR")) {
    define("HTTP_RESPONSE_INTERNAL_SERVER_ERROR", 500);
}
if ( ! defined("HTTP_RESPONSE_NOT_IMPLEMENTED")) {
    define("HTTP_RESPONSE_NOT_IMPLEMENTED", 501);
}

if ( ! defined("PERMISSION_APP_ADMIN")) {
    define("PERMISSION_APP_ADMIN", 'App admin');
}


if ( ! defined("PERMISSION_APP_MANAGER")) {
    define("PERMISSION_APP_MANAGER", 'App manager');
}


/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

return $app;
