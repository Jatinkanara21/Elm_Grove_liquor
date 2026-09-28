<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'category' => ['nullable', 'string', 'max:100'],
            'brand' => ['nullable', 'string', 'max:100'],
            'type' => ['nullable', 'string', 'max:100'],
            'page' => ['nullable', 'integer', 'min:1'],
        ]);

        $products = Product::active()
            ->with('category')
            ->filter($filters)
            ->orderBy('brand')
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('products._results', compact('products'))->render(),
            ]);
        }

        return view('products.index', [
            'products' => $products,
            'categories' => Category::active()->orderBy('sort_order')->get(),
            'brands' => Product::active()->whereNotNull('brand')->distinct()->orderBy('brand')->pluck('brand'),
            'types' => Product::active()->whereNotNull('type')->distinct()->orderBy('type')->pluck('type'),
        ]);
    }

    public function show(Product $product)
    {
        abort_unless($product->is_active, 404);

        $product->load('category');

        $related = Product::active()
            ->where('category_id', $product->category_id)
            ->whereKeyNot($product->id)
            ->with('category')
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'related'));
    }
}