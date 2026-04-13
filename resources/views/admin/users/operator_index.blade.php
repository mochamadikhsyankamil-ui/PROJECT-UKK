@extends('layouts.admin')

@section('content')
<div class="bg-white rounded shadow-sm border border-gray-100 mt-6 relative z-30 overflow-hidden">
    
    <!-- Card Header -->
    <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-white">
        <div>
            <h2 class="text-[17px] font-bold text-[#1f2937] capitalize">Operator Accounts Table</h2>
            <p class="text-[13px] text-gray-500 mt-1">
                Add, delete, update <span class="text-pink-500 font-medium">.operator-accounts</span>
                <br>
                <span class="text-gray-400">p.s password 4 character of email and nomor.</span>
            </p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.users.export', ['role' => 'operator']) }}" class="flex items-center gap-2 bg-[#8b5cf6] hover:bg-violet-600 transition-colors text-white px-5 py-2.5 rounded text-[13px] font-semibold">
                Export Excel
            </a>
            <a href="{{ route('admin.users.create') }}" class="flex items-center gap-2 bg-[#10b981] hover:bg-emerald-600 transition-colors text-white px-5 py-2.5 rounded text-[13px] font-semibold">
                <i class="fa-solid fa-bars"></i>
                Add
            </a>
        </div>
    </div>

    <!-- Session Success Alert -->
    @if(session('success'))
    <div class="bg-emerald-50 text-emerald-600 px-6 py-4 border-b border-emerald-100 text-sm font-medium flex items-center justify-between">
        <span>{{ session('success') }}</span>
        <button onclick="this.parentElement.style.display='none'" class="text-emerald-700 font-bold hover:text-emerald-900">&times;</button>
    </div>
    @endif

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-700">
            <thead>
                <tr class="border-b border-gray-100 bg-white">
                    <th class="px-6 py-4 font-semibold text-gray-600 w-16 text-center">#</th>
                    <th class="px-6 py-4 font-semibold text-gray-600">Name</th>
                    <th class="px-6 py-4 font-semibold text-gray-600">Email</th>
                    <th class="px-6 py-4 font-semibold text-gray-600 text-center w-48">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $index => $user)
                <tr class="border-b border-gray-50 hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-5 text-center font-medium">{{ $index + 1 }}</td>
                    <td class="px-6 py-5">{{ $user->name }}</td>
                    <td class="px-6 py-5">{{ $user->email }}</td>
                    <td class="px-6 py-5 text-center flex justify-center gap-2">
                        
                        <form action="{{ route('admin.users.reset-password', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin me-reset password akun operator ini?');">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="inline-block bg-[#facc15] hover:bg-yellow-500 text-white text-[13px] font-medium px-4 py-2 rounded transition-colors shadow-sm">
                                Reset Password
                            </button>
                        </form>

                        <!-- Form Delete Mungil -->
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-block bg-[#ef4444] hover:bg-red-600 text-white text-[13px] font-medium px-4 py-2 rounded transition-colors shadow-sm">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">Tidak ada data akun operator.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
