<?php

namespace App\Http\Controllers;

use App\Models\Store;

class StoreController extends Controller
{
    public function index()
    {
        return view('stores.index', [
            'stores' => Store::active()->orderBy('name')->get(),
        ]);
    }

    public function show(Store $store)
    {
        abort_unless($store->is_active, 404);

        return view('stores.show', compact('store'));
    }
}