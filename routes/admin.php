<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CmsController;
use App\Http\Controllers\Admin\CommissionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmailTemplateController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PaymentSettingsController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/get-countries', [LocationController::class, 'getCountries'])->name('get-countries');
Route::get('/get-states', [LocationController::class, 'getStates'])->name('get-states');
Route::get('/get-cities', [LocationController::class, 'getCities'])->name('get-cities');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    // User Management
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->middleware(['permission:user-view'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->middleware(['permission:user-add'])->name('create');
        Route::any('/store', [UserController::class, 'store'])->middleware(['permission:user-add'])->name('store');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->middleware(['permission:user-edit'])->name('edit');
        Route::put('/{id}', [UserController::class, 'update'])->middleware(['permission:user-edit'])->name('update');
        Route::get('/{id}/delete', [UserController::class, 'destroy'])->middleware(['permission:user-delete'])->name('destroy');
        Route::get('/{id}/show', [UserController::class, 'show'])->middleware(['permission:user-view'])->name('show');
        Route::get('/{id}/suspend', [UserController::class, 'suspend'])->middleware(['permission:user-edit'])->name('suspend');
        Route::get('/apply', [UserController::class, 'applyUser'])->middleware(['permission:user-edit', 'permission:user-delete'])->name('apply');
        Route::get('/download-csv', [UserController::class, 'downloadCSV'])->middleware(['permission:user-edit', 'permission:user-delete'])->name('download-csv');
        Route::post('/share-csv', [UserController::class, 'shareCsv'])->middleware(['permission:user-edit', 'permission:user-delete'])->name('share-csv');
        Route::get('/activity', [UserController::class, 'userActivity'])->middleware(['permission:user-activity-view'])->name('activity');
    });

    // Sub-admin Management
    Route::get('/sub-admin', [UserController::class, 'subAdmin'])->middleware(['permission:subadmin-view'])->name('subadmin.index');

    // MANAGE PROFILE
    Route::get('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'showProfile'])->name('main.profile');
    Route::post('/update', [\App\Http\Controllers\Admin\ProfileController::class, 'updateProfile'])->name('update-profile');
    Route::get('/change-password', [\App\Http\Controllers\Admin\ProfileController::class, 'showChangePasswordForm'])->name('change-password');
    Route::post('/update-password', [\App\Http\Controllers\Admin\ProfileController::class, 'changePassword'])->name('update-password');

    // Category Management
    Route::prefix('category')->name('category.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->middleware(['permission:category-view'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->middleware(['permission:category-add'])->name('create');
        Route::any('/store', [CategoryController::class, 'store'])->middleware(['permission:category-add'])->name('store');
        Route::get('/{id}/edit', [CategoryController::class, 'edit'])->middleware(['permission:category-edit'])->name('edit');
        Route::put('/{id}', [CategoryController::class, 'update'])->middleware(['permission:category-edit'])->name('update');
        Route::get('/{id}/delete', [CategoryController::class, 'destroy'])->middleware(['permission:category-delete'])->name('destroy');
        Route::get('/apply', [CategoryController::class, 'applyCategory'])->middleware(['permission:category-edit', 'permission:category-delete'])->name('apply');
    });

    // CMS Page Management
    Route::prefix('cms')->name('cms.')->group(function () {
        Route::get('/', [CmsController::class, 'index'])->middleware(['permission:cms-view'])->name('index');
        Route::get('/{slug}/edit', [CmsController::class, 'edit'])->middleware(['permission:cms-edit'])->name('edit');
        Route::post('/{page}', [CMSController::class, 'update'])->middleware(['permission:cms-edit'])->name('update');
    });

    // Role Management
    Route::prefix('roles')->name('role.')->group(function () {
        Route::get('/', [RolePermissionController::class, 'roleIndex'])->middleware(['permission:role-view'])->name('index');
        Route::get('/create/{role?}', [RolePermissionController::class, 'createOrUpdate'])->middleware(['permission:role-add', 'permission:role-edit'])->name('createOrUpdate');
        Route::post('/store/{role?}', [RolePermissionController::class, 'storeRole'])->middleware(['permission:role-add', 'permission:role-edit'])->name('store');
        Route::get('/{role}', [RolePermissionController::class, 'destroy'])->middleware(['permission:role-delete'])->name('destroy');
    });

    // Commission Management
    Route::prefix('commissions')->name('commission.')->group(function () {
        Route::get('/', [CommissionController::class, 'listCommissions'])->middleware(['permission:commission-view'])->name('index');
        Route::get('/{commission}/edit', [CommissionController::class, 'showEditForm'])->middleware(['permission:commission-edit'])->name('edit');
        Route::post('/{commission}', [CommissionController::class, 'updateCommission'])->middleware(['permission:commission-edit'])->name('update');
    });

    // Plan Management
    Route::prefix('plans')->name('plan.')->group(function () {
        Route::get('/', [PlanController::class, 'listPlans'])->middleware(['permission:plan-view'])->name('index');
        Route::get('/create', [PlanController::class, 'showPlanForm'])->middleware(['permission:plan-edit'])->name('create');
        Route::get('/{plan}/edit', [PlanController::class, 'showPlanForm'])->middleware(['permission:plan-edit'])->name('edit');
        Route::post('/{plan?}', [PlanController::class, 'savePlan'])->middleware(['permission:plan-edit'])->name('save');
        Route::delete('/{plan}', [PlanController::class, 'deletePlan'])->middleware(['permission:plan-edit'])->name('destroy');
        Route::post('/status/{plan}', [PlanController::class, 'togglePlanStatus'])->middleware(['permission:plan-edit'])->name('status');
        Route::get('/apply', [PlanController::class, 'changeStatus'])->middleware(['permission:plan-edit'])->name('apply');
    });

    // Payment Settings
    Route::prefix('payment-settings')->name('payment-settings.')->group(function () {
        Route::get('/', [PaymentSettingsController::class, 'index'])->name('index');
        Route::get('/create', [PaymentSettingsController::class, 'create'])->name('create');
        Route::post('/store', [PaymentSettingsController::class, 'store'])->name('store');
        Route::get('/{setting}/edit/{type}', [PaymentSettingsController::class, 'edit'])->name('edit');
        Route::put('/update/{setting}', [PaymentSettingsController::class, 'update'])->name('update');
        Route::get('/{id}/delete', [PaymentSettingsController::class, 'destroy'])->name('destroy');
        Route::post('/stripe-keys', [PaymentSettingsController::class, 'checkStripeDetails'])->name('check-stripe-details');
        Route::post('/paypal-keys', [PaymentSettingsController::class, 'checkPaypalDetails'])->name('check-paypal-details');
        Route::post('/update-status', [PaymentSettingsController::class, 'updateStatus'])->name('update-status');
    });

    // Settings
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::prefix('thumbnail-size')->name('thumbnail.')->controller(SettingsController::class)->group(function () {
            Route::get('/', 'indexThumbnailSize')->name('index');
            Route::get('/create', 'createThumbnailSize')->name('create');
            Route::post('/store', 'storeThumbnailSize')->name('store');
            Route::get('/edit/{index}', 'editThumbnailSize')->name('edit');
            Route::post('/update/{index}', 'updateThumbnailSize')->name('update');
            Route::get('/delete/{index}', 'deleteThumbnailSize')->name('delete');
        });

        // Route::get('/image-conversion', [SettingsController::class, 'indexImageConversion'])->name('image-conversion.index');
        // Route::post('/image-conversion/store', [SettingsController::class, 'storeImageConversion'])->name('image-conversion.store');
        Route::post('/image-conversion/update', [SettingsController::class, 'updateImageConversion'])->name('image-conversion.update');

        // Route::get('/webp-quality', [SettingsController::class, 'indexWebpQuality'])->name('webp-quality.index');
        // Route::post('/webp-quality/store', [SettingsController::class, 'storeWebpQuality'])->name('webp-quality.store');
        Route::post('/webp-quality/update', [SettingsController::class, 'updateWebpQuality'])->name('webp-quality.update');

        Route::get('/website', [SettingsController::class, 'indexWebsiteSettings'])->name('website.index');
        Route::post('/website/store', [SettingsController::class, 'storeWebsiteSettings'])->name('website.store');
        Route::get('/two-factor-create', [SettingsController::class, 'twoFactorCreate'])->name('two-factor-create');
        Route::post('/two-factor-enabled', [SettingsController::class, 'twoFactorEnabled'])->name('two-factor-enabled');

        Route::get('/smtp-details', [SettingsController::class, 'indexSmtpDetails'])->name('smpt_details.index');
        Route::post('/smtp-details/store', [SettingsController::class, 'storeSmtpDetails'])->name('smpt_details.store');
    });

    Route::prefix('email-templates')->name('email-templates.')->group(function () {
        Route::get('/', [EmailTemplateController::class, 'index'])->name('index');
        Route::get('/create', [EmailTemplateController::class, 'create'])->name('create');
        Route::post('/', [EmailTemplateController::class, 'store'])->name('store');
        Route::get('/{emailTemplate}/edit', [EmailTemplateController::class, 'edit'])->name('edit');
        Route::put('/{emailTemplate}', [EmailTemplateController::class, 'update'])->name('update');
        Route::get('/{emailTemplate}', [EmailTemplateController::class, 'destroy'])->name('destroy');
        Route::get('/apply', [EmailTemplateController::class, 'applyEmailTemplate'])->name('apply');
    });

    // Store Management
    Route::prefix('stores')->name('store.')->group(function(){
        Route::get('/', [\App\Http\Controllers\Admin\StoreController::class, 'index'])->middleware(['permission:store-view'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Admin\StoreController::class, 'create'])->middleware(['permission:store-add'])->name('create');
        Route::post('/store', [\App\Http\Controllers\Admin\StoreController::class, 'store'])->middleware(['permission:store-add'])->name('store');
        Route::get('/{store}/edit', [\App\Http\Controllers\Admin\StoreController::class, 'edit'])->middleware(['permission:store-edit'])->name('edit');
        Route::put('/{store}', [\App\Http\Controllers\Admin\StoreController::class, 'update'])->middleware(['permission:store-edit'])->name('update');
        Route::get('/{store}/delete', [\App\Http\Controllers\Admin\StoreController::class, 'destroy'])->middleware(['permission:store-delete'])->name('destroy');
    });
    
});



require __DIR__ . '/auth.php';
