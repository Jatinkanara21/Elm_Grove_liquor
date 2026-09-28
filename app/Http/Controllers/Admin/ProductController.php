<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Services\ImageService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(private ImageService $images) {}

    public function index(Request $request)
    {
        $products = Product::with('category')
            ->when($request->string('search')->toString(), fn ($q, $s) => $q->where(fn ($q) => $q
                ->where('name', 'like', "%{$s}%")->orWhere('brand', 'like', "%{$s}%")))
            ->when($request->filled('category'), fn ($q) => $q->where('category_id', $request->integer('category')))
            ->when(in_array($request->input('status'), ['active', 'inactive'], true),
                fn ($q) => $q->where('is_active', $request->input('status') === 'active'))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.products.index', [
            'products' => $products,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.products.form', [
            'product' => new Product(['is_active' => true]),
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->safe()->except('image');

        if ($request->hasFile('image')) {
            $data['image'] = $this->images->store($request->file('image'), 'products');
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.form', [
            'product' => $product,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function update(StoreProductRequest $request, Product $product)
    {
        $data = $request->safe()->except('image');

        if ($request->hasFile('image')) {
            $this->images->delete($product->image);
            $data['image'] = $this->images->store($request->file('image'), 'products');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete(); // soft delete

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}