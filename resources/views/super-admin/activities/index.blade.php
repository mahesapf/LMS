@extends('layouts.dashboard')

@section('title', 'Kegiatan')

@section('sidebar')
    @if($routePrefix === 'admin')
        @include('admin.partials.sidebar')
    @else
        @include('super-admin.partials.sidebar')
    @endif
@endsection

@section('content')
<div class="space-y-6" x-data="{ showCreateModal: false, showEditModal: {{ request('edit') ? 'true' : 'false' }} }" x-init="console.log('Alpine.js loaded on activities page')">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Daftar Kegiatan</h1>
            <p class="mt-1 text-sm text-slate-500">Kelola jadwal kegiatan, sumber dana, dan status pelaksanaan.</p>
        </div>
        <button @click="showCreateModal = true; console.log('Button clicked, showCreateModal:', showCreateModal)"
                class="inline-flex items-center gap-2 rounded-lg bg-[#0284c7] px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#0369a1]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Kegiatan
        </button>
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
                        <td class="px-4 py-2 text-sm">
                            <div class="flex justify-end">
                                <div x-data="{ open: false }" class="relative">
                                    <button @click="open = !open" @click.outside="open = false" class="rounded-md border border-slate-300 bg-white px-3 py-1.5 shadow-sm hover:bg-slate-50 focus:outline-none" aria-label="Aksi kegiatan">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-600" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zm6 0a2 2 0 11-4 0 2 2 0 014 0zm6 0a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </button>

                                    <div x-show="open" x-transition @keydown.escape.window="open = false" class="absolute right-0 z-40 mt-2 w-44 rounded-lg border border-slate-200 bg-white py-1 shadow-lg" role="menu">
                                        <a href="{{ route($routePrefix . '.activities') }}?edit={{ $activity->id }}" class="flex items-center gap-2.5 px-3 py-2 text-sm hover:bg-slate-50" role="menuitem">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            <span class="text-slate-700">Edit</span>
                                        </a>

                                        <form method="POST" action="{{ route($routePrefix . '.activities.delete', $activity) }}" onsubmit="return confirm('Hapus kegiatan ini?')" role="menuitem">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="flex w-full items-center gap-2.5 px-3 py-2 text-left text-sm hover:bg-slate-50">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                <span class="text-red-500">Hapus</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
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

        {{-- Pagination --}}
        <div class="mt-6 border-t border-slate-200 pt-4">
            {{ $activities->links() }}
        </div>
    </div>

    {{-- Create Activity Modal --}}
    @include('super-admin.activities.partials.create-modal')

    {{-- Edit Activity Modal --}}
    @include('super-admin.activities.partials.edit-modal')
</div>
@endsection
