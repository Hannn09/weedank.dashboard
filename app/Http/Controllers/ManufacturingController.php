<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManufacturingController extends Controller
{
    public function index()
    {
        return view('pages.manufacturing.manufacturing');
    }
}
