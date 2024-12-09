<?php

namespace App\Http\Controllers;

use File;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('pages.product.product', compact('products'));
    }

    public function store(Request $request) {
        $request->validate([
            'code' => 'required|unique:products|max:50',
            'name' => 'required|max:100',
            'stock' => 'nullable',
            'profit' => 'required|min:0',
            'img' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            if ($request->hasFile('img')) {
                $file = $request->file('img');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/products'), $fileName);
        
                Product::create([
                    'code' => $request->code,
                    'name' => $request->name,
                    'profit' => $request->profit,
                    'img' => $fileName,
                ]);
            }
    
            return redirect()->route('product')
                ->with('success', 'Product added successfully!');
        } catch (\Exception $e) {
            return redirect()->route('product')
                ->with('error', 'An error occurred. Please try again.');
        }
    }

    public function destroy($id)
    {
        
        $product = Product::find($id);
        File::delete(public_path('uploads/products/' . $product->img));
        $product->delete();

        return redirect()->route('product')
            ->with('success', 'Product deleted successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|unique:products,code,' . $id . '|max:50',
            'name' => 'required|max:100',
            'stock' => 'nullable',
            'profit' => 'required|min:0',
            'img' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $product = Product::find($id);

        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/products'), $fileName);
        
            if ($product->img && file_exists(public_path('uploads/products/' . $product->img))) {
                unlink(public_path('uploads/products/' . $product->img));
            }
        
            $product->img = $fileName;
        }
        
        $product->update([
            'code' => $request->code,
            'name' => $request->name,
            'profit' => $request->profit,
            'img' => $product->img, 
        ]);

        return redirect()->route('product')
            ->with('success', 'Product updated successfully!');
    }
}
