@extends('layouts.dashboard')

@section('title', 'Tambah Kelas')

@section('sidebar')
@include('super-admin.partials.sidebar')
@endsection

@section('content')
<script>
    window.location.href = "{{ route($routePrefix . '.classes.index') }}?create=1";
</script>
@endsection
