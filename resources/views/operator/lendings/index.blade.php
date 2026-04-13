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

        <div class="flex gap-3 items-center">
            <form method="GET" class="flex items-center gap-2">
                <input type="date" name="date" value="{{ request('date') }}" class="border rounded px-3 py-2 text-sm">
                <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-sm">Filter</button>

                @if(request('date'))
                <a href="{{ route('operator.lendings.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded text-sm">
                    Reset
                </a>
                @endif
            </form>

            <a href="{{ route('operator.lendings.export') }}" class="bg-[#8b5cf6] hover:bg-violet-600 text-white px-5 py-2.5 rounded text-[13px] font-semibold">
                Export Excel
            </a>

            <a href="{{ route('operator.lendings.create') }}" class="bg-[#10b981] hover:bg-emerald-600 text-white px-5 py-2.5 rounded text-[13px] font-semibold">
                Add
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-[#dcfce7] text-[#166534] px-6 py-4 text-sm font-medium border-b border-[#bbf7d0]">
        {{ session('success') }}
    </div>
    @endif

    <!-- TABLE -->
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-700">
            <thead>
                <tr class="border-b border-gray-100 bg-white">
                    <th class="px-6 py-4 text-center">#</th>
                    <th class="px-6 py-4">Item</th>
                    <th class="px-6 py-4 text-center">Total</th>
                    <th class="px-6 py-4">Name</th>
                    <th class="px-6 py-4">Ket.</th>
                    <th class="px-6 py-4">Date</th>
                    <th class="px-6 py-4">Returned</th>
                    <th class="px-6 py-4">Edited By</th>
                    <th class="px-6 py-4 text-center">Action</th>
                </tr>
            </thead>
            @viteReactRefresh
            @vite('resources/js/app.jsx')
            <tbody>
            @forelse($lendings as $index => $item)
            <tr class="border-b hover:bg-gray-50">
                <td class="px-6 py-5 text-center">{{ $index+1 }}</td>
                <td class="px-6 py-5">{{ optional($item->item)->name }}</td>
                <td class="px-6 py-5 text-center">{{ $item->total }}</td>
                <td class="px-6 py-5">{{ $item->name }}</td>
                <td class="px-6 py-5">{{ $item->notes }}</td>
                <td class="px-6 py-5">{{ $item->created_at->format('j F, Y') }}</td>

                <td class="px-6 py-5">
                    @if(!$item->returned_at)
                        <span class="text-yellow-600 font-bold">Not returned</span>
                    @else
                        <span class="text-green-600 font-bold">{{ $item->returned_at->format('j F, Y') }}</span>
                    @endif
                </td>

                <td class="px-6 py-5">{{ optional($item->user)->name }}</td>

                <td class="px-6 py-5 text-center flex gap-2 justify-center">

                    {{-- BUTTON RETURN + TTD --}}
                    @if(!$item->returned_at)
                    <button onclick="openReturnModal({{ $item->id }})"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">
                        Returned + TTD
                    </button>
                    @endif

                    <form action="{{ route('operator.lendings.destroy',$item->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
                            Delete
                        </button>
                    </form>

                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center py-10 text-gray-400">
                    Belum ada data peminjaman
                </td>
            </tr>
            @endforelse
            </tbody>

        </table>
    </div>
</div>

{{-- ================= MODAL TTD RETURN ================= --}}
<div id="returnModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white w-[700px] rounded-xl p-6">

        <h2 class="text-xl font-bold mb-4">Tanda Tangan Pengembalian</h2>

<form id="returnForm" method="POST">
    @csrf
    @method('PATCH')

    {{-- React Signature Canvas Mount Point --}}
    <div id="react-return-modal"></div>

    {{-- Hidden input hasil signature React --}}
    <input type="hidden" name="return_operator_sign_1" id="r_input1">
    <input type="hidden" name="return_operator_sign_2" id="r_input2">
    <input type="hidden" name="return_borrower_sign_1" id="r_input3">
    <input type="hidden" name="return_borrower_sign_2" id="r_input4">

    <div class="flex justify-end gap-3 mt-6">
        <button type="button" onclick="closeReturnModal()" class="px-4 py-2 bg-gray-400 text-white rounded">
            Cancel
        </button>

        <!-- tombol ini trigger React ambil tanda tangan -->
        <button type="submit"
            onclick="document.getElementById('reactSubmitSign').click()"
            class="px-4 py-2 bg-green-600 text-white rounded">
            Submit Return
        </button>
    </div>
</form>
    </div>
</div>


<script>
let pad1,pad2,pad3,pad4;

function openReturnModal(id){
    document.getElementById('returnModal').classList.remove('hidden');
    document.getElementById('returnModal').classList.add('flex');
    document.getElementById('returnForm').action = "/operator/lendings/"+id+"/return";
    initPads();
}

function closeReturnModal(){
    document.getElementById('returnModal').classList.add('hidden');
}

function initPads(){
    pad1 = new SignaturePad(document.getElementById('r_sign1'));
    pad2 = new SignaturePad(document.getElementById('r_sign2'));
    pad3 = new SignaturePad(document.getElementById('r_sign3'));
    pad4 = new SignaturePad(document.getElementById('r_sign4'));
}

document.getElementById("returnForm").addEventListener("submit", function () {
    document.getElementById('r_input1').value = pad1.toDataURL();
    document.getElementById('r_input2').value = pad2.toDataURL();
    document.getElementById('r_input3').value = pad3.toDataURL();
    document.getElementById('r_input4').value = pad4.toDataURL();
});
</script>
@viteReactRefresh
@vite('resources/js/app.jsx')
@endsection
