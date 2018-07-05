<?php

namespace App\Http\Controllers\Api\Crm;

use App\Http\Requests\Api\Crm\CountryStoreRequest;
use App\Models\Country;
use App\Http\Controllers\Controller;
use App\Repositories\CountryRepository;
use Illuminate\Http\Request;

/**
 * Country resource controller
 *
 * Class CountryController
 * @package App\Http\Controllers\Api
 */
class CountryController extends Controller
{
    protected $repository;

    public function __construct(CountryRepository $countryRepository)
    {
        $this->middleware(['super_user'])->except(['index', 'show']);

        $this->repository = $countryRepository;
    }

    /**
     * Return list of coutries
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $countries = $this->repository->all();

        return response()->json([
            'result' => 'success',
            'data'   => [
                'items'   => $countries,
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
     * Create new country
     *
     * @param CountryStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CountryStoreRequest $request)
    {
        $country = $this->repository->create($request->all());

        return response()->json([
            'result' => 'success',
            'data'   => $country,
        ]);
    }

    /**
     * Display country.
     *
     * @param  integer $countryId
     * @return \Illuminate\Http\Response
     */
    public function show($countryId)
    {
        return response()->json([
            'result' => 'success',
            'data'   => $this->repository->find($countryId),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  integer $countryId
     * @return \Illuminate\Http\Response
     */
    public function edit($countryId)
    {
        return response()->json([
            'result' => 'success',
            'data'   => [
                'form' => $this->getForm(),
                'item' => $this->repository->find($countryId),
            ],
        ]);
    }

    /**
     * Update country by ID
     *
     * @param integer $countryId
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($countryId, Request $request)
    {
        $country = $this->repository->update($request->all(), $countryId);

        return response()->json([
            'result' => 'success',
            'data'   => $country,
        ]);
    }

    /**
     * Delete country bu ID
     *
     * @param integer $countryId
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($countryId, Request $request)
    {
        $this->repository->delete($countryId);

        return response()->json(['result' => 'success']);
    }

    protected function getForm()
    {
        return [
            'name'     => [
                'title' => __('Название'),
                'type'  => 'text',
            ],
            'currency' => [
                'title'  => __('Валюта'),
                'type'   => 'select',
                'values' => [
                    'rub' => __('RUB'),
                    'usd' => __('USD'),
                ],
            ],
        ];
    }
}
