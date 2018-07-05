<?php


namespace App\Http\Controllers\Api\Crm;


use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Crm\EmployerPermissionRequest;
use App\Http\Requests\Api\Crm\PermissionSaveRequest;
use App\Repositories\EmployerRepository;
use App\Repositories\PermissionRepository;

class EmployerPermissionController extends Controller
{

    protected $employerRepository;

    public function __construct(EmployerRepository $employerRepository)
    {
        $this->employerRepository = $employerRepository;
    }

    /**
     * Get employer permissions
     *
     * @param PermissionRepository $permissionRepository
     * @param EmployerPermissionRequest $request
     * @param integer $employerId
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(
        PermissionRepository $permissionRepository,
        EmployerPermissionRequest $request,
        $employerId
    ) {
        $employer = $this->employerRepository->find($employerId);

        $permissions = $permissionRepository->getAccess($employer);

        if ($request->full) {
            $data = $permissions;
        } else {
            $data = array_keys($permissions['units'] + $permissions['legalEntity']);
        }

        return response()->json([
            'result' => 'success',
            'data'   => $data,
        ]);
    }

    public function set(
        PermissionRepository $permissionRepository,
        PermissionSaveRequest $request,
        $employerId
    ) {
        $employer = $this->employerRepository->find($employerId);

        $permissionRepository->savePermission(
            $employer,
            $request->access_type,
            $request->access_id,
            $request->permission_type,
            $request->permission_id
        );

        return response()->json([
            'result' => 'success',
        ]);
    }
}