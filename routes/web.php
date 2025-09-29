<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CenterController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\MockTestController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\AccountingController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\DemoQuestionController;
use App\Http\Controllers\BusinessSettingController;
use App\Http\Controllers\CertificateClaimContoller;

Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/do-login', [LoginController::class, 'doLogin'])->name('doLogin');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [DashboardController::class, 'showDashboard'])->name('user.dashboard');

    Route::group(['prefix' => 'roles', 'as' => 'user.roles.', 'module' => 'Role'], function () {
        Route::get('/', [RoleController::class, 'index'])->name('list')->middleware('checkPermission:user.roles.list');
        Route::get('/create', [RoleController::class, 'create'])->name('create')->middleware('checkPermission:user.roles.create');
        Route::post('/store', [RoleController::class, 'store'])->name('store')->middleware('checkPermission:user.roles.store');
        Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('edit')->middleware('checkPermission:user.roles.edit');
        Route::post('/update/{id}', [RoleController::class, 'update'])->name('update')->middleware('checkPermission:user.roles.update');
        Route::post('{id}/toggle-status', [RoleController::class, 'toggleStatus'])->name('toggleStatus')->middleware('checkPermission:user.roles.toggleStatus');
    });

    Route::group(['prefix' => 'users', 'as' => 'users.', 'module' => 'users'], function () {
        Route::get('/', [UserController::class, 'index'])->name('list');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('toggleStatus');
        Route::post('/create', [UserController::class, 'store'])->name('store');
        Route::get('/view/{id}', [UserController::class, 'show'])->name('edit');
        Route::get('/profile', [UserController::class, 'profile'])->name('profile');
        Route::post('/update/{id}', [UserController::class, 'update'])->name('update'); // Using POST instead of PUT/PATCH
        Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'candidate', 'as' => 'candidate.', 'module' => 'Candidate'], function () {
        Route::get('/', [CandidateController::class, 'list'])->name('list');
        Route::get('/create', [CandidateController::class, 'showRegistration'])->name('create');
        Route::post('/store', [CandidateController::class, 'register'])->name('store');
        Route::get('/edit/{id}', [CandidateController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [CandidateController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [CandidateController::class, 'destroy'])->name('delete');
        Route::post('{id}/toggle-status', [CandidateController::class, 'toggleStatus'])->name('toggleStatus');
        Route::get('/{candidate_id}/applications', [CandidateController::class, 'candidateApplications'])->name('applications');
    });

    Route::group(['prefix' => 'exam', 'as' => 'exam.', 'module' => 'Exam'], function () {
        Route::get('/', [ExamController::class, 'list'])->name('list');
        Route::get('/create', [ExamController::class, 'showCreateExam'])->name('create');
        Route::post('/store', [ExamController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [ExamController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [ExamController::class, 'update'])->name('update');
        Route::post('{id}/toggle-status', [ExamController::class, 'toggleStatus'])->name('toggleStatus');
    });


    Route::group(['prefix' => 'payment', 'as' => 'payment.', 'module' => 'payment'], function () {
        Route::get('/', [PaymentController::class, 'list'])->name('list');
    });


    Route::group(['prefix' => 'mock-tests', 'as' => 'mock-tests.', 'module' => 'mock-tests'], function () {
        Route::get('/question-list', [MockTestController::class, 'questionList'])->name('question.list');
        Route::get('/module-info', [MockTestController::class, 'index'])->name('module-section.info');
        Route::get('/question-setup-form', [MockTestController::class, 'questionSetupForm'])->name('question-setup.form');
        Route::post('/question-setup', [MockTestController::class, 'questionSetup'])->name('question-setup.post');
        Route::get('/section-edit/{id}', [MockTestController::class, 'editSection'])->name('section.edit');
        Route::post('/section-update/{id}', [MockTestController::class, 'updateSection'])->name('section.update');
        Route::get('/edit-question/{id}', [MockTestController::class, 'editQuestion'])->name('edit.question');
        Route::post('/update-question/{id}', [MockTestController::class, 'updateQuestion'])->name('question.update');
        Route::delete('/delete-question/{id}', [MockTestController::class, 'deleteQuestion'])->name('question.delete');
    });

    Route::resource('packages', PackageController::class);

    // Extra routes
    Route::post('packages/{package}/buy', [PackageController::class, 'buy'])->name('packages.buy');
    Route::post('packages/attend/{detail}', [PackageController::class, 'attendExam'])->name('packages.attend');

});
