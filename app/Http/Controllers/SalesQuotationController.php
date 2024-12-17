<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use App\Models\SalesQuotation;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class SalesQuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quotations = SalesQuotation::with('customer', 'product')->get();
        $customers = Customer::all();
        $products = Product::all();

        $filteredQuotations = $quotations->groupBy('code')->map(function ($group) {
            return $group->first();
        });
        return view('pages.sales.sales-quotation', compact('quotations', 'customers', 'products', 'filteredQuotations'));
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
            'code' => 'required|unique:sales_quotations,code|max:50',
            'idCustomers' => 'required|exists:customers,id',
            'idProducts' => 'required|array',
            'idProducts.*' => 'required|exists:products,id',
            'qty' => 'required|array',
            'qty.*' => 'required|integer|min:1',
            'price' => 'required|array',
            'price.*' => 'required|integer|min:0',
        ]);

        try {
            // Ambil data input
            $productData = $request->input('idProducts');
            $qtyData = $request->input('qty');
            $priceData = $request->input('price');
            $grandTotal = 0;

            // Hitung total keseluruhan
            foreach ($productData as $key => $productId) {
                $qty = $qtyData[$key];
                $price = $priceData[$key];
                $grandTotal += $qty * $price;

                // Simpan setiap produk
                SalesQuotation::create([
                    'code' => $request->code,
                    'idCustomers' => $request->idCustomers,
                    'idProducts' => $productId,
                    'expDate' => now()->addDays(30),
                    'qty' => $qty,
                    'price' => $price,
                    'total' => $qty * $price,
                    'status' => 0, // Draft
                ]);
            }

            // Perbarui total keseluruhan pada salah satu baris
            SalesQuotation::where('code', $request->code)->update(['total' => $grandTotal]);

            return redirect()->route('sales-quotation')
                ->with('success', 'Sales Quotation created successfully!');
        } catch (\Exception $e) {
            return redirect()->route('sales-quotation')
                ->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(SalesQuotation $salesQuotation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SalesQuotation $salesQuotation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $quotation = SalesQuotation::findOrFail($id);

        $validated = $request->validate([
            'quotation_number' => 'required|unique:sales_quotations,quotation_number,' . $quotation->id,
            'customer_id' => 'required|exists:customers,id',
            'exp_date' => 'required|date',
            'products' => 'required|array',
            'products.*.product_name' => 'required|string|max:255',
            'products.*.qty' => 'required|numeric|min:1',
            'products.*.price' => 'required|numeric|min:0',
            'status' => 'required|in:0,1,2', // 0 = Draft, 1 = Sent, 2 = Confirmed
        ]);

        $total = array_sum(array_map(function ($product) {
            return $product['qty'] * $product['price'];
        }, $request->products));

        $quotation->update([
            'quotation_number' => $request->quotation_number,
            'customer_id' => $request->customer_id,
            'exp_date' => $request->exp_date,
            'products' => $request->products,
            'total' => $total,
            'status' => $request->status,
        ]);

        return redirect()->route('sales-quotation')->with('success', 'Sales Quotation updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($code)
    {
        try {
            // Hapus semua baris dengan code yang sama
            SalesQuotation::where('code', $code)->delete();

            return redirect()->route('sales-quotation')
                ->with('success', 'Sales Quotation deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('sales-quotation')
                ->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function updateStatusToSent($code)
    {
        try {
            $quotation = SalesQuotation::where('code', $code)->firstOrFail();

            if ($quotation->status !== 0) { // Pastikan statusnya Draft sebelum mengirim
                return redirect()->route('sales-quotation')->with('error', 'Quotation must be in Draft status to be sent.');
            }

            $quotation->update(['status' => 1]); // 1 = Sent

            return redirect()->route('sales-quotation')->with('success', 'Quotation sent successfully!');
        } catch (\Exception $e) {
            return redirect()->route('sales-quotation')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function updateStatusToConfirmed($code)
    {
        try {
            $quotation = SalesQuotation::where('code', $code)->firstOrFail();

            if ($quotation->status !== 1) { // Pastikan statusnya Sent sebelum mengonfirmasi
                return redirect()->route('sales-quotation')->with('error', 'Quotation must be in Sent status to be confirmed.');
            }

            $quotation->update(['status' => 2]); // 2 = Confirmed

            return redirect()->route('sales-quotation')->with('success', 'Quotation confirmed successfully!');
        } catch (\Exception $e) {
            return redirect()->route('sales-quotation')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }


    public function exportPDF($code)
    {
        try {
            $quotationDetails = SalesQuotation::with('product', 'customer')->where('code', $code)->get();

            if ($quotationDetails->isEmpty()) {
                return redirect()->route('sales-quotation')->with('error', 'Quotation not found.');
            }

            $data = [
                'quotation' => $quotationDetails->first(),
                'details' => $quotationDetails,
                'grandTotal' => $quotationDetails->sum(fn($q) => $q->qty * $q->price),
            ];

            $pdf = Pdf::loadView('layouts.quotation-report', $data);

            return $pdf->download('quotation_' . $code . '.pdf');
        } catch (\Exception $e) {
            return redirect()->route('sales-quotation')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
