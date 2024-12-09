<?php

namespace App\Http\Controllers;

use File;
use Illuminate\Http\Request;
use App\Models\Ingredients;

class IngredientsController extends Controller
{
    public function index()
    {
        $ingredients = Ingredients::all();
        return view('pages.ingredients.ingredients', compact('ingredients'));
    }

    public function store(Request $request) {
        $request->validate([
            'code' => 'required|unique:products|max:50',
            'name' => 'required|max:100',
            'stock' => 'nullable',
            'price' => 'required|integer|min:0',
            'img' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            if ($request->hasFile('img')) {
                $file = $request->file('img');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/ingredients'), $fileName);
        
                Ingredients::create([
                    'code' => $request->code,
                    'name' => $request->name,
                    'price' => $request->price,
                    'img' => $fileName,
                ]);
            }
    
            return redirect()->route('ingredients')
                ->with('success', 'Ingredients added successfully!');
        } catch (\Exception $e) {
            return redirect()->route('ingredients')
                ->with('error', 'An error occurred. Please try again.');
        }
    }

    public function destroy($id)
    {
        
        $ingredients = Ingredients::find($id);
        File::delete(public_path('uploads/ingredients/' . $ingredients->img));
        $ingredients->delete();

        return redirect()->route('ingredients')
            ->with('success', 'Ingredients deleted successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|unique:products,code,' . $id . '|max:50',
            'name' => 'required|max:100',
            'stock' => 'nullable',
            'price' => 'required|integer|min:0',
            'img' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $ingredients = Ingredients::find($id);

        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/ingredients'), $fileName);
        
            if ($ingredients->img && file_exists(public_path('uploads/ingredients/' . $ingredients->img))) {
                unlink(public_path('uploads/ingredients/' . $ingredients->img));
            }
        
            $ingredients->img = $fileName;
        }
        
        $ingredients->update([
            'code' => $request->code,
            'name' => $request->name,
            'price' => $request->price,
            'img' => $ingredients->img, 
        ]);

        return redirect()->route('ingredients')
            ->with('success', 'Ingredients updated successfully!');
    }
}
