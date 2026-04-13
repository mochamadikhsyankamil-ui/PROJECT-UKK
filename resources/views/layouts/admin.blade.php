<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar { background-color: #2b45a0; }
        .sidebar-active { background-color: #1e3381; }
        .menu-title { font-size: 0.65rem; padding-left: 0.25rem; }
    </style>
</head>
<body class="bg-gray-100 flex h-screen overflow-hidden text-sm font-sans">

    <!-- Sidebar -->
    <aside class="sidebar w-64 flex-shrink-0 text-white flex flex-col h-full shadow-lg z-20 relative">
        <div class="px-6 py-8">
            <div class="menu-title font-semibold mb-3 text-blue-200 tracking-wider">Menu</div>
            <a href="{{ Auth::user()->role === 'admin' ? route('admin') : route('operator') }}" class="{{ request()->routeIs('admin') || request()->routeIs('operator') ? 'sidebar-active border-white' : 'border-transparent hover:bg-blue-800' }} px-4 py-3 border-l-4 flex items-center mb-6 transition-colors">
                <i class="fa-solid fa-table-columns w-6"></i>
                <span class="font-semibold text-[13px]">Dashboard</span>
            </a>

            <div class="menu-title font-semibold mb-3 text-blue-200 tracking-wider">Items Data</div>
            @if(Auth::check() && Auth::user()->role === 'admin')
            <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'sidebar-active border-white' : 'border-transparent hover:bg-blue-800' }} px-4 py-3 border-l-4 flex items-center mb-1 font-medium transition-colors">
                <i class="fa-solid fa-bars w-6"></i>
                <span class="text-[13px]">Categories</span>
            </a>
            @endif
            <a href="{{ route('admin.items.index') }}" class="{{ request()->routeIs('admin.items.*') ? 'sidebar-active border-white' : 'border-transparent hover:bg-blue-800' }} px-4 py-3 border-l-4 flex items-center mb-6 font-medium transition-colors">
                <i class="fa-solid fa-chart-pie w-6"></i>
                <span class="text-[13px]">Items</span>
            </a>
            @if(Auth::check() && in_array(Auth::user()->role, ['operator', 'staff']))
            <a href="{{ route('operator.lendings.index') }}" class="{{ request()->routeIs('operator.lendings.*') ? 'sidebar-active border-white' : 'border-transparent hover:bg-blue-800' }} px-4 py-3 border-l-4 flex items-center mb-6 font-medium transition-colors">
                <i class="fa-solid fa-arrows-rotate w-6"></i>
                <span class="text-[13px]">Lending</span>
            </a>
            @endif

            <div class="menu-title font-semibold mb-3 text-blue-200 tracking-wider">Accounts</div>
            <div class="mb-2">
                <a href="#" onclick="toggleUsersSubmenu(event)" class="px-4 py-3 border-l-4 border-transparent flex items-center justify-between hover:bg-blue-800 font-medium transition-colors">
                    <div class="flex items-center">
                        <i class="fa-solid fa-user w-6"></i>
                        <span class="text-[13px] font-bold">Users</span>
                    </div>
                    <i id="usersCaret" class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200 {{ request()->routeIs('admin.users.*') ? 'transform rotate-180' : '' }}"></i>
                </a>
                <div id="usersSubmenu" class="{{ request()->routeIs('admin.users.*') ? 'flex' : 'hidden' }} flex-col ml-9 mt-1 gap-1 text-[13px] font-medium text-gray-300 transition-all duration-200">
                    @if(Auth::check() && Auth::user()->role === 'admin')
                    <a href="{{ route('admin.users.index', ['role' => 'admin']) }}" class="{{ request()->routeIs('admin.users.*') && request('role', 'admin') == 'admin' ? 'text-white font-bold' : 'hover:text-white' }} px-2 py-2 flex items-center gap-2 transition-colors">
                        <div class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.users.*') && request('role', 'admin') == 'admin' ? 'bg-white' : 'bg-gray-400' }}"></div>
                        Admin
                    </a>
                    <a href="{{ route('admin.users.index', ['role' => 'operator']) }}" class="{{ request()->routeIs('admin.users.index') && request('role') == 'operator' ? 'text-white font-bold' : 'hover:text-white' }} px-2 py-2 flex items-center gap-2 transition-colors">
                        <div class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.users.index') && request('role') == 'operator' ? 'bg-white' : 'bg-gray-400' }}"></div>
                        Operator
                    </a>
                    @else
                    <a href="{{ route('admin.users.edit', \Illuminate\Support\Facades\Auth::id()) }}" class="{{ request()->routeIs('admin.users.edit') ? 'text-white font-bold' : 'hover:text-white' }} px-2 py-2 flex items-center gap-2 transition-colors">
                        <div class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('admin.users.edit') ? 'bg-white' : 'bg-gray-400' }}"></div>
                        Edit
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col relative h-full bg-gray-50 z-10 w-full overflow-y-auto">

        <!-- Tall Header with Mountain Image -->
        <!-- Using realistic height for the banner overlay -->
        <div class="h-72 w-full flex-shrink-0 relative bg-cover bg-center" style="background-image: url('{{ asset('images/mountain_bg.png') }}');">
            <!-- Overlay to darken if needed, but original looks bright -->
            <div class="absolute inset-0 bg-black/10"></div>
            
            <!-- Top Nav -->
            <div class="relative z-10 px-8 py-6 w-full flex justify-between items-center text-white drop-shadow-md">
                <div class="flex items-center gap-4">
                    <button class="text-xl hover:text-gray-300 transition-colors">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <!-- Simulated logo since we dynamically load it -->
                    <div class="flex items-center justify-center w-10 h-10 rounded-full overflow-hidden bg-white/20 border border-white/30 backdrop-blur-sm">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-8 h-8 object-contain">
                    </div>
                    <h1 class="text-lg font-bold ml-1 tracking-wide">Welcome Back, {{ Auth::user()->name ?? 'Admin Wikrama' }}</h1>
                </div>
                <div>
                    <span class="font-bold text-base tracking-wide" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.4);">
                        {{ \Carbon\Carbon::now()->format('d F, Y') }}
                    </span>
                </div>
            </div>

            <!-- White Menu Bar overlaying the Mountain Image -->
            <div class="relative z-20 mx-8 mt-12 bg-white flex justify-between items-center px-6 py-4 rounded-sm" style="box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);">
                <div class="font-semibold text-gray-700 text-sm tracking-wide">
                    Check menu in sidebar
                </div>
                
                <div class="relative group cursor-pointer" onclick="toggleDropdown()">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full border border-black flex items-center justify-center bg-white text-black">
                            <i class="fa-regular fa-user"></i>
                        </div>
                        <span class="font-semibold text-gray-700 text-[13px] whitespace-nowrap">{{ Auth::user()->name ?? 'Admin Wikrama' }}</span>
                        <i class="fa-solid fa-chevron-down text-[10px] ml-1 text-gray-600"></i>
                    </div>

                    <!-- Dropdown Content -->
                    <div id="userDropdown" class="hidden absolute left-0 top-full mt-2 min-w-full w-40 bg-white rounded-md z-50 border border-gray-100" style="box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-3 text-[13px] font-semibold text-gray-600 hover:bg-gray-50 flex items-center justify-center gap-3 transition-colors rounded-md">
                                <i class="fa-solid fa-arrow-right-from-bracket text-blue-500 transform rotate-180"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
        </div>

        <!-- Content Area -->
        <div class="p-8 pb-16 flex-1 w-full bg-gray-50 relative mt-[-2rem]">
            @yield('content')
        </div>
        
    </main>
    
    <script>
        function toggleDropdown() {
            var dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('hidden');
        }

        function toggleUsersSubmenu(e) {
            e.preventDefault();
            var submenu = document.getElementById('usersSubmenu');
            var caret = document.getElementById('usersCaret');
            
            if (submenu.classList.contains('hidden')) {
                submenu.classList.remove('hidden');
                submenu.classList.add('flex');
                caret.classList.add('rotate-180');
            } else {
                submenu.classList.remove('flex');
                submenu.classList.add('hidden');
                caret.classList.remove('rotate-180');
            }
        }

        // Menutup dropdown (Profile) jika user melakukan klik di luar dropdown
        window.onclick = function(event) {
            if (!event.target.closest('.group')) {
                var dropdowns = document.getElementsByClassName("absolute");
                var myDropdown = document.getElementById('userDropdown');
                if (myDropdown && !myDropdown.classList.contains('hidden')) {
                    myDropdown.classList.add('hidden');
                }
            }
        }
    </script>
</body>
</html>
