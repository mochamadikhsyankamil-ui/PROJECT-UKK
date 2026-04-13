<?php

namespace App\Exports;

use App\Models\Lending;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class LendingExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Lending::with(['item', 'user'])->latest()->get();
    }

    public function headings(): array
    {
        return [
            'Item',
            'Total',
            'Name',
            'Ket.',
            'Date',
            'Returned',
            'Edited By'
        ];
    }

    public function map($lending): array
    {
        return [
            optional($lending->item)->name ?? 'Unknown item',
            $lending->total,
            $lending->name,
            $lending->notes ?? '-',
            Carbon::parse($lending->created_at)->format('j F, Y'),
            $lending->returned_at ? Carbon::parse($lending->returned_at)->format('j F, Y') : ' - ',
            optional($lending->user)->name ?? '-'
        ];
    }
}
