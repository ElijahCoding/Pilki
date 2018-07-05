<?php

namespace App\Http\Controllers\Api\Crm;

use App\Http\Requests\Api\Crm\RegionStoreRequest;
use App\Models\Country;
use App\Models\Region;
use App\Http\Controllers\Controller;
use App\Repositories\CountryRepository;
use App\Repositories\RegionRepository;

/**
 * Region resource controller
 *
 * Class RegionController
 * @package App\Http\Controllers\Api
 */
class RegionController extends Controller
{

    protected $repository;

    public function __construct(RegionRepository $regionRepository)
    {
        $this->middleware(['super_user'])->except(['index', 'show']);

        $this->repository = $regionRepository;
    }

    /**
     * Return list of regions
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $regions = $this->repository->all();

        return response()->json([
            'result' => 'success',
            'data'   => [
                'items'   => $regions,
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
     * Create new region
     *
     * @param RegionStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RegionStoreRequest $request)
    {
        $region = $this->repository->create($request->all());

        return response()->json([
            'result' => 'success',
            'data'   => [
                'region' => $region,
            ],
        ]);
    }

    /**
     * Update region by ID
     *
     * @param integer $regionId
     * @param RegionStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($regionId, RegionStoreRequest $request)
    {
        $region = $this->repository->update($request->all(), $regionId);

        return response()->json([
            'result' => 'success',
            'data'   => $region,
        ]);
    }

    /**
     * @param $regionId
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($regionId)
    {
        return response()->json([
            'result' => 'success',
            'data'   => $this->repository->find($regionId),
        ]);
    }

    /**
     * @param $regionId
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($regionId)
    {
        return response()->json([
            'result' => 'success',
            'data'   => [
                'form' => $this->getForm(),
                'item' => $this->repository->find($regionId),
            ],
        ]);
    }

    /**
     * Delete country by ID
     *
     * @param integer $regionId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($regionId)
    {
        $this->repository->delete($regionId);

        return response()->json(['result' => 'success']);
    }

    protected function getForm()
    {
        $countryRepository = app(CountryRepository::class);

        return [
            'name'       => [
                'title' => __('Title'),
                'type'  => 'text',
            ],
            'country_id' => [
                'title'  => __('Country'),
                'type'   => 'select',
                'values' => $countryRepository->all(['id', 'name'])->pluck('name', 'id'),
            ],
        ];
    }
}
