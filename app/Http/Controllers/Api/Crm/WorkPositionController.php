<?php

namespace App\Http\Controllers\Api\Crm;

use App\Repositories\WorkPositionRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WorkPositionController extends Controller
{
    protected $repository;

    public function __construct(WorkPositionRepository $workPositionRepository)
    {
        $this->repository = $workPositionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $audits = $this->repository->all();

        return response()->json([
            'result' => 'success',
            'data'   => [
                'items'   => $audits,
                'filters' => $this->repository->getFieldsSearchable(),
            ],
        ]);
    }

    /**
     *
     * @param  integer $workPositionId
     * @return \Illuminate\Http\Response
     */
    public function show($workPositionId)
    {
        $workPosition = $this->repository->find($workPositionId);

        return response()->json([
            'result' => 'success',
            'data'   => $workPosition,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  integer $workPositionId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $workPositionId)
    {
        $workPosition = $this->repository->update($request->all(), $workPositionId);

        return response()->json([
            'result' => 'success',
            'data'   => $workPosition,
        ]);
    }

    /**
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $workPosition = $this->repository->create($request->all());

        return response()->json([
            'result' => 'success',
            'data'   => $workPosition,
        ]);
    }
}
