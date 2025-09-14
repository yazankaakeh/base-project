<?php

use Modules\Core\App\Enum\Gender;
use Modules\Core\app\Enums\UserStatusEnum;
use Modules\Doctor\Enums\ActiveClinic;
use Modules\Doctor\Enums\BloodType;
use Modules\Doctor\Enums\MaritalStatus;

return [
    'enum' => [
        'ActiveClinic' => [
            ActiveClinic::ACTIVE->value => 'Active',
            ActiveClinic::INACTIVE->value => 'Inactive',
        ],
        'UserStatusEnum' => [
            UserStatusEnum::ACTIVE->value => 'Active',
            UserStatusEnum::DEACTIVATE->value => 'Inactive',
        ],
        'Gender' => [
            Gender::MALE->value => 'Male',
            Gender::FEMALE->value => 'Female',
        ],
        'MaritalStatus' => [
            MaritalStatus::SINGLE->value => 'Single',
            MaritalStatus::MARRIED->value => 'Married',
            MaritalStatus::DIVORCED->value => 'Divorced',
        ],
        'BloodType' => [
            BloodType::A_POSITIVE->value => 'A Positive',
            BloodType::A_NEGATIVE->value => 'A Negative',
            BloodType::B_POSITIVE->value => 'B Positive',
            BloodType::B_NEGATIVE->value => 'B Negative',
            BloodType::AB_POSITIVE->value => 'AB Positive',
            BloodType::AB_NEGATIVE->value => 'AB Negative',
            BloodType::O_POSITIVE->value => 'O Positive',
            BloodType::O_NEGATIVE->value => 'O Negative',
        ],

    ],
    'patients' => [
        'nameTitle' => 'Patients',
        'name' => 'Name',
        'age' => 'Age',
        'minAge' => 'Min Age',
        'maxAge' => 'MaxAge',
        'gender' => 'Gender',
        'clinics' => 'Clinics',
        'children' => 'Children',
        'work' => 'Work',
        'blood_type' => 'Blood Type',
        'marital_status' => 'Marital Status',
        'nationality_id' => 'Nationality',
        'drug_allergies' => 'Drug Allergies',
        'disabilities' => 'Disabilities',
        'medical_history' => 'Medical History',
        'surgical_history' => 'Surgical History',
        'accident_history' => 'Accident History',
        'email' => 'Email',
        'password' => 'Password',
        'active' => 'Active',
        'createPatients' => 'Create Patient',
        'updatePatients' => 'Update Patient',
        'filterPatients' => 'Filter Patient',
    ],
    'clinic' => [
        'name' => 'Clinic name',
        'img' => 'Image',
        'createClinic' => 'Create Clinic',
        'updateClinic' => 'Update Clinic',
    ],
    'medicalTest' => [
        'name' => 'Medical Test name',
        'createMedicalTest' => 'Create Medical Test',
        'updateMedicalTest' => 'Update Medical Test',
    ],
    'medicine' => [
        'name' => 'Medicine name',
        'createMedicine' => 'Create Medicine',
        'updateMedicine' => 'Update Medicine',
    ],
    'medicalSpecialty' => [
        'name' => 'Medical specialty name',
        'createMedicalSpecialty' => 'Create Medical specialty',
        'updateMedicalSpecialty' => 'Update Medical specialty',
    ],
    'filter' => 'Filter',
    'close' => 'Close',
    'submit' => 'Submit',
    'save' => 'Save',
    'create' => 'Create',
    'pleaseSelectOne' => 'Please Select One',
    'id' => 'ID',
];
