<?php

namespace App\Http\Controllers\Api\Crm;

use App\Models\LegalEntity;
use App\Repositories\LegalEntityRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LegalEntityController extends Controller
{

    protected $repository;


    public function __construct(LegalEntityRepository $legalEntityRepository)
    {
        $this->repository = $legalEntityRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LegalEntity  $legalEntity
     * @return \Illuminate\Http\Response
     */
    public function show(LegalEntity $legalEntity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LegalEntity  $legalEntity
     * @return \Illuminate\Http\Response
     */
    public function edit(LegalEntity $legalEntity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LegalEntity  $legalEntity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LegalEntity $legalEntity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LegalEntity  $legalEntity
     * @return \Illuminate\Http\Response
     */
    public function destroy(LegalEntity $legalEntity)
    {
        //
    }
}
