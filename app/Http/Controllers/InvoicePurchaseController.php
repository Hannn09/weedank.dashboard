<?php

namespace App\Http\Controllers;

use App\Models\InvoicePurchase;
use Illuminate\Http\Request;

class InvoicePurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.invoice.invoice-purchase');
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(InvoicePurchase $invoicePurchase)
    {
        //
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
