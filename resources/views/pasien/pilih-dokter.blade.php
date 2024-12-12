@extends('pasien.dashboard_pasien')

@section('content')
<div class="container mx-auto px-4 mt-10">
    @if(isset($pasien_name))
        <input type="hidden" name="pasien_name" value="{{ $pasien_name }}">
    @endif

    <h1 class="text-3xl font-semibold text-center text-blue-600 mb-8">Pilih Dokter di Poli {{ $poli->nama_poli }}</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($dokters as $dokter)
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="p-6">
                <h5 class="text-xl font-semibold text-gray-800">{{ $dokter->nama }}</h5>
                <p class="text-gray-600">Spesialisasi: {{ $dokter->spesialisasi }}</p>

                <!-- Form untuk memilih dokter dan melihat jadwal -->
                <form action="{{ route('pasien.pilih-dokter-submit', $poli->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="dokter_id" value="{{ $dokter->id }}">
                    
                    <!-- Dropdown atau tampilan jadwal berdasarkan dokter -->
                    <div class="mt-4">
                        <label for="jadwal" class="block text-gray-700">Pilih Jadwal:</label>
                        <select name="jadwal_id" id="jadwal" class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih Jadwal</option>
                            @foreach($dokter->jadwalPeriksas as $jadwal)
                                <option value="{{ $jadwal->id }}">
                                    {{ $jadwal->hari }} - {{ $jadwal->jam_mulai }} hingga {{ $jadwal->jam_selesai }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <br>
                    <button type="submit" class="w-full py-2 mt-4 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 transition-all duration-200">
                        Pilih Dokter & Jadwal
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
