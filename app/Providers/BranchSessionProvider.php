<?php

namespace App\Providers;

use App\Models\Branches;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class BranchSessionProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $branchId = session('selected_branch_id');

            // Ambil data cabang berdasarkan session
            $selectedBranch = null;
            if ($branchId) {
                $selectedBranch = Branches::find($branchId);
            }

            // Ambil semua daftar cabang untuk modal pilihan
            $allBranches = Branches::all();

            // Lempar variabel ke SEMUA view
            $view->with([
                'currentBranch' => $selectedBranch,
                'allBranches' => $allBranches
            ]);
        });
    }
}
