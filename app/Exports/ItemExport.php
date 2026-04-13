<?php

namespace App\Exports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ItemExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Menyertakan relasi category agar tidak berat saat pemanggilan tabel (Eager Loading)
        return Item::with('category')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Category',
            'Name Item',
            'Total',
            'Repair Total',
            'Last Updated',
        ];
    }

    /**
    * Menerjemahkan data row Excel dengan aturan khusus (seperti 0 menjadi -)
    * 
    * @var Item $item
    * @return array
    */
    public function map($item): array
    {
        return [
            $item->category->name ?? '-',
            $item->name,
            $item->total,
            $item->repair == 0 ? '-' : $item->repair,
            $item->updated_at->format('M j, Y')
        ];
    }
}
