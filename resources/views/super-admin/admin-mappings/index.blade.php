@extends('layouts.dashboard')

@section('title', 'Pemetaan Admin')

@section('sidebar')
@include('super-admin.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6" x-data="{ 
    openDropdownId: null,
    showCreateModal: false,
    toggleDropdown(id) {
        this.openDropdownId = this.openDropdownId === id ? null : id;
    },
    closeDropdowns() {
        this.openDropdownId = null;
    }
}" @click.away="closeDropdowns()">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Pemetaan Admin</h1>
            <p class="mt-1 text-sm text-slate-500">Tugas admin terhadap program atau kegiatan.</p>
        </div>
        <button @click="showCreateModal = true" class="inline-flex items-center gap-2 rounded-lg bg-[#0284c7] px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#0369a1]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Pemetaan
        </button>
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
                            @if($mapping->admin)
                                <div class="text-slate-900 font-semibold">{{ $mapping->admin->name }}</div>
                                <div class="text-xs text-slate-500">{{ $mapping->admin->email }}</div>
                            @else
                                <div class="text-slate-900 font-semibold">Admin Dihapus</div>
                                <div class="text-xs text-red-500">ID: {{ $mapping->admin_id }}</div>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-sm text-slate-700">{{ $mapping->program ? $mapping->program->name : '-' }}</td>
                        <td class="px-4 py-2 text-sm text-slate-700">{{ $mapping->activity ? $mapping->activity->name : '-' }}</td>
                        <td class="px-4 py-2 text-sm">
                            @if($mapping->status == 'in')
                                <div class="flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#0284c7] flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <div class="flex flex-col">
                                        <span class="text-xs font-medium text-[#0284c7]">Aktif</span>
                                        <span class="text-[10px] text-sky-600">Sedang bertugas</span>
                                    </div>
                                </div>
                            @else
                                <div class="flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                    </svg>
                                    <div class="flex flex-col">
                                        <span class="text-xs font-medium text-slate-700">Keluar</span>
                                        <span class="text-[10px] text-slate-600">Tidak bertugas</span>
                                    </div>
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-sm text-slate-700">{{ $mapping->assigned_date ? $mapping->assigned_date->format('d/m/Y') : '-' }}</td>
                        <td class="px-4 py-2 text-sm text-slate-700">{{ $mapping->removed_date ? $mapping->removed_date->format('d/m/Y') : '-' }}</td>
                        <td class="px-4 py-2 text-sm text-slate-700">{{ $mapping->assignedBy->name }}</td>
                        <td class="px-4 py-2 text-sm">
                            <div class="flex justify-end">
                                <div class="relative">
                                    <button @click="toggleDropdown({{ $mapping->id }})" 
                                            :class="{ 'ring-2 ring-[#0284c7] ring-offset-2': openDropdownId === {{ $mapping->id }} }"
                                            class="inline-flex items-center gap-1 rounded-md border border-slate-300 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 shadow-sm hover:bg-slate-50" 
                                            aria-label="Aksi pemetaan admin">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zm6 0a2 2 0 11-4 0 2 2 0 014 0zm6 0a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </button>

                                    <div x-show="openDropdownId === {{ $mapping->id }}" 
                                         x-transition 
                                         @keydown.escape.window="closeDropdowns()" 
                                         class="absolute right-0 z-40 mt-2 w-44 rounded-lg border border-slate-200 bg-white py-1 shadow-lg" 
                                         role="menu">
                                        @if($mapping->status == 'in')
                                            <form method="POST" action="{{ route('super-admin.admin-mappings.update-status', [$mapping, 'out']) }}" onsubmit="return confirm('Keluarkan admin dari tugas ini?')" role="menuitem">
                                                @csrf
                                                <button type="submit" class="flex w-full items-center gap-2.5 px-3 py-2 text-left text-sm hover:bg-slate-50">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                    </svg>
                                                    <span class="text-slate-700">Keluarkan</span>
                                                </button>
                                            </form>
                                        @else
                                            <form method="POST" action="{{ route('super-admin.admin-mappings.update-status', [$mapping, 'in']) }}" role="menuitem">
                                                @csrf
                                                <button type="submit" class="flex w-full items-center gap-2.5 px-3 py-2 text-left text-sm hover:bg-slate-50">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <span class="text-slate-700">Aktifkan Kembali</span>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        <a href="{{ route('super-admin.admin-mappings.edit', $mapping) }}" class="flex items-center gap-2.5 px-3 py-2 text-sm hover:bg-slate-50" role="menuitem">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                                            </svg>
                                            <span class="text-slate-700">Edit</span>
                                        </a>
                                        
                                        <form method="POST" action="{{ route('super-admin.admin-mappings.delete', $mapping) }}" onsubmit="return confirm('Hapus pemetaan admin ini secara permanent?')" role="menuitem">
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
                    @empty
                    <tr>
                        <td colspan="8" class="px-4 py-6 text-center text-sm text-slate-500">Tidak ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-6 border-t border-slate-200 pt-4">
            {{ $mappings->links() }}
        </div>
    </div>

    <!-- Create Modal - Same as User Modal -->
<div x-show="showCreateModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" @keydown.escape.window="showCreateModal = false">
    <div class="fixed inset-0 bg-slate-900/70" @click="showCreateModal = false"></div>
    <div class="relative z-10 flex min-h-screen items-center justify-center p-4">
        <div @click.away="showCreateModal = false" class="relative w-full max-w-lg overflow-hidden rounded-2xl bg-white shadow-2xl ring-1 ring-slate-200">
            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4 sticky top-0 bg-white z-10">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Formulir</p>
                    <h2 class="text-lg font-semibold text-slate-900">Tambah Pemetaan Admin</h2>
                </div>
                <button type="button" class="rounded-md p-2 text-slate-500 hover:bg-slate-100" @click="showCreateModal = false">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form method="POST" action="{{ route('super-admin.admin-mappings.store') }}">
                @csrf

                <div class="space-y-6 px-6 py-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Admin <span class="text-red-600">*</span></label>
                        <select name="admin_id" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('admin_id') border-red-500 @enderror" required>
                            <option value="">Pilih Admin</option>
                            @if(isset($admins))
                                @foreach($admins as $admin)
                                    <option value="{{ $admin->id }}" {{ old('admin_id') == $admin->id ? 'selected' : '' }}>
                                        {{ $admin->name }} ({{ $admin->email }})
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('admin_id')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Program</label>
                        <select name="program_id" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('program_id') border-red-500 @enderror">
                            <option value="">Pilih Program (Opsional)</option>
                            @if(isset($programs))
                                @foreach($programs as $program)
                                    <option value="{{ $program->id }}" {{ old('program_id') == $program->id ? 'selected' : '' }}>
                                        {{ $program->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('program_id')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Kegiatan</label>
                        <select name="activity_id" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('activity_id') border-red-500 @enderror">
                            <option value="">Pilih Kegiatan (Opsional)</option>
                            @if(isset($activities))
                                @foreach($activities as $activity)
                                    <option value="{{ $activity->id }}" {{ old('activity_id') == $activity->id ? 'selected' : '' }}>
                                        {{ $activity->name }}
                                        @if($activity->program)
                                            ({{ $activity->program->name }})
                                        @endif
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('activity_id')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-slate-500">Admin dapat ditugaskan ke Program, Kegiatan, atau keduanya</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Status <span class="text-red-600">*</span></label>
                        <select name="status" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('status') border-red-500 @enderror" required>
                            <option value="in" {{ old('status') == 'in' ? 'selected' : '' }}>Aktif (In)</option>
                            <option value="out" {{ old('status') == 'out' ? 'selected' : '' }}>Keluar (Out)</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Ditugaskan</label>
                        <input type="date" name="assigned_date" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-2 focus:ring-sky-200 @error('assigned_date') border-red-500 @enderror" value="{{ old('assigned_date', date('Y-m-d')) }}">
                        @error('assigned_date')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="sticky bottom-0 flex items-center justify-end gap-3 border-t border-slate-200 bg-slate-50 px-6 py-4">
                    <button type="button" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100" @click="showCreateModal = false">
                        Batal
                    </button>
                    <button type="submit" class="rounded-lg bg-[#0284c7] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#0369a1]">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection
