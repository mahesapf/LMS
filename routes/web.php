<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FasilitatorController;
use App\Http\Controllers\PesertaController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/news', [HomeController::class, 'news'])->name('news');
Route::get('/news/{id}', [HomeController::class, 'newsDetail'])->name('news.detail');

// Auth Routes
Auth::routes();

// Dashboard Route - Redirect based on role
Route::get('/dashboard', function () {
    $user = auth()->user();
    
    return match($user->role) {
        'super_admin' => redirect()->route('super-admin.dashboard'),
        'admin' => redirect()->route('admin.dashboard'),
        'fasilitator' => redirect()->route('fasilitator.dashboard'),
        'peserta' => redirect()->route('peserta.dashboard'),
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
    Route::get('/users/import', [SuperAdminController::class, 'importUsers'])->name('users.import');
    Route::post('/users/import', [SuperAdminController::class, 'processImportUsers'])->name('users.import.process');
    
    // Program Management
    Route::get('/programs', [SuperAdminController::class, 'programs'])->name('programs');
    Route::get('/programs/create', [SuperAdminController::class, 'createProgram'])->name('programs.create');
    Route::post('/programs', [SuperAdminController::class, 'storeProgram'])->name('programs.store');
    Route::get('/programs/{program}/edit', [SuperAdminController::class, 'editProgram'])->name('programs.edit');
    Route::put('/programs/{program}', [SuperAdminController::class, 'updateProgram'])->name('programs.update');
    Route::delete('/programs/{program}', [SuperAdminController::class, 'deleteProgram'])->name('programs.delete');
    
    // Activity Management
    Route::get('/activities', [SuperAdminController::class, 'activities'])->name('activities');
    Route::get('/activities/create', [SuperAdminController::class, 'createActivity'])->name('activities.create');
    Route::post('/activities', [SuperAdminController::class, 'storeActivity'])->name('activities.store');
    Route::get('/activities/{activity}/edit', [SuperAdminController::class, 'editActivity'])->name('activities.edit');
    Route::put('/activities/{activity}', [SuperAdminController::class, 'updateActivity'])->name('activities.update');
    Route::delete('/activities/{activity}', [SuperAdminController::class, 'deleteActivity'])->name('activities.delete');
    
    // Admin Mapping
    Route::get('/admin-mappings', [SuperAdminController::class, 'adminMappings'])->name('admin-mappings');
    Route::get('/admin-mappings/create', [SuperAdminController::class, 'createAdminMapping'])->name('admin-mappings.create');
    Route::post('/admin-mappings', [SuperAdminController::class, 'storeAdminMapping'])->name('admin-mappings.store');
    Route::post('/admin-mappings/{mapping}/status/{status}', [SuperAdminController::class, 'updateAdminMappingStatus'])->name('admin-mappings.update-status');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Payment Validation
    Route::get('/payments', [\App\Http\Controllers\PaymentValidationController::class, 'index'])->name('payments.index');
    Route::get('/payments/{payment}', [\App\Http\Controllers\PaymentValidationController::class, 'show'])->name('payments.show');
    Route::patch('/payments/{payment}/validate', [\App\Http\Controllers\PaymentValidationController::class, 'validate'])->name('payments.validate');
    Route::patch('/payments/{payment}/reject', [\App\Http\Controllers\PaymentValidationController::class, 'reject'])->name('payments.reject');
    
    // Registration Management
    Route::get('/registrations', [\App\Http\Controllers\RegistrationManagementController::class, 'index'])->name('registrations.index');
    Route::patch('/registrations/{registration}/assign', [\App\Http\Controllers\RegistrationManagementController::class, 'assignToClass'])->name('registrations.assignToClass');
    Route::delete('/registrations/{registration}/remove', [\App\Http\Controllers\RegistrationManagementController::class, 'removeFromClass'])->name('registrations.removeFromClass');
    
    // Participant Management
    Route::get('/participants', [AdminController::class, 'participants'])->name('participants');
    Route::get('/participants/create', [AdminController::class, 'createParticipant'])->name('participants.create');
    Route::post('/participants', [AdminController::class, 'storeParticipant'])->name('participants.store');
    Route::get('/participants/{participant}/edit', [AdminController::class, 'editParticipant'])->name('participants.edit');
    Route::put('/participants/{participant}', [AdminController::class, 'updateParticipant'])->name('participants.update');
    Route::delete('/participants/{participant}', [AdminController::class, 'deleteParticipant'])->name('participants.delete');
    Route::post('/participants/{participant}/suspend', [AdminController::class, 'suspendParticipant'])->name('participants.suspend');
    
    // Activity Management
    Route::get('/activities', [AdminController::class, 'activities'])->name('activities');
    
    // Class Management
    Route::get('/classes', [AdminController::class, 'classes'])->name('classes');
    Route::get('/classes/create', [AdminController::class, 'createClass'])->name('classes.create');
    Route::post('/classes', [AdminController::class, 'storeClass'])->name('classes.store');
    Route::get('/classes/{class}/edit', [AdminController::class, 'editClass'])->name('classes.edit');
    Route::put('/classes/{class}', [AdminController::class, 'updateClass'])->name('classes.update');
    Route::delete('/classes/{class}', [AdminController::class, 'deleteClass'])->name('classes.delete');
    
    // Participant Mapping
    Route::get('/mappings', [AdminController::class, 'mappingsIndex'])->name('mappings.index');
    Route::get('/classes/{class}/participants', [AdminController::class, 'participantMappings'])->name('classes.participants');
    Route::post('/classes/{class}/participants', [AdminController::class, 'assignParticipant'])->name('classes.participants.assign');
    Route::post('/mappings/{mapping}/move', [AdminController::class, 'moveParticipant'])->name('mappings.move');
    Route::post('/mappings/{mapping}/remove', [AdminController::class, 'removeParticipant'])->name('mappings.remove');
    
    // Fasilitator Mapping
    Route::get('/classes/{class}/fasilitators', [AdminController::class, 'fasilitatorMappings'])->name('classes.fasilitators');
    Route::post('/classes/{class}/fasilitators', [AdminController::class, 'assignFasilitator'])->name('classes.fasilitators.assign');
    Route::delete('/fasilitator-mappings/{mapping}', [AdminController::class, 'removeFasilitator'])->name('fasilitators.remove');
    
    // Stage Management
    Route::get('/classes/{class}/stages', [AdminController::class, 'classStages'])->name('classes.stages');
    Route::post('/classes/{class}/stages', [AdminController::class, 'storeStage'])->name('classes.stages.store');
    Route::put('/classes/{class}/stages/{stage}', [AdminController::class, 'updateStage'])->name('classes.stages.update');
    Route::delete('/classes/{class}/stages/{stage}', [AdminController::class, 'destroyStage'])->name('classes.stages.destroy');
    
    // Document Requirements
    Route::get('/classes/{class}/documents', [AdminController::class, 'classDocuments'])->name('classes.documents');
    Route::post('/classes/{class}/documents', [AdminController::class, 'storeDocumentRequirement'])->name('classes.documents.store');
    Route::put('/classes/{class}/documents/{requirement}', [AdminController::class, 'updateDocumentRequirement'])->name('classes.documents.update');
    Route::delete('/classes/{class}/documents/{requirement}', [AdminController::class, 'destroyDocumentRequirement'])->name('classes.documents.destroy');
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
    
    // Documents
    Route::get('/documents', [FasilitatorController::class, 'documents'])->name('documents');
    Route::get('/documents/upload', [FasilitatorController::class, 'uploadDocument'])->name('documents.upload');
    Route::post('/documents', [FasilitatorController::class, 'storeDocument'])->name('documents.store');
    Route::delete('/documents/{document}', [FasilitatorController::class, 'deleteDocument'])->name('documents.delete');
    
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
    
    // Program Registration
    Route::get('/programs', [\App\Http\Controllers\ProgramRegistrationController::class, 'index'])->name('programs.index');
    Route::get('/programs/{program}', [\App\Http\Controllers\ProgramRegistrationController::class, 'show'])->name('programs.show');
    Route::post('/programs/{program}/register', [\App\Http\Controllers\ProgramRegistrationController::class, 'register'])->name('programs.register');
    
    // Payment
    Route::get('/registrations/{registration}/payment', [\App\Http\Controllers\ProgramRegistrationController::class, 'createPayment'])->name('payment.create');
    Route::post('/registrations/{registration}/payment', [\App\Http\Controllers\ProgramRegistrationController::class, 'storePayment'])->name('payment.store');
    
    // Profile
    Route::get('/profile', [PesertaController::class, 'profile'])->name('profile');
    Route::put('/profile', [PesertaController::class, 'updateProfile'])->name('profile.update');
    
    // Classes
    Route::get('/classes', [PesertaController::class, 'myClasses'])->name('classes');
    Route::get('/classes/{class}', [PesertaController::class, 'classDetail'])->name('classes.detail');
    
    // Grades (redirect to classes)
    Route::get('/grades', function() {
        return redirect()->route('peserta.classes');
    })->name('grades');
    
    // Documents
    Route::get('/documents', [PesertaController::class, 'documents'])->name('documents');
    Route::post('/documents/upload', [PesertaController::class, 'uploadDocument'])->name('documents.upload');
    Route::delete('/documents/{document}', [PesertaController::class, 'destroyDocument'])->name('documents.destroy');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
