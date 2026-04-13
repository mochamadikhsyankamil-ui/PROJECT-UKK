@extends('layouts.admin')

@section('content')
<div class="bg-white rounded shadow-sm border border-gray-100 mt-6 relative z-30 overflow-hidden">
    
    <!-- Card Header -->
    <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-white">
        <div>
            <h2 class="text-[17px] font-bold text-[#1f2937]">Items Table</h2>
            <p class="text-[13px] text-gray-500 mt-1">
                Add, delete, update <span class="text-pink-500 font-medium">.items</span>
            </p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.items.export') }}" class="flex items-center gap-2 bg-[#8b5cf6] hover:bg-violet-600 transition-colors text-white px-5 py-2.5 rounded text-[13px] font-semibold">
                Export Excel
            </a>
            <a href="{{ route('admin.items.create') }}" class="flex items-center gap-2 bg-[#10b981] hover:bg-emerald-600 transition-colors text-white px-5 py-2.5 rounded text-[13px] font-semibold">
                <i class="fa-solid fa-bars"></i>
                Add
            </a>
        </div>
    </div>

    <!-- Session Success Alert -->
    @if(session('success'))
    <div class="bg-emerald-50 text-emerald-600 px-6 py-3 border-b border-emerald-100 text-sm font-medium">
        {{ session('success') }}
    </div>
    @endif

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-700">
            <thead>
                <tr class="border-b border-gray-100 bg-white">
                    <th class="px-6 py-4 font-semibold text-gray-600 w-16 text-center">#</th>
                    <th class="px-6 py-4 font-semibold text-gray-600">Category</th>
                    <th class="px-6 py-4 font-semibold text-gray-600">Name</th>
                    <th class="px-6 py-4 font-semibold text-gray-600 text-center">Total</th>
                    <th class="px-6 py-4 font-semibold text-gray-600 text-center">Repair</th>
                    <th class="px-6 py-4 font-semibold text-gray-600 text-center">Lending</th>
                    <th class="px-6 py-4 font-semibold text-gray-600 text-center w-32">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $index => $item)
                <tr class="border-b border-gray-50 hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-5 text-center font-medium">{{ $index + 1 }}</td>
                    <td class="px-6 py-5">{{ $item->category->name ?? '-' }}</td>
                    <td class="px-6 py-5">{{ $item->name }}</td>
                    <td class="px-6 py-5 text-center">{{ $item->total }}</td>
                    <td class="px-6 py-5 text-center">{{ $item->repair }}</td>
                    <td class="px-6 py-5 text-center">
                        @if($item->lending_total > 0)
                            <a href="{{ route('admin.items.lendings', $item->id) }}" class="text-blue-500 hover:text-blue-700 font-bold underline transition-colors">{{ $item->lending_total }}</a>
                        @else
                            <span class="text-gray-500 font-medium">0</span>
                        @endif
                    </td>
                    <td class="px-6 py-5 text-center">
                        <a href="{{ route('admin.items.edit', $item->id) }}" class="inline-block bg-[#8b5cf6] hover:bg-violet-600 text-white text-[13px] font-medium px-6 py-2 rounded transition-colors shadow-sm">
                            Edit
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">Tidak ada data item.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
