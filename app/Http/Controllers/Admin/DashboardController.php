<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;
use App\Models\Lending;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik utama
        $totalCategories = Category::count();
        $totalItems      = Item::sum('total');
        $borrowedItems   = Lending::whereNull('returned_at')->sum('total');
        $availableStock  = $totalItems - $borrowedItems;

        return view('admin.dashboard', compact(
            'totalCategories',
            'totalItems',
            'borrowedItems',
            'availableStock'
        ));
    }
}
