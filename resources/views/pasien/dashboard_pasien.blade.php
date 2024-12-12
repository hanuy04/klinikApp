<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pasien</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-purple-600 text-white flex flex-col">
            <div class="p-6">
                <h2 class="text-2xl font-bold">Poliklinik</h2>
            </div>
            <nav class="flex-1">
                <ul>
                    <li class="px-6 py-3 hover:bg-purple-700">
                        <a href="#" class="block">Dashboard</a>
                    </li>
                    <li class="px-6 py-3 hover:bg-purple-700">
                        <a href="#" class="block">Pilih Poli</a>
                    </li>
                    <li class="px-6 py-3 hover:bg-purple-700">
                        <a href="#" class="block">Riwayat</a>
                    </li>
                </ul>
            </nav>
            <form method="POST" action="{{ route('logout') }}" class="p-6">
                @csrf
                <button type="submit" class="w-full bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600">Logout</button>
            </form>
        </aside>

        <!-- Content -->
        <main class="flex-1 bg-gray-100 p-8">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h1 class="text-2xl font-semibold text-gray-700">Selamat Datang, Pasien</h1>
                <p class="text-gray-600 mt-4">Silakan memilih menu di sidebar untuk melanjutkan.</p>
            </div>
        </main>
    </div>
</body>
</html>
