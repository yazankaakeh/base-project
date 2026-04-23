<?php

namespace Modules\AdminManagement\Repository\User;

use Modules\AdminManagement\Http\Requests\DoctorRequest;
use Modules\AdminManagement\Http\Requests\UpdateDoctorRequest;
use Modules\AdminManagement\Http\Requests\UpdateStatusAminRequest;

interface DoctorInterface
{
    /**
     * @param array{q?: ?string, role?: mixed, status?: mixed} $filters
     */
    public function index(array $filters = []);

    public function store(DoctorRequest $request);

    public function update(UpdateDoctorRequest $request);

    public function activateDeActivate(UpdateStatusAminRequest $request);
}
