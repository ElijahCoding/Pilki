<?php

namespace App\Http\Controllers\Api\Crm;

use App\Http\Requests\Api\Crm\ServiceStoreRequest;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Repositories\ServiceCategoryRepository;
use App\Repositories\ServiceRepository;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    protected $repository;

    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->repository = $serviceRepository;
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
     * @param ServiceStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceStoreRequest $request)
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
     * @param ServiceStoreRequest|Request $request
     * @param  integer $serviceId
     * @return \Illuminate\Http\Response
     * @throws AuthenticationException
     */
    public function update(ServiceStoreRequest $request, $serviceId)
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

    /**
     * Return form for service
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
            'service_category_id' => [
                'title'  => __('Категория'),
                'type'   => 'select'
            ],
            'title'               => [
                'title'     => __('Название'),
                'type'      => 'text',
                'translate' => true,
                'required' => true
            ],
            'title_online'        => [
                'title'     => __('Название для онлайн'),
                'type'      => 'text',
                'translate' => true,
            ],
            'title_cashier'       => [
                'title'     => __('Название для чека'),
                'type'      => 'text',
                'translate' => true,
            ],
            'article'             => [
                'article' => __('Артикул'),
                'type'    => 'text',
            ],
            'barcode'             => [
                'article' => __('Штрихкод'),
                'type'    => 'text',
            ],
        ];
    }
}
