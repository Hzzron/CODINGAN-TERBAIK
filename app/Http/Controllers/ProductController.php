<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::latest()->paginate(12);

        // Check if this is for customer route
        if ($request->routeIs('customer.products')) {
            $cartCount = Auth::check() ? Cart::where('user_id', Auth::id())->sum('quantity') : 0;
            return view('customer.product', compact('products', 'cartCount'));
        }

        // Admin products page
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image'       => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title'       => 'required|min:5',
            'description' => 'required|min:10',
            'price'       => 'required|numeric',
            'stock'       => 'required|numeric',
        ]);

        $image = $request->file('image');
        $image->storeAs('products', $image->hashName());

        Product::create([
            'image'       => $image->hashName(),
            'title'       => $request->title,
            'description' => $request->description,
            'price'       => $request->price,
            'stock'       => $request->stock,
        ]);

        return redirect()->route('products.index')
            ->with(['success' => 'Product created successfully.']);
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'       => 'required|min:5',
            'description' => 'required|min:10',
            'price'       => 'required|numeric',
            'stock'       => 'required|numeric',
        ]);

        $product = Product::findOrFail($id);

        if ($request->hasFile('image')) {
            Storage::delete('products/'.$product->image);
            $image = $request->file('image');
            $image->storeAs('products', $image->hashName());

            $product->update([
                'image'       => $image->hashName(),
                'title'       => $request->title,
                'description' => $request->description,
                'price'       => $request->price,
                'stock'       => $request->stock,
            ]);
        } else {
            $product->update([
                'title'       => $request->title,
                'description' => $request->description,
                'price'       => $request->price,
                'stock'       => $request->stock,
            ]);
        }

        return redirect()->route('products.index')
            ->with(['success' => 'Product updated successfully.']);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        Storage::delete('products/'.$product->image);
        $product->delete();

        return redirect()->route('products.index')
            ->with(['success' => 'Product deleted successfully.']);
    }
}

