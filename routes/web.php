<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FasilitatorController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\PublicSekolahController;
use App\Http\Controllers\SekolahManagementController;
use App\Http\Controllers\Auth\SekolahRegisterController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/news', [HomeController::class, 'news'])->name('news');
Route::get('/news/{id}', [HomeController::class, 'newsDetail'])->name('news.detail');

// Registrasi Sekolah (Public)
Route::get('/sekolah/register', [PublicSekolahController::class, 'showRegistrationForm'])->name('sekolah.register');
Route::post('/sekolah/register', [PublicSekolahController::class, 'register'])->name('sekolah.register.submit');

// Activity Registration Routes (public access)
Route::get('/activities', [\App\Http\Controllers\ActivityRegistrationController::class, 'index'])->name('activities.index');
Route::get('/activities/{activity}', [\App\Http\Controllers\ActivityRegistrationController::class, 'show'])->name('activities.show');
Route::get('/activities/{activity}/register', [\App\Http\Controllers\ActivityRegistrationController::class, 'showRegisterForm'])->name('activities.register.form');
Route::post('/activities/{activity}/register', [\App\Http\Controllers\ActivityRegistrationController::class, 'register'])->name('activities.register');

// Payment Routes (public - can be accessed without login for public registrations)
Route::get('/registrations/{registration}/payment', [\App\Http\Controllers\ActivityRegistrationController::class, 'createPayment'])->name('payment.create');
Route::post('/registrations/{registration}/payment', [\App\Http\Controllers\ActivityRegistrationController::class, 'storePayment'])->name('payment.store');

// Auth Routes (Login only - registration disabled, admin will create accounts)
Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::get('password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');

// Dashboard Route - Redirect based on role
Route::get('/dashboard', function () {
    $user = auth()->user();

    return match($user->role) {
        'super_admin' => redirect()->route('super-admin.dashboard'),
        'admin' => redirect()->route('admin.dashboard'),
        'fasilitator' => redirect()->route('fasilitator.dashboard'),
        'peserta' => redirect()->route('peserta.dashboard'),
        'sekolah' => redirect()->route('sekolah.dashboard'),
        default => abort(403),
    };
})->middleware('auth')->name('dashboard');

// Super Admin Routes
Route::prefix('super-admin')->name('super-admin.')->middleware(['auth', 'role:super_admin'])->group(function () {
    Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');

    // User Management
    Route::get('/users', [SuperAdminController::class, 'users'])->name('users');
    Route::get('/users/create', [SuperAdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [SuperAdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}/edit', [SuperAdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [SuperAdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [SuperAdminController::class, 'deleteUser'])->name('users.delete');
    Route::post('/users/{user}/suspend', [SuperAdminController::class, 'suspendUser'])->name('users.suspend');
    Route::post('/users/{user}/activate', [SuperAdminController::class, 'activateUser'])->name('users.activate');
    Route::post('/users/import', [SuperAdminController::class, 'processImportUsers'])->name('users.import.process');

    // Program Management
    Route::get('/programs', [SuperAdminController::class, 'programs'])->name('programs');
    Route::get('/programs/create', [SuperAdminController::class, 'createProgram'])->name('programs.create');
    Route::post('/programs', [SuperAdminController::class, 'storeProgram'])->name('programs.store');
    Route::get('/programs/{program}/edit', [SuperAdminController::class, 'editProgram'])->name('programs.edit');
    Route::put('/programs/{program}', [SuperAdminController::class, 'updateProgram'])->name('programs.update');
    Route::delete('/programs/{program}', [SuperAdminController::class, 'deleteProgram'])->name('programs.delete');

    // Admin Mapping
    Route::get('/admin-mappings', [SuperAdminController::class, 'adminMappings'])->name('admin-mappings');
    Route::get('/admin-mappings/create', [SuperAdminController::class, 'createAdminMapping'])->name('admin-mappings.create');
    Route::post('/admin-mappings', [SuperAdminController::class, 'storeAdminMapping'])->name('admin-mappings.store');
    Route::post('/admin-mappings/{mapping}/status/{status}', [SuperAdminController::class, 'updateAdminMappingStatus'])->name('admin-mappings.update-status');

    // Payment Validation (Super Admin Only)
    Route::get('/payments', [\App\Http\Controllers\PaymentValidationController::class, 'index'])->name('payments.index');
    Route::get('/payments/export/participants', [\App\Http\Controllers\PaymentValidationController::class, 'exportParticipants'])->name('payments.export-participants');
    Route::get('/payments/export/single/{payment}', [\App\Http\Controllers\PaymentValidationController::class, 'exportSinglePayment'])->name('payments.export-single');
    Route::post('/payments/export/by-schools', [\App\Http\Controllers\PaymentValidationController::class, 'exportBySchools'])->name('payments.export-by-schools');
    Route::get('/payments/{payment}', [\App\Http\Controllers\PaymentValidationController::class, 'show'])->name('payments.show');
    Route::patch('/payments/{payment}/approve', [\App\Http\Controllers\PaymentValidationController::class, 'approve'])->name('payments.approve');

    // Sekolah Management
    Route::get('/sekolah', [SekolahManagementController::class, 'index'])->name('sekolah.index');
    Route::get('/sekolah/{sekolah}', [SekolahManagementController::class, 'show'])->name('sekolah.show');
    Route::patch('/sekolah/{sekolah}/approve', [SekolahManagementController::class, 'approve'])->name('sekolah.approve');
    Route::patch('/sekolah/{sekolah}/reject', [SekolahManagementController::class, 'reject'])->name('sekolah.reject');
    Route::get('/sekolah/{sekolah}/download-sk', [SekolahManagementController::class, 'downloadSK'])->name('sekolah.download-sk');
    Route::delete('/sekolah/{sekolah}', [SekolahManagementController::class, 'destroy'])->name('sekolah.destroy');
    Route::patch('/payments/{payment}/reject', [\App\Http\Controllers\PaymentValidationController::class, 'reject'])->name('payments.reject');
});

// Routes for Super Admin AND Admin (Kegiatan, Kelas, Manajemen Peserta)
Route::prefix('super-admin')->name('super-admin.')->middleware(['auth', 'role:super_admin,admin'])->group(function () {
    // Activity Management
    Route::get('/activities', [SuperAdminController::class, 'activities'])->name('activities');
    Route::get('/activities/create', [SuperAdminController::class, 'createActivity'])->name('activities.create');
    Route::post('/activities', [SuperAdminController::class, 'storeActivity'])->name('activities.store');
    Route::get('/activities/{activity}/edit', [SuperAdminController::class, 'editActivity'])->name('activities.edit');
    Route::put('/activities/{activity}', [SuperAdminController::class, 'updateActivity'])->name('activities.update');
    Route::delete('/activities/{activity}', [SuperAdminController::class, 'deleteActivity'])->name('activities.delete');

    // Registration Management
    Route::get('/registrations', [\App\Http\Controllers\RegistrationManagementController::class, 'index'])->name('registrations.index');
    Route::patch('/registrations/{registration}/assign', [\App\Http\Controllers\RegistrationManagementController::class, 'assignToClass'])->name('registrations.assignToClass');
    Route::delete('/registrations/{registration}/remove', [\App\Http\Controllers\RegistrationManagementController::class, 'removeFromClass'])->name('registrations.removeFromClass');

    // Class Management
    Route::get('/classes', [SuperAdminController::class, 'classes'])->name('classes.index');
    Route::get('/classes/create', [SuperAdminController::class, 'createClass'])->name('classes.create');
    Route::post('/classes', [SuperAdminController::class, 'storeClass'])->name('classes.store');
    Route::get('/classes/{class}', [SuperAdminController::class, 'showClass'])->name('classes.show');
    Route::get('/classes/{class}/edit', [SuperAdminController::class, 'editClass'])->name('classes.edit');
    Route::put('/classes/{class}', [SuperAdminController::class, 'updateClass'])->name('classes.update');
    Route::delete('/classes/{class}', [SuperAdminController::class, 'deleteClass'])->name('classes.delete');
    Route::post('/classes/{class}/participants', [SuperAdminController::class, 'assignParticipantToClass'])->name('classes.assignParticipant');
    Route::post('/classes/{class}/participants/bulk', [SuperAdminController::class, 'assignParticipantsByLocation'])->name('classes.assignParticipantsByLocation');
    Route::post('/classes/{class}/participants/by-kecamatan', [SuperAdminController::class, 'assignParticipantsByKecamatan'])->name('classes.assignParticipantsByKecamatan');
    Route::delete('/classes/{class}/participants/{participant}', [SuperAdminController::class, 'removeParticipant'])->name('classes.removeParticipant');
    Route::delete('/classes/{class}/teacher-participants/{teacher}', [SuperAdminController::class, 'removeTeacherParticipant'])->name('classes.removeTeacherParticipant');
    Route::delete('/classes/{class}/kepala-sekolah/{registration}', [SuperAdminController::class, 'removeKepalaSekolah'])->name('classes.removeKepalaSekolah');
    Route::get('/classes/{class}/fasilitators', function($class) { return redirect()->route('super-admin.classes.show', $class); });
    Route::post('/classes/{class}/fasilitators', [SuperAdminController::class, 'assignFasilitatorToClass'])->name('classes.assignFasilitator');
    Route::delete('/classes/{class}/fasilitators/{fasilitator}', [SuperAdminController::class, 'removeFasilitatorFromClass'])->name('classes.removeFasilitator');
    Route::post('/classes/{class}/admins', [SuperAdminController::class, 'assignAdminToActivity'])->name('classes.assignAdmin');
    Route::delete('/classes/{class}/admins/{adminMapping}', [SuperAdminController::class, 'removeAdminFromActivity'])->name('classes.removeAdmin');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Activity Management (sama seperti super admin)
    Route::get('/activities', [SuperAdminController::class, 'activities'])->name('activities');
    Route::get('/activities/create', [SuperAdminController::class, 'createActivity'])->name('activities.create');
    Route::post('/activities', [SuperAdminController::class, 'storeActivity'])->name('activities.store');
    Route::get('/activities/{activity}/edit', [SuperAdminController::class, 'editActivity'])->name('activities.edit');
    Route::put('/activities/{activity}', [SuperAdminController::class, 'updateActivity'])->name('activities.update');
    Route::delete('/activities/{activity}', [SuperAdminController::class, 'deleteActivity'])->name('activities.delete');

    // Class Management (sama seperti super admin)
    Route::get('/classes', [SuperAdminController::class, 'classes'])->name('classes.index');
    Route::get('/classes/create', [SuperAdminController::class, 'createClass'])->name('classes.create');
    Route::post('/classes', [SuperAdminController::class, 'storeClass'])->name('classes.store');
    Route::get('/classes/{class}', [SuperAdminController::class, 'showClass'])->name('classes.show');
    Route::get('/classes/{class}/edit', [SuperAdminController::class, 'editClass'])->name('classes.edit');
    Route::put('/classes/{class}', [SuperAdminController::class, 'updateClass'])->name('classes.update');
    Route::delete('/classes/{class}', [SuperAdminController::class, 'deleteClass'])->name('classes.delete');
    Route::post('/classes/{class}/participants', [SuperAdminController::class, 'assignParticipantToClass'])->name('classes.assignParticipant');
    Route::post('/classes/{class}/participants/bulk', [SuperAdminController::class, 'assignParticipantsByLocation'])->name('classes.assignParticipantsByLocation');
    Route::post('/classes/{class}/participants/by-kecamatan', [SuperAdminController::class, 'assignParticipantsByKecamatan'])->name('classes.assignParticipantsByKecamatan');
    Route::delete('/classes/{class}/participants/{participant}', [SuperAdminController::class, 'removeParticipant'])->name('classes.removeParticipant');
    Route::delete('/classes/{class}/teacher-participants/{teacher}', [SuperAdminController::class, 'removeTeacherParticipant'])->name('classes.removeTeacherParticipant');
    Route::delete('/classes/{class}/kepala-sekolah/{registration}', [SuperAdminController::class, 'removeKepalaSekolah'])->name('classes.removeKepalaSekolah');
    Route::get('/classes/{class}/fasilitators', function($class) { return redirect()->route('admin.classes.show', $class); });
    Route::post('/classes/{class}/fasilitators', [SuperAdminController::class, 'assignFasilitatorToClass'])->name('classes.assignFasilitator');
    Route::delete('/classes/{class}/fasilitators/{fasilitator}', [SuperAdminController::class, 'removeFasilitatorFromClass'])->name('classes.removeFasilitator');

    // Registration Management (sama seperti super admin)
    Route::get('/registrations', [\App\Http\Controllers\RegistrationManagementController::class, 'index'])->name('registrations.index');
    Route::patch('/registrations/{registration}/assign', [\App\Http\Controllers\RegistrationManagementController::class, 'assignToClass'])->name('registrations.assignToClass');
    Route::delete('/registrations/{registration}/remove', [\App\Http\Controllers\RegistrationManagementController::class, 'removeFromClass'])->name('registrations.removeFromClass');
});

// Fasilitator Routes
Route::prefix('fasilitator')->name('fasilitator.')->middleware(['auth', 'role:fasilitator'])->group(function () {
    Route::get('/dashboard', [FasilitatorController::class, 'dashboard'])->name('dashboard');

    // Profile
    Route::get('/profile', [FasilitatorController::class, 'profile'])->name('profile');
    Route::put('/profile', [FasilitatorController::class, 'updateProfile'])->name('profile.update');

    // Classes
    Route::get('/classes', [FasilitatorController::class, 'myClasses'])->name('classes');
    Route::get('/classes/{class}', [FasilitatorController::class, 'classDetail'])->name('classes.detail');

    // Grades
    Route::get('/classes/{class}/grades', [FasilitatorController::class, 'grades'])->name('grades');
    Route::post('/classes/{class}/grades', [FasilitatorController::class, 'storeGrade'])->name('grades.store');

    // Documents - Removed: Upload now handled within class context via document-requirements

    // Document Requirements & Submissions
    Route::get('/classes/{class}/document-requirements', [FasilitatorController::class, 'viewDocumentRequirements'])->name('classes.document-requirements');
    Route::get('/classes/{class}/document-requirements/create', [FasilitatorController::class, 'createDocumentRequirement'])->name('classes.document-requirements.create');
    Route::post('/classes/{class}/document-requirements', [FasilitatorController::class, 'storeDocumentRequirement'])->name('classes.document-requirements.store');
    Route::delete('/classes/{class}/document-requirements/{requirement}', [FasilitatorController::class, 'deleteDocumentRequirement'])->name('classes.document-requirements.delete');
    Route::get('/classes/{class}/requirements/{requirement}/submissions', [FasilitatorController::class, 'viewSubmissions'])->name('classes.submissions');

    // Participant Mappings (Read Only)
    Route::get('/mappings', [FasilitatorController::class, 'participantMappingsIndex'])->name('mappings.index');

    // Participant Mapping (Full Access)
    Route::get('/classes/{class}/participants', [FasilitatorController::class, 'participantMappings'])->name('classes.participants');
    Route::post('/classes/{class}/participants', [FasilitatorController::class, 'assignParticipant'])->name('classes.participants.assign');
    Route::post('/participant-mappings/{mapping}/move', [FasilitatorController::class, 'moveParticipant'])->name('mappings.move');
    Route::post('/participant-mappings/{mapping}/remove', [FasilitatorController::class, 'removeParticipant'])->name('mappings.remove');
});

// Peserta Routes
Route::prefix('peserta')->name('peserta.')->middleware(['auth', 'role:peserta'])->group(function () {
    Route::get('/dashboard', [PesertaController::class, 'dashboard'])->name('dashboard');

    // Profile
    Route::get('/profile', [PesertaController::class, 'profile'])->name('profile');
    Route::put('/profile', [PesertaController::class, 'updateProfile'])->name('profile.update');

    // Biodata
    Route::get('/biodata', [PesertaController::class, 'biodata'])->name('biodata');
    Route::put('/biodata', [PesertaController::class, 'updateBiodata'])->name('biodata.update');

    // Classes
    Route::get('/classes', [PesertaController::class, 'myClasses'])->name('classes');
    Route::get('/classes/{class}', [PesertaController::class, 'classDetail'])->name('classes.detail');

    // Grades (redirect to classes)
    Route::get('/grades', function() {
        return redirect()->route('peserta.classes');
// Sekolah Routes
Route::prefix('sekolah')->name('sekolah.')->middleware(['auth', 'role:sekolah'])->group(function () {
    Route::get('/dashboard', [SekolahController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [SekolahController::class, 'profile'])->name('profile');
    Route::put('/profile', [SekolahController::class, 'updateProfile'])->name('profile.update');
    Route::get('/registrations', [SekolahController::class, 'registrations'])->name('registrations');
});

    })->name('grades');

    // Documents
    Route::get('/documents', [PesertaController::class, 'documents'])->name('documents');
    Route::post('/documents/upload', [PesertaController::class, 'uploadDocument'])->name('documents.upload');
    Route::delete('/documents/{document}', [PesertaController::class, 'destroyDocument'])->name('documents.destroy');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
