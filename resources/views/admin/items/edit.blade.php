@extends('layouts.admin')

@section('content')
<!-- Include Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    /* Customizing select2 to match Tailwind input height and border */
    .select2-container .select2-selection--single {
        height: 48px !important;
        border: 1px solid #e5e7eb !important;
        border-radius: 0.25rem !important;
        display: flex;
        align-items: center;
        padding-left: 0.5rem;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 46px !important;
    }
    .select2-error .select2-selection--single {
        border-color: #ef4444 !important;
    }
</style>

<div class="bg-white rounded shadow-sm border border-gray-100 mt-6 relative z-30 p-8 w-full">

    <!-- Card Header -->
    <div class="mb-8">
        <h2 class="text-xl font-bold text-[#1f2937] tracking-wide">Edit Item Forms</h2>
        <p class="text-[13px] text-gray-500 mt-1.5 font-medium">
            Please <span class="text-pink-500">.fill-all</span> input form with right value.
        </p>
    </div>

    <form action="{{ route('admin.items.update', $item->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Name Field -->
        <div class="mb-6">
            <label class="block mb-2 text-[14.5px] font-bold text-gray-700">Name</label>
            <div class="relative">
                <input 
                    type="text" 
                    name="name" 
                    value="{{ old('name', $item->name) }}"
                    class="w-full text-gray-700 bg-white border border-gray-200 rounded px-4 py-3 outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-shadow @error('name') !border-red-500 !ring-red-500 @enderror">
                
                @error('name')
                    <i class="fa-solid fa-circle-exclamation text-red-500 absolute right-4 top-1/2 transform -translate-y-1/2"></i>
                @enderror
            </div>
            @error('name')
                <p class="text-[#cc0000] text-[13px] mt-1.5 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Category Field -->
        <div class="mb-6">
            <label class="block mb-2 text-[14.5px] font-bold text-gray-700">Category</label>
            <div class="relative @error('category_id') select2-error @enderror">
                <select name="category_id" class="select2 w-full text-gray-700 bg-white border border-gray-200 rounded px-4 py-3 outline-none">
                    <option value="" disabled>Pilih Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $item->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                
                @error('category_id')
                    <i class="fa-solid fa-circle-exclamation text-red-500 absolute right-8 top-1/2 transform -translate-y-1/2 z-10 pointer-events-none"></i>
                @enderror
            </div>
            @error('category_id')
                <p class="text-[#cc0000] text-[13px] mt-1.5 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Total Field -->
        <div class="mb-6">
            <label class="block mb-2 text-[14.5px] font-bold text-gray-700">Total</label>
            <div class="flex relative">
                <input 
                    type="number" 
                    name="total" 
                    value="{{ old('total', $item->total) }}"
                    class="w-full text-gray-700 bg-white border border-gray-200 border-r-0 rounded-l px-4 py-3 outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-shadow @error('total') !border-red-500 !ring-red-500 @enderror">
                
                <div class="bg-gray-100 border border-gray-200 rounded-r px-5 flex items-center justify-center text-gray-500 text-[13px] font-medium @error('total') !border-red-500 @enderror">
                    item
                </div>

                @error('total')
                    <i class="fa-solid fa-circle-exclamation text-red-500 absolute right-20 top-1/2 transform -translate-y-1/2"></i>
                @enderror
            </div>
            @error('total')
                <p class="text-[#cc0000] text-[13px] mt-1.5 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- New Broke Item Field (Repair Accumulation) -->
        <div class="mb-8">
            <label class="block mb-2 text-[14.5px] font-bold text-gray-700">
                New Broke Item <span class="text-yellow-500 font-medium text-xs ml-1">(currently: {{ $item->repair }})</span>
            </label>
            <div class="flex relative">
                <input 
                    type="number" 
                    name="new_broke_item" 
                    value="{{ old('new_broke_item', 0) }}"
                    min="0"
                    class="w-full text-gray-700 bg-white border border-gray-200 border-r-0 rounded-l px-4 py-3 outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-shadow @error('new_broke_item') !border-red-500 !ring-red-500 @enderror">
                
                <div class="bg-gray-100 border border-gray-200 rounded-r px-5 flex items-center justify-center text-gray-500 text-[13px] font-medium @error('new_broke_item') !border-red-500 @enderror">
                    item
                </div>

                @error('new_broke_item')
                    <i class="fa-solid fa-circle-exclamation text-red-500 absolute right-20 top-1/2 transform -translate-y-1/2"></i>
                @enderror
            </div>
            @error('new_broke_item')
                <p class="text-[#cc0000] text-[13px] mt-1.5 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Buttons -->
        <div class="flex justify-end gap-3 pt-4">
            <a href="{{ route('admin.items.index') }}" class="px-6 py-2.5 bg-[#a1a1aa] hover:bg-gray-500 text-[#1f2937] hover:text-white font-medium rounded transition-colors text-[13px]">
                Cancel
            </a>
            <button type="submit" class="px-7 py-2.5 bg-[#8b5cf6] hover:bg-violet-600 text-white font-medium rounded transition-colors text-[13px] shadow-sm">
                Update
            </button>
        </div>

    </form>

</div>

<!-- Include jQuery and Select2 JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Pilih Category",
            allowClear: true
        });
    });
</script>
@endsection
