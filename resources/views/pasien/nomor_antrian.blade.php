<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nomor Antrian</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <!-- Navbar -->
    <header class="bg-white shadow-md">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-purple-600">Poliklinik</h1>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-gray-600 hover:text-red-600 font-medium">Logout</button>
            </form>
        </div>
    </header>

    <!-- Content -->
    <main class="container mx-auto px-4 py-8">
        <div class="bg-white p-6 rounded-lg shadow-md text-center">
            <h2 class="text-2xl font-semibold text-gray-700 mb-6">Nomor Antrian Anda</h2>
            <div
                class="bg-purple-100 text-purple-700 font-bold text-5xl py-6 px-8 rounded-lg shadow-lg inline-block mb-6">
                {{ $nomorAntrian }}
            </div>
            <p class="text-gray-600 text-lg mb-4">Silakan datang sesuai dengan nomor antrian Anda. Pastikan Anda membawa
                dokumen yang diperlukan.</p>
            <a href="{{ route('home') }}"
                class="bg-purple-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500">Kembali
                ke Halaman Utama</a>
        </div>
    </main>
</body>

</html>
