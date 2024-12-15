<?php

namespace App\Http\Controllers;

use File;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all();
        return view('pages.customer.customer', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:customers|max:50',
            'name' => 'required|max:100',
            'address' => 'required|max:255',
            'email' => 'required|email|max:100',
            'phone' => 'nullable|max:20',
            'img' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            $fileName = null; // Default jika tidak ada file
            if ($request->hasFile('img')) {
                $file = $request->file('img');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/customers'), $fileName);
            }

            // Simpan data ke database
            Customer::create([
                'code' => $request->code,
                'name' => $request->name,
                'address' => $request->address,
                'email' => $request->email,
                'phone' => $request->phone,
                'img' => $fileName,
            ]);

            return redirect()->route('customer')
                ->with('success', 'Customer added successfully!');
        } catch (\Exception $e) {
            return redirect()->route('customer')
                ->with('error', 'An error occurred. Please try again.');
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|max:50|unique:customers,code,' . $id,
            'name' => 'required|max:100',
            'address' => 'required|max:255',
            'email' => 'required|email|max:100',
            'phone' => 'nullable|max:20',
            'img' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            $customer = Customer::findOrFail($id); // Gunakan findOrFail untuk menangani ID yang tidak ditemukan

            $fileName = $customer->img; // Gunakan nilai gambar lama jika tidak diupload file baru
            if ($request->hasFile('img')) {
                $file = $request->file('img');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/customers'), $fileName);

                // Hapus file lama jika ada
                if ($customer->img && file_exists(public_path('uploads/customers/' . $customer->img))) {
                    unlink(public_path('uploads/customers/' . $customer->img));
                }
            }

            // Update data
            $customer->update([
                'code' => $request->code,
                'name' => $request->name,
                'address' => $request->address,
                'email' => $request->email,
                'phone' => $request->phone,
                'img' => $fileName,
            ]);

            return redirect()->route('customer')
                ->with('success', 'Customer updated successfully!');
        } catch (\Exception $e) {
            return redirect()->route('customer')
                ->with('error', 'An error occurred. Please try again.');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);
        File::delete(public_path('uploads/customers/' . $customer->img));
        $customer->delete();

        return redirect()->route('customer')
            ->with('success', 'Customer deleted successfully!');
    }
}
