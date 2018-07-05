<?php


namespace App\Http\Controllers\Crm;


use App\Http\Controllers\Controller;
use App\Models\Unit;
use App\Models\UnitGroup;

class IndexController extends Controller
{
    public function index()
    {
        Unit::find(1);
        return view('crm.index');
    }
}