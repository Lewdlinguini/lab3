<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->get('search');
        $genre = $request->get('genre');
    
        $products = Product::when($search, function ($query, $search) {
                            return $query->where('product_name', 'like', '%' . $search . '%')
                                         ->orWhere('description', 'like', '%' . $search . '%');
                        })
                        ->when($genre, function ($query, $genre) {
                            return $query->where('genre', $genre);
                        })
                        ->paginate(10);
    
        return view('products.index', compact('products'));
    }
    
    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|min:3|unique:products',
            'description' => 'nullable|string',
            'genre' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'discount' => 'nullable|integer|min:0|max:50'
        ]);

        $price = $request->price;
        $discount = $request->discount;
        $discountedPrice = $discount > 0 ? $price - ($price * ($discount / 100)) : $price;

       
        $imageName = $request->hasFile('image') 
            ? time() . '.' . $request->image->extension()
            : null;

        if ($request->hasFile('image')) {
            $request->image->move(public_path('images'), $imageName);
        }

       
        Product::create([
            'product_name' => $request->product_name,
            'description' => $request->description,
            'genre' => $request->genre,
            'price' => $price,
            'discounted_price' => $discountedPrice, 
            'stock' => $request->stock,
            'image' => $imageName,
            'discount' => $discount
        ]);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'product_name' => 'required|min:3|unique:products,product_name,' . $product->id,
            'description' => 'nullable|string',
            'genre' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'discount' => 'nullable|integer|min:0|max:50'
        ]);

       
        $price = $request->price;
        $discount = $request->discount;
        $discountedPrice = $discount > 0 ? $price - ($price * ($discount / 100)) : $price;

       
        if ($request->hasFile('image')) {
            if ($product->image) {
                unlink(public_path('images/' . $product->image));
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $product->image = $imageName;
        }

     
        $product->update([
            'product_name' => $request->product_name,
            'description' => $request->description,
            'genre' => $request->input('genre'),
            'price' => $price,
            'discounted_price' => $discountedPrice, 
            'stock' => $request->stock,
            'discount' => $discount
            
        ]);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            unlink(public_path('images/' . $product->image));
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

  
public function buy(Product $product)
{
    if ($product->stock > 0) {
      
        $product->decrement('stock', 1);

        return redirect()->route('products.index')->with('success', 'Product purchased successfully!');
    }

    return redirect()->route('products.index')->with('error', 'Sorry, this product is out of stock.');
}

}  