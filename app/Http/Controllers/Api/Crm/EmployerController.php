<?php

namespace App\Http\Controllers\Api\Crm;

use App\Criteria\Api\Crm\EmployerCriteria;
use App\Http\Requests\Api\Crm\EmployerStoreRequest;
use App\Models\Service;
use App\Models\WorkPosition;
use App\Repositories\EmployerRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmployerController extends Controller
{
    protected $repository;

    public function __construct(EmployerRepository $employerRepository)
    {
        $this->repository = $employerRepository;
        $this->repository->pushCriteria(app(EmployerCriteria::class));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employers = $this->repository->all();

        return response()->json([
            'result' => 'success',
            'data'   => [
                'items'   => $employers,
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
     * @param EmployerStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployerStoreRequest $request)
    {
        $employer = $this->repository->create($request->all());

        return response()->json([
            'result' => 'success',
            'data'   => $employer,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  integer $employerId
     * @return \Illuminate\Http\Response
     */
    public function show($employerId)
    {
        $employer = $this->repository->find($employerId);

        return response()->json([
            'result' => 'success',
            'data'   => $employer,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  integer $employerId
     * @return \Illuminate\Http\Response
     */
    public function edit($employerId)
    {
        $employer = $this->repository->find($employerId);

        return response()->json([
            'result' => 'success',
            'data'   => [
                'form' => $this->getForm(),
                'item' => $employer,
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  integer $employerId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $employerId)
    {
        $employer = $this->repository->update($request->all(), $employerId);

        return response()->json([
            'result' => 'success',
            'data'   => $employer,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer $employerId
     * @return \Illuminate\Http\Response
     */
    public function destroy($employerId)
    {
        $this->repository->delete($employerId);

        return response()->json(['result' => 'success']);
    }


    /**
     * Return form for employer
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function form()
    {
        return response()->json([
            'result' => 'success',
            'data'   => [
                'form' => $this->getForm(),
            ]
        ]);
    }

    protected function getForm()
    {
        return [
            'name'             => [
                'title' => __('Имя'),
                'type'  => 'text',
            ],
            'work_position_id' => [
                'title'  => __('Должность'),
                'type'   => 'select'
            ],
            'services'         => [
                'title'  => __('Услуги'),
                'type'   => 'checkbox_list',
                'values' => Service::all()->pluck('title', 'id'),
            ],
        ];
    }
}
