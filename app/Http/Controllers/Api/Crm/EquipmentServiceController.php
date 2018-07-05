<?php


namespace App\Http\Controllers\Api\Crm;


use App\Exceptions\Api\UnknownException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Crm\EquipmentServiceStoreRequest;
use App\Models\Equipment;
use App\Repositories\EquipmentRepository;
use Illuminate\Http\Request;

class EquipmentServiceController extends Controller
{

    protected $repository;

    public function __construct(EquipmentRepository $equipmentRepository)
    {
        $this->repository = $equipmentRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($equipmentId)
    {
        /** @var Equipment $equipment */
        $equipment = $this->repository->with(['services', 'serviceCategories'])->find($equipmentId);

        return response()->json([
            'result' => 'success',
            'data'   => [
                'services'           => $equipment->services,
                'service_categories' => $equipment->serviceCategories,
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param EquipmentServiceStoreRequest|Request $request
     * @param $equipmentId
     * @return \Illuminate\Http\Response
     * @throws UnknownException
     */
    public function store(EquipmentServiceStoreRequest $request, $equipmentId)
    {
        /** @var Equipment $equipment */
        $equipment = $this->repository->find($equipmentId);

        switch ($request->type) {
            case 'category':
                $equipment->serviceCategories()->attach($request->id, [
                    'enabled' => $request->enabled,
                ]);
                break;
            case 'service':
                $equipment->services()->attach($request->id, [
                    'enabled' => $request->enabled,
                ]);
                break;
            default:
                throw new UnknownException('unknown type');
        }

        return response()->json([
            'result' => 'success',
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EquipmentServiceStoreRequest|Request $request
     * @param $equipmentId
     * @param $serviceId
     * @return \Illuminate\Http\Response
     * @throws UnknownException
     */
    public function update(EquipmentServiceStoreRequest $request, $equipmentId, $serviceId)
    {
        /** @var Equipment $equipment */
        $equipment = $this->repository->find($equipmentId);

        switch ($request->type) {
            case 'category':
                $equipment->serviceCategories()->updateExistingPivot($serviceId, [
                    'enabled' => $request->enabled,
                ]);
                break;
            case 'service':
                $equipment->services()->updateExistingPivot($serviceId, [
                    'enabled' => $request->enabled,
                ]);
                break;
            default:
                throw new UnknownException('unknown type');
        }

        return response()->json([
            'result' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param $equipmentId
     * @param $serviceId
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, $equipmentId, $serviceId)
    {
        /** @var Equipment $equipment */
        $equipment = $this->repository->find($equipmentId);

        switch ($request->type) {
            case 'category':
                $equipment->serviceCategories()->detach($serviceId);
                break;
            case 'service':
                $equipment->services()->detach($serviceId);
                break;
            default:
                throw new UnknownException('unknown type');
        }


        return response()->json([
            'result' => 'success',
        ]);
    }

}