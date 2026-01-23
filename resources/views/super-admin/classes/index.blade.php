@extends('layouts.dashboard')

@section('title', 'Manajemen Kelas')

@section('sidebar')
    @if($routePrefix === 'admin')
        @include('admin.partials.sidebar')
    @else
        @include('super-admin.partials.sidebar')
    @endif
@endsection

@section('content')
<div class="space-y-6" x-data="{ showCreateModal: false, showEditModal: {{ request('edit') ? 'true' : 'false' }} }">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Manajemen Kelas</h1>
            <p class="mt-1 text-sm text-slate-500">Kelola kelas pada kegiatan, peserta, dan status pendaftaran.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route($routePrefix . '.registrations.index') }}" class="inline-flex items-center gap-2 rounded-lg bg-[#0284c7] px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#0369a1]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a7 7 0 100 14A7 7 0 0010 3zm1 10a1 1 0 11-2 0V9a1 1 0 112 0v4zm-1-8a1 1 0 110 2 1 1 0 010-2z" clip-rule="evenodd" />
                </svg>
                Assign Peserta
            </a>
            <button @click="showCreateModal = true" class="inline-flex items-center gap-2 rounded-lg bg-[#0284c7] px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#0369a1]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Kelas
            </button>
        </div>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm overflow-visible">
        <form method="GET" action="{{ route($routePrefix . '.classes.index') }}" class="mb-4">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:gap-2">
                <div class="flex-1">
                    <label class="mb-2 block text-xs font-medium text-slate-600">Filter Kegiatan</label>
                    <select name="activity_id" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/20" onchange="this.form.submit()">
                        <option value="">Semua Kegiatan</option>
                        @foreach($activities as $activity)
                        <option value="{{ $activity->id }}" {{ request('activity_id') == $activity->id ? 'selected' : '' }}>
                            {{ $activity->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="inline-flex items-center rounded-lg bg-[#0284c7] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#0369a1]">Filter</button>
                    <a href="{{ route($routePrefix . '.classes.index') }}" class="inline-flex items-center rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">Reset</a>
                </div>
            </div>
        </form>

        <div class="relative overflow-x-auto overflow-y-visible">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">No</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Nama Kelas</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Kegiatan</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Tanggal</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Max Peserta</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Status</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Pembuat</th>
                        <th class="px-4 py-2 text-right text-xs font-semibold text-slate-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse($classes as $class)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-2 text-sm text-slate-700">{{ $loop->iteration + ($classes->currentPage() - 1) * $classes->perPage() }}</td>
                        <td class="px-4 py-2 text-sm">
                            <div class="text-slate-900 font-semibold">{{ $class->name }}</div>
                            @if($class->description)
                            <div class="text-xs text-slate-500">{{ Str::limit($class->description, 70) }}</div>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-sm text-slate-700">{{ $class->activity->name ?? '-' }}</td>
                        <td class="px-4 py-2 text-sm text-slate-700">
                            @if($class->start_date && $class->end_date)
                                <div class="text-xs">
                                    <div>{{ $class->start_date->format('d/m/Y') }}</div>
                                    <div class="text-slate-500">s/d {{ $class->end_date->format('d/m/Y') }}</div>
                                </div>
                            @elseif($class->activity && $class->activity->start_date && $class->activity->end_date)
                                <div class="text-xs">
                                    <div>{{ $class->activity->start_date->format('d/m/Y') }}</div>
                                    <div class="text-slate-500">s/d {{ $class->activity->end_date->format('d/m/Y') }}</div>
                                </div>
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-4 py-2 text-sm text-slate-700">{{ $class->max_participants ?? 'Unlimited' }}</td>
                        <td class="px-4 py-2 text-sm">
                            @if($class->status == 'open')
                                <div class="flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#0284c7] flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <div class="flex flex-col">
                                        <span class="text-xs font-medium text-[#0284c7]">Buka</span>
                                        <span class="text-[10px] text-sky-600">Menerima peserta</span>
                                    </div>
                                </div>
                            @elseif($class->status == 'closed')
                                <div class="flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-orange-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                    </svg>
                                    <div class="flex flex-col">
                                        <span class="text-xs font-medium text-orange-700">Tutup</span>
                                        <span class="text-[10px] text-orange-600">Tidak menerima peserta</span>
                                    </div>
                                </div>
                            @else
                                <div class="flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <div class="flex flex-col">
                                        <span class="text-xs font-medium text-slate-700">Selesai</span>
                                        <span class="text-[10px] text-slate-600">Kelas berakhir</span>
                                    </div>
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-sm text-slate-700">{{ $class->creator->name ?? '-' }}</td>
                        <td class="px-4 py-2 text-sm">
                            <div class="flex justify-end">
                                <div x-data="{ open: false }" class="relative">
                                    <button @click="open = !open" @click.outside="open = false" class="rounded-md border border-slate-300 bg-white px-3 py-1.5 shadow-sm hover:bg-slate-50 focus:outline-none" aria-label="Aksi kelas">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-600" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zm6 0a2 2 0 11-4 0 2 2 0 014 0zm6 0a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </button>

                                    <div x-show="open" x-transition @keydown.escape.window="open = false" class="absolute right-0 z-40 mt-2 w-44 rounded-lg border border-slate-200 bg-white py-1 shadow-lg" role="menu">
                                        <a href="{{ route($routePrefix . '.classes.show', $class) }}" class="flex items-center gap-2.5 px-3 py-2 text-sm hover:bg-slate-50" role="menuitem">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <span class="text-slate-700">Detail</span>
                                        </a>

                                        <a href="{{ route($routePrefix . '.classes.index') }}?edit={{ $class->id }}" class="flex items-center gap-2.5 px-3 py-2 text-sm hover:bg-slate-50" role="menuitem">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            <span class="text-slate-700">Edit</span>
                                        </a>

                                        <form action="{{ route($routePrefix . '.classes.delete', $class) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kelas ini?')" role="menuitem">
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
                        <td colspan="8" class="px-4 py-6 text-center text-sm text-slate-500">Tidak ada data kelas</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-6 border-t border-slate-200 pt-4">
            {{ $classes->links() }}
        </div>
    </div>

    {{-- Create Class Modal --}}
    @include('super-admin.classes.partials.create-modal')

    {{-- Edit Class Modal --}}
    @include('super-admin.classes.partials.edit-modal')
</div>
@endsection
