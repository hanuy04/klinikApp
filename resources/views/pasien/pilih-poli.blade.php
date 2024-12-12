@extends('pasien.dashboard_pasien')

@section('content')
<div class="container">
    <h1>Pilih Poli</h1>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <ul class="list-group">
        @foreach($polis as $poli)
            <li class="list-group-item">
                <a href="{{ route('pasien.pilih-dokter', $poli->id) }}">
                    {{ $poli->nama_poli }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
@endsection
