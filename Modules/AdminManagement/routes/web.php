<?php

use Illuminate\Support\Facades\Route;
use Modules\AdminManagement\Http\Controllers\AuditLogController;
use Modules\AdminManagement\Http\Controllers\DashboardController;
use Modules\AdminManagement\Http\Controllers\RoleManagementController;
use Modules\AdminManagement\Http\Controllers\UserManagementController;

Route::middleware(['auth:admin', 'admin-enabled', 'authorize', 'adminMenu', 'setLocale', 'audit'])->prefix(
    'admin',
)->group(
    function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('user-management', [UserManagementController::class, 'index'])->name('admin.user_management.index');
        Route::post('user-management/store', [UserManagementController::class, 'store'])->name(
            'admin.user_management.store',
        );
        Route::put('user-management/update', [UserManagementController::class, 'update'])->name(
            'admin.user_management.update',
        );
        Route::delete('user-management/delete', [UserManagementController::class, 'status'])->name(
            'admin.user_management.status',
        );
        Route::get('audit-log', [AuditLogController::class, 'index'])->name('admin.audits.index');
        Route::get('audit-log/getPayload/{id?}', [AuditLogController::class, 'getPayload'])->name(
            'admin.audits.getPayload',
        );

        Route::resource('role-management', RoleManagementController::class)
            ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
            ->names('admin.role_management');
    },
);
