<?php

namespace App\Http\Controllers;

use App\Models\Ingredients;
use App\Models\Quotation;
use App\Models\Vendor;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    public function index()
    {
        $ingredients = Ingredients::all();
        $vendors = Vendor::all();
        $quotation = Quotation::with('vendor', 'ingredient')->get();

        $filteredQuotation = $quotation->groupBy('reference');
        return view('pages.quotation.quotation', compact('ingredients', 'vendors', 'quotation', 'filteredQuotation'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'reference' => 'required',
            'idIngredients' => 'required',
            'idVendor' => 'required',
            'qtyIngredients' => 'required',
            'orderDate' => 'required',
        ]);

        try {
            $ingredientsData = $request->input('idIngredients');
            $qtyIngredients = $request->input('qtyIngredients');

            $total = 0;

            foreach ($ingredientsData as $key => $ingredientId) {
                $ingredient = Ingredients::findOrFail($ingredientId); 
                $qty = $qtyIngredients[$key]; 
                $total += $qty * $ingredient->price; 
            }

            foreach ($ingredientsData as $key => $ingredientId) {
                $ingredient = Ingredients::findOrFail($ingredientId); 
                $qty = $qtyIngredients[$key]; 
                Quotation::create([
                    'reference' => $request->reference,
                    'idIngredients' => $ingredientId,
                    'idVendor' => $request->idVendor,
                    'qtyIngredients' => $qty,
                    'orderDate' => $request->orderDate,
                    'total' => $total,
                ]);
            }

            return redirect()->route('quotation')
                    ->with('success', 'Quotation added successfully!');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('quotation')
            ->with('error', 'An error occurred. Please try again.');
        }
    }

    public function destroy($id)
    {
        $quotation = Quotation::where('reference', $id)->get();
        if ($quotation->isEmpty()) {
            return redirect()->route('quotation')
                ->with('error', 'No Quotation found with the specified reference');
        }

        Quotation::where('reference', $id)->delete();


        return redirect()->route('quotation')
            ->with('success', 'Quotation deleted successfully!');
    }

    public function update($id) {
        try {
            $quotations = Quotation::where('reference', $id)->get();
            
            foreach ($quotations as $quotation) {
                if ($quotation->status == 0) {
                    $quotation->status = 1; 
                } elseif ($quotation->status == 1) {
                    $quotation->status = 2;
                } elseif ($quotation->status == 2) {
                    $quotation->status = 3;
                } 
    
                $quotation->save();  
            }
            return redirect()->route('quotation')
                        ->with('success', 'Quotation updated successfully!');

        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('quotation')
            ->with('error', 'An error occurred. Please try again.');
        }
    }
}
