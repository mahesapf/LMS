@extends('layouts.dashboard')

@section('title', 'Kelola Pendaftaran Peserta')

@section('sidebar')
@if(auth()->user()->role === 'super_admin')
    @include('super-admin.partials.sidebar')
@else
    <nav class="nav flex-column">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a class="nav-link" href="{{ route('admin.activities') }}">Kegiatan</a>
        <a class="nav-link" href="{{ route('admin.classes.index') }}">Kelas</a>
        <a class="nav-link active" href="{{ route('admin.registrations.index') }}">Manajemen Peserta</a>
    </nav>
@endif
@endsection

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-semibold text-slate-900">Kelola Pendaftaran Peserta</h1>
        <p class="mt-1 text-sm text-slate-500">Lihat peserta tervalidasi dan status penempatan ke kelas.</p>
    </div>

    <div class="rounded-xl border border-sky-200 bg-sky-50 p-4">
        <p class="text-sm text-slate-700">
            Untuk menambahkan peserta ke kelas, buka menu <span class="font-semibold">Kelas</span>, pilih kelas yang diinginkan, lalu klik <span class="font-semibold">Detail</span>.
        </p>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
        <div class="border-b border-slate-200 bg-slate-50 px-4 py-3 rounded-t-xl -mx-4 -mt-4 mb-4">
            <h2 class="text-sm font-semibold text-slate-800">Peserta Tervalidasi</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Tanggal Daftar</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Nama & Kontak</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Jabatan</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Sekolah</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Kegiatan</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Kelas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse($registrations as $registration)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-2 text-sm text-slate-700">{{ $registration->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-2 text-sm">
                                <div class="text-slate-900 font-semibold">{{ $registration->name }}</div>
                                <div class="text-xs text-slate-500">{{ $registration->email }}</div>
                                <div class="text-xs text-slate-500">{{ $registration->phone }}</div>
                            </td>
                            <td class="px-4 py-2 text-sm text-slate-700">{{ $registration->position ?? '-' }}</td>
                            <td class="px-4 py-2 text-sm text-slate-700">{{ $registration->school ?? '-' }}</td>
                            <td class="px-4 py-2 text-sm text-slate-700">
                                {{ $registration->activity->name ?? '-' }}
                                @if($registration->activity && $registration->activity->program)
                                    <div class="text-xs text-slate-500">{{ $registration->activity->program->name }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-sm">
                                @if($registration->class)
                                    <a href="{{ route($routePrefix . '.classes.show', $registration->class) }}" class="inline-flex rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-semibold text-emerald-700">
                                        {{ $registration->class->name }}
                                    </a>
                                @else
                                    <span class="inline-flex rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-semibold text-amber-700">Belum Ditentukan</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-sm text-slate-500">Belum ada peserta yang tervalidasi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
        </div>
    </div>
</div>
@endsection
