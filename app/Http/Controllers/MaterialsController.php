<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MaterialsController extends Controller
{
    public function index()
    {
        return view('pages.bom.materials');
    }

    public function report()
    {
        return view('layouts.report');
    }
}
