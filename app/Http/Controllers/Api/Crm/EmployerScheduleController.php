<?php

namespace App\Http\Controllers\Api\Crm;

use App\Exceptions\Api\PermissionDeniedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Crm\EmployerScheduleApproveRequest;
use App\Http\Requests\Api\Crm\EmployerScheduleStoreRequest;
use App\Models\Employer;
use App\Models\EmployerSchedule;
use App\Repositories\EmployerRepository;
use App\Repositories\EmployerScheduleRepository;
use App\Repositories\PermissionRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EmployerScheduleController extends Controller
{
    public function get(EmployerRepository $employerRepository, $employerId)
    {
        if (!$employer = $employerRepository->find($employerId)) {
            throw new NotFoundHttpException();
        }

        return response()->json([
            'result' => 'success',
            'data'   => $employer->schedules,
        ]);
    }

    public function store(
        EmployerRepository $employerRepository,
        EmployerScheduleRepository $employerScheduleRepository,
        EmployerScheduleStoreRequest $request,
        $employerId
    ) {
        if (!$employer = $employerRepository->find($employerId)) {
            throw new NotFoundHttpException();
        }
        /** @var Employer $employer */

        $employerSchedule = $employerScheduleRepository->create([
            'employer_id'  => $employer->id,
            'equipment_id' => $request->equipment_id,
            'begin_at'     => new Carbon($request->begin_at),
            'end_at'       => new Carbon($request->end_at),
            'status'       => EmployerSchedule::STATUS_NEW,
        ]);

        return response()->json([
            'result' => 'success',
            'data'   => $employerSchedule,
        ]);
    }

    public function approve(
        PermissionRepository $permissionRepository,
        EmployerRepository $employerRepository,
        EmployerScheduleRepository $employerScheduleRepository,
        EmployerScheduleApproveRequest $request,
        $employerId,
        $employerScheduleId
    ) {
        if (!$employer = $employerRepository->find($employerId)) {
            throw new NotFoundHttpException();
        }

        if (!$permissionRepository->checkByUnitId($employer, Employer::class, 'schedule.approve', $request->unit_id)) {
            throw new PermissionDeniedException();
        }

        $employerScheduleRepository->approve($employer, $employerScheduleId, $request->unit_id);

        return response()->json([
            'result' => 'success',
        ]);
    }

    public function delete(
        EmployerRepository $employerRepository,
        EmployerScheduleRepository $employerScheduleRepository,
        $employerId,
        $employerScheduleId
    ) {
        if (!$employer = $employerRepository->find($employerId)) {
            throw new NotFoundHttpException();
        }

        /** @var Employer $employer */
        $employer->schedules()->find($employerScheduleId)->delete();

        return response()->json([
            'result' => 'success',
        ]);
    }
}
