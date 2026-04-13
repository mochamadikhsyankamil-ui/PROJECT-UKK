@extends('layouts.admin')

@section('content')
<div class="bg-white rounded shadow-sm border border-gray-100 mt-6 relative z-30 overflow-hidden">
    
    <!-- Flash Error untuk stok abis -->
    @if(session('error'))
    <div class="bg-[#fee2e2] text-[#991b1b] px-8 py-5 text-sm font-medium border-b border-[#fecaca] drop-shadow-sm">
        {{ session('error') }}
    </div>
    @endif
    
    @if ($errors->any())
        <div class="bg-red-100 text-red-800 px-8 py-5 text-sm font-medium border-b border-red-200">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="px-8 py-8">
        <h2 class="text-xl font-bold text-[#1f2937] capitalize mb-1">Lending Form</h2>
        <p class="text-[13px] text-gray-500 mb-8">
            Please <span class="text-pink-500 font-medium">.fill-all</span> input form with right value.
        </p>

        <form action="{{ route('operator.lendings.store') }}" method="POST">
            @csrf
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                <input type="text" name="name" class="w-full px-4 py-3 bg-gray-50/50 border border-gray-100 rounded focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition-all text-sm placeholder-gray-400 font-medium" placeholder="Name" required value="{{ old('name') }}">
            </div>

            <!-- Dynamic DOM array -->
            <div id="items-wrapper">
                <!-- Base Item Row -->
                <div class="relative bg-white mb-2 item-row" data-index="0">
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Items</label>
                        <select name="item_id[]" class="w-full px-4 py-3 bg-gray-50/50 border border-gray-100 rounded focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition-all text-sm text-gray-600 font-medium" required>
                            <option value="">Select Items</option>
                            @foreach($items as $i)
                                <option value="{{ $i->id }}">{{ $i->name }} (Available: {{ $i->available }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-2 relative">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Total</label>
                        <input type="number" name="total[]" class="w-full px-4 py-3 bg-gray-50/50 border border-gray-100 rounded focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition-all text-sm placeholder-gray-300 font-medium" placeholder="total item" required min="1">
                    </div>
                </div>
            </div>

            <!-- Toggle More (Tombol pengganda) -->
            <div class="mb-6 mt-2">
                <button type="button" onclick="addMoreItemRow()" class="text-[#06b6d4] hover:text-cyan-600 font-bold text-[13px] flex items-center gap-1.5 transition-colors">
                    <i class="fa-solid fa-chevron-down text-[10px]"></i> More
                </button>
            </div>

            <div class="mb-8">
                <label class="block text-sm font-medium text-gray-700 mb-2">Ket.</label>
                <textarea name="notes" rows="3" class="w-full px-4 py-3 bg-gray-50/50 border border-gray-100 rounded focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition-all text-sm placeholder-gray-400 font-medium" placeholder="">{{ old('notes') }}</textarea>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-[#8b5cf6] hover:bg-violet-600 text-white font-medium py-2 px-8 rounded text-[13px] transition-colors shadow-sm">
                    Submit
                </button>
                <a href="{{ route('operator.lendings.index') }}" class="bg-gray-50 border border-gray-200 hover:bg-gray-100 text-gray-600 font-medium py-2 px-6 rounded text-[13px] transition-colors cursor-pointer text-center inline-block">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    let itemIndex = 1;

    function addMoreItemRow() {
        const wrapper = document.getElementById('items-wrapper');
        
        // Memakai padding dan BG yang sedikit berbeda di row cloningan untuk penanda sub-form
        const rowHTML = `
            <div class="relative bg-gray-50 p-5 border border-gray-200 rounded mb-4 mt-6 item-row group transition-all" id="row-${itemIndex}">
                
                <!-- Cross / Remove Button in the top right -->
                <button type="button" onclick="removeRow(${itemIndex})" class="absolute top-3 right-3 flex items-center justify-center w-6 h-6 bg-red-100 text-red-600 hover:bg-red-600 hover:text-white rounded shadow-sm transition-colors" title="Remove this item">
                    <i class="fa-solid fa-xmark text-[11px] font-bold"></i>
                </button>

                <div class="mb-5">
                    <label class="block text-[13px] font-semibold text-gray-700 mb-2">Items</label>
                    <select name="item_id[]" class="w-full px-4 py-3 bg-white border border-gray-200 rounded focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition-all text-sm text-gray-600 font-medium" required>
                        <option value="">Select Items</option>
                        @foreach($items as $i)
                            <option value="{{ $i->id }}">{{ $i->name }} (Available: {{ $i->available }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-1">
                    <label class="block text-[13px] font-semibold text-gray-700 mb-2">Total</label>
                    <input type="number" name="total[]" class="w-full px-4 py-3 bg-white border border-gray-200 rounded focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition-all text-sm placeholder-gray-300 font-medium shadow-sm" placeholder="total item" required min="1">
                </div>
            </div>
        `;

        wrapper.insertAdjacentHTML('beforeend', rowHTML);
        itemIndex++;
    }

    function removeRow(id) {
        const row = document.getElementById('row-' + id);
        if(row) {
            row.remove();
        }
    }
</script>
@endsection
