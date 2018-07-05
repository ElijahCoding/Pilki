<?php

namespace App\Http\Controllers\Api\Crm;

use App\Http\Requests\Api\Crm\EquipmentStoreRequest;
use App\Http\Requests\Api\Crm\EquipmentUpdateRequest;
use App\Models\Equipment;
use App\Repositories\EquipmentRepository;
use App\Repositories\EquipmentTypeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EquipmentController extends Controller
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
    public function index()
    {
        return response()->json([
            'result' => 'success',
            'data'   => [
                'items'   => $this->repository->all(),
                'filters' => $this->repository->getFieldsSearchable(),
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
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
     * Store a newly created resource in storage.
     *
     * @param EquipmentStoreRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(EquipmentStoreRequest $request)
    {
        $equipment = $this->repository->create($request->all());

        return response()->json([
            'result' => 'success',
            'data'   => $equipment,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  integer $equipmentId
     * @return \Illuminate\Http\Response
     */
    public function show($equipmentId)
    {
        $equipment = $this->repository->find($equipmentId);

        return response()->json([
            'result' => 'success',
            'data'   => $equipment,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  integer $equipmentId
     * @return \Illuminate\Http\Response
     */
    public function edit($equipmentId)
    {
        $equipment = $this->repository->find($equipmentId);

        return response()->json([
            'result' => 'success',
            'data'   => [
                'form' => $this->getForm(),
                'item' => $equipment,
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EquipmentUpdateRequest|Request $request
     * @param  integer $equipmentId
     * @return \Illuminate\Http\Response
     */
    public function update(EquipmentUpdateRequest $request, $equipmentId)
    {
        $this->repository->update($request->all(), $equipmentId);

        return response()->json([
            'result' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer $equipmentId
     * @return \Illuminate\Http\Response
     */
    public function destroy($equipmentId)
    {
        $this->repository->delete($equipmentId);

        return response()->json([
            'result' => 'success',
        ]);
    }

    protected function getForm()
    {

        return [
            'title'   => [
                'title' => __('Название'),
                'type'  => 'text',
            ],
            'comment' => [
                'title' => __('Комментарий'),
                'type'  => 'text',
            ],
            'status'  => [
                'title'  => __('Статус'),
                'type'   => 'select',
                'values' => Equipment::getStatuses(),
            ],
        ];
    }
}
