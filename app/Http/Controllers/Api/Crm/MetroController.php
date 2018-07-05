<?php

namespace App\Http\Controllers\Api\Crm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Crm\MetroStoreRequest;
use App\Http\Requests\Api\Crm\MetroUpdateRequest;
use App\Repositories\MetroRepository;

class MetroController extends Controller
{
    protected $repository;

    public function __construct(MetroRepository $metroRepository)
    {
        $this->repository = $metroRepository;
    }

    public function index()
    {
        $metros = $this->repository->all();

        return response()->json([
            'result' => 'success',
            'data'   => [
                'items'   => $metros,
                'filters' => $this->repository->getFieldsSearchable(),
            ],
        ]);
    }

    public function show($metroId)
    {
        return response()->json([
            'result' => 'success',
            'data'   => $this->repository->find($metroId),
        ]);
    }

    public function create()
    {
        return response()->json([
            'result' => 'success',
            'data'   => [
                'form' => $this->getForm(),
            ],
        ]);
    }

    public function store(MetroStoreRequest $request)
    {
        $metro = $this->repository->create($request->all());

        return response()->json([
            'result' => 'success',
            'data'   => $metro,
        ]);
    }

    public function edit($metroId)
    {
        return response()->json([
            'result' => 'success',
            'data'   => [
                'form' => $this->getForm(),
                'item' => $this->repository->find($metroId),
            ],
        ]);
    }

    public function update($metroId, MetroUpdateRequest $request)
    {
        $metro = $this->repository->update($request->all(), $metro);

        return response()->json([
            'result' => 'success',
            'data'   => $metro,
        ]);
    }

    public function destroy($metroId, Request $request)
    {
        $this->repository->delete($metroId);

        return response()->json(['result' => 'success']);
    }

    protected function getForm()
    {
        return [
            'name'     => [
                'title' => __('Название'),
                'type'  => 'text',
            ]
        ];
    }
}
