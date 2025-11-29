<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class StoreController extends Controller
{
    public function edit()
    {
        $store = Auth::user()->store;
        return view('dashboard.seller.store.edit', compact('store'));
    }

    public function update(Request $request)
    {
        $store = Auth::user()->store;

        //validasi input
        $request->validate([
            'name' => 'required|string|max:255|unique:stores,name,' . $store->id,
            'description' => 'nullable|string',
            'address' => 'nullable|string|max:500',
        ]);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'slug' => Str::slug($request->name),
        ];

        if ($request->hasFile('logo')) {
            //hapus logo lama jika ada
            if ($store->logo) {
                Storage::disk('public')->delete($store->logo);
            }
            //simpan logo baru
            $data['logo'] = $request->file('logo')->store('stores', 'public');
        }

        $store->update($data);
        return redirect()->route('seller.store.edit')->with('success', 'Store updated successfully.');
    }
}
