<?php

namespace Modules\UserManagement\app\Repository\User;

use Modules\UserManagement\app\Http\Requests\AdminRequest;
use Modules\UserManagement\app\Http\Requests\UpdateAdminRequest;
use Modules\UserManagement\app\Http\Requests\UpdateStatusAminRequest;

interface UserInterface
{

  public function index();

  public function store(AdminRequest $request);

  public function update(UpdateAdminRequest $request);

  public function activateDeActivate(UpdateStatusAminRequest $request);
}
