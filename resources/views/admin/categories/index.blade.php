@extends('layouts.admin')

@section('content')
<div class="bg-white rounded shadow-sm border border-gray-100 mt-6 relative z-30 overflow-hidden">
    
    <!-- Card Header -->
    <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-white">
        <div>
            <h2 class="text-[17px] font-bold text-[#1f2937]">Categories Table</h2>
            <p class="text-[13px] text-gray-500 mt-1">
                Add, delete, update <span class="text-pink-500 font-medium">.categories</span>
            </p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="flex items-center gap-2 bg-[#10b981] hover:bg-emerald-600 transition-colors text-white px-5 py-2.5 rounded text-[13px] font-semibold">
            <i class="fa-solid fa-bars"></i>
            Add
        </a>
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
                    <th class="px-6 py-4 font-semibold text-gray-600">Name</th>
                    <th class="px-6 py-4 font-semibold text-gray-600">Division PJ</th>
                    <th class="px-6 py-4 font-semibold text-gray-600 text-center">Total Items</th>
                    <th class="px-6 py-4 font-semibold text-gray-600 text-center w-32">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $index => $category)
                <tr class="border-b border-gray-50 hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-5 text-center font-medium">{{ $index + 1 }}</td>
                    <td class="px-6 py-5">{{ $category->name }}</td>
                    <td class="px-6 py-5 text-gray-600">{{ $category->division_pj }}</td>
                    <td class="px-6 py-5 text-center font-bold text-gray-700">{{ $category->items()->count() }}</td>
                    <td class="px-6 py-5 text-center">
                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="inline-block bg-[#8b5cf6] hover:bg-violet-600 text-white text-[13px] font-medium px-6 py-2 rounded transition-colors shadow-sm">
                            Edit
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">Tidak ada data kategori.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
