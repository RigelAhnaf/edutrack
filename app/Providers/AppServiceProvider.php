<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    // Ubah ini:
    public const HOME = '/dashboard';  // Ganti dari '/home' ke '/dashboard'

    // ... rest of the code
}