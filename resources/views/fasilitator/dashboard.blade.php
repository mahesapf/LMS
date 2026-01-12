@extends('layouts.dashboard')

@section('title', 'Fasilitator Dashboard')

@section('sidebar')
<nav class="nav flex-column">
    <a class="nav-link active" href="{{ route('fasilitator.dashboard') }}">Dashboard</a>
    <a class="nav-link" href="{{ route('fasilitator.profile') }}">Edit Biodata</a>
    <a class="nav-link" href="{{ route('fasilitator.classes') }}"Input Nilai</a>
    <a class="nav-link" href="{{ route('fasilitator.mappings.index') }}">Pemetaan Peserta</a>
</nav>
@endsection

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Dashboard Fasilitator</h1>

    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Kelas</h5>
                    <h2 class="mb-0">{{ $stats['total_classes'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Peserta</h5>
                    <h2 class="mb-0">{{ $stats['total_participants'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Nilai Terinput</h5>
                    <h2 class="mb-0">{{ $stats['total_grades'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">Dokumen</h5>
                    <h2 class="mb-0">{{ $stats['total_documents'] }}</h2>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
