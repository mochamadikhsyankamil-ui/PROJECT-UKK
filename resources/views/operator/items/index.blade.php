@extends('layouts.admin')

@section('content')
<div class="bg-white rounded shadow-sm border border-gray-100 mt-6 relative z-30 overflow-hidden">
    
    <!-- Card Header -->
    <div class="px-8 py-6 border-b border-gray-100 bg-white">
        <h2 class="text-[17px] font-bold text-[#1f2937] capitalize">Data Items</h2>
        <p class="text-[13px] text-gray-500 mt-1">
            Data of <span class="text-green-500 font-medium">.items</span>
        </p>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-700">
            <thead>
                <tr class="border-b border-gray-100 bg-white">
                    <th class="px-8 py-5 font-semibold text-gray-600 w-16 text-center">#</th>
                    <th class="px-6 py-5 font-semibold text-gray-600">Category</th>
                    <th class="px-6 py-5 font-semibold text-gray-600">Name</th>
                    <th class="px-6 py-5 font-semibold text-gray-600 text-center">Total</th>
                    <th class="px-6 py-5 font-semibold text-gray-600 text-center">Available</th>
                    <th class="px-6 py-5 font-semibold text-gray-600 text-center">Lending Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $index => $item)
                <tr class="border-b border-gray-50 hover:bg-gray-50 transition-colors">
                    <td class="px-8 py-5 text-center text-gray-500">{{ $index + 1 }}</td>
                    <td class="px-6 py-5 text-gray-600">{{ optional($item->category)->name ?? '-' }}</td>
                    <td class="px-6 py-5 font-semibold text-gray-800">{{ $item->name }}</td>
                    <td class="px-6 py-5 text-center font-medium">{{ $item->total }}</td>
                    <!-- Kolom hitungan dinami -->
                    <td class="px-6 py-5 text-center font-bold text-gray-700">{{ $item->available }}</td>
                    <td class="px-6 py-5 text-center">
                        @if($item->lending_total > 0)
                            <a href="{{ route('admin.items.lendings', $item->id) }}" class="text-blue-500 hover:text-blue-700 font-bold underline transition-colors">{{ $item->lending_total }}</a>
                        @else
                            <span class="text-gray-500 font-semibold">{{ $item->lending_total }}</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-8 py-8 text-center text-gray-500">Belum ada data barang.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
