<?php

namespace App\Http\Controllers\Crm;

use App\Models\Unit;

class UnitController
{
    public function index()
    {
        return view('crm.unit.index', [
            'units' => Unit::all(),
        ]);
    }
}
