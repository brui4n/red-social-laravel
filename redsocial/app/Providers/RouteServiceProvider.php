<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Broadcast;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Este middleware es el correcto
        Broadcast::routes([
            'middleware' => ['web', 'auth'],
        ]);
    }
}
