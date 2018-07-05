<?php

namespace App\Http\Controllers\Api\Crm;

use App\Http\Requests\Api\Crm\ServiceResourceStoreRequest;
use App\Models\ServiceResource;
use App\Repositories\ServiceResourceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceResourceController extends Controller
{
    protected $repository;

    public function __construct(ServiceResourceRepository $serviceResourceRepository)
    {
        $this->repository = $serviceResourceRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $serviceResources = $this->repository->all();

        return response()->json([
            'result' => 'success',
            'data'   => [
                'items'   => $serviceResources,
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
     * @param ServiceResourceStoreRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceResourceStoreRequest $request)
    {
        $serviceResource = $this->repository->create($request->all());

        return response()->json([
            'result' => 'success',
            'data'   => $serviceResource,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  integer $serviceResourceId
     * @return \Illuminate\Http\Response
     */
    public function show($serviceResourceId)
    {
        $serviceResource = $this->repository->find($serviceResourceId);

        return response()->json([
            'result' => 'success',
            'data'   => $serviceResource,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  integer $serviceResourceId
     * @return \Illuminate\Http\Response
     */
    public function edit($serviceResourceId)
    {
        $serviceResource = $this->repository->find($serviceResourceId);

        return response()->json([
            'result' => 'success',
            'data'   => [
                'form' => $this->getForm(),
                'item' => $serviceResource,
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ServiceResourceStoreRequest|Request $request
     * @param  integer $serviceResourceId
     * @return \Illuminate\Http\Response
     */
    public function update(ServiceResourceStoreRequest $request, $serviceResourceId)
    {
        $this->repository->update($request->all(), $serviceResourceId);

        return response()->json([
            'result' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer $serviceResourceId
     * @return \Illuminate\Http\Response
     */
    public function destroy($serviceResourceId)
    {
        $this->repository->delete($serviceResourceId);

        return response()->json([
            'result' => 'success',
        ]);
    }

    protected function getForm()
    {
        return [
            'title' => [
                'title'     => __('Название'),
                'type'      => 'text',
                'translate' => true,
            ],
        ];
    }
}
