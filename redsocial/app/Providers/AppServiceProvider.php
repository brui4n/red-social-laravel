<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    //Se modifico el boot para que no aparesca mensaje de forma insegura al enviar algun formulario
    public function boot()
    {
        if (env('APP_ENV') === 'production') {
            Request::setTrustedProxies(
                [request()->getClientIp()],
                SymfonyRequest::HEADER_X_FORWARDED_FOR |
                SymfonyRequest::HEADER_X_FORWARDED_HOST |
                SymfonyRequest::HEADER_X_FORWARDED_PROTO
            );

            URL::forceScheme('https');
        }
    }
}
