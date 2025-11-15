<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TiketController;
use App\Http\Controllers\userController;
use App\Http\Controllers\CinemaController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\ScheduleController;

Route::get('/', [MovieController::class, 'home'])->name('home');

// Route::get('/schedules/detail', function () {
//     return view('schedule.detail');
// })->name('schedules.detail');

Route::get('/movies/active', [MovieController::class, 'homeMovies'])->name('home.movies.all');

Route::get('/schedule/detail/{movie_id}', [MovieController::class, 'movieSchedule'])->name('schedules.detail');

Route::middleware('isUser')->group(function(){    
    Route::get('/schedules/{scheduleId}/hours/{hourId}', [ScheduleController::class, 'showSeats'])->name('schedules.show-seats');

    Route::prefix('/tickets')->name('tickets.')->group(function() {
        Route::post('/', [TiketController::class, 'store'])->name('store');
        Route::get('/{ticketId}/order', [TiketController::class, 'orderPage'])->name('order');
        Route::post('/qrcode', [TiketController::class, 'createQrcode'])->name('qrcode');
        Route::get('/{ticketId}/payment', [TiketController::class, 'paymentPage'])->name('payment');
        Route::patch('/{ticketId}/payment/status', [TiketController::class, 'updateStatusPayment'])->name('payment.status');
        Route::get('/{ticketId}/payment/proof', [TiketController::class, 'proofPayment'])->name('paymentProof');
        Route::get('/{ticketId}/pdf', [TiketController::class, 'exportPdf'])->name('export_pdf');
    });
});
    
Route::get('/auth/logout', [userController::class, 'logout'])->name('logout');

// menu "bioskop" pada navbar user
Route::get('/cinemas/list', [CinemaController::class, 'cinemaList'])->name('cinemas.list');
Route::get('/cinemas/{cinema_id}/schedules', [CinemaController::class, 'cinemaSchedules'])->name('cinema.schedules');

// unntuk halaman yang hanya bisa diakses admin
Route::middleware('isAdmin')->prefix('/admin')->name('admin.')->group(function () {
    // tambahkan route yang hanya bisa diakses admin di sini
    // route untuk admin
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // bioskop
    Route::prefix('/cinemas')->name('cinemas.')->group(function () {
        Route::get('/index', [CinemaController::class, 'index'])->name('index');
        Route::get('/create', [CinemaController::class, 'create'])->name('create');
        Route::post('/store', [CinemaController::class, 'store'])->name('store');
        // parameter placeholder -> {id} : mencari data spesifik
        Route::get('/edit/{id}', [CinemaController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [CinemaController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [CinemaController::class, 'destroy'])->name('delete');
        Route::get('/trash', [CinemaController::class, 'trash'])->name('trash');
        Route::patch('/restore/{id}', [CinemaController::class, 'restore'])->name('restore');
        Route::delete('/delete-permanent/{id}', [CinemaController::class, 'deletePermanent'])->name('delete_permanent');
        Route::get('/export', [CinemaController::class, 'export'])->name('export');
    });

    // staff
    Route::prefix('/staffs')->name('staffs.')->group(function () {
        Route::get('/index', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        // parameter placeholder -> {id} : mencari data spesifik
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('delete');
        Route::get('/trash', [UserController::class, 'trash'])->name('trash');
        Route::patch('/restore/{id}', [UserController::class, 'restore'])->name('restore');
        Route::delete('/delete-permanent/{id}', [UserController::class, 'deletePermanent'])->name('delete_permanent');
        Route::get('/export', [UserController::class, 'export'])->name('export');
    });

    // film
    Route::prefix('/movies')->name('movies.')->group(function () {
        Route::get('/index', [MovieController::class, 'index'])->name('index');
        Route::get('/create', [MovieController::class, 'create'])->name('create');
        Route::post('/store', [MovieController::class, 'store'])->name('store');
        // parameter placeholder -> {id} : mencari data spesifik
        Route::get('/edit/{id}', [MovieController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [MovieController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [MovieController::class, 'destroy'])->name('delete');
        Route::get('/trash', [MovieController::class, 'trash'])->name('trash');
        Route::put('/deactivate/{id}', [MovieController::class, 'deactivate'])->name('deactivate');
        Route::put('/activate/{id}', [MovieController::class, 'activate'])->name('activate');
        Route::patch('/restore/{id}', [MovieController::class, 'restore'])->name('restore');
        Route::delete('/delete-permanent/{id}', [MovieController::class, 'deletePermanent'])->name('delete_permanent');
        Route::get('/export', [MovieController::class, 'export'])->name('export');
        Route::get('/datatables', [MovieController::class, 'datatables'])->name('datatables');
    });
});

Route::middleware('isGuest')->group(function () {
    // hanya user yang belum login (guest) bisa akses signup & login
    Route::get('/auth/login', function () {
        return view('auth.login');
    })->name('login');

    Route::get('/auth/signup', function () {
        return view('auth.signup');
    })->name('signup');

    Route::post('/auth/signup', [userController::class, 'register'])->name('signup.send_data');
    Route::post('/auth/login', [userController::class, 'authentication'])->name('auth');
});

Route::middleware('isStaff')->prefix('/staff')->name('staff.')->group(function () {
    // tambahkan route yang hanya bisa diakses staff di sini
    // route untuk staff
    Route::get('/dashboard', function () {
        return view('staff.dashboard');
    })->name('dashboard');

    // promo
    Route::prefix('/promos')->name('promos.')->group(function () {
        Route::get('/index', [PromoController::class, 'index'])->name('index');
        Route::get('/create', [PromoController::class, 'create'])->name('create');
        Route::post('/store', [PromoController::class, 'store'])->name('store');
        // parameter placeholder -> {id} : mencari data spesifik
        Route::get('/edit/{id}', [PromoController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [PromoController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [PromoController::class, 'destroy'])->name('delete');
        Route::get('/trash', [PromoController::class, 'trash'])->name('trash');
        Route::patch('/restore/{id}', [PromoController::class, 'restore'])->name('restore');
        Route::delete('/delete-permanent/{id}', [PromoController::class, 'deletePermanent'])->name('delete_permanent');
        Route::get('/export', [PromoController::class, 'export'])->name('export');
    });

    // jadwal tayang 
    Route::prefix('/schedules')->name('schedules.')->group(function () {
        Route::get('/', [ScheduleController::class, 'index'])->name('index');
        Route::post('/store', [ScheduleController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [ScheduleController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [ScheduleController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [ScheduleController::class, 'destroy'])->name('delete');
        Route::get('/trash', [ScheduleController::class, 'trash'])->name('trash');
        Route::patch('/restore/{id}', [ScheduleController::class, 'restore'])->name('restore');
        Route::delete('/delete-permanent/{id}', [ScheduleController::class, 'deletePermanent'])->name('delete_permanent');
        Route::get('/export', [ScheduleController::class, 'export'])->name('export');
    });
});
