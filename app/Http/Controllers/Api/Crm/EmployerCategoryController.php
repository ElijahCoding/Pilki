<?php

namespace App\Http\Controllers\Api\Crm;

use App\Http\Requests\Api\Crm\EmployerCategoryStoreRequest;
use App\Repositories\EmployerCategoryRepository;
use App\Repositories\ServiceCategoryRepository;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmployerCategoryController extends Controller
{
    protected $repository;

    public function __construct(EmployerCategoryRepository $employerCategoryRepository)
    {
        $this->repository = $employerCategoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = $this->repository->all();

        return response()->json([
            'result' => 'success',
            'data'   => [
                'items'   => $services,
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
     * @param EmployerCategoryStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployerCategoryStoreRequest $request)
    {
        $service = $this->repository->create($request->all());

        return response()->json([
            'result' => 'success',
            'data'   => $service,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  integer $serviceId
     * @return \Illuminate\Http\Response
     */
    public function show($serviceId)
    {
        $service = $this->repository->find($serviceId);

        return response()->json([
            'result' => 'success',
            'data'   => $service,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  integer $serviceId
     * @return \Illuminate\Http\Response
     */
    public function edit($serviceId)
    {
        $service = $this->repository->find($serviceId);

        return response()->json([
            'result' => 'success',
            'data'   => [
                'form' => $this->getForm(),
                'item' => $service,
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EmployerCategoryStoreRequest|Request $request
     * @param  integer $serviceId
     * @return \Illuminate\Http\Response
     * @throws AuthenticationException
     */
    public function update(EmployerCategoryStoreRequest $request, $serviceId)
    {
        $data = $request->all();

        $this->repository->update($data, $serviceId);

        return response()->json([
            'result' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer $serviceId
     * @return \Illuminate\Http\Response
     */
    public function destroy($serviceId)
    {
        $this->repository->delete($serviceId);

        return response()->json([
            'result' => 'success',
        ]);
    }

    protected function getForm()
    {
        $repositoryServiceCategory = app(ServiceCategoryRepository::class);

        return [
            'title'   => [
                'title' => __('Название'),
                'type'  => 'text',
            ],
            'aliases' => [
                'title' => __('Сопоставления'),
                'type'  => 'key_value',
            ],
        ];
    }
}
