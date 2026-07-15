<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
        Paginator::useBootstrapFive();

        try {
            $setting = Setting::first() ?? new Setting();
            View::share('setting', $setting);
        } catch (\Exception $e) {
            View::share('setting', new Setting());
        }

        \Illuminate\Support\Facades\Gate::define('manage-users', function ($user) {
            $position = $user->member?->position?->name;
            return $user->role === 'Admin' && in_array($position, ['Ketua', 'Ketua Umum']);
        });

        \Illuminate\Support\Facades\Gate::define('view-users', function ($user) {
            return in_array($user->role, ['Admin', 'Pengurus']);
        });

        \Illuminate\Support\Facades\Gate::define('view-settings', function ($user) {
            return true;
        });

        \Illuminate\Support\Facades\Gate::define('manage-settings', function ($user) {
            $position = $user->member?->position?->name;
            return $user->role === 'Admin' && in_array($position, ['Ketua', 'Ketua Umum']);
        });

        \Illuminate\Support\Facades\Gate::define('manage-finances', function ($user) {
            $position = $user->member?->position?->name;
            return $user->role === 'Admin' && in_array($position, ['Ketua', 'Bendahara']);
        });

        \Illuminate\Support\Facades\Gate::define('view-documents', function ($user) {
            // Pengurus (Admin, Pengurus) bisa melihat
            return in_array($user->role, ['Admin', 'Pengurus']);
        });

        \Illuminate\Support\Facades\Gate::define('manage-documents', function ($user) {
            // Hanya sekretaris yang bisa CRUD dokumen
            $position = $user->member?->position?->name ?? '';
            return str_contains(strtolower($position), 'sekretaris');
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
            return $user->role === 'Admin' && in_array($position, ['Ketua', 'Sekretaris', 'Koordinator Divisi', 'Ketua Umum', 'Sekretaris Umum']);
        });

        \Illuminate\Support\Facades\Gate::define('fill-attendance', function ($user) {
            return $user->role === 'Admin';
        });

        // ==========================================
        // MEMBERS
        // ==========================================
        \Illuminate\Support\Facades\Gate::define('view-members', function ($user) {
            // Semua pengguna boleh melihat data anggota
            return true;
        });

        \Illuminate\Support\Facades\Gate::define('create-members', function ($user) {
            $position = $user->member?->position?->name;
            return $user->role === 'Admin' && in_array($position, ['Ketua', 'Sekretaris']);
        });

        \Illuminate\Support\Facades\Gate::define('update-members', function ($user) {
            $position = $user->member?->position?->name;
            return $user->role === 'Admin' && in_array($position, ['Ketua', 'Sekretaris']);
        });

        \Illuminate\Support\Facades\Gate::define('delete-members', function ($user) {
            $position = $user->member?->position?->name;
            return $user->role === 'Admin' && in_array($position, ['Ketua', 'Sekretaris']);
        });

        // ==========================================
        // DIVISIONS
        // ==========================================
        \Illuminate\Support\Facades\Gate::define('view-divisions', function ($user) {
            // Admin dan Pengurus boleh melihat
            return in_array($user->role, ['Admin', 'Pengurus']);
        });

        \Illuminate\Support\Facades\Gate::define('create-divisions', function ($user) {
            $position = $user->member?->position?->name;
            return $user->role === 'Admin' && $position === 'Ketua';
        });

        \Illuminate\Support\Facades\Gate::define('update-divisions', function ($user) {
            $position = $user->member?->position?->name;
            return $user->role === 'Admin' && $position === 'Ketua';
        });

        \Illuminate\Support\Facades\Gate::define('delete-divisions', function ($user) {
            $position = $user->member?->position?->name;
            return $user->role === 'Admin' && $position === 'Ketua';
        });

        // ==========================================
        // POSITIONS
        // ==========================================
        \Illuminate\Support\Facades\Gate::define('view-positions', function ($user) {
            return in_array($user->role, ['Admin', 'Pengurus']);
        });

        \Illuminate\Support\Facades\Gate::define('create-positions', function ($user) {
            $position = $user->member?->position?->name;
            return $user->role === 'Admin' && $position === 'Ketua';
        });

        \Illuminate\Support\Facades\Gate::define('update-positions', function ($user) {
            $position = $user->member?->position?->name;
            return $user->role === 'Admin' && $position === 'Ketua';
        });

        \Illuminate\Support\Facades\Gate::define('delete-positions', function ($user) {
            $position = $user->member?->position?->name;
            return $user->role === 'Admin' && $position === 'Ketua';
        });
        // ==========================================
        // PROGRAMS
        // ==========================================
        \Illuminate\Support\Facades\Gate::define('view-programs', function ($user) {
            return in_array($user->role, ['Admin', 'Pengurus']);
        });

        \Illuminate\Support\Facades\Gate::define('create-programs', function ($user) {
            $position = $user->member?->position?->name;
            return $user->role === 'Admin' && in_array($position, ['Ketua', 'Sekretaris', 'Koordinator Divisi']);
        });

        \Illuminate\Support\Facades\Gate::define('update-programs', function ($user, $program) {
            $position = $user->member?->position?->name;
            if ($user->role === 'Admin' && in_array($position, ['Ketua', 'Sekretaris'])) {
                return true;
            }
            if ($user->role === 'Admin' && $position === 'Koordinator Divisi') {
                return $user->member?->division_id === $program->division_id;
            }
            return false;
        });

        \Illuminate\Support\Facades\Gate::define('delete-programs', function ($user, $program) {
            $position = $user->member?->position?->name;
            if ($user->role === 'Admin' && in_array($position, ['Ketua', 'Sekretaris'])) {
                return true;
            }
            if ($user->role === 'Admin' && $position === 'Koordinator Divisi') {
                return $user->member?->division_id === $program->division_id;
            }
            return false;
        });

        // ==========================================
        // ACTIVITIES & ATTENDANCES
        // ==========================================
        \Illuminate\Support\Facades\Gate::define('view-activities', function ($user) {
            return true; // Atau sesuaikan dengan role
        });
        \Illuminate\Support\Facades\Gate::define('view-attendances', function ($user) {
            return true;
        });

        // ==========================================
        // BUDGETS (ANGGARAN KEGIATAN)
        // ==========================================
        \Illuminate\Support\Facades\Gate::define('manage-budgets', function ($user) {
            // Hanya Bendahara Umum yang boleh mengubah/membuat RAB
            $position = $user->member?->position?->name;
            return $user->role === 'Admin' && in_array($position, ['Bendahara Umum', 'Bendahara']);
        });
        
        // ==========================================
        // DUES
        // ==========================================
        \Illuminate\Support\Facades\Gate::define('view-dues', function ($user) {
            // Ketua Umum, Sekretaris Umum, dan pengurus lainnya (Admin, Pengurus) boleh melihat
            return in_array($user->role, ['Admin', 'Pengurus']);
        });
        
        \Illuminate\Support\Facades\Gate::define('manage-dues', function ($user) {
            // Hanya Bendahara Umum yang boleh mengubah data
            $position = $user->member?->position?->name;
            return $user->role === 'Admin' && in_array($position, ['Bendahara Umum', 'Bendahara']);
        });
    }
}
