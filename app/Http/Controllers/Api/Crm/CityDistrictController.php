<?php

namespace App\Http\Controllers\Api\Crm;

use App\Http\Requests\Api\Crm\DistrictStoreRequest;
use App\Models\City;
use App\Http\Controllers\Controller;
use App\Repositories\CityDistrictRepository;
use App\Repositories\CityRepository;
use Illuminate\Http\Request;

class CityDistrictController extends Controller
{

    protected $repository;


    public function __construct(CityDistrictRepository $cityDistrictRepository)
    {
        $this->middleware(['super_user'])->except(['index', 'show']);

        $this->repository = $cityDistrictRepository;
    }

    /**
     * Return list of districs
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $cityDistricts = $this->repository->all();

        return response()->json([
            'result' => 'success',
            'data'   => [
                'items'   => $cityDistricts,
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
        return response()->json([
            'result' => 'success',
            'data'   => [
                'form' => $this->getForm(),
            ],
        ]);
    }

    /**
     * Create new district
     *
     * @param DistrictStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(DistrictStoreRequest $request)
    {
        $district = $this->repository->create($request->only(['name', 'city_id']));

        return response()->json([
            'result' => 'success',
            'data'   => $district,
        ]);
    }

    /**
     * Update district by ID
     *
     * @param integer $cityDistrictId
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($cityDistrictId, Request $request)
    {
        $cityDistrict = $this->repository->update($request->all(), $cityDistrictId);

        return response()->json([
            'result' => 'success',
            'data'   => $cityDistrict,
        ]);
    }

    /**
     * Get edit form
     *
     * @param integer $cityDistrictId
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($cityDistrictId)
    {
        return response()->json([
            'result' => 'success',
            'data'   => [
                'form' => $this->getForm(),
                'item' => $this->repository->find($cityDistrictId),
            ],
        ]);
    }

    /**
     * Delete district by ID
     *
     * @param integer $cityDistrictId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($cityDistrictId)
    {
        $this->repository->delete($cityDistrictId);

        return response()->json(['result' => 'success']);
    }

    protected function getForm()
    {
        $repositoryCity = app(CityRepository::class);

        return [
            'name'    => [
                'title' => __('Название'),
                'type'  => 'text',
            ],
            'city_id' => [
                'title'  => __('Город'),
                'type'   => 'select',
                'values' => $repositoryCity->all(['id', 'name'])->pluck('name', 'id'),
            ],
        ];
    }
}
