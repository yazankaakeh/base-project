<?php

use Modules\AdminManagement\Enums\ActiveAdminEnum;

return [
        'ActiveAdminEnum' => [
                ActiveAdminEnum::ACTIVE->value => 'Active',
                ActiveAdminEnum::DE_ACTIVE->value => 'De Active',
        ],
        'user' => [
                'title' => 'User Management',
                'editUserStatus' => 'Edit User Status',
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
                        'name' => 'Name',
                        'guard' => 'Guard',
                        'allCheckBoxes' => 'allCheck Boxes',
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
                'doctor-categories-index' => 'View Categories',
                'doctor-categories-create' => 'Create Category',
                'doctor-categories-store' => 'Store Category',
                'doctor-categories-show' => 'View Category Details',
                'doctor-categories-edit' => 'Edit Category',
                'doctor-categories-update' => 'Update Category',
                'doctor-categories-destroy' => 'Delete Category',

                'doctor-posts-index' => 'View Posts',
                'doctor-posts-create' => 'Create Post',
                'doctor-posts-store' => 'Store Post',
                'doctor-posts-show' => 'View Post Details',
                'doctor-posts-edit' => 'Edit Post',
                'doctor-posts-update' => 'Update Post',
                'doctor-posts-destroy' => 'Delete Post',

                'doctor-quillUpload-store' => 'Upload Images to Editor',

                'doctor-tags-index' => 'View Tags',
                'doctor-tags-create' => 'Create Tag',
                'doctor-tags-store' => 'Store Tag',
                'doctor-tags-show' => 'View Tag Details',
                'doctor-tags-edit' => 'Edit Tag',
                'doctor-tags-update' => 'Update Tag',
                'doctor-tags-destroy' => 'Delete Tag',
                'doctor-tags-storeAjax' => 'Create Tag via AJAX',
                'doctor-tags-options' => 'Get Tag Options',

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
                'doctor-dashboard' => 'View Dashboard',

                'doctor-clinic-index' => 'View Clinic',
                'doctor-clinic-store' => 'Store Clinic Information',
                'doctor-clinic-update' => 'Update Clinic Information',

                'doctor-patients-index' => 'View Patients',
                'doctor-patients-store' => 'Create Patient',
                'doctor-patients-update' => 'Update Patient',
                'doctor-patients-show' => 'View Patient Details',
                'doctor-patients-downloadVCard' => 'Download Patient VCard',

                'doctor-medicalTest-index' => 'View Medical Tests',
                'doctor-medicalTest-store' => 'Create Medical Test',
                'doctor-medicalTest-update' => 'Update Medical Test',

                'doctor-medicine-index' => 'View Medicines',
                'doctor-medicine-store' => 'Create Medicine',
                'doctor-medicine-update' => 'Update Medicine',

                'doctor-medicalSpecialty-index' => 'View Medical Specialties',
                'doctor-medicalSpecialty-store' => 'Create Medical Specialty',
                'doctor-medicalSpecialty-update' => 'Update Medical Specialty',

                'doctor-vitalSign-index' => 'View Vital Signs',
                'doctor-vitalSign-store' => 'Create Vital Sign',
                'doctor-vitalSign-update' => 'Update Vital Sign',

                'doctor-finalDiagnosis-index' => 'View Final Diagnoses',
                'doctor-finalDiagnosis-store' => 'Create Final Diagnosis',
                'doctor-finalDiagnosis-update' => 'Update Final Diagnosis',

                'doctor-dosageForm-index' => 'View Dosage Forms',
                'doctor-dosageForm-store' => 'Create Dosage Form',
                'doctor-dosageForm-update' => 'Update Dosage Form',

                'doctor-medicalExamination-create' => 'Create Medical Examination',
                'doctor-medicalExamination-store' => 'Store Medical Examination',
                'doctor-medicalExamination-submit' => 'Submit Medical Examination',
                'doctor-medicalExamination-show' => 'View Medical Examination',
                'doctor-medicalExamination-index' => 'View Medical Examinations',

                'doctor-uploadFile-index' => 'Upload Files',
                'doctor-uploadFile-delete' => 'Delete Files',

                'doctor-pdf-downloadMedicines' => 'Download Medicines PDF',
                'doctor-pdf-downloadMedicalTest' => 'Download Medical Test PDF',
                'doctor-pdf-downloadMedicinesPharmacy' => 'Download Pharmacy Medicines PDF',
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
                'clinic' => 'Clinic',
                'patients' => 'Patients',
                'medicalTest' => 'Medical Tests',
                'medicine' => 'Medicines',
                'medicalSpecialty' => 'Medical Specialties',
                'vitalSign' => 'Vital Signs',
                'finalDiagnosis' => 'Final Diagnoses',
                'dosageForm' => 'Dosage Forms',
                'medicalExamination' => 'Medical Examinations',
                'uploadFile' => 'File Upload',
                'pdf' => 'PDF Reports',
        ],
];
