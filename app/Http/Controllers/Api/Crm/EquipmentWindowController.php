<?php

namespace App\Http\Controllers\Api\Crm;

use App\Http\Requests\Api\Crm\EquipmentWindowStoreRequest;
use App\Repositories\EquipmentWindowRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EquipmentWindowController extends Controller
{

    protected $repository;

    public function __construct(EquipmentWindowRepository $equipmentWindowRepository)
    {
        $this->repository = $equipmentWindowRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $equipmentTypes = $this->repository->all();

        return response()->json([
            'result' => 'success',
            'data'   => [
                'items'   => $equipmentTypes,
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
     * @param EquipmentWindowStoreRequest|Request $request
     * @param $equipmentId
     * @return \Illuminate\Http\Response
     */
    public function store(EquipmentWindowStoreRequest $request, $equipmentId)
    {
        $data = $request->all();

        $data['equipment_id'] = $equipmentId;

        $equipmentType = $this->repository->create($data);

        return response()->json([
            'result' => 'success',
            'data'   => $equipmentType,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  integer $equipmentWindowId
     * @return \Illuminate\Http\Response
     */
    public function show($equipmentWindowId)
    {
        $equipmentType = $this->repository->find($equipmentWindowId);

        return response()->json([
            'result' => 'success',
            'data'   => $equipmentType,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  integer $equipmentWindowId
     * @return \Illuminate\Http\Response
     */
    public function edit($equipmentWindowId)
    {
        $equipmentType = $this->repository->find($equipmentWindowId);

        return response()->json([
            'result' => 'success',
            'data'   => [
                'form' => $this->getForm(),
                'item' => $equipmentType,
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EquipmentWindowStoreRequest|Request $request
     * @param  integer $equipmentWindowId
     * @return \Illuminate\Http\Response
     */
    public function update(EquipmentWindowStoreRequest $request, $equipmentWindowId)
    {
        $this->repository->update($request->all(), $equipmentWindowId);

        return response()->json([
            'result' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer $equipmentWindowId
     * @return \Illuminate\Http\Response
     */
    public function destroy($equipmentWindowId)
    {
        $this->repository->delete($equipmentWindowId);

        return response()->json([
            'result' => 'success',
        ]);
    }

    protected function getForm()
    {
        return [
            'begin_at' => [
                'title' => __('Начиная с'),
                'type'  => 'datetime',
            ],
            'schedule' => [
                'title' => __('Расписание'),
                'type'  => 'array',
            ],
        ];
    }
}
