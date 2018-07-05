<?php

namespace App\Repositories;

use App\Exceptions\Api\Employer\Schedule\AlreadyApprovedException;
use App\Exceptions\Api\Employer\Schedule\EquipmentWindowEmptyException;
use App\Exceptions\Api\Employer\Schedule\TooSmallException;
use App\Models\Employer;
use App\Models\EmployerWindow;
use App\Models\Equipment;
use App\Models\EquipmentWindow;
use App\Models\Window;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\EmployerSchedule;

/**
 * Class EmployerScheduleRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EmployerScheduleRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return EmployerSchedule::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
    }


    /**
     * Approve schedule
     *
     * @param Employer $employer
     * @param integer $scheduleId
     * @param integer $unitId
     * @return bool
     * @throws \Exception
     */
    public function approve(Employer $employer, $scheduleId, $unitId)
    {
        $windowRepository = app(WindowRepository::class);

        \DB::beginTransaction();
        try {

            /** @var EmployerSchedule $employerSchedule */
            $employerSchedule = $this->find($scheduleId);

            if ($employerSchedule->status === EmployerSchedule::STATUS_APPROVED) {
                throw new AlreadyApprovedException();
            }

            $employerSchedule->unit_id = $unitId;
            $employerSchedule->status = EmployerSchedule::STATUS_APPROVED;
            $employerSchedule->save();

            switch ($employer->schedule_type) {
                case Employer::SCHEDULE_TYPE_WINDOW_INDIVIDUAL:
                    $employerWindow = EmployerWindow::query()
                        ->where('begin_at', '>=', $employerSchedule->begin_at)
                        ->where(function (Builder $query) use ($employerSchedule) {
                            return $query
                                ->where('end_at', '<=', $employerSchedule->end_at)
                                ->orWhereNull('end_at');
                        })
                        ->orderBy('begin_at', 'desc')
                        ->limit(1)
                        ->first();

                    if ($employerWindow) {
                        $windowSchedule = collect($employerWindow->schedule);
                    } else {
                        $equipmentWindow = EquipmentWindow::query()
                            ->where('begin_at', '>=', $employerSchedule->begin_at)
                            ->where('equipment_id', $employerSchedule->equipment_id)
                            ->orderBy('begin_at', 'desc')
                            ->limit(1)
                            ->first();

                        $windowSchedule = collect($equipmentWindow->schedule);
                    }

                    break;
                case Employer::SCHEDULE_TYPE_WINDOW_DEFAULT:
                    $equipmentWindow = EquipmentWindow::query()
                        ->where('begin_at', '>=', $employerSchedule->begin_at)
                        ->where('equipment_id', $employerSchedule->equipment_id)
                        ->orderBy('begin_at', 'desc')
                        ->limit(1)
                        ->first();


                    $windowSchedule = collect($equipmentWindow->schedule);

                    break;
            }

            if (empty($windowSchedule)) {
                throw new EquipmentWindowEmptyException();
            }

            /** @var Carbon $currentScheduledTime */
            $currentScheduledTime = clone $employerSchedule->begin_at;

            /** @var Window|null $lastWindow */
            $lastWindow = null;

            $employerCategoryAliases = $employer->employerCategory->aliases;
            while (true) {

                foreach ($windowSchedule as $scheduleOriginal) {

                    if (!empty($employerCategoryAliases) && isset($employerCategoryAliases[$scheduleOriginal])) {
                        $schedule = $employerCategoryAliases[$scheduleOriginal];
                    } else {
                        $schedule = $scheduleOriginal;
                    }

                    $startTimeAt = clone $currentScheduledTime;

                    $currentScheduledTime->addSeconds($schedule);
                    if ($currentScheduledTime->gt($employerSchedule->end_at)) {
                        if (is_null($lastWindow)) {
                            throw new TooSmallException();
                        }

                        $remainingTime = $employerSchedule->end_at->timestamp - $lastWindow->end_at->timestamp;

                        $availableWindow = $windowSchedule->filter(
                            function ($item) use ($employerCategoryAliases, $remainingTime) {
                                return isset($employerCategoryAliases[$item]) ? ($employerCategoryAliases[$item] <= $remainingTime) : ($item <= $remainingTime);
                            }
                        );

                        if ($availableWindow->count()) {
                            $windowRepository->create([
                                'unit_id'           => $employerSchedule->equipment->unit_id,
                                'employer_id'       => $employer->id,
                                'equipment_id'      => $employerSchedule->equipment_id,
                                'booking_id'        => null,
                                'begin_at'          => $startTimeAt,
                                'end_at'            => $employerSchedule->end_at,
                                'duration_original' => $scheduleOriginal,
                                'duration'          => $schedule,
                            ]);
                        } else {
                            $lastWindow->update([
                                'end_at' => $employerSchedule->end_at,
                            ]);
                        }

                        break 2;
                    }


                    $lastWindow = $windowRepository->create([
                        'unit_id'           => $employerSchedule->equipment->unit_id,
                        'employer_id'       => $employer->id,
                        'equipment_id'      => $employerSchedule->equipment_id,
                        'booking_id'        => null,
                        'begin_at'          => $startTimeAt,
                        'end_at'            => $currentScheduledTime,
                        'duration_original' => $scheduleOriginal,
                        'duration'          => $schedule,
                    ]);

                }

            }


            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

    }

}
