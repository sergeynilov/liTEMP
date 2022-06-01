<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LogoutResponse;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        //
    }


    public function render($request, Throwable $e)
    {
        $response = parent::render($request, $e);
        \Log::info(varDump($response->status(), ' -1 app/Exceptions/Handler.php $response->status()::'));
        if($response->status() == 500) {
//            \Log::info(varDump($response->getMessage(), ' -1 app/Exceptions/Handler.php $response->status()::'));
        }
        if ($response->status() === 419) {
            return app(LogoutResponse::class);
        }

        if ($response->status() === 401) {
            Auth::logout();
            return redirect('/login')
                ->with('status', 'You have no permission to enter this page');
        }

        return $response;
    }

}
