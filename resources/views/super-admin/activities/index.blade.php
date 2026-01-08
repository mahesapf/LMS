@extends('layouts.dashboard')

@section('title', 'Kegiatan')

@section('sidebar')
    @include('super-admin.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Daftar Kegiatan</h1>
            <p class="mt-1 text-sm text-slate-500">Kelola jadwal kegiatan, sumber dana, dan status pelaksanaan.</p>
        </div>
        <a href="{{ route($routePrefix . '.activities.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-sky-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-sky-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Kegiatan
        </a>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Nama Kegiatan</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Program</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Batch</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Tanggal</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Sumber Dana</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Status</th>
                        <th class="px-4 py-2 text-right text-xs font-semibold text-slate-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse($activities as $activity)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-2 text-sm font-semibold text-slate-900">{{ $activity->name }}</td>
                        <td class="px-4 py-2 text-sm text-slate-700">{{ $activity->program ? $activity->program->name : '-' }}</td>
                        <td class="px-4 py-2 text-sm text-slate-700">{{ $activity->batch ?? '-' }}</td>
                        <td class="px-4 py-2 text-sm text-slate-700">{{ $activity->start_date->format('d/m/Y') }} - {{ $activity->end_date->format('d/m/Y') }}</td>
                        <td class="px-4 py-2 text-sm text-slate-700">
                            @if($activity->funding_source == 'Other')
                                {{ $activity->funding_source_other }}
                            @else
                                {{ $activity->funding_source }}
                            @endif
                        </td>
                        <td class="px-4 py-2 text-sm">
                            @if($activity->status == 'planned')
                                <span class="inline-flex rounded-full bg-slate-200 px-2.5 py-0.5 text-xs font-semibold text-slate-700">Direncanakan</span>
                            @elseif($activity->status == 'ongoing')
                                <span class="inline-flex rounded-full bg-sky-100 px-2.5 py-0.5 text-xs font-semibold text-sky-700">Berlangsung</span>
                            @elseif($activity->status == 'completed')
                                <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-semibold text-emerald-700">Selesai</span>
                            @else
                                <span class="inline-flex rounded-full bg-rose-100 px-2.5 py-0.5 text-xs font-semibold text-rose-700">Dibatalkan</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-sm">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route($routePrefix . '.activities.edit', $activity) }}" class="inline-flex items-center rounded-md bg-amber-500 px-2.5 py-1.5 text-xs font-semibold text-white shadow-sm hover:bg-amber-600">Edit</a>
                                <form method="POST" action="{{ route($routePrefix . '.activities.delete', $activity) }}" onsubmit="return confirm('Hapus kegiatan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center rounded-md bg-rose-600 px-2.5 py-1.5 text-xs font-semibold text-white shadow-sm hover:bg-rose-700">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-6 text-center text-sm text-slate-500">Tidak ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $activities->links() }}</div>
    </div>
</div>
@endsection
