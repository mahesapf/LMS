@extends('layouts.dashboard')

@section('title', 'Tambah Kegiatan')

@section('sidebar')
@include('super-admin.partials.sidebar')
@endsection

@section('content')
<script>
    window.location.href = "{{ route($routePrefix . '.activities') }}?create=1";
</script>
@endsection
