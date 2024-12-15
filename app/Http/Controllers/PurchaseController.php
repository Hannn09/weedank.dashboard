<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Quotation;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index() {
        $quotations = Quotation::with('ingredient')->where('status', 3)->get();
        $purchase = Purchase::with(['quotation.vendor','quotation'])->get();

        $filteredQuotations = $quotations->groupBy('reference')->map(function ($group) {
            return [
                'reference' => $group->first()->reference,
                'ingredients' => $group->map(function ($item) {
                    return [
                        'ingredient_name' => $item->ingredient->name,
                        'qty' => $item->qtyIngredients,
                        'price' => $item->ingredient->price,
                        'total' => $item->qtyIngredients * $item->ingredient->price,
                    ];
                }),
                'total' => $group->sum(function ($item) {
                    return $item->qtyIngredients * $item->ingredient->price;
                }),
            ];
        });

      
        return view('pages.purchase.purchase', compact('quotations', 'filteredQuotations', 'purchase'));
    }

    public function store(Request $request) {

        // dd($request->all());
       $request->validate([
            'code' => 'required',
            'idQuotation' => 'required',
        ]);

        try {
 
            $quotationId = Quotation::where('reference', $request->idQuotation)->pluck('id');

            Purchase::create([
                'code' => $request->code,
                'idQuotation' => $quotationId->first(),
            ]);

            return redirect()->route('purchase')
                    ->with('success', 'Purchase added successfully!');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('purchase')
                    ->with('error', 'An error occurred. Please try again.');
        }
    }

    public function update($id) {
        try {
            $purchase = Purchase::find( $id);

            if ($purchase->status == 0) {
                $purchase->status = 1;
            } elseif ($purchase->status == 1) {
                $purchase->status = 2;
            } elseif ($purchase->status == 2) {
                $purchase->status = 3;
            }

            $purchase->save();
            return redirect()->route('purchase')
            ->with('succeess', 'Purchase added successfully!');

        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('purchase')
                    ->with('error', 'An error occurred. Please try again.');
        }
    }

    public function destroy($id)
{
    try {
        // Cari data purchase
        $purchase = Purchase::findOrFail($id);

        // Hapus data payment yang terkait
        $purchase->payment()->delete();

        // Hapus data purchase
        $purchase->delete();

        return redirect()->route('purchase')
            ->with('success', 'Purchase and related payments deleted successfully!');
    } catch (\Exception $e) {
        \Log::error('Error deleting purchase: ' . $e->getMessage());
        return redirect()->route('purchase')
            ->with('error', 'An error occurred. Please try again.');
    }
}


}
