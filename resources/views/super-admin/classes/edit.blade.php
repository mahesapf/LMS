@extends('layouts.dashboard')

@section('title', 'Edit Kelas')

@section('sidebar')
@include('super-admin.partials.sidebar')
    @endif
</nav>
@endsection

@section('content')
<script>
    window.location.href = "{{ route($routePrefix . '.classes.index') }}?edit={{ $class->id }}";
</script>
@endsection
