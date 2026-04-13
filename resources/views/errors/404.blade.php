<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Access Denied</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white flex flex-col items-center justify-center min-h-screen font-sans">
    
    <div class="text-center">
        <!-- Menampilkan gambar 404 dari web atau lokal -->
        <img src="{{ asset('images/404.png') }}" alt="Error 404" class="h-64 mx-auto mb-6" onerror="this.src='https://raw.githubusercontent.com/mrizqa19/laravel-inventory/main/public/images/404.png'; this.onerror=null;">
        
        <h2 class="text-xl font-bold text-gray-800 mb-6 font-medium tracking-wide">You can't access this page.</h2>
        
        <a href="{{ url()->previous() == url()->current() ? '/' : url()->previous() }}" class="px-8 py-2 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded shadow transition-colors text-sm">
            Back
        </a>
    </div>

</body>
</html>
