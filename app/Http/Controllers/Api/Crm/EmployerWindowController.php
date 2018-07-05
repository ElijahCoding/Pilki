<?php

namespace App\Http\Controllers\Api\Crm;

use App\Http\Requests\Api\Crm\EmployerWindowStoreRequest;
use App\Repositories\EmployerWindowRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmployerWindowController extends Controller
{
    protected $repository;

    public function __construct(EmployerWindowRepository $equipmentWindowRepository)
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
     * @param EmployerWindowStoreRequest|Request $request
     * @param $employerId
     * @return \Illuminate\Http\Response
     */
    public function store(EmployerWindowStoreRequest $request, $employerId)
    {
        $data = $request->all();

        $data['employer_id'] = $employerId;

        $equipmentType = $this->repository->create($data);

        return response()->json([
            'result' => 'success',
            'data'   => $equipmentType,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  integer $equipmentTypeId
     * @return \Illuminate\Http\Response
     */
    public function show($equipmentTypeId)
    {
        $equipmentType = $this->repository->find($equipmentTypeId);

        return response()->json([
            'result' => 'success',
            'data'   => $equipmentType,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  integer $equipmentTypeId
     * @return \Illuminate\Http\Response
     */
    public function edit($equipmentTypeId)
    {
        $equipmentType = $this->repository->find($equipmentTypeId);

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
     * @param EmployerWindowStoreRequest|Request $request
     * @param  integer $equipmentTypeId
     * @return \Illuminate\Http\Response
     */
    public function update(EmployerWindowStoreRequest $request, $equipmentTypeId)
    {
        $this->repository->update($request->all(), $equipmentTypeId);

        return response()->json([
            'result' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer $equipmentTypeId
     * @return \Illuminate\Http\Response
     */
    public function destroy($equipmentTypeId)
    {
        $this->repository->delete($equipmentTypeId);

        return response()->json([
            'result' => 'success',
        ]);
    }

    protected function getForm()
    {
        return [
            'service_category_id' => [
                'title'  => __('Категория услуг'),
                'type'   => 'select',
                'values' => [],
            ],
            'begin_at'            => [
                'title' => __('Начиная с'),
                'type'  => 'datetime',
            ],
            'schedule'            => [
                'title' => __('Расписание'),
                'type'  => 'array',
            ],
        ];
    }
}
