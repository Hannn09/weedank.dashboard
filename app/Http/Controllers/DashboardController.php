<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Ingredients;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'productCount' => Product::count(),
            'ingredientCount' => Ingredients::count(),
            'customerCount' => Customer::count(),
            'vendorCount' => Vendor::count(),
        ];
        return view('pages.dashboard.dashboard', compact('data'));
    }
}
