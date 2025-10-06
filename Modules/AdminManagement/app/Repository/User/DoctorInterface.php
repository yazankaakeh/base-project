<?php

namespace Modules\AdminManagement\app\Repository\User;

use Modules\AdminManagement\app\Http\Requests\DoctorRequest;
use Modules\AdminManagement\app\Http\Requests\UpdateDoctorRequest;
use Modules\AdminManagement\app\Http\Requests\UpdateStatusAminRequest;

interface DoctorInterface
{

    public function index();

    public function store(DoctorRequest $request);

    public function update(UpdateDoctorRequest $request);

    public function activateDeActivate(UpdateStatusAminRequest $request);
}
