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

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Reports
    Route::get('/reports/bookings', [BookingReportController::class, 'index'])->name('reports.bookings');
    Route::get('/reports/customers', [BookingReportController::class, 'customers'])->name('reports.customers');
    // Customers + Sub Customers
    Route::resource('customers', App\Http\Controllers\CustomerController::class);
    Route::resource('customers.subcustomers', App\Http\Controllers\SubCustomerController::class);
    Route::resource('subcustomers', App\Http\Controllers\SubCustomerController::class);
    Route::get('subcustomers/{id}/edit', [SubCustomerController::class, 'edit'])->name('subcustomers.edit');
    Route::delete('customers/{customer}/subcustomers', [CustomerController::class, 'deleteSubCustomers'])->name('customers.subcustomers.delete');





    Route::get('/ajax/customers', [BookingController::class, 'ajaxCustomers'])->name('ajax.customers');
    Route::get('/ajax/trips', [BookingController::class, 'ajaxTrips'])->name('ajax.trips');

    Route::get('/api/customers/search', [App\Http\Controllers\CustomerController::class, 'search'])->name('customers.search');


    // Resource routes (CRUD)
    Route::resources([
        'hotels' => HotelController::class,
        'trips' => TripController::class,
        'customers' => CustomerController::class,
        'bookings' => BookingController::class,
        'boats' => BoatController::class,
        'drivers' => DriverController::class,
        'vehicles' => VehicleController::class,
        'diving-courses' => DivingCourseController::class,
        'guides' => GuideController::class,
        'transfercontracts' => TransferContractController::class,
        'agencies' => AgencyController::class,
    ]);
});





