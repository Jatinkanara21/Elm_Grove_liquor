<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStoreRequest;
use App\Models\Store;
use App\Services\ImageService;

class StoreController extends Controller
{
    public function __construct(private ImageService $images) {}

    public function index()
    {
        return view('admin.stores.index', ['stores' => Store::orderBy('name')->paginate(15)]);
    }

    public function create()
    {
        return view('admin.stores.form', ['store' => new Store(['is_active' => true])]);
    }

    public function store(StoreStoreRequest $request)
    {
        $data = $request->safe()->except('image');

        if ($request->hasFile('image')) {
            $data['image'] = $this->images->store($request->file('image'), 'stores');
        }

        Store::create($data);

        return redirect()->route('admin.stores.index')->with('success', 'Store created successfully.');
    }

    public function edit(Store $store)
    {
        return view('admin.stores.form', compact('store'));
    }

    public function update(StoreStoreRequest $request, Store $store)
    {
        $data = $request->safe()->except('image');

        if ($request->hasFile('image')) {
            $this->images->delete($store->image);
            $data['image'] = $this->images->store($request->file('image'), 'stores');
        }

        $store->update($data);

        return redirect()->route('admin.stores.index')->with('success', 'Store updated successfully.');
    }

    public function destroy(Store $store)
    {
        $store->delete();

        return redirect()->route('admin.stores.index')->with('success', 'Store deleted successfully.');
    }
}