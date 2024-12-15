<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use App\Models\SalesQuotation;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function delivery()
    {
        $sales = Sales::with('customer')
            ->get();
        $quotations = SalesQuotation::with('customer')
            ->select('code', 'idCustomers')
            ->groupBy('code', 'idCustomers') // Pastikan hanya mengelompokkan berdasarkan kode dan pelanggan
            ->where('status', 2) // Misalnya, hanya quotation yang berstatus confirmed
            ->get();
        return view('pages.delivery.delivery', compact('sales', 'quotations'));
    }

    public function index()
    {
        $sales = Sales::with('customer')->whereIn('status', [1, 2])
            ->get();
        $quotations = SalesQuotation::with('customer')
            ->select('code', 'idCustomers')
            ->groupBy('code', 'idCustomers') // Pastikan hanya mengelompokkan berdasarkan kode dan pelanggan
            ->where('status', 2) // Misalnya, hanya quotation yang berstatus confirmed
            ->get();
        return view('pages.validate.validate', compact('sales', 'quotations'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sales $sales)
    {
        $sales->delete();

        return redirect()->route('sales.index')->with('success', 'Sales record deleted successfully.');
    }

    public function deliver(Request $request, $code)
    {
        $sales = Sales::where('salesOrderCode', $code)->firstOrFail();

        if ($sales->status != 0) {
            return redirect()->route('delivery')->with('error', 'Sales must be in Waiting Delivery status.');
        }

        // Update status menjadi Delivered (1)
        $sales->update(['status' => 1]);

        return redirect()->route('delivery')->with('success', 'Sales has been delivered.');
    }

    public function validateOrder(Request $request, $code)
    {
        $sales = Sales::where('salesOrderCode', $code)->first();

        if ($sales->status != 1) {
            return redirect()->route('validate')->with('error', 'Sales must be in Delivered status before validation.');
        }

        DB::transaction(function () use ($sales) {
            foreach ($sales->quotation as $quotation) {
                $product = $quotation->product;

                // Cek apakah stok mencukupi
                if ($product->stock < $quotation->qty) {
                    throw new \Exception("Insufficient stock for product: {$product->name}");
                }

                // Kurangi stok produk
                $product->stock -= $quotation->qty;
                $product->save();
            }

            // Update status menjadi Validated (3)
            $sales->update(['status' => 2]);
        });

        return redirect()->route('validate')->with('success', 'Sales Order has been validated.');
    }
}
