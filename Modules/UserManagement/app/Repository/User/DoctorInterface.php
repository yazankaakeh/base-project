<?php

namespace Modules\UserManagement\app\Repository\User;

use Modules\UserManagement\app\Http\Requests\DoctorRequest;
use Modules\UserManagement\app\Http\Requests\UpdateDoctorRequest;
use Modules\UserManagement\app\Http\Requests\UpdateStatusAminRequest;

interface DoctorInterface
{

    public function index();

    public function store(DoctorRequest $request);

    public function update(UpdateDoctorRequest $request);

    public function activateDeActivate(UpdateStatusAminRequest $request);
}
