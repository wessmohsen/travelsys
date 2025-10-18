<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookingReportController;
use App\Http\Controllers\BoatController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\DivingCourseController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\TransferContractController;
use App\Http\Controllers\AgencyController;
use App\Http\Controllers\TripProgramController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {

    // Dashboard - accessible by all authenticated users
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile - accessible by all authenticated users
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');

    // User Management - Admin and Manager only
    Route::middleware(['role:admin,manager'])->group(function () {
        Route::resource('users', UserController::class);
    });

    // Role Management - Admin only
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);
    });

    // Reports - accessible by Admin, Manager, and Operation Manager
    Route::middleware(['role:admin,manager,operation-manager'])->group(function () {
        Route::get('/reports/bookings', [BookingReportController::class, 'index'])->name('reports.bookings');
        Route::get('/reports/customers', [BookingReportController::class, 'customers'])->name('reports.customers');
    });

    // Customers - Admin and Manager only
    Route::middleware(['role:admin,manager'])->group(function () {
        Route::resource('customers', App\Http\Controllers\CustomerController::class);
        Route::resource('customers.subcustomers', App\Http\Controllers\SubCustomerController::class);
        Route::resource('subcustomers', App\Http\Controllers\SubCustomerController::class);
        Route::delete('customers/{customer}/subcustomers', [CustomerController::class, 'deleteSubCustomers'])->name('customers.subcustomers.delete');
        Route::get('/api/customers/search', [App\Http\Controllers\CustomerController::class, 'search'])->name('customers.search');

        // AJAX routes
        Route::get('/ajax/customers', [BookingController::class, 'ajaxCustomers'])->name('ajax.customers');
        Route::get('/ajax/trips', [BookingController::class, 'ajaxTrips'])->name('ajax.trips');

        // Bookings
        Route::resource('bookings', BookingController::class);
    });

    // Trip Programs - Admin, Manager, and Operation Manager only
    Route::middleware(['role:admin,manager,operation-manager'])->group(function () {
        Route::resource('trip-programs', TripProgramController::class);
        Route::delete('trip-programs/families/{family}', [TripProgramController::class, 'destroyFamily'])
            ->name('trip-programs.families.destroy');
        Route::delete('program-families/{id}/delete', [TripProgramController::class, 'destroyFamily'])->name('program-families.destroy');
        Route::delete('trip-programs/{program}/families/{family}', [TripProgramController::class, 'deleteFamily'])->name('trip-programs.families.delete');
        Route::delete('trip-programs/delete-family/{id}', [TripProgramController::class, 'deleteProgramFamily'])->name('trip-programs.delete-family');
        Route::post('ajax/delete-family/{id}', [TripProgramController::class, 'ajaxDeleteFamily'])->name('ajax.delete-family');
        Route::delete('ajax/program-family/{family}', [TripProgramController::class, 'ajaxDeleteProgramFamily'])->name('ajax.program-family.delete');
        Route::delete('program-families/{id}', [TripProgramController::class, 'deleteProgramFamily'])->name('program-families.delete');
        Route::post('delete-program-family/{id}', [TripProgramController::class, 'deleteProgramFamily'])
            ->name('delete-program-family');
    });

    // Master Data Management - Admin and Manager only (NOT Operation Manager)
    Route::middleware(['role:admin,manager'])->group(function () {
        Route::resource('hotels', HotelController::class);
        Route::resource('trips', TripController::class);
        Route::resource('boats', BoatController::class);
        Route::resource('drivers', DriverController::class);
        Route::resource('vehicles', VehicleController::class);
        Route::resource('diving-courses', DivingCourseController::class);
        Route::resource('guides', GuideController::class);
        Route::resource('transfercontracts', TransferContractController::class);
        Route::resource('agencies', AgencyController::class);
    });
});





