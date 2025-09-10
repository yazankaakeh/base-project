<?php

use Illuminate\Support\Facades\Route;
use Modules\Doctor\Http\Controllers\ClinicController;
use Modules\Doctor\Http\Controllers\DoctorController;
use Modules\Doctor\Http\Controllers\MedicalSpecialtyController;
use Modules\Doctor\Http\Controllers\MedicalTestController;
use Modules\Doctor\Http\Controllers\MedicineController;
use Modules\Doctor\Http\Controllers\PatientController;

Route::middleware(['auth:doctor', 'admin-enabled', 'verified', 'doctorMenu'])->name('doctor.')->prefix('doctor')->group(
    function () {
        Route::get('dashboard', [DoctorController::class, 'index'])->name('dashboard');

        Route::get('/clinic', [ClinicController::class, 'index'])->name('clinic.index');
        Route::get('/clinic/store', [ClinicController::class, 'store'])->name(
            'clinic.store',
        );
        Route::get('/clinic/update', [ClinicController::class, 'update'])->name(
            'clinic.update',
        );

        Route::get('/patients', [PatientController::class, 'index'])->name(
            'patients.index',
        );

        Route::get('/patients/store', [PatientController::class, 'store'])->name(
            'patients.store',
        );

        Route::get('/patients/update', [PatientController::class, 'update'])->name(
            'patients.update',
        );

        Route::get('/medicalTest', [MedicalTestController::class, 'index'])->name(
            'medicalTest.index',
        );

        Route::get('/medicine', [MedicineController::class, 'index'])->name(
            'medicine.index',
        );

        Route::get('/medicalSpecialty', [MedicalSpecialtyController::class, 'index'])->name(
            'medicalSpecialty.index',
        );
    },
);
