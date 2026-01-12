@extends('layouts.dashboard')

@section('title', 'Edit Program')

@section('sidebar')
@include('super-admin.partials.sidebar')
@endsection

@section('content')
<script>
    window.location.href = "{{ route('super-admin.programs') }}?edit={{ $program->id }}";
</script>
@endsection
