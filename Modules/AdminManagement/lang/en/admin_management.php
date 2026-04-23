<?php

use Modules\AdminManagement\Enums\ActiveAdminEnum;

return [
        'ActiveAdminEnum' => [
                ActiveAdminEnum::ACTIVE->value => 'Active',
                ActiveAdminEnum::DE_ACTIVE->value => 'De Active',
        ],
        'user' => [
                'title' => 'User Management',
                'subtitle' => 'Manage admins, their roles, and access',
                'createLabel' => 'New User',
                'editUserStatus' => 'Edit User Status',
                'name' => 'Name',
                'email' => 'Email',
                'role' => 'Role',
                'image' => 'Photo',
                'status' => 'Status',
                'actions' => 'Actions',
                'search' => 'Search by name or email',
                'filter_by_role' => 'Filter by role',
                'filter_by_status' => 'Filter by status',
                'all_roles' => 'All roles',
                'all_statuses' => 'All statuses',
                'reset' => 'Reset filters',
                'no_results' => 'No users match your filters',
                'no_results_hint' => 'Try adjusting your search or clearing filters.',
                'stats' => [
                    'total' => 'Total users',
                    'active' => 'Active',
                    'inactive' => 'Inactive',
                    'roles' => 'Roles',
                ],
                'edit' => [
                        'title' => 'Edit User',
                ],
                'create' => [
                        'title' => 'Create User',
                        'img' => 'Img',
                        'password' => 'Password',
                        'password_confirmation' => 'Password Confirmation',
                        'isActive' => 'Is Active',
                        'name' => 'Name',
                        'email' => 'Email',
                        'role' => 'Role',
                        'phone' => 'Phone',
                ],
        ],
        'roles' => [
                'title' => 'Roles',
                'createBtn' => 'Create',
                'id' => 'ID',
                'name' => 'Name',
                'created_at' => 'Created At',
                'updated_at' => 'Updated At',
                'actions' => 'Actions',
                'create' => [
                        'title' => 'Create Role',
                        'subtitle' => 'Pick a name and toggle the permissions this role should have.',
                        'name' => 'Name',
                        'namePlaceholder' => 'e.g. Editor, Content Manager',
                        'guard' => 'Guard',
                        'allCheckBoxes' => 'Select all permissions',
                        'searchPermissions' => 'Search permissions…',
                        'selected' => 'Selected',
                        'permissions_count' => ':count permissions',
                        'selectAllSection' => 'Select all in this group',
                        'noPermissions' => 'No permissions match your search.',
                        'save' => 'Create role',
                        'cancel' => 'Cancel',
                ],
                'edit' => [
                        'title' => 'Edit Role',
                ],
        ],
        'audits' => [
                'index' => 'Audit Logs',
                'getPayLoad' => 'Get Pay Load',
                'filter' => 'Filter',
                'admin' => 'Admin',
                'action' => 'Action',
                'ip' => 'IP Address',
                'time' => 'Time',
                'changes' => 'Changes',
                'filterModal' => [
                        'all' => 'All',
                        'index' => 'Filter',
                        'adminId' => 'Admin',
                        'date' => 'Date',
                        'routeName' => 'Route Name',
                ],
        ],
        'submit' => 'Submit',
        'close' => 'Close',
        'save' => 'Save changes',
        'pleaseSelectOne' => 'Please Select One',
        'permissions' => [
            // Admin Management Permissions
                'admin-user_management-index' => 'View User Management',
                'admin-user_management-store' => 'Create User',
                'admin-user_management-update' => 'Update User',
                'admin-user_management-status' => 'Delete/Change User Status',

                'admin-audits-index' => 'View Audit Logs',
                'admin-audits-getPayload' => 'View Audit Log Details',

                'admin-role_management-index' => 'View Role Management',
                'admin-role_management-create' => 'Create Role',
                'admin-role_management-store' => 'Store Role',
                'admin-role_management-edit' => 'Edit Role',
                'admin-role_management-update' => 'Update Role',
                'admin-role_management-destroy' => 'Delete Role',

            // Blog Permissions
                'admin-categories-index' => 'View Categories',
                'admin-categories-create' => 'Create Category',
                'admin-categories-store' => 'Store Category',
                'admin-categories-show' => 'View Category Details',
                'admin-categories-edit' => 'Edit Category',
                'admin-categories-update' => 'Update Category',
                'admin-categories-destroy' => 'Delete Category',

                'admin-posts-index' => 'View Posts',
                'admin-posts-create' => 'Create Post',
                'admin-posts-store' => 'Store Post',
                'admin-posts-show' => 'View Post Details',
                'admin-posts-edit' => 'Edit Post',
                'admin-posts-update' => 'Update Post',
                'admin-posts-destroy' => 'Delete Post',

                'admin-quillUpload-store' => 'Upload Images to Editor',

                'admin-tags-index' => 'View Tags',
                'admin-tags-create' => 'Create Tag',
                'admin-tags-store' => 'Store Tag',
                'admin-tags-show' => 'View Tag Details',
                'admin-tags-edit' => 'Edit Tag',
                'admin-tags-update' => 'Update Tag',
                'admin-tags-destroy' => 'Delete Tag',
                'admin-tags-storeAjax' => 'Create Tag via AJAX',
                'admin-tags-options' => 'Get Tag Options',

            // CMS Permissions
                'cms-home-edit' => 'Edit Home Page',
                'cms-home-update' => 'Update Home Page',

                'cms-index' => 'View CMS Pages',
                'cms-create' => 'Create CMS Page',
                'cms-store' => 'Store CMS Page',
                'cms-show' => 'View CMS Page Details',
                'cms-edit' => 'Edit CMS Page',
                'cms-update' => 'Update CMS Page',
                'cms-destroy' => 'Delete CMS Page',

                'menus-index' => 'View Menus',
                'menus-create' => 'Create Menu',
                'menus-store' => 'Store Menu',
                'menus-show' => 'View Menu Details',
                'menus-edit' => 'Edit Menu',
                'menus-update' => 'Update Menu',
                'menus-destroy' => 'Delete Menu',

            // Doctor Permissions
                'admin-dashboard' => 'View Dashboard',

                'admin-clinic-index' => 'View Clinic',
                'admin-clinic-store' => 'Store Clinic Information',
                'admin-clinic-update' => 'Update Clinic Information',

                'admin-patients-index' => 'View Patients',
                'admin-patients-store' => 'Create Patient',
                'admin-patients-update' => 'Update Patient',
                'admin-patients-show' => 'View Patient Details',
                'admin-patients-downloadVCard' => 'Download Patient VCard',

                'admin-medicalTest-index' => 'View Medical Tests',
                'admin-medicalTest-store' => 'Create Medical Test',
                'admin-medicalTest-update' => 'Update Medical Test',

                'admin-medicine-index' => 'View Medicines',
                'admin-medicine-store' => 'Create Medicine',
                'admin-medicine-update' => 'Update Medicine',


                'admin-vitalSign-index' => 'View Vital Signs',
                'admin-vitalSign-store' => 'Create Vital Sign',
                'admin-vitalSign-update' => 'Update Vital Sign',

                'admin-finalDiagnosis-index' => 'View Final Diagnoses',
                'admin-finalDiagnosis-store' => 'Create Final Diagnosis',
                'admin-finalDiagnosis-update' => 'Update Final Diagnosis',

                'admin-dosageForm-index' => 'View Dosage Forms',
                'admin-dosageForm-store' => 'Create Dosage Form',
                'admin-dosageForm-update' => 'Update Dosage Form',

                'admin-medicalExamination-create' => 'Create Medical Examination',
                'admin-medicalExamination-store' => 'Store Medical Examination',
                'admin-medicalExamination-submit' => 'Submit Medical Examination',
                'admin-medicalExamination-show' => 'View Medical Examination',
                'admin-medicalExamination-index' => 'View Medical Examinations',

                'admin-uploadFile-index' => 'Upload Files',
                'admin-uploadFile-delete' => 'Delete Files',

                'admin-pdf-downloadMedicines' => 'Download Medicines PDF',
                'admin-pdf-downloadMedicalTest' => 'Download Medical Test PDF',
                'admin-pdf-downloadMedicinesPharmacy' => 'Download Pharmacy Medicines PDF',

            // Portfolio Permissions
                'admin-portfolios-index' => 'View Portfolios',
                'admin-portfolios-create' => 'Create Portfolio',
                'admin-portfolios-store' => 'Store Portfolio',
                'admin-portfolios-show' => 'View Portfolio Details',
                'admin-portfolios-edit' => 'Edit Portfolio',
                'admin-portfolios-update' => 'Update Portfolio',
                'admin-portfolios-destroy' => 'Delete Portfolio',
                'admin-portfolios-toggle-status' => 'Toggle Portfolio Status',
                'admin-portfolios-toggle-featured' => 'Toggle Featured Portfolio',
                'admin-portfolios-duplicate' => 'Duplicate Portfolio',
                'admin-portfolios-reorder' => 'Reorder Portfolios',
                'admin-portfolios-delete-gallery' => 'Delete Gallery Image',

            // Panel management
                'admin-panels-sort' => 'Sort Panels',
                'admin-panel-items-sort' => 'Sort Panel Items',

            // CMS Panel CRUD
                'cms-panels-forPage' => 'View Panels for Page',
                'cms-panels-store' => 'Create Panel',
                'cms-panels-show' => 'View Panel Details',
                'cms-panels-update' => 'Update Panel',
                'cms-panels-destroy' => 'Delete Panel',
                'cms-panels-toggle' => 'Toggle Panel Visibility',
                'cms-panels-duplicate' => 'Duplicate Panel',
                'cms-panels-reorder' => 'Reorder Panels',

            // CMS Panel Items CRUD
                'cms-panel-items-store' => 'Create Panel Item',
                'cms-panel-items-show' => 'View Panel Item Details',
                'cms-panel-items-update' => 'Update Panel Item',
                'cms-panel-items-destroy' => 'Delete Panel Item',

            // Notification / push config
                'admin-notification-configs' => 'View Notification Settings',
                'admin-notification-update' => 'Update Notification Settings',

            // SEO
                'admin-seo-index' => 'View SEO Settings',
                'admin-seo-update' => 'Update SEO Settings',

            // Theme settings
                'admin-theme_settings-index' => 'View Theme Settings',
                'admin-theme_settings-update' => 'Update Theme Settings',
        ],
        'sections' => [
                'admin' => 'Admin Management',
                'audits' => 'Audits',
                'role_management' => 'Role Management',
                'user_management' => 'User Management',
                'categories' => 'Categories',
                'posts' => 'Posts',
                'tags' => 'Tags',
                'cms' => 'CMS',
                'menus' => 'Menus',
                'dashboard' => 'Dashboard',
                'portfolios' => 'Portfolios',
                'panels' => 'Panels',
                'panel-items' => 'Panel Items',
                'notification' => 'Notifications',
                'seo' => 'SEO',
                'theme_settings' => 'Theme Settings',
                'quillUpload' => 'Editor Uploads',
                'clinic' => 'Clinic',
                'patients' => 'Patients',
                'medicalTest' => 'Medical Tests',
                'medicine' => 'Medicines',
                'vitalSign' => 'Vital Signs',
                'finalDiagnosis' => 'Final Diagnoses',
                'dosageForm' => 'Dosage Forms',
                'medicalExamination' => 'Medical Examinations',
                'uploadFile' => 'File Upload',
                'pdf' => 'PDF Reports',
                'etc' => 'Other',
        ],
];
