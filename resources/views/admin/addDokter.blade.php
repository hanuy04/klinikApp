@extends('layouts.main')

@section('navbar')
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #0288d1;">
        <a class="nav-link" href="{{ route('admin.dashboard') }}" style="color: white;">KlinikApp</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}" style="color: white;">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.poli') }}" style="color: white;">Poli</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('admin.dokter') }}" style="color: white;">Dokter</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.pasien') }}" style="color: white;">Pasien</a>
                </li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-link" style="color: white;">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>
@endsection

@section('content')
    <div class="container mt-5" style="background-color: #b3e5fc; padding: 20px; border-radius: 10px;">
        <h2>Tambah Dokter</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.poli.add') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>

            <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" class="form-control" id="alamat" name="alamat" required>
            </div>

            <div class="form-group">
                <label for="alamat">No HP</label>
                <input type="text" class="form-control" id="no_hp" name="no_hp" required>
            </div>

            <div class="form-group">
                <label for="id_poli">Poli</label>
                <select class="form-control" id="id_poli" name="id_poli" required>
                    <option value="">Pilih Poli</option>
                    @foreach ($polis as $poli)
                        <option value="{{ $poli->id }}">
                            {{ $poli->nama_poli }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn" style="background-color: blue; color: white;">Tambah</button>
            <a href="{{ route('admin.poli') }}" class="btn" style="background-color: red; color: white;">Batal</a>
        </form>
    </div>
@endsection
