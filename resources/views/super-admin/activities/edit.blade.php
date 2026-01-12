@extends('layouts.dashboard')

@section('title', 'Edit Kegiatan')

@section('sidebar')
@include('super-admin.partials.sidebar')
@endsection

@section('content')
<script>
    window.location.href = "{{ route($routePrefix . '.activities') }}?edit={{ $activity->id }}";
</script>
@endsection
