@extends('layouts.main')

@section('navbar')
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #0288d1;">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">KlinikApp</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.poli') }}">Poli</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.dokter') }}">Dokter</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.pasien') }}">Pasien</a>
                </li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>
@endsection

@section('content')
    <div class="container d-flex justify-content-center align-items-center" style="height: calc(100vh - 56px);">
        <div class="row g-3 justify-content-center">
            <div class="col-6 col-md-4">
                <div class="card text-center" style="border: none; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <img src="https://w1.pngwing.com/pngs/673/501/png-transparent-circle-icon-health-care-medicine-clinic-hospital-physician-symbol-patient.png"
                            alt="Poli" class="rounded-circle mb-3"
                            style="width: 100px; height: 100px; object-fit: cover;">
                        <h5 class="card-title">Jumlah Poli</h5>
                        <p class="card-text">{{ $jumlahPoli }}</p>
                        <a href="{{ route('admin.poli') }}" class="btn btn-primary">Lihat</a>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4">
                <div class="card text-center" style="border: none; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <img src="https://t4.ftcdn.net/jpg/02/29/53/11/360_F_229531197_jmFcViuzXaYOQdoOK1qyg7uIGdnuKhpt.jpg"
                            alt="Dokter" class="rounded-circle mb-3"
                            style="width: 100px; height: 100px; object-fit: cover;">
                        <h5 class="card-title">Jumlah Dokter</h5>
                        <p class="card-text">{{ $jumlahDokter }}</p>
                        <a href="{{ route('admin.dokter') }}" class="btn btn-primary">Lihat</a>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4">
                <div class="card text-center" style="border: none; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <img src="https://cdn.icon-icons.com/icons2/3705/PNG/512/hospital_person_people_profile_patient_icon_229961.png"
                            alt="Pasien" class="rounded-circle mb-3"
                            style="width: 100px; height: 100px; object-fit: cover;">
                        <h5 class="card-title">Jumlah Pasien</h5>
                        <p class="card-text">{{ $jumlahPasien }}</p>
                        <a href="{{ route('admin.pasien') }}" class="btn btn-primary">Lihat</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
