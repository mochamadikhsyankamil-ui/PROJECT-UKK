@extends('layouts.admin')

@section('content')
<div class="bg-white rounded shadow-sm border border-gray-100 mt-6 relative z-30 p-8 w-full">

    <!-- Card Header -->
    <div class="mb-8">
        <h2 class="text-xl font-bold text-[#1f2937] tracking-wide">Add Category Forms</h2>
        <p class="text-[13px] text-gray-500 mt-1.5 font-medium">
            Please <span class="text-pink-500">.fill-all</span> input form with right value.
        </p>
    </div>

    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf

        <!-- Name Field -->
        <div class="mb-6">
            <label class="block mb-2 text-[14.5px] font-bold text-gray-700">Name</label>
            <div class="relative">
                <input 
                    type="text" 
                    name="name" 
                    value="{{ old('name') }}"
                    placeholder="Alat Dapur"
                    class="w-full text-gray-700 bg-white border border-gray-200 rounded px-4 py-3 outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-shadow @error('name') !border-red-500 !ring-red-500 @enderror">
                
                @error('name')
                    <i class="fa-solid fa-circle-exclamation text-red-500 absolute right-4 top-1/2 transform -translate-y-1/2"></i>
                @enderror
            </div>
            @error('name')
                <p class="text-[#cc0000] text-[13px] mt-1.5 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Division PJ Field -->
        <div class="mb-8">
            <label class="block mb-2 text-[14.5px] font-bold text-gray-700">Division PJ</label>
            <div class="flex">
                <div class="bg-gray-100 border border-gray-200 border-r-0 rounded-l px-5 flex items-center justify-center text-gray-400">
                    <i class="fa-solid fa-user-large"></i>
                </div>
                <div class="relative flex-1">
                    <select 
                        name="division_pj" 
                        class="w-full appearance-none text-gray-700 bg-white border border-gray-200 rounded-r px-4 py-3 outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-shadow @error('division_pj') !border-red-500 !ring-red-500 @enderror">
                        <option value="" disabled selected class="text-gray-400">Select Division PJ</option>
                        <option value="Sarpras" {{ old('division_pj') == 'Sarpras' ? 'selected' : '' }}>Sarpras</option>
                        <option value="Tata Usaha" {{ old('division_pj') == 'Tata Usaha' ? 'selected' : '' }}>Tata Usaha</option>
                        <option value="tefa" {{ old('division_pj') == 'tefa' ? 'selected' : '' }}>tefa</option>
                    </select>
                    
                    @error('division_pj')
                        <i class="fa-solid fa-circle-exclamation text-red-500 absolute right-4 top-1/2 transform -translate-y-1/2"></i>
                    @enderror
                </div>
            </div>
            @error('division_pj')
                <p class="text-[#cc0000] text-[13px] mt-1.5 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Buttons -->
        <div class="flex justify-end gap-3 pt-4">
            <a href="{{ route('admin.categories.index') }}" class="px-6 py-2.5 bg-[#a1a1aa] hover:bg-gray-500 text-[#1f2937] hover:text-white font-medium rounded transition-colors text-[13px]">
                Cancel
            </a>
            <button type="submit" class="px-7 py-2.5 bg-[#8b5cf6] hover:bg-violet-600 text-white font-medium rounded transition-colors text-[13px] shadow-sm">
                Submit
            </button>
        </div>

    </form>

</div>
@endsection
