<?php

use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\ChildController as AdminChildController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\HospitalController;
use App\Http\Controllers\Admin\ParentRequestController;
use App\Http\Controllers\Admin\VaccinationDateController as AdminVaccinationDateController;
use App\Http\Controllers\Admin\VaccinationReportController as AdminVaccinationReportController;
use App\Http\Controllers\Admin\VaccineController;
use App\Http\Controllers\Hospital\AppointmentController;
use App\Http\Controllers\Hospital\DashboardController as HospitalDashboardController;
use App\Http\Controllers\Parent\ChildController as ParentChildController;
use App\Http\Controllers\Parent\DashboardController as ParentDashboardController;
use App\Http\Controllers\Parent\HospitalBookingController;
use App\Http\Controllers\Parent\VaccinationDateController as ParentVaccinationDateController;
use App\Http\Controllers\Parent\VaccinationReportController as ParentVaccinationReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Hospital\DrController;
use App\Http\Controllers\landingController;
// use App\Http\Controllers\Hospital\HistoryController;
use App\Http\Controllers\Parent\appoinmentController;
use Illuminate\Support\Facades\Route;
Route::get('/', [landingController::class, 'index']);

Route::prefix('admin')->middleware(['auth', 'role.admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/children', [AdminChildController::class, 'index'])->name('children.index');
    Route::get('/children/{child}', [AdminChildController::class, 'show'])->name('children.show');
    Route::get('/vaccination-dates', [AdminVaccinationDateController::class, 'index'])->name('vaccination-dates.index');
    Route::get('/reports', [AdminVaccinationReportController::class, 'index'])->name('reports.index');
    Route::get('/vaccines', [VaccineController::class, 'index'])->name('vaccines.index');
    Route::patch('/vaccines/{vaccine}/availability', [VaccineController::class, 'updateAvailability'])->name('vaccines.availability');
    Route::get('/requests', [ParentRequestController::class, 'index'])->name('requests.index');
    Route::post('/requests/{parentRequest}/approve', [ParentRequestController::class, 'approve'])->name('requests.approve');
    Route::post('/requests/{parentRequest}/reject', [ParentRequestController::class, 'reject'])->name('requests.reject');
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::resource('hospitals', HospitalController::class)->except(['show']);
    Route::post('/vaccine/insert', [vaccineController::class, 'insert'])->name('vaccines.store');
});

Route::prefix('parent')->middleware(['auth', 'verified', 'role.parent'])->name('parent.')->group(function () {
    Route::get('/dashboard', [ParentDashboardController::class, 'index'])->name('dashboard');
    Route::resource('children', ParentChildController::class)->except(['show']);
    Route::get('/vaccination-dates', [ParentVaccinationDateController::class, 'index'])->name('vaccination-dates.index');
    Route::get('/book-hospital', [HospitalBookingController::class, 'index'])->name('bookings.index');
    Route::post('/book-hospital', [HospitalBookingController::class, 'store'])->name('bookings.store');
    Route::get('/reports', [ParentVaccinationReportController::class, 'index'])->name('reports.index');
    Route::post('/parent/bookings/already-vaccinated', [HospitalBookingController::class, 'markAlreadyVaccinated'])->name('parent.bookings.already-vaccinated');
    Route::get('/reports/download/{id}', [ParentVaccinationReportController::class, 'download'])->name('reports.download');
    Route::get('/reports/view/{id}', [ParentVaccinationReportController::class, 'viewPdf'])->name('reports.view');
    Route::get('/myappointments', [AppoinmentController::class, 'index'])->name('appointments.index');
    Route::get('/parent/meeting/join/{id}', [AppoinmentController::class, 'joinMeeting'])
        ->name('meeting.join');
    /// api
    Route::get('/api/get-doctors/{hospital_id}', [HospitalBookingController::class, 'getDoctorsByHospital']);
    Route::get('/api/doctor-status/{doctor_id}', [App\Http\Controllers\Parent\HospitalBookingController::class, 'getDoctorStatus']);
});


Route::prefix('hospital')->middleware(['auth', 'verified', 'role.hospital'])->name('hospital.')->group(function () {
    Route::get('/dashboard', [HospitalDashboardController::class, 'index'])->name('dashboard');
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/docters', [DrController::class, 'index'])->name('docters.index');
    Route::post('/docters/store', [DrController::class, 'store'])->name('docters.store');
    Route::patch('/appointments/{id}', [AppointmentController::class, 'updateStatus'])->name('appointments.update');
    Route::get('/vaccination/history', [HospitalDashboardController::class, 'getDetails'])->name('hospital.history');
    //api
    Route::get('/doctors/toggle-status/{id}', [App\Http\Controllers\Hospital\DrController::class, 'toggleStatus'])->name('docters.toggle-status');
    Route::delete('/docters/destroy/{id}', [DrController::class, 'destroy'])->name('docters.destroy');
});

Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user?->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }

    if ($user?->hasRole('parent')) {
        return redirect()->route('parent.dashboard');
    }

    if ($user?->hasRole('hospital')) {
        return redirect()->route('hospital.dashboard');
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__ . '/auth.php';
