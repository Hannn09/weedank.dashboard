<?php

namespace App\Http\Controllers;

use App\Models\Ingredients;
use App\Models\Materials;
use App\Models\Product;
use Illuminate\Http\Request;

class MaterialsController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $ingredients = Ingredients::all();
        $materials = Materials::with('product')->get();

        $filteredMaterials = $materials->groupBy('code')->map(function ($group) { return $group->first(); });
        return view('pages.bom.materials', compact('products', 'ingredients', 'filteredMaterials', 'materials'));
    }

    public function store(Request $request) {
        $request->validate([
            'code' => 'required|max:50',
            'idProducts' => 'required',
            'idIngredients' => 'required',
            'qtyBom' => 'required',
            'qtyProduct' => 'required|integer',
        ]);

        try {
            $ingredientsData = $request->input('idIngredients'); 
            $qtyBomData = $request->input('qtyBom');
            
        
            $product = Product::find($request->input('idProducts')); 

        
            $bomCost = 0;
        
            foreach ($ingredientsData as $key => $ingredientId) {
                $ingredient = Ingredients::findOrFail($ingredientId); 
                $qtyBom = $qtyBomData[$key]; 
                $bomCost += $qtyBom * $ingredient->price; 
            }
        
            $productCost = $bomCost * (1 + ($product->profit / 100));

            foreach ($ingredientsData as $key => $ingredientId) {

                $ingredient = Ingredients::findOrFail($ingredientId); 
                $qtyBom = $qtyBomData[$key]; 
                Materials::create([
                    'code' => $request->code,
                    'idProducts' => $request->idProducts,
                    'idIngredients' => $ingredientId,
                    'qtyBom' => $qtyBom,
                    'qtyProduct' => $request->qtyProduct,
                    'productCost' => $productCost,
                    'bomCost' => $bomCost,
                ]);
            }

            return redirect()->route('materials')
                    ->with('success', 'BoM added successfully!');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('materials')
            ->with('error', 'An error occurred. Please try again.');
       }
    }

    public function update(Request $request, $id) {
        $request->validate([
            'code' => 'required|max:50',
            'idProducts' => 'required',
            'idIngredients' => 'required',
            'qtyBom' => 'required',
            'qtyProduct' => 'required|integer',
        ]);

        try {
            
            $ingredientsData = $request->input('idIngredients'); 
            $qtyBomData = $request->input('qtyBom');
        
            $product = Product::findOrFail($request->input('idProducts')); // Pastikan product ditemukan
            
            $bomCost = 0;

            foreach ($ingredientsData as $key => $ingredientId) {
                $ingredient = Ingredients::findOrFail($ingredientId); 
                $qtyBom = $qtyBomData[$key]; 
                $bomCost += $qtyBom * $ingredient->price; 
            }

            $productCost = $bomCost * (1 + ($product->profit / 100));

            Materials::where('code', $request->code)->delete();

            foreach ($ingredientsData as $key => $ingredientId) {
                $ingredient = Ingredients::findOrFail($ingredientId);
                $qtyBom = $qtyBomData[$key];

                Materials::create([
                    'code' => $request->code,
                    'idProducts' => $request->idProducts,
                    'idIngredients' => $ingredientId,
                    'qtyBom' => $qtyBom,
                    'qtyProduct' => $request->qtyProduct,
                    'productCost' => $productCost,
                    'bomCost' => $bomCost,
                ]);
            }

            return redirect()->route('materials')
                ->with('success', 'BoM updated successfully!');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('materials')
                ->with('error', 'An error occurred. Please try again.');
        }
    }

    public function destroy($code)
    {
        
        $materials = Materials::where('code', $code)->get();
        if ($materials->isEmpty()) {
            return redirect()->route('materials')
                ->with('error', 'No BoM found with the specified code.');
        }

        Materials::where('code', $code)->delete();


        return redirect()->route('materials')
            ->with('success', 'BoM deleted successfully!');
    }


    public function report()
    {
        return view('layouts.report');
    }
}
