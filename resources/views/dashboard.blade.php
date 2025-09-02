@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- Welcome Message -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="card-title text-primary">Selamat Datang, {{ Auth::user()->username }}!</h5>
                <p class="card-text text-muted">Selamat datang di Dashboard Laravel Terakorp. Halaman ini siap untuk dikembangkan lebih lanjut sesuai kebutuhan aplikasi.</p>
            </div>
        </div>
    </div>
</div>

<!-- Dashboard Stats Cards -->
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-start border-primary border-4 shadow-sm h-100">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="text-xs fw-bold text-primary text-uppercase mb-1">
                            Total Users
                        </div>
                        <div class="h5 mb-0 fw-bold text-gray-800">{{ \App\Models\User::count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-start border-success border-4 shadow-sm h-100">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="text-xs fw-bold text-success text-uppercase mb-1">
                            Rumah Sakit
                        </div>
                        <div class="h5 mb-0 fw-bold text-gray-800">{{ \App\Models\RumahSakit::count() }}</div>
                        <a href="{{ route('rumah-sakits.index') }}" class="small text-success">
                            <i class="fas fa-arrow-right me-1"></i>Kelola Data
                        </a>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-hospital fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-start border-info border-4 shadow-sm h-100">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="text-xs fw-bold text-info text-uppercase mb-1">
                            Pasien
                        </div>
                        <div class="h5 mb-0 fw-bold text-gray-800">{{ \App\Models\Pasien::count() }}</div>
                        <a href="{{ route('pasiens.index') }}" class="small text-info">
                            <i class="fas fa-arrow-right me-1"></i>Kelola Data
                        </a>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-injured fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-start border-warning border-4 shadow-sm h-100">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="text-xs fw-bold text-warning text-uppercase mb-1">
                            Status
                        </div>
                        <div class="h5 mb-0 fw-bold text-gray-800">Active</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Additional Info Card -->
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h6 class="m-0 fw-bold">
                    <i class="fas fa-info-circle me-2"></i>Informasi Sistem
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-2"><strong>Aplikasi:</strong> Laravel Terakorp</p>
                        <p class="mb-2"><strong>Versi Laravel:</strong> {{ app()->version() }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-2"><strong>User Login:</strong> {{ Auth::user()->username }}</p>
                        <p class="mb-2"><strong>Total Rumah Sakit:</strong> {{ \App\Models\RumahSakit::count() }} rumah sakit</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection