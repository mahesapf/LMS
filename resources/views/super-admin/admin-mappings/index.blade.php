@extends('layouts.dashboard')

@section('title', 'Pemetaan Admin')

@section('sidebar')
@include('super-admin.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Pemetaan Admin</h1>
            <p class="mt-1 text-sm text-slate-500">Tugas admin terhadap program atau kegiatan.</p>
        </div>
        <a href="{{ route('super-admin.admin-mappings.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-sky-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-sky-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Pemetaan
        </a>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Admin</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Program</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Kegiatan</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Status</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Tgl Ditugaskan</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Tgl Dihapus</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Ditugaskan Oleh</th>
                        <th class="px-4 py-2 text-right text-xs font-semibold text-slate-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse($mappings as $mapping)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-2 text-sm">
                            <div class="text-slate-900 font-semibold">{{ $mapping->admin->name }}</div>
                            <div class="text-xs text-slate-500">{{ $mapping->admin->email }}</div>
                        </td>
                        <td class="px-4 py-2 text-sm text-slate-700">{{ $mapping->program ? $mapping->program->name : '-' }}</td>
                        <td class="px-4 py-2 text-sm text-slate-700">{{ $mapping->activity ? $mapping->activity->name : '-' }}</td>
                        <td class="px-4 py-2 text-sm">
                            @if($mapping->status == 'in')
                                <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-semibold text-emerald-700">Aktif</span>
                            @else
                                <span class="inline-flex rounded-full bg-slate-200 px-2.5 py-0.5 text-xs font-semibold text-slate-700">Keluar</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-sm text-slate-700">{{ $mapping->assigned_date ? $mapping->assigned_date->format('d/m/Y') : '-' }}</td>
                        <td class="px-4 py-2 text-sm text-slate-700">{{ $mapping->removed_date ? $mapping->removed_date->format('d/m/Y') : '-' }}</td>
                        <td class="px-4 py-2 text-sm text-slate-700">{{ $mapping->assignedBy->name }}</td>
                        <td class="px-4 py-2 text-sm">
                            <div class="flex justify-end gap-2">
                                @if($mapping->status == 'in')
                                    <form method="POST" action="{{ route('super-admin.admin-mappings.update-status', [$mapping, 'out']) }}" onsubmit="return confirm('Keluarkan admin dari tugas ini?')">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center rounded-md bg-rose-600 px-2.5 py-1.5 text-xs font-semibold text-white shadow-sm hover:bg-rose-700">Keluarkan</button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('super-admin.admin-mappings.update-status', [$mapping, 'in']) }}">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center rounded-md bg-emerald-600 px-2.5 py-1.5 text-xs font-semibold text-white shadow-sm hover:bg-emerald-700">Aktifkan Kembali</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-4 py-6 text-center text-sm text-slate-500">Tidak ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $mappings->links() }}</div>
    </div>
</div>
@endsection
