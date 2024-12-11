<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Dokter</title>
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
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold text-gray-700 mb-6">Pilih Dokter</h2>
            <form action="{{ route('proses.pilih.dokter') }}" method="POST">
                @csrf
                <input type="hidden" name="poliklinik_id" value="{{ $poliklinik->id }}">
                <div class="mb-4">
                    <label for="dokter_id" class="block text-sm font-medium text-gray-600 mb-2">Pilih Dokter</label>
                    <select name="dokter_id" id="dokter_id" class="w-full border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500">
                        @foreach($dokter as $dok)
                            <option value="{{ $dok->id }}">{{ $dok->nama }} - Jadwal: {{ $dok->jadwal }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="keluhan" class="block text-sm font-medium text-gray-600 mb-2">Keluhan (Opsional)</label>
                    <textarea name="keluhan" id="keluhan" rows="3" class="w-full border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500"></textarea>
                </div>
                <button type="submit" class="w-full bg-purple-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500">Dapatkan Nomor Antrian</button>
            </form>
        </div>
    </main>
</body>
</html>
