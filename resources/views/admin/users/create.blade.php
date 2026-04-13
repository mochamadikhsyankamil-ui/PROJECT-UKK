@extends('layouts.admin')

@section('content')
<div class="bg-white rounded shadow-sm border border-gray-100 mt-6 relative z-30 p-8 w-full">

    <!-- Card Header -->
    <div class="mb-8">
        <h2 class="text-xl font-bold text-[#1f2937] tracking-wide">Add Account Forms</h2>
        <p class="text-[13px] text-gray-500 mt-1.5 font-medium">
            Please <span class="text-pink-500">.fill-all</span> input form with right value.
        </p>
    </div>

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf

        <!-- Name Field -->
        <div class="mb-6">
            <label class="block mb-2 text-[14.5px] font-bold text-gray-700">Name</label>
            <div class="relative">
                <input 
                    type="text" 
                    name="name" 
                    value="{{ old('name') }}"
                    placeholder="Fema Flamelina Putri"
                    class="w-full text-gray-700 bg-white border border-gray-200 rounded px-4 py-3 outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-shadow @error('name') !border-red-500 !ring-red-500 @enderror">
                
                @error('name')
                    <i class="fa-solid fa-circle-exclamation text-red-500 absolute right-4 top-1/2 transform -translate-y-1/2"></i>
                @enderror
            </div>
            @error('name')
                <p class="text-[#cc0000] text-[13px] mt-1.5 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email Field -->
        <div class="mb-6">
            <label class="block mb-2 text-[14.5px] font-bold text-gray-700">Email</label>
            <div class="relative">
                <input 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}"
                    placeholder="femaflam22@gmail.com"
                    class="w-full text-gray-700 bg-white border border-gray-200 rounded px-4 py-3 outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-shadow @error('email') !border-red-500 !ring-red-500 @enderror">
                
                @error('email')
                    <i class="fa-solid fa-circle-exclamation text-red-500 absolute right-4 top-1/2 transform -translate-y-1/2"></i>
                @enderror
            </div>
            @error('email')
                <p class="text-[#cc0000] text-[13px] mt-1.5 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Role Field -->
        <div class="mb-8">
            <label class="block mb-2 text-[14.5px] font-bold text-gray-700">Role</label>
            <div class="relative">
                <select 
                    name="role" 
                    class="w-full appearance-none text-gray-700 bg-white border border-gray-200 rounded px-4 py-3 outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-shadow @error('role') !border-red-500 !ring-red-500 @enderror">
                    <option value="" disabled selected class="text-gray-400">Select Role</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>admin</option>
                    <option value="operator" {{ old('role') == 'operator' ? 'selected' : '' }}>operator</option>
                </select>
                
                @error('role')
                    <i class="fa-solid fa-circle-exclamation text-red-500 absolute right-8 top-1/2 transform -translate-y-1/2"></i>
                @enderror
            </div>
            @error('role')
                <p class="text-[#cc0000] text-[13px] mt-1.5 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Buttons -->
        <div class="flex justify-end gap-3 pt-4">
            <!-- Cancel Button meredirect ke role admin jika null, tp fallback saja -->
            <a href="{{ route('admin.users.index', ['role' => 'admin']) }}" class="px-6 py-2.5 bg-[#a1a1aa] hover:bg-gray-500 text-[#1f2937] hover:text-white font-medium rounded transition-colors text-[13px]">
                Cancel
            </a>
            <button type="submit" class="px-7 py-2.5 bg-[#8b5cf6] hover:bg-violet-600 text-white font-medium rounded transition-colors text-[13px] shadow-sm">
                Submit
            </button>
        </div>

    </form>

</div>
@endsection
