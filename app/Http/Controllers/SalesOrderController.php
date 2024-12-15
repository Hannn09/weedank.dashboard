<?php

namespace App\Http\Controllers;

use App\Models\SalesOrder;
use App\Models\SalesQuotation;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $salesOrders = SalesOrder::with('customer')->get();
        // Ambil data unik berdasarkan kode quotation
        $quotations = SalesQuotation::with('customer')
            ->select('code', 'idCustomers')
            ->groupBy('code', 'idCustomers') // Pastikan hanya mengelompokkan berdasarkan kode dan pelanggan
            ->where('status', 2) // Misalnya, hanya quotation yang berstatus confirmed
            ->get();
        return view('pages.sales.sales-order', compact('salesOrders', 'quotations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'quotationCode' => 'required|exists:sales_quotations,code',
        ]);

        $quotation = SalesQuotation::where('code', $request->quotationCode)->get();

        $total = $quotation->sum(function ($item) {
            return $item->qty * $item->price;
        });

        SalesOrder::create([
            'code' => 'SO' . now()->timestamp,
            'quotationCode' => $request->quotationCode,
            'idCustomers' => $quotation->first()->idCustomers,
            'total' => $total,
            'status' => 0, // Draft
        ]);

        return redirect()->route('sales-order')->with('success', 'Sales Order created successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($code)
    {
        // Gunakan transaksi database untuk memastikan integritas data
        DB::transaction(function () use ($code) {
            // Cari Sales Order berdasarkan kode
            $salesOrder = SalesOrder::where('code', $code)->firstOrFail();

            // Hapus data terkait di tabel sales
            Sales::where('salesOrderCode', $salesOrder->code)->delete();

            // Hapus Sales Order
            $salesOrder->delete();
        });

        return redirect()->route('sales-order')->with('success', 'Sales Order and related Sales records deleted successfully.');
    }

    public function accept($code)
    {
        $salesOrder = SalesOrder::where('code', $code)->firstOrFail();

        if ($salesOrder->status !== 0) {
            return redirect()->route('sales-order', $code)->with('error', 'Sales Order cannot be accepted!');
        }

        $salesOrder->update(['status' => 1]); // Accepted

        return redirect()->route('sales-order', $code)->with('success', 'Sales Order accepted!');
    }

    public function checkAvailability(Request $request, $code)
    {
        $salesOrder = SalesOrder::with('quotation.product')->where('code', $code)->first();

        if (!$salesOrder) {
            return redirect()->route('sales-order')->with('error', 'Sales Order not found.');
        }

        $availability = true; // Flag untuk mengecek ketersediaan stok

        foreach ($salesOrder->quotation as $quotation) {
            $product = $quotation->product;

            // Jika stok tidak mencukupi, ubah flag menjadi false
            if ($product->stock < $quotation->qty) {
                $availability = false;
                break;
            }
        }

        if (!$availability) {
            return redirect()->route('sales-order')->with('error', 'Some products do not have enough stock.');
        }

        // Jika semua stok tersedia, ubah status menjadi Waiting Bill (2)
        $salesOrder->update(['status' => 2]);

        return redirect()->route('sales-order')->with('success', 'All products are available. Status updated to Waiting Bill.');
    }

    public function paid(Request $request, $code)
    {
        $salesOrder = SalesOrder::where('code', $code)->firstOrFail();

        if (!$salesOrder || $salesOrder->status != 2) {
            return redirect()->route('sales-order')->with('error', 'Sales Order must be in Waiting Bill status.');
        }

        // Jalankan dalam transaksi database
        DB::transaction(function () use ($salesOrder) {
            // Ubah status menjadi Paid (3)
            $salesOrder->update(['status' => 3]);

            // Tambahkan data ke tabel Sales
            Sales::create([
                'salesOrderCode' => $salesOrder->code,
                'quotationCode' => $salesOrder->quotationCode, // Relasi ke Sales Quotation
                'idCustomers' => $salesOrder->idCustomers,
                'total' => $salesOrder->total,
                'status' => 0, // Waiting Delivery
            ]);
        });

        return redirect()->route('sales-order')->with('success', 'Sales Order has been marked as Paid.');
    }

    public function getQuotationProducts($code)
    {
        $quotation = SalesQuotation::with('product')->where('code', $code)->get();

        if ($quotation) {
            return response()->json($quotation);
        } else {
            return response()->json(['message' => 'Quotation not found'], 404);
        }
    }
}
