<?php

use App\Http\Controllers\API\SchoolController;
use App\Http\Middleware\VerifySetupToken;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/sekolah/excel', [SchoolController::class, 'excel']);

Route::group(['middleware' => [VerifySetupToken::class]], function () {
    Route::get('/migrate', function () {
        try {
            Artisan::call('migrate:fresh', [
                '--force' => true, // Required to run migrations in a non-interactive environment
                '--seed' => true,  // Adds the seed option to run database seeding after migrations
            ]);

            return 'Migrations and seeding have been run successfully.';
        } catch (\Exception $e) {
            throw $e;
        }
    });
    Route::get('/setup', function () {
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('clear-compiled');
        Artisan::call('optimize');

        Artisan::call('route:cache');
        Artisan::call('view:cache');
        Artisan::call('config:cache');

    });
    Route::get('/link', function () {
        Artisan::call('storage:link');

        return 'Fresh migrations, seeding, and storage linking to public_html have been run successfully.';
    });
});
Route::get('/cekext', function () {
    $extensions = get_loaded_extensions();

    // Output the extensions as a simple list
    foreach ($extensions as $extension) {
        echo $extension.'<br>';
    }
});
Route::get('/sekolah/excel', [SchoolController::class, 'excel']);

Route::get('/{any}', function () {
    if (request()->is('api/*')) {
        abort(404); // Return a 404 for API routes
    }

    return view('welcome');
})->where('any', '.*');
