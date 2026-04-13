<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lending;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use App\Exports\LendingExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class LendingController extends Controller
{
    public function index()
    {
        // Menyajikan data lengkap dengan timestamp ascending (yang terbaru di atas)
        $lendings = Lending::with(['item', 'user'])->latest()->get();
        return view('operator.lendings.index', compact('lendings'));
    }

    // EXPORT EXCEL
    public function export()
    {
        return Excel::download(new LendingExport, 'lending-data.xlsx');
    }

    // 🆕 EXPORT PDF PER TRANSAKSI
    public function exportPdf($id)
    {
        $lending = Lending::with(['item','user'])->findOrFail($id);

        $pdf = Pdf::loadView('operator.lendings.pdf', compact('lending'))
                  ->setPaper('A4','portrait');

        return $pdf->download('lending-'.$lending->id.'.pdf');
    }

    public function create()
    {
        $items = Item::all();
        return view('operator.lendings.create', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'item_id' => 'required|array|min:1',
            'item_id.*' => 'required|exists:items,id',
            'total' => 'required|array|min:1',
            'total.*' => 'required|numeric|min:1',
            'notes' => 'nullable|string',
        ], [
            'name.required' => 'The name field is required.',
        ]);

        // cek stok
        foreach ($request->item_id as $key => $itemId) {
            $requestedTotal = $request->total[$key] ?? 0;
            $item = Item::find($itemId);

            if ($item->available < $requestedTotal) {
                return redirect()->back()->withInput()->with('error', 'Total item more than available!');
            }
        }

        // simpan data lending
        foreach ($request->item_id as $key => $itemId) {
            $requestedTotal = $request->total[$key] ?? 0;

            Lending::create([
                'user_id' => Auth::id(),
                'item_id' => $itemId,
                'name' => $request->name,
                'total' => $requestedTotal,
                'notes' => $request->notes,
            ]);
        }

        return redirect()->route('operator.lendings.index')
            ->with('success', 'Success add new lending item!');
    }

    public function markReturned(Lending $lending)
    {
        if (!$lending->returned_at) {
            $lending->update(['returned_at' => now()]);
            return redirect()->route('operator.lendings.index')
                ->with('success', 'Item is returned!');
        }

        return redirect()->route('operator.lendings.index');
    }

    public function destroy(Lending $lending)
    {
        $lending->delete();
        return redirect()->route('operator.lendings.index')
            ->with('success', 'Deleted successfully!');
    }
}
