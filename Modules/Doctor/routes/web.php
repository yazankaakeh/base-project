<?php

use Illuminate\Support\Facades\Route;
use Modules\Doctor\Http\Controllers\ClinicController;
use Modules\Doctor\Http\Controllers\DoctorController;
use Modules\Doctor\Http\Controllers\MedicalSpecialtyController;
use Modules\Doctor\Http\Controllers\MedicalTestController;
use Modules\Doctor\Http\Controllers\MedicineController;
use Modules\Doctor\Http\Controllers\PatientController;

Route::middleware(['auth:doctor', 'audit', 'admin-enabled', 'authorize', 'setLocale', 'doctorMenu'])->name(
    'doctor.',
)->prefix(
    'doctor',
)->group(
    function () {
        Route::get('dashboard', [DoctorController::class, 'index'])->name('dashboard');

        Route::get('/clinic', [ClinicController::class, 'index'])->name('clinic.index');

        Route::post('/clinic/store', [ClinicController::class, 'store'])->name(
            'clinic.store',
        );

        Route::post('/clinic/update', [ClinicController::class, 'update'])->name(
            'clinic.update',
        );

        Route::get('/patients', [PatientController::class, 'index'])->name(
            'patients.index',
        );

        Route::post('/patients/store', [PatientController::class, 'store'])->name(
            'patients.store',
        );

        Route::post('/patients/update', [PatientController::class, 'update'])->name(
            'patients.update',
        );
        Route::get('/patients/show/{id}', [PatientController::class, 'show'])->name(
            'patients.show',
        );

        Route::get('/medicalTest', [MedicalTestController::class, 'index'])->name(
            'medicalTest.index',
        );
        Route::post('/medicalTest/store', [MedicalTestController::class, 'store'])->name(
            'medicalTest.store',
        );
        Route::post('/medicalTest/update', [MedicalTestController::class, 'update'])->name(
            'medicalTest.update',
        );

        Route::get('/medicine', [MedicineController::class, 'index'])->name(
            'medicine.index',
        );

        Route::post('/medicine/store', [MedicineController::class, 'store'])->name(
            'medicine.store',
        );


        Route::post('/medicine/update', [MedicineController::class, 'update'])->name(
            'medicine.update',
        );


        Route::get('/medicalSpecialty', [MedicalSpecialtyController::class, 'index'])->name(
            'medicalSpecialty.index',
        );
    },
);
