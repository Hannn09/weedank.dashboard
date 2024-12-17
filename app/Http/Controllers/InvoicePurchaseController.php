<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Quotation;
use App\Models\InvoicePurchase;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InvoicePurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoice = InvoicePurchase::all();
        $purchase = Purchase::with(['quotation.ingredient'])->where('status', 3)->get();

        $filteredPurchase = $purchase->map(function ($item) {
            $ingredients = Quotation::where('reference', $item->quotation->reference)
                ->with('ingredient')
                ->get()
                ->map(function ($quotation) {
                    return [
                        'ingredient_name' => $quotation->ingredient->name,
                        'qty' => $quotation->qtyIngredients,
                        'price' => $quotation->ingredient->price,
                        'total' => $quotation->qtyIngredients * $quotation->ingredient->price,
                    ];
                });
    
            return [
                'id' => $item->id,
                'code' => $item->code,
                'ingredients' => $ingredients,
            ];
        });
    
        return view('pages.invoice.invoice-purchase', compact('filteredPurchase', 'invoice'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'purchaseId' => 'required',
        ]);

        try {
            InvoicePurchase::create([
                'purchaseId' => $request->purchaseId,
            ]);

            return redirect()->route('invoice-purchase')
                        ->with('success', 'Invoice added successfully!');
        } catch (\Exception $e) {
            return redirect()->route('invoice-purchase')
            ->with('error', 'An error occurred. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function exportPdf($id)
    {
        $invoice = InvoicePurchase::find($id);
        $purchase = Purchase::with(['quotation.ingredient'])->where('status', 3)->get();

        $filteredPurchase = $purchase->map(function ($item) {
            $ingredients = Quotation::where('reference', $item->quotation->reference)
                ->with('ingredient')
                ->get()
                ->map(function ($quotation) {
                    return [
                        'ingredient_name' => $quotation->ingredient->name,
                        'qty' => $quotation->qtyIngredients,
                        'price' => $quotation->ingredient->price,
                        'total' => $quotation->qtyIngredients * $quotation->ingredient->price,
                    ];
                });
    
            return [
                'id' => $item->id,
                'code' => $item->code,
                'ingredients' => $ingredients,
            ];
        });

        $pdf = Pdf::loadView('layouts.invoice-report', compact('purchase', 'filteredPurchase', 'invoice'));
        return $pdf->stream('invoice-purchase.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InvoicePurchase $invoicePurchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InvoicePurchase $invoicePurchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InvoicePurchase $invoicePurchase)
    {
        //
    }
}
