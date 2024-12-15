<?php

namespace App\Http\Controllers;

use File;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::all();
        return view('pages.vendor.vendor', compact('vendors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:vendors|max:50',
            'name' => 'required|max:100',
            'address' => 'required|max:255',
            'email' => 'nullable|email|max:100',
            'phone' => 'nullable|max:20',
            'img' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            $fileName = null;
            if ($request->hasFile('img')) {
                $file = $request->file('img');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/vendors'), $fileName);
            }

            Vendor::create(array_filter([
                'code' => $request->code,
                'name' => $request->name,
                'address' => $request->address,
                'email' => $request->email,
                'phone' => $request->phone,
                'img' => $fileName,
            ]));

            return redirect()->route('vendor')
                ->with('success', 'Vendor added successfully!');
        } catch (\Exception $e) {
            return redirect()->route('vendor')
                ->with('error', 'An error occurred. Please try again.');
        }
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|max:50|unique:vendors,code,' . $id,
            'name' => 'required|max:100',
            'address' => 'required|max:255',
            'email' => 'required|email|max:100',
            'phone' => 'nullable|max:20',
            'img' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            $vendor = Vendor::findOrFail($id);

            if ($request->hasFile('img')) {
                $file = $request->file('img');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/vendors'), $fileName);

                if ($vendor->img && file_exists(public_path('uploads/vendors/' . $vendor->img))) {
                    unlink(public_path('uploads/vendors/' . $vendor->img));
                }

                $vendor->img = $fileName;
            }

            $vendor->update(array_filter([
                'code' => $request->code,
                'name' => $request->name,
                'address' => $request->address,
                'email' => $request->email,
                'phone' => $request->phone,
                'img' => $vendor->img,
            ]));

            return redirect()->route('vendor')
                ->with('success', 'Vendor updated successfully!');
        } catch (\Exception $e) {
            return redirect()->route('vendor')
                ->with('error', 'An error occurred. Please try again.');
        }
    }


    public function destroy($id)
    {
        $vendor = Vendor::find($id);
        File::delete(public_path('uploads/vendors/' . $vendor->img));
        $vendor->delete();

        return redirect()->route('vendor')
            ->with('success', 'Vendor deleted successfully!');
    }
}
