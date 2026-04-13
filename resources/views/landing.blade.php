<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventory SMK Wikrama</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="bg-gray-100">

<!-- Navbar -->
<nav class="sticky top-0 z-50 bg-white shadow">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

        <div class="flex items-center gap-3">
            <img src="{{ asset('images/logo.png') }}" class="w-10">
            <span class="font-semibold text-lg">SMK Wikrama</span>
        </div>

        <button
            onclick="openModal()"
            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Login
        </button>

    </div>
</nav>


<!-- Hero Section -->
<section class="bg-gray-200 py-20">

    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-10 items-center">

        <div>
            <h1 class="text-4xl font-bold mb-4">
                Inventory Management of <br>
                SMK Wikrama
            </h1>

            <p class="text-gray-600">
                Management of incoming and outgoing items
                at SMK Wikrama Bogor.
            </p>
        </div>

        <div>
            <img src="{{ asset('images/landing.png') }}" alt="inventory illustration">
        </div>

    </div>

</section>


<!-- System Flow -->
<section class="py-20 bg-white">

    <div class="max-w-7xl mx-auto px-6 text-center">

        <h2 class="text-3xl font-bold mb-2">
            Our system flow
        </h2>

        <p class="text-gray-500 mb-12">
            Our inventory system workflow
        </p>


        <div class="grid md:grid-cols-4 gap-8">

            <!-- Card 1 -->
            <div class="p-6 bg-blue-900 text-white rounded">
                <img src="{{ asset('images/landing1.png') }}" class="mx-auto mb-4">
                <h3 class="font-semibold">Items Data</h3>
            </div>

            <!-- Card 2 -->
            <div class="p-6 bg-yellow-400 text-white rounded">
                <img src="{{ asset('images/landing2.jpg') }}" class="mx-auto mb-4">
                <h3 class="font-semibold">Management Technician</h3>
            </div>

            <!-- Card 3 -->
            <div class="p-6 bg-purple-300 text-white rounded">
                <img src="{{ asset('images/landing3.jpg') }}" class="mx-auto mb-4">
                <h3 class="font-semibold">Managed Lending</h3>
            </div>

            <!-- Card 4 -->
            <div class="p-6 bg-green-400 text-white rounded">
                <img src="{{ asset('images/landing4.jpg') }}" class="mx-auto mb-4">
                <h3 class="font-semibold">All Can Borrow</h3>
            </div>

        </div>

    </div>

</section>


<!-- Footer -->
<footer class="bg-gray-100 py-12">

    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-3 gap-10">

        <!-- Contact -->
        <div>
            <img src="{{ asset('images/logo.png')}}" class="w-10 mb-4">

            <p class="text-gray-600">
                smkwikrama@sch.id <br>
                001-7876-2876
            </p>
        </div>

        <!-- Guidelines -->
        <div>
            <h4 class="font-semibold mb-3">Our Guidelines</h4>

            <ul class="text-gray-600 space-y-2">
                <li>Terms</li>
                <li>Privacy policy</li>
                <li>Cookie Policy</li>
                <li>Discover</li>
            </ul>
        </div>

        <!-- Address -->
        <div>
            <h4 class="font-semibold mb-3">Our address</h4>

            <p class="text-gray-600">
                Jalan Wangun Tengah <br>
                Sindangsari <br>
                Jawa Barat
            </p>
        </div>

    </div>

</footer>

<!-- Modal Background -->
<div id="loginModal" class="fixed inset-0 bg-black/40 {{ $errors->any() || session('error') ? 'flex' : 'hidden' }} items-center justify-center z-50">

    <!-- Modal Box -->
    <div class="bg-white rounded-lg shadow-lg w-[400px] p-6">

        <!-- Title -->
        <h2 class="text-3xl font-bold mb-6 text-center">
            Login
        </h2>

        @if($errors->any() || session('error'))
        <div class="bg-[#ffdddd] text-[#cc0000] px-4 py-4 mb-6 rounded border border-[#fad2d2]">
            <ul class="list-disc pl-5 font-medium tracking-wide">
                @if(session('error'))
                    <li>{{ session('error') }}</li>
                @endif
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Form -->
        <form action="{{ route('login') }}" method="POST">
            @csrf

            <!-- Email -->
            <div class="mb-4">
                <label class="block mb-1 text-[15px] font-medium text-gray-800">Email</label>
                <div class="relative">
                    <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Email"
                    class="w-full bg-[#f8f9fa] border-none rounded px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('email') ring-1 ring-red-500 @enderror">
                    @error('email')
                        <i class="fa-solid fa-xmark text-red-500 absolute right-3 top-1/2 transform -translate-y-1/2 font-bold z-10"></i>
                    @enderror
                </div>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-6">
                <label class="block mb-1 text-[15px] font-medium text-gray-800">Password</label>
                <div class="relative">
                    <input
                    type="password"
                    name="password"
                    placeholder="Password"
                    class="w-full bg-[#f8f9fa] border-none rounded px-3 py-2.5 pr-10 focus:outline-none focus:ring-2 focus:ring-blue-400 @error('password') ring-1 ring-red-500 @enderror">
                    @error('password')
                        <i class="fa-solid fa-xmark text-[#cc0000] absolute right-3 top-1/2 transform -translate-y-1/2 font-extrabold z-10"></i>
                    @enderror
                </div>
                @error('password')
                    <p class="text-[#cc0000] text-[13.5px] font-medium mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex justify-start gap-3 mt-8">
                <button
                type="button"
                onclick="closeModal()"
                class="px-6 py-2.5 bg-[#f4734a] font-medium text-white rounded hover:bg-[#e05f38] transition-colors">
                Close
                </button>

                <button
                type="submit"
                class="px-6 py-2.5 bg-[#5bd5a4] font-medium text-white rounded hover:bg-[#4ac292] transition-colors">
                Submit
                </button>
            </div>

        </form>

    </div>

</div>

<script>

function openModal() {
    const modal = document.getElementById('loginModal')
    modal.classList.remove('hidden')
    modal.classList.add('flex')
}

function closeModal() {
    const modal = document.getElementById('loginModal')
    modal.classList.remove('flex')
    modal.classList.add('hidden')
}

</script>

</body>
</html>
