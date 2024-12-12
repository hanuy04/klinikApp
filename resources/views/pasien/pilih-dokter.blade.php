@extends('pasien.dashboard_pasien')

@section('content')
<div class="container">
    <h1>Pilih Dokter di Poli {{ $poli->nama_poli }}</h1>

    <form action="{{ route('pasien.pilih-dokter', $poli->id) }}" method="POST">
        @csrf
        <input type="hidden" name="pasien_id" value="{{ $pasien->id }}">

        <div class="mb-3">
            <label for="dokter_id" class="form-label">Pilih Dokter</label>
            <select name="dokter_id" id="dokter_id" class="form-control" required onchange="this.form.submit()">
                <option value="">Pilih Dokter</option>
                @foreach($dokters as $dokter)
                    <option value="{{ $dokter->id }}" {{ old('dokter_id') == $dokter->id ? 'selected' : '' }}>
                        {{ $dokter->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        @if(!empty($jadwals))
        <div class="mb-3">
            <label for="jadwal_id" class="form-label">Pilih Jadwal</label>
            <select name="jadwal_id" id="jadwal_id" class="form-control" required>
                <option value="">Pilih Jadwal</option>
                @foreach($jadwals as $jadwal)
                    <option value="{{ $jadwal->id }}" {{ old('jadwal_id') == $jadwal->id ? 'selected' : '' }}>
                        {{ $jadwal->hari }} {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}
                    </option>
                @endforeach
            </select>
        </div>
        @endif

        <div class="mb-3">
            <label for="keluhan" class="form-label">Keluhan</label>
            <textarea name="keluhan" id="keluhan" class="form-control">{{ old('keluhan') }}</textarea>
        </div>

        @if(!empty($jadwals))
        <button type="submit" class="btn btn-primary">Daftar</button>
        @endif
    </form>
</div>
@endsection
