<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Wildcard permission override
        Gate::before(function ($user, $ability) {
            // Langsung izinkan jika user punya permission tersebut
            if ($user->can($ability)) {
                return true;
            }

            // Cek jika ability dalam format: 'kegiatan.edit' → coba cocokkan dengan 'manage kegiatans'
            if (Str::contains($ability, '.')) {
                [$entity] = explode('.', $ability);
                $managePermission = 'manage ' . Str::plural($entity);

                if ($user->can($managePermission)) {
                    return true;
                }
            }

            return null;
        });
    }
}
