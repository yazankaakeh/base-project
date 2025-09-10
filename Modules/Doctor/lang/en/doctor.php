<?php

use Modules\Doctor\Enums\ActiveClinic;

return [
    'enum' => [
        'ActiveClinic' => [
            ActiveClinic::ACTIVE->value => 'Active',
            ActiveClinic::INACTIVE->value => 'Inactive',
        ],
    ],
    'patients' => [
        'name' => 'Patients',
        'createPatients' => 'Create Patient',
        'updatePatients' => 'Update Patient',
    ],
    'clinic' => [
        'name' => 'Clinic name',
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
