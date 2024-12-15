<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Purchase;
use App\Models\Quotation;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payment = Payment::with('purchase.quotation.vendor')
        ->get()
        ->groupBy('idPurchase')
        ->map(function ($group) {
            return $group->first(); // Ambil hanya data pertama untuk setiap idPurchase
        });

        $filteredPayments = $payment->map(function ($item) {
            $quotations = Quotation::where('reference', $item->purchase->quotation->reference)
                ->with('ingredient')
                ->get();
    
            return [
                'payment' => $item,
                'quotations' => $quotations,
            ];
        });
    

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



        return view('pages.payment.payment', compact('payment','purchase','filteredPurchase', 'filteredPayments' ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'idPurchase' => 'required',
            'paymentMethod' => 'nullable',
            'paymentDate' => 'nullable',
        ]);
        try {
            Payment::create([
                'idPurchase' => $request->idPurchase,
            ]);

            return redirect()->route('payment')
                    ->with('success', 'Payment added successfully!');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('payment')
                    ->with('error', 'An error occurred. Please try again.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'paymentMethod' => 'required',
            'paymentDate' => 'required',
        ]);

        try {

            $payment = Payment::findOrFail($id);

            $purchase = Purchase::with('quotation.ingredient')->findOrFail($payment->idPurchase);

            if ($payment->status == 0) {
                $payment->status = 1; // Status berubah ke "Waiting Payment"
            } elseif ($payment->status == 1) {
                $payment->status = 2; // Status berubah ke "Paid"

                $quotations = Quotation::where('reference', $purchase->quotation->reference)->get();
            foreach ($quotations as $quotation) {
                $ingredient = $quotation->ingredient;
                if ($ingredient) {
                    // Tambahkan stok ingredient sesuai qtyIngredients
                    $ingredient->stock += $quotation->qtyIngredients;
                    $ingredient->save();
                } else {
                    \Log::warning("Ingredient not found for Quotation ID: {$quotation->id}");
                }
            }
            } else {
                $payment->status = 3; // Status berubah ke "Completed"
            }

            // Update data payment
            $payment->update([
                'paymentMethod' => $request->paymentMethod,
                'paymentDate' => $request->paymentDate,
                'status' => $payment->status,
            ]);

            return redirect()->route('payment')
                ->with('success', 'Payment updated successfully!');
        } catch (\Exception $e) {
            \Log::error('Error updating payment: ' . $e->getMessage());
            return redirect()->route('payment')
                ->with('error', 'An error occurred. Please try again.');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $payment = Payment::find($id);

            $payment->delete();

            return redirect()->route('payment')
                ->with('success', 'Payment deleted successfully!');
        } catch (\Exception $e) {
            \Log::error('Error deleting payment: ' . $e->getMessage());
            return redirect()->route('payment')
                ->with('error', 'An error occurred. Please try again.');
        }

    }
}
