{{-- Modal content now in index.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'Tambah Pengguna')

@section('sidebar')
@include('super-admin.partials.sidebar')
@endsection

@section('content')
<script>
    window.location.href = "{{ route('super-admin.users') }}?create=1";
</script>
@endsection
