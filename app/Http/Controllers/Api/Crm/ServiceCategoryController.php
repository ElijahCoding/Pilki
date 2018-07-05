<?php

namespace App\Http\Controllers\Api\Crm;

use App\Http\Requests\Api\Crm\ServiceCategoryStoreRequest;
use App\Models\ServiceCategory;
use App\Repositories\ServiceCategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceCategoryController extends Controller
{
    protected $repository;

    public function __construct(ServiceCategoryRepository $serviceCategoryRepository)
    {
        $this->repository = $serviceCategoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $serviceCategories = $this->repository->with(['services'])
            ->all();

        return response()->json([
            'result' => 'success',
            'data'   => [
                'items'   => $serviceCategories,
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
     * @param ServiceCategoryStoreRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceCategoryStoreRequest $request)
    {
        $serviceCategory = $this->repository->create($request->all());

        return response()->json([
            'result' => 'success',
            'data'   => $serviceCategory,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  integer $serviceCategoryId
     * @return \Illuminate\Http\Response
     */
    public function show($serviceCategoryId)
    {
        $serviceCategory = $this->repository->find($serviceCategoryId);

        return response()->json([
            'result' => 'success',
            'data'   => $serviceCategory,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  integer $serviceCategoryId
     * @return \Illuminate\Http\Response
     */
    public function edit($serviceCategoryId)
    {
        $serviceCategory = $this->repository->find($serviceCategoryId);

        return response()->json([
            'result' => 'success',
            'data'   => [
                'form' => $this->getForm(),
                'item' => $serviceCategory,
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ServiceCategoryStoreRequest|Request $request
     * @param  integer $serviceCategoryId
     * @return \Illuminate\Http\Response
     */
    public function update(ServiceCategoryStoreRequest $request, $serviceCategoryId)
    {
        $this->repository->update($request->all(), $serviceCategoryId);

        return response()->json([
            'result' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer $serviceCategoryId
     * @return \Illuminate\Http\Response
     */
    public function destroy($serviceCategoryId)
    {
        $this->repository->delete($serviceCategoryId);

        return response()->json([
            'result' => 'success',
        ]);
    }

    protected function getForm()
    {
        return [
            'title' => [
                'title' => __('Название'),
                'type'  => 'text',
            ],
        ];
    }
}
