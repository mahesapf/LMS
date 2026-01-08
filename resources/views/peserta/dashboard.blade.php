@extends('layouts.dashboard')

@section('title', 'Peserta Dashboard')

@section('sidebar')
<nav class="nav flex-column">
    <a class="nav-link active" href="{{ route('peserta.dashboard') }}">Dashboard</a>
    <a class="nav-link" href="{{ route('peserta.profile') }}">Profil</a>
    <a class="nav-link" href="{{ route('peserta.biodata') }}">Biodata</a>
    <a class="nav-link" href="{{ route('peserta.classes') }}">Kelas & Nilai Saya</a>
    <a class="nav-link" href="{{ route('peserta.documents') }}">Dokumen</a>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Dashboard Peserta</h1>
    
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Kelas yang Diikuti</h5>
                    <h2 class="mb-0">{{ $stats['total_classes'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Nilai</h5>
                    <h2 class="mb-0">{{ $stats['total_grades'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Dokumen Terupload</h5>
                    <h2 class="mb-0">{{ $stats['total_documents'] }}</h2>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
