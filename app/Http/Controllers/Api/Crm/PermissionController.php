<?php

namespace App\Http\Controllers\Api\Crm;

use App\Models\EmployerRelPermission;
use App\Models\Permission;
use App\Repositories\PermissionGroupRepository;
use App\Repositories\PermissionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    protected $repository;

    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->repository = $permissionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'result' => 'success',
            'data'   => [
                'items'   => $this->repository->getPermissions(),
                'filters' => $this->repository->getFieldsSearchable(),
            ],
        ]);
    }

    public function groups(PermissionGroupRepository $permissionGroupRepository)
    {
        return response()->json([
            'result' => 'success',
            'data'   => $permissionGroupRepository->all(),
        ]);
    }

    public function accessTypes()
    {
        return response()->json([
            'result' => 'success',
            'data'   => EmployerRelPermission::$accessTypes,
        ]);
    }

}
