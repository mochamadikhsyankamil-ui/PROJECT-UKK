<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Item;
use App\Models\Category;
use App\Exports\ItemExport;
use Maatwebsite\Excel\Facades\Excel;

class ItemController extends Controller
{
    public function export()
    {
        return Excel::download(new ItemExport, 'items.xlsx');
    }

    public function index()
    {
        if (\Illuminate\Support\Facades\Auth::user()->role === 'operator') {
            $items = Item::with('category')->get();
            return view('operator.items.index', compact('items'));
        }

        $items = Item::with('category')->get();
        return view('admin.items.index', compact('items'));
    }

    public function showLendings(Item $item)
    {
        // Memuat record peminjaman hanya untuk item tertentu dengan urutan terbaru di atas
        $lendings = $item->lendings()->with('user')->latest()->get();
        return view('admin.items.lendings', compact('item', 'lendings'));
    }

    public function create()
    {
        if (\Illuminate\Support\Facades\Auth::user()->role === 'operator') abort(403);
        $categories = Category::all();
        return view('admin.items.create', compact('categories'));
    }

    public function store(Request $request)
    {
        if (\Illuminate\Support\Facades\Auth::user()->role === 'operator') abort(403);
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'total' => 'required|numeric|min:1',
        ], [
            'name.required' => 'The name field is required.',
            'category_id.required' => 'The category id field is required.',
            'total.required' => 'The total field is required.',
        ]);

        Item::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'total' => $request->total,
            'repair' => 0,
        ]);

        return redirect()->route('admin.items.index')->with('success', 'Item added successfully.');
    }

    public function edit(Item $item)
    {
        if (\Illuminate\Support\Facades\Auth::user()->role === 'operator') abort(403);
        $categories = Category::all();
        return view('admin.items.edit', compact('item', 'categories'));
    }

    public function update(Request $request, Item $item)
    {
        if (\Illuminate\Support\Facades\Auth::user()->role === 'operator') abort(403);
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'total' => 'required|numeric',
            'new_broke_item' => 'nullable|numeric|min:0',
        ], [
            'name.required' => 'The name field is required.',
            'category_id.required' => 'The category id field is required.',
            'total.required' => 'The total field is required.',
        ]);

        $item->name = $request->name;
        $item->category_id = $request->category_id;
        $item->total = $request->total;
        
        if ($request->filled('new_broke_item') && $request->new_broke_item > 0) {
            $item->repair += $request->new_broke_item;
        }

        $item->save();

        return redirect()->route('admin.items.index')->with('success', 'Item updated successfully.');
    }
}
