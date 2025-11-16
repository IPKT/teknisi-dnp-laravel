<?php

namespace App\Providers;
use Carbon\Carbon;


use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\View;
use App\Models\Peralatan;


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
        Carbon::setLocale('id');
        $jenisAloptamaMenu = Peralatan::where('kelompok', 'aloptama')->select('jenis')->distinct()->orderBy('jenis')->get();
        $jenisNonAloptamaMenu = Peralatan::where('kelompok', 'non-aloptama')->select('jenis')->distinct()->orderBy('jenis')->get();
        View::share('jenisAloptamaMenu', $jenisAloptamaMenu);
        View::share('jenisNonAloptamaMenu', $jenisNonAloptamaMenu);

    }
}