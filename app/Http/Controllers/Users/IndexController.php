<?php


namespace App\Http\Controllers\Users;


use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index()
    {
        return view('users.index');
    }
}