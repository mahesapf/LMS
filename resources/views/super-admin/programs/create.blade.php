@extends('layouts.dashboard')

@section('title', 'Tambah Program')

@section('sidebar')
@include('super-admin.partials.sidebar')
@endsection

@section('content')
<script>
    window.location.href = "{{ route('super-admin.programs') }}?create=1";
</script>
@endsection
