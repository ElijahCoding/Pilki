<?php

namespace App\Http\Controllers\Api\Crm;

use App\Repositories\AuditRepository;
use App\Http\Controllers\Controller;

class AuditController extends Controller
{
    protected $repository;

    public function __construct(AuditRepository $auditRepository)
    {
        $this->repository = $auditRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $audits = $this->repository->all();

        return response()->json([
            'result' => 'success',
            'data'   => [
                'items'   => $audits,
                'filters' => $this->repository->getFieldsSearchable(),
            ],
        ]);
    }
}
