@extends('layouts.admin')

@section('content')
    @if(session('success'))
    <div class="bg-[#dcfce7] text-[#166534] px-6 py-4 mb-4 text-sm font-medium border border-[#bbf7d0] rounded shadow-sm">
        {{ session('success') }}
    </div>
    @endif

<div class="bg-white rounded shadow-sm border border-gray-100 p-8">
    <h2 class="text-xl font-bold text-gray-800 mb-2">Welcome to Operator Dashboard</h2>
    <p class="text-[13px] text-gray-500">
        Silakan bernavigasi ke menu <span class="font-bold text-blue-600">Items</span> atau <span class="font-bold text-[#8b5cf6]">Lending</span> melalui panel Sidebar di sebelah kiri.
    </p>
</div>
@endsection
