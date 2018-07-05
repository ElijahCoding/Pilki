<?php

namespace App\Http\Controllers\Api\Crm;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Crm\WorkPositionServiceRequest;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\WorkPosition;
use App\Repositories\WorkPositionRepository;
use App\Repositories\WorkPositionServiceRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class WorkPositionServiceController extends Controller
{
    protected $workPositionRepository;
    protected $workPositionServiceRepository;
    protected $serviceRepository;

    public function __construct(WorkPositionRepository $workPositionRepository,
                                WorkPositionServiceRepository $workPositionServiceRepository)
    {
        $this->workPositionRepository = $workPositionRepository;
        $this->workPositionServiceRepository = $workPositionServiceRepository;
    }

    /**
     * Get work position services
     *
     * @param integer $workPositionId
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(
        $workPositionId
    )
    {
        $workPosition = $this->workPositionRepository->find($workPositionId);
        $workPosition->load('service.service');

        return response()->json([
            'result' => 'success',
            'data' => $workPosition
        ]);
    }


    /**
     * Return information for create form
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        return response()->json([
            'result' => 'success',
            'data'   => [
                'form' => $this->getForm(),
            ],
        ]);
    }

    /**
     * Create new relation between (work position) and (service or service category)
     *
     * @param WorkPositionServiceRequest $request
     * @param integer $workPositionId
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(WorkPositionServiceRequest $request, $workPositionId)
    {
        $workPositionService = $this->workPositionServiceRepository->create([
                'service_id' => $request->service_id,
                'service_type' => $this->_getServiceType($request->type),
                'work_position_id' => $workPositionId,
            ]
        );
        return response()->json([
            'result' => 'success',
            'data'   => $workPositionService->service
        ]);
    }

    private function _getServiceType($type)
    {
        return ($type === 'category') ? ServiceCategory::class : Service::class;
    }

    /**
     * Remove relation between (work position) and (service or service category)
     *
     * @param  WorkPositionServiceRequest $request
     * @param  integer $workPositionId
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(WorkPositionServiceRequest $request, $workPositionId) {
        $workPosition = $this->workPositionRepository->find($workPositionId);
        if (!$workPosition) {
            throw new NotFoundHttpException();
        }

        $workPosition->load('service.service');

        // TODO refactor
        $service = $workPosition->service()
            ->where('service_id', $request->service_id)
            ->where('service_type', $this->_getServiceType($request->type))
            ->first();
        if ($service) $service->delete();

        return response()->json([
            'result' => 'success'
        ]);
    }

    /**
     * Return information for create form
     *
     * @return array
     */
    protected function getForm()
    {
        return [
            'work_position_id' => [
                'title'  => __('Должность'),
                'type'   => 'select',
                'values' => WorkPosition::all()->pluck('title', 'id'),
            ],
            'category' => [
                'title'  => ('Тип сервиса'),
                'type'   => 'select',
                'values' =>
                [
                    'category',
                    'service',
                ]
            ],
            'service_id' => [
                'title'  => __('Cервис'),
                'type'   => 'select',
            ],
        ];
    }
}