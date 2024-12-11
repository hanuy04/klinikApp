@extends('layouts.main')

@section('content')
    <div class="d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-lg" style="width: 100%; max-width: 400px;">
            <div class="card-header text-center">
                <h3>Login</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('login.submit') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
                @if (session('error'))
                    <div class="mt-3 alert alert-danger text-center">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
