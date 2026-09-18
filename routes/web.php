<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Middleware\SetLocale;

use App\Http\Controllers\AuthController;

use App\Http\Controllers\EmployeeLookupController;
use App\Http\Controllers\EmployeeImportController;
use App\Http\Controllers\EmployeeImportTemplateController;
use App\Http\Controllers\ExportEmployeeController;

use App\Http\Controllers\AssessmentSelfController;
use App\Http\Controllers\AssessmentEmployeesController;
use App\Http\Controllers\AssessmentSummaryController;
use App\Http\Controllers\AssessmentResultController;

use App\Http\Controllers\AdminCycleController;
use App\Http\Controllers\AdminResultsController;
use App\Http\Controllers\AdminEmployeesController;

Route::middleware([SetLocale::class])->group(function () {

    Route::view('/offline', 'offline')->name('offline');
    Route::view('/guide', 'guide')->name('guide');
    Route::view('/landing', 'landing')->name('landing');

    Route::post('/locale', function (Request $request) {
        $supported = ['th', 'en'];
        $locale = (string) $request->input('locale', 'th');

        if (!in_array($locale, $supported, true)) {
            $locale = 'th';
        }

        session(['locale' => $locale]);
        app()->setLocale($locale);

        return back();
    })->name('locale.switch');

    Route::post('/employees/lookup', [EmployeeLookupController::class, 'lookup'])
        ->name('employees.lookup');

    Route::get('/', function () {
        return Auth::check()
            ? redirect()->route('profile')
            : view('landing');
    })->name('welcome');

    Route::middleware('guest')->group(function () {

        Route::get('/login', [AuthController::class, 'showLoginForm'])
            ->name('login');

        Route::post('/login', [AuthController::class, 'login'])
            ->name('login.submit');

        Route::post('/login/employee-preview', [AuthController::class, 'employeePreview'])
            ->name('login.employee.preview');

        Route::post('/password/forgot/verify', [AuthController::class, 'forgotVerify'])
            ->name('password.forgot.verify');

        Route::post('/password/forgot/reset', [AuthController::class, 'forgotReset'])
            ->name('password.forgot.reset');
    });

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout')
        ->middleware('auth');

    Route::middleware(['auth'])->group(function () {

        Route::post('/login/first-picture', [AuthController::class, 'firstPicture'])
            ->name('login.first_picture');

        Route::get('/admin/export/employees', [ExportEmployeeController::class, 'export'])
            ->name('export_employees.excel');

        Route::prefix('admin')->name('admin.')->group(function () {

            Route::get('/cycles', [AdminCycleController::class, 'index'])
                ->name('cycles');

            Route::post('/cycles', [AdminCycleController::class, 'store'])
                ->name('cycles.store');

            Route::post('/cycles/{cycle}/activate', [AdminCycleController::class, 'activate'])
                ->name('cycles.activate');

            Route::post('/cycles/{cycle}/read-mode', [AdminCycleController::class, 'enableReadMode'])
                ->name('cycles.read_mode');

            Route::post('/cycles/{cycle}/close', [AdminCycleController::class, 'close'])
                ->name('cycles.close');

            Route::delete('/cycles/{cycle}', [AdminCycleController::class, 'destroy'])
                ->name('cycles.destroy');

            Route::get('/results/download', [AdminResultsController::class, 'index'])
                ->name('results.download');

            Route::get('/results/{cycle}/download', [AdminResultsController::class, 'download'])
                ->name('results.download.cycle');
        });

        Route::get('/profile', [AuthController::class, 'profile'])
            ->name('profile');

        Route::get('/profile/edit', [AuthController::class, 'showEditProfile'])
            ->name('profile.edit');

        Route::put('/profile/picture', [AuthController::class, 'updateProfilePicture'])
            ->name('profile.update.picture');

        Route::put('/profile/email', [AuthController::class, 'updateEmail'])
            ->name('profile.update.email');

        Route::put('/profile/password', [AuthController::class, 'updatePassword'])
            ->name('profile.update.password');

        Route::get('/assessment', [AssessmentSelfController::class, 'index'])
            ->name('assessment.self');

        Route::post('/assessment', [AssessmentSelfController::class, 'store'])
            ->name('assessment.self.store');

        Route::get('/assessment/self/{code}', [AssessmentSelfController::class, 'showEmployee'])
            ->name('assessment.self.employee');

        Route::get('/assessment/employees', [AssessmentEmployeesController::class, 'index'])
            ->name('assessment.employees');

        Route::get('/assessment/employees/{employee}', [AssessmentEmployeesController::class, 'show'])
            ->name('assessment.employees.show');

        Route::post('/assessment/employees/{employee}', [AssessmentEmployeesController::class, 'store'])
            ->name('assessment.employees.store');

        Route::post('/assessment/employees/{employee}/save-total', [AssessmentResultController::class, 'store'])
            ->name('assessment.save_total');

        Route::get('/assessment/overview', [AssessmentSummaryController::class, 'index'])
            ->name('assessment.overview');

        Route::get('/employees/import', [EmployeeImportController::class, 'showForm'])
            ->name('employees.import.form');

        Route::get('/employees/import-template', [EmployeeImportTemplateController::class, 'download'])
            ->name('employees.import.template');

        Route::post('/employees/import/append', [EmployeeImportController::class, 'importAppend'])
            ->name('employees.import.append');

        Route::post('/employees/import/replace', [EmployeeImportController::class, 'importReplace'])
            ->name('employees.import.replace');
    });
});
