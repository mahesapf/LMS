@extends('layouts.dashboard')

@section('title', 'Kegiatan')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Daftar Kegiatan</h1>
            <p class="mt-1 text-sm text-slate-500">Lihat jadwal kegiatan dan status pelaksanaan.</p>
        </div>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm overflow-visible">
        <div class="relative overflow-x-auto overflow-y-visible">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Nama Kegiatan</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Program</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Batch</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Tanggal</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Sumber Dana</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Status</th>
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
                                <div class="flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-orange-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                    </svg>
                                    <div class="flex flex-col">
                                        <span class="text-xs font-medium text-orange-700">Direncanakan</span>
                                        <span class="text-[10px] text-orange-600">Akan datang</span>
                                    </div>
                                </div>
                            @elseif($activity->status == 'ongoing')
                                <div class="flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#0284c7] flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                    </svg>
                                    <div class="flex flex-col">
                                        <span class="text-xs font-medium text-[#0284c7]">Berlangsung</span>
                                        <span class="text-[10px] text-sky-600">Sedang berjalan</span>
                                    </div>
                                </div>
                            @elseif($activity->status == 'completed')
                                <div class="flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <div class="flex flex-col">
                                        <span class="text-xs font-medium text-slate-700">Selesai</span>
                                        <span class="text-[10px] text-slate-600">Telah selesai</span>
                                    </div>
                                </div>
                            @else
                                <div class="flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                    <div class="flex flex-col">
                                        <span class="text-xs font-medium text-red-700">Dibatalkan</span>
                                        <span class="text-[10px] text-red-600">Tidak jadi</span>
                                    </div>
                                </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-sm text-slate-500">
                            Tidak ada kegiatan yang tersedia.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
