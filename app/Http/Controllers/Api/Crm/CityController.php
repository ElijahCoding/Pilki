<?php

namespace App\Http\Controllers\Api\Crm;

use App\Http\Requests\Api\Crm\CityStoreRequest;
use App\Models\City;
use App\Http\Controllers\Controller;
use App\Models\Region;
use App\Repositories\CityRepository;
use App\Repositories\RegionRepository;
use Illuminate\Http\Request;

class CityController extends Controller
{

    protected $repository;


    public function __construct(CityRepository $cityRepository)
    {
        $this->middleware(['super_user'])->except(['index', 'show']);

        $this->repository = $cityRepository;
    }

    /**
     * Return list of cities
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $cities = $this->repository->all();

        return response()->json([
            'result' => 'success',
            'data'   => [
                'items' => $cities,
                'filters' => $this->repository->getFieldsSearchable(),
            ],
        ]);
    }

    /**
     * Return information for create form
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        $this->authorize('create', City::class);

        return response()->json([
            'result' => 'success',
            'data'   => [
                'form' => $this->getForm(),
            ],
        ]);
    }

    /**
     * Create new city
     *
     * @param CityStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CityStoreRequest $request)
    {
        $city = $this->repository->create($request->only(['name', 'region_id']));

        return response()->json([
            'result' => 'success',
            'data'   => $city,
        ]);
    }

    /**
     * Update city by ID
     *
     * @param integer $cityId
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($cityId, Request $request)
    {
        $city = $this->repository->update($request->all(), $cityId);

        return response()->json([
            'result' => 'success',
            'data'   => $city,
        ]);
    }

    /**
     * Edit form for city
     *
     * @param integer $cityId
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($cityId)
    {
        return response()->json([
            'result' => 'success',
            'data'   => [
                'form' => $this->getForm(),
                'item' => $this->repository->find($cityId),
            ],
        ]);
    }

    /**
     * Delete city by ID
     *
     * @param integer $cityId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($cityId)
    {
        $this->repository->delete($cityId);

        return response()->json(['result' => 'success']);
    }

    protected function getForm()
    {
        $repositoryRegion = app(RegionRepository::class);

        return [
            'name'      => [
                'title' => __('Название'),
                'type'  => 'text',
            ],
            'region_id' => [
                'title'  => __('Регион'),
                'type'   => 'select',
                'values' => $repositoryRegion->all(['id', 'name'])->pluck('name', 'id'),
            ],
        ];
    }
}
