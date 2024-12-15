<?php

namespace App\Http\Controllers;

use App\Models\Manufacturing;
use App\Models\Materials;
use Illuminate\Http\Request;

class ManufacturingController extends Controller
{
    public function index()
    {
        $manufacturings = Manufacturing::all();
        $materials = Materials::with('product')->get();

        $filteredMaterials = $materials->groupBy('code')->map(function ($group) { return $group->first(); });
        return view('pages.manufacturing.manufacturing', compact('materials', 'filteredMaterials', 'manufacturings'));
    }

    public function store(Request $request){
        $request->validate([
            'idMaterials' => 'required',
            'qty' => 'required',
        ]);

        try {
            Manufacturing::create([
                'idMaterials' => $request->idMaterials,
                'qty' => $request->qty,
                'status' => 0,
            ]);
    
            return redirect()->route('manufacturing')
                        ->with('success', 'Manufacturing added successfully!');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('manufacturing')
            ->with('error', 'An error occurred. Please try again.');
        }       
    }

    public function update(Request $request, $id){
        try {
            $manufacturing = Manufacturing::find($id);

            $materials = Materials::where('code', $manufacturing->material->code)->get();
           
            foreach ($materials as $material) {
                if ($material->ingredient->stock < ($material->qtyBom * $manufacturing->qty)) {
                   return redirect()->back()
                    ->with('error', 'Insufficient raw materials for production')
                    ->with('modal_id', $id);
                }
            }

            if ($manufacturing->status == 0) {
                $manufacturing->status = 1; 
            } elseif ($manufacturing->status == 1) {
                $manufacturing->status = 2;

                foreach ($materials as $material) {
                    $product = $material->product;
                    $ingredient = $material->ingredient;
                    $quantityToConsume = $material->qtyBom * $manufacturing->qty;
                    $ingredient->stock -= $quantityToConsume;
                    $ingredient->save();
                }
                $product->stock += $manufacturing->qty;
                $product->save();
            } 

            $manufacturing->save();
    

            return redirect()->route('manufacturing')
                        ->with('success', 'Manufacturing updated successfully!');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('manufacturing')
            ->with('error', 'An error occurred. Please try again.');
        }       
    }

    public function destroy($id){
        try {
            $manufacturing = Manufacturing::find($id);
            $manufacturing->delete();
    
            return redirect()->route('manufacturing')
                        ->with('success', 'Manufacturing deleted successfully!');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('manufacturing')
            ->with('error', 'An error occurred. Please try again.');
        }       
    }
}
