@extends('pasien.dashboard_pasien')

@section('content')
<div class="container">
    <h1>Jadwal Anda</h1>

    @if($daftarPolis->isEmpty())
        <p>Anda belum memiliki jadwal yang terdaftar.</p>
    @else
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Poli</th>
                        <th>Dokter</th>
                        <th>Jadwal</th>
                        <th>No. Antrian</th>
                        <th>Keluhan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($daftarPolis as $index => $daftar)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $daftar->jadwalPeriksa->poli->nama_poli }}</td>
                        <td>{{ $daftar->jadwalPeriksa->dokter->nama }}</td>
                        <td>{{ $daftar->jadwalPeriksa->hari }} {{ $daftar->jadwalPeriksa->jam_mulai }} - {{ $daftar->jadwalPeriksa->jam_selesai }}</td>
                        <td>{{ $daftar->no_antrian }}</td>
                        <td>{{ $daftar->keluhan }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
