<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();
        return view('inventory', compact('items'));
    }

    public function store(Request $request)
    {
        Item::create($request->all());
        return back();
    }

    public function update(Request $request, Item $item)
    {
        $item->update($request->all());
        return back();
    }

    public function destroy(Item $item)
    {
        $item->delete();
        return back();
    }
}