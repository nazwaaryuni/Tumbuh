<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        try {
            $setting = Setting::first();
            View::share('setting', $setting);
        } catch (\Exception $e) {
            // database tidak ditemukan
        }

        \Illuminate\Support\Facades\Gate::define('manage-users', function ($user) {
            $position = $user->member?->position?->name;
            return $user->role === 'Admin' && $position === 'Ketua';
        });

        \Illuminate\Support\Facades\Gate::define('manage-settings', function ($user) {
            $position = $user->member?->position?->name;
            return $user->role === 'Admin' && $position === 'Ketua';
        });

        \Illuminate\Support\Facades\Gate::define('manage-finances', function ($user) {
            $position = $user->member?->position?->name;
            return $user->role === 'Admin' && in_array($position, ['Ketua', 'Bendahara']);
        });

        \Illuminate\Support\Facades\Gate::define('manage-documents', function ($user, $model = null) {
            $position = $user->member?->position?->name;
            if ($user->role === 'Admin' && in_array($position, ['Ketua', 'Sekretaris'])) return true;
            if ($user->role === 'Admin' && $position === 'Koordinator Divisi') {
                if ($model && isset($model->division_id)) {
                    return $user->member?->division_id == $model->division_id;
                }
                return true;
            }
            return false;
        });

        \Illuminate\Support\Facades\Gate::define('manage-programs-activities', function ($user, $model = null) {
            $position = $user->member?->position?->name;
            if ($user->role === 'Admin' && in_array($position, ['Ketua', 'Sekretaris'])) return true;
            if ($user->role === 'Admin' && $position === 'Koordinator Divisi') {
                if ($model) {
                    if (isset($model->division_id)) {
                        return $user->member?->division_id == $model->division_id;
                    }
                    if (isset($model->program->division_id)) {
                        return $user->member?->division_id == $model->program->division_id;
                    }
                }
                return true;
            }
            return false;
        });

        \Illuminate\Support\Facades\Gate::define('manage-achievements', function ($user) {
            $position = $user->member?->position?->name;
            return $user->role === 'Admin' && in_array($position, ['Ketua', 'Sekretaris', 'Koordinator Divisi']);
        });

        \Illuminate\Support\Facades\Gate::define('fill-attendance', function ($user) {
            $position = $user->member?->position?->name;
            return ($user->role === 'Admin' && in_array($position, ['Ketua', 'Sekretaris', 'Koordinator Divisi'])) || $user->role === 'Pengurus';
        });
    }
}
