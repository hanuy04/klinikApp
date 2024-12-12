
@extends('pasien.dashboard_pasien')

@section('content')
<div class="container">
    <h1>Pilih Dokter di Poli {{ $poli->nama_poli }}</h1>

    <div class="row">
        @foreach($dokters as $dokter)
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $dokter->nama }}</h5>
                    <p class="card-text">Jadwal:</p>
                    <ul>
                        @foreach($dokter->jadwalPeriksas as $jadwal)
                            <li>{{ $jadwal->hari }} {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</li>
                        @endforeach
                    </ul>
                    <form action="{{ route('pasien.pilih-dokter-submit', $poli->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="dokter_id" value="{{ $dokter->id }}">
                        <button type="submit" class="btn btn-primary">Pilih Dokter</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
