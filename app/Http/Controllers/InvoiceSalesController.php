<?php

namespace App\Http\Controllers;

use App\Models\InvoiceSales;
use App\Models\SalesOrder;
use App\Models\SalesQuotation;
use Illuminate\Http\Request;

class InvoiceSalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $salesOrders =  SalesOrder::with(['quotation.product'])->get();

        $filteredSales = $salesOrders->map(function ($item) {

            $quotation = $item->quotation->first();


            $products = SalesQuotation::where('code',  $quotation->code)
                ->with('product')
                ->get()
                ->map(function ($quotation) {
                    return [
                        'product_name' => $quotation->product->name,
                        'qty' => $quotation->qty,
                        'price' => $quotation->price,
                        'total' => $quotation->total,
                    ];
                });
    
                return (object) [ 
                    'id' => $item->id,
                    'code' => $item->code,
                    'customer' => $item->customer, 
                    'products' => $item->quotation->map(function ($q) {
                        return [
                            'product_name' => $q->product->name,
                            'qty' => $q->qty,
                            'price' => $q->price,
                            'subtotal' => $q->total,
                        ];
                    }),
                ];
        });

        $quotations = SalesQuotation::with('customer')
            ->select('code', 'idCustomers')
            ->groupBy('code', 'idCustomers') // Pastikan hanya mengelompokkan berdasarkan kode dan pelanggan
            ->where('status', 2) // Misalnya, hanya quotation yang berstatus confirmed
            ->get();
      
        return view('pages.invoice.invoice-sales', compact('salesOrders', 'quotations', 'filteredSales'));
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
            'salesOrderId' => 'required',
        ]);

        try {
            InvoiceSales::create([
                'salesOrderId' => $request->salesOrderId,
            ]);

            return redirect()->route('invoice-sales')
                        ->with('success', 'Invoice added successfully!');
        } catch (\Exception $e) {
            return redirect()->route('invoice-sales')
            ->with('error', 'An error occurred. Please try again.');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(InvoiceSales $invoiceSales)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InvoiceSales $invoiceSales)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InvoiceSales $invoiceSales)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InvoiceSales $invoiceSales)
    {
        //
    }
}
