@extends('layouts.admin')

@section('content')
<div class="bg-white rounded shadow-sm border border-gray-100 mt-6 relative z-30 overflow-hidden">
    
    <!-- Card Header -->
    <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-white">
        <div>
            <h2 class="text-[17px] font-bold text-[#1f2937] capitalize">Lending Table</h2>
            <p class="text-[13px] text-gray-500 mt-1">
                Data of <span class="text-pink-500 font-medium">.lendings</span>
            </p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.items.index') }}" class="flex items-center gap-2 bg-[#a1a1aa] hover:bg-gray-500 transition-colors text-white px-5 py-2.5 rounded text-[13px] font-semibold">
                Back
            </a>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-700">
            <thead>
                <tr class="border-b border-gray-100 bg-white">
                    <th class="px-6 py-4 font-semibold text-gray-600 w-16 text-center">#</th>
                    <th class="px-6 py-4 font-semibold text-gray-600">Item</th>
                    <th class="px-6 py-4 font-semibold text-gray-600">Total</th>
                    <th class="px-6 py-4 font-semibold text-gray-600">Name</th>
                    <th class="px-6 py-4 font-semibold text-gray-600 w-64">Ket.</th>
                    <th class="px-6 py-4 font-semibold text-gray-600">Date</th>
                    <th class="px-6 py-4 font-semibold text-gray-600 text-center">Returned</th>
                    <th class="px-6 py-4 font-semibold text-gray-600 text-center">Edited By</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lendings as $index => $lending)
                <tr class="border-b border-gray-50 hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-5 text-center font-medium">{{ $index + 1 }}</td>
                    <td class="px-6 py-5">{{ $item->name }}</td>
                    <td class="px-6 py-5">{{ $lending->total }}</td>
                    <td class="px-6 py-5 font-medium">{{ $lending->name }}</td>
                    <td class="px-6 py-5 text-gray-600 break-words">{{ $lending->notes ?? '-' }}</td>
                    <td class="px-6 py-5 whitespace-nowrap">{{ \Carbon\Carbon::parse($lending->created_at)->format('j F, Y') }}</td>
                    <td class="px-6 py-5 text-center">
                        @if(!$lending->returned_at)
                            <div class="inline-block px-3 py-1.5 text-[11px] font-bold border rounded text-[#d97706] border-[#fcd34d]">
                                not returned
                            </div>
                        @else
                            <div class="inline-block px-3 py-1.5 text-[11px] font-bold border rounded text-[#059669] border-[#34d399]">
                                returned
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-5 text-center font-bold text-gray-800">
                        {{ optional($lending->user)->name ?? '-' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-8 text-center text-gray-500">Belum ada riwayat peminjaman untuk barang ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
