<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IngredientsController extends Controller
{
    public function index()
    {
        return view('pages.ingredients.ingredients');
    }
}
