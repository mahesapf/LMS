@extends('layouts.dashboard')

@section('title', 'Manajemen Pengguna')

@section('sidebar')
    @if($routePrefix === 'admin')
        @include('admin.partials.sidebar')
    @else
        @include('super-admin.partials.sidebar')
    @endif
@endsection

@section('content')
<div class="space-y-6" x-data="{ 
    showCreateModal: false, 
    showEditModal: {{ request('edit') ? 'true' : 'false' }}, 
    showImportModal: false, 
    openDetailId: null,
    selectedUsers: [],
    selectAll: false,
    toggleAll() {
        if (this.selectAll) {
            this.selectedUsers = Array.from(document.querySelectorAll('.user-checkbox')).map(cb => parseInt(cb.value));
        } else {
            this.selectedUsers = [];
        }
    },
    toggleUser(id) {
        if (this.selectedUsers.includes(id)) {
            this.selectedUsers = this.selectedUsers.filter(u => u !== id);
        } else {
            this.selectedUsers.push(id);
        }
        this.selectAll = this.selectedUsers.length === document.querySelectorAll('.user-checkbox').length;
    },
    deleteSelected() {
        console.log('deleteSelected called');
        console.log('selectedUsers:', this.selectedUsers);
        
        if (this.selectedUsers.length === 0) {
            alert('Pilih minimal satu user untuk dihapus');
            return;
        }
        
        if (confirm(`Hapus ${this.selectedUsers.length} user yang dipilih?`)) {
            console.log('Creating form for bulk delete');
            const form = document.createElement('form');
            form.method = 'POST';
            // Try POST route first, fallback to DELETE with method spoofing
            form.action = '{{ route($routePrefix . ".users.bulkDeletePost") }}';
            console.log('Form action:', form.action);
            
            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';
            form.appendChild(csrf);
            
            // No method spoofing needed for POST route
            this.selectedUsers.forEach(id => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'user_ids[]';
                input.value = id;
                form.appendChild(input);
                console.log('Adding user ID:', id);
            });
            
            // Add role filter if exists
            @if(request('role') && request('role') !== 'all')
                const roleInput = document.createElement('input');
                roleInput.type = 'hidden';
                roleInput.name = 'role';
                roleInput.value = '{{ request("role") }}';
                form.appendChild(roleInput);
                console.log('Adding role filter:', '{{ request("role") }}');
            @endif
            
            console.log('Submitting form...');
            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
        }
    }
}">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Manajemen Pengguna</h1>
            <p class="mt-1 text-sm text-slate-500">Kelola akun, status, dan peran pengguna.</p>
        </div>
        <div class="flex items-center gap-2">
            <button @click="deleteSelected()" 
                    :disabled="selectedUsers.length === 0"
                    onclick="console.log('Button clicked, selectedUsers:', this.selectedUsers)"
                    class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-700 disabled:opacity-50 disabled:cursor-not-allowed">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Hapus (<span x-text="selectedUsers.length">0</span>)
            </button>
            <button @click="showImportModal = true" class="inline-flex items-center gap-2 rounded-lg bg-[#0284c7] px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#0369a1]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v4a1 1 0 11-2 0V4H5v12h9v-3a1 1 0 112 0v4a1 1 0 01-1 1H4a1 1 0 01-1-1V3zm7 5a1 1 0 011 1v1h2a1 1 0 110 2h-2v1a1 1 0 11-2 0v-1H6a1 1 0 110-2h2V9a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Import CSV
            </button>
            <button @click="showCreateModal = true" class="inline-flex items-center gap-2 rounded-lg bg-[#0284c7] px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-[#0369a1]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Pengguna
            </button>
        </div>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm overflow-visible">
        <form method="GET" class="mb-4">
            <div class="grid gap-3 sm:grid-cols-2 md:grid-cols-4">
                <div>
                    <label class="mb-1 block text-xs font-medium text-slate-600">Filter peran</label>
                    <select name="role" class="select select-bordered w-full" onchange="this.form.submit()">
                        <option value="all" {{ $role == 'all' ? 'selected' : '' }}>Semua Role</option>
                        @if(auth()->user()->role !== 'admin')
                        <option value="admin" {{ $role == 'admin' ? 'selected' : '' }}>Admin</option>
                        @endif
                        <option value="fasilitator" {{ $role == 'fasilitator' ? 'selected' : '' }}>Fasilitator</option>
                        <option value="peserta" {{ $role == 'peserta' ? 'selected' : '' }}>Peserta</option>
                    </select>
                </div>
            </div>
        </form>

        <div class="relative overflow-x-auto overflow-y-visible">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-2 text-left">
                            <input type="checkbox"
                                   x-model="selectAll"
                                   @change="toggleAll()"
                                   class="rounded border-slate-300 text-sky-600 focus:ring-sky-500">
                        </th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Nama</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Email</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Role</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Telepon</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Status</th>
                        <th class="px-4 py-2 text-right text-xs font-semibold text-slate-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-2">
                            <input type="checkbox"
                                   class="user-checkbox rounded border-slate-300 text-sky-600 focus:ring-sky-500"
                                   :checked="selectedUsers.includes({{ $user->id }})"
                                   @change="toggleUser({{ $user->id }})"
                                   value="{{ $user->id }}">
                        </td>
                        <td class="px-4 py-2 text-sm text-slate-900">{{ $user->degree }} {{ $user->name }}</td>
                        <td class="px-4 py-2 text-sm text-slate-700">{{ $user->email }}</td>
                        <td class="px-4 py-2 text-sm">
                            @if($user->role == 'admin')
                                <div class="flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-purple-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
                                    </svg>
                                    <div class="flex flex-col">
                                        <span class="text-xs font-medium text-purple-700">Admin</span>
                                        <span class="text-[10px] text-purple-600">Administrator</span>
                                    </div>
                                </div>
                            @elseif($user->role == 'fasilitator')
                                <div class="flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                                    </svg>
                                    <div class="flex flex-col">
                                        <span class="text-xs font-medium text-blue-700">Fasilitator</span>
                                        <span class="text-[10px] text-blue-600">Pengajar</span>
                                    </div>
                                </div>
                            @elseif($user->role == 'peserta')
                                <div class="flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-teal-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z" />
                                        <path d="M3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                                    </svg>
                                    <div class="flex flex-col">
                                        <span class="text-xs font-medium text-teal-700">Peserta</span>
                                        <span class="text-[10px] text-teal-600">Siswa/Pelajar</span>
                                    </div>
                                </div>
                            @elseif($user->role == 'sekolah')
                                <div class="flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd" />
                                    </svg>
                                    <div class="flex flex-col">
                                        <span class="text-xs font-medium text-amber-700">Sekolah</span>
                                        <span class="text-[10px] text-amber-600">Instansi</span>
                                    </div>
                                </div>
                            @else
                                <div class="flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                    <div class="flex flex-col">
                                        <span class="text-xs font-medium text-slate-700">{{ ucfirst($user->role) }}</span>
                                        <span class="text-[10px] text-slate-600">Pengguna</span>
                                    </div>
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-sm text-slate-700">{{ $user->phone }}</td>
                        <td class="px-4 py-2 text-sm">
                            @if($user->status == 'active')
                                <div class="flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#0284c7] flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <div class="flex flex-col">
                                        <span class="text-xs font-medium text-[#0284c7]">Aktif</span>
                                        <span class="text-[10px] text-sky-600">Dapat login</span>
                                    </div>
                                </div>
                            @elseif($user->status == 'suspended')
                                <div class="flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd" />
                                    </svg>
                                    <div class="flex flex-col">
                                        <span class="text-xs font-medium text-red-700">Suspended</span>
                                        <span class="text-[10px] text-red-600">Tidak dapat login</span>
                                    </div>
                                </div>
                            @else
                                <div class="flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                    </svg>
                                    <div class="flex flex-col">
                                        <span class="text-xs font-medium text-slate-700">Tidak Aktif</span>
                                        <span class="text-[10px] text-slate-600">Tidak dapat login</span>
                                    </div>
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-sm">
                            <div class="flex justify-end">
                                <div x-data="{ open: false }" class="relative">
                                    <button @click="open = !open" @click.outside="open = false" class="inline-flex items-center gap-1 rounded-md border border-slate-300 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 shadow-sm hover:bg-slate-50" aria-label="Aksi pengguna">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zm6 0a2 2 0 11-4 0 2 2 0 014 0zm6 0a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </button>

                                    <div x-show="open" x-transition @keydown.escape.window="open = false" class="absolute right-0 z-40 mt-2 w-44 rounded-lg border border-slate-200 bg-white py-1 shadow-lg" role="menu">
                                        <button @click="openDetailId = openDetailId === {{ $user->id }} ? null : {{ $user->id }}; open = false"
                                                class="flex w-full items-center gap-2.5 px-3 py-2 text-left text-sm hover:bg-slate-50" role="menuitem">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <span class="text-slate-700">Lihat Detail</span>
                                        </button>

                                        <a href="{{ route($routePrefix . '.users') }}?edit={{ $user->id }}" class="flex items-center gap-2.5 px-3 py-2 text-sm hover:bg-slate-50" role="menuitem">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                                            </svg>
                                            <span class="text-slate-700">Edit</span>
                                        </a>

                                        @if($user->status == 'active')
                                            <form method="POST" action="{{ route($routePrefix . '.users.suspend', $user) }}" onsubmit="return confirm('Suspend user ini?')" role="menuitem">
                                                @csrf
                                                <button type="submit" class="flex w-full items-center gap-2.5 px-3 py-2 text-left text-sm hover:bg-slate-50">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                    </svg>
                                                    <span class="text-slate-700">Suspend</span>
                                                </button>
                                            </form>
                                        @else
                                            <form method="POST" action="{{ route($routePrefix . '.users.activate', $user) }}" onsubmit="return confirm('Aktifkan user ini?')" role="menuitem">
                                                @csrf
                                                <button type="submit" class="flex w-full items-center gap-2.5 px-3 py-2 text-left text-sm hover:bg-slate-50">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <span class="text-slate-700">Aktifkan</span>
                                                </button>
                                            </form>
                                        @endif

                                        <form method="POST" action="{{ route($routePrefix . '.users.delete', $user) }}" onsubmit="return confirm('Hapus user ini?')" role="menuitem">
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

                    <!-- Detail Row -->
                    <tr x-show="openDetailId === {{ $user->id }}"
                        x-transition
                        class="bg-white border-b border-slate-200">
                        <td colspan="7" class="px-4 py-4">
                            <div class="max-w-6xl space-y-4">
                                <!-- Header -->
                                <div class="flex items-center justify-between rounded-lg border border-slate-200 bg-slate-50 p-3">
                                    <h3 class="text-sm font-semibold text-slate-800">Informasi Detail Pengguna</h3>
                                    <span class="text-xs text-slate-600">ID: {{ $user->id }}</span>
                                </div>

                                <!-- Summary Cards -->
                                <div class="grid grid-cols-1 gap-3 sm:grid-cols-4">
                                    <div class="rounded-lg border border-slate-200 bg-white p-3">
                                        <p class="text-xs font-medium text-slate-500">Nama Lengkap</p>
                                        <p class="mt-1 text-base font-semibold text-slate-900">{{ $user->degree }} {{ $user->name }}</p>
                                    </div>
                                    <div class="rounded-lg border border-slate-200 bg-white p-3">
                                        <p class="text-xs font-medium text-slate-500">Email</p>
                                        <p class="mt-1 text-sm font-semibold text-slate-900">{{ $user->email }}</p>
                                    </div>
                                    <div class="rounded-lg border border-slate-200 bg-white p-3">
                                        <p class="text-xs font-medium text-slate-500">Role</p>
                                        <p class="mt-1 text-sm font-semibold text-slate-900">{{ ucfirst($user->role) }}</p>
                                    </div>
                                    <div class="rounded-lg border border-slate-200 bg-white p-3">
                                        <p class="text-xs font-medium text-slate-500">Status Akun</p>
                                        <p class="mt-1 text-sm font-semibold {{ $user->status == 'active' ? 'text-sky-700' : 'text-red-700' }}">{{ ucfirst($user->status) }}</p>
                                    </div>
                                </div>

                                <!-- Info Grid -->
                                <div class="grid grid-cols-1 gap-3 lg:grid-cols-2">
                                    <div class="rounded-lg border border-slate-200 bg-white p-4">
                                        <h6 class="text-xs font-semibold text-slate-600 uppercase tracking-wider mb-3">Informasi Pribadi</h6>
                                        <div class="space-y-2 text-sm">
                                            <div class="flex justify-between">
                                                <span class="text-slate-500">NIP:</span>
                                                <span class="font-medium text-slate-900">{{ $user->nip ?? '-' }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-slate-500">NIK:</span>
                                                <span class="font-medium text-slate-900">{{ $user->nik ?? '-' }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-slate-500">Telepon:</span>
                                                <span class="font-medium text-slate-900">{{ $user->phone ?? '-' }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-slate-500">Jenis Kelamin:</span>
                                                <span class="font-medium text-slate-900">{{ $user->gender ? ($user->gender == 'male' ? 'Laki-laki' : 'Perempuan') : '-' }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-slate-500">Tanggal Lahir:</span>
                                                <span class="font-medium text-slate-900">{{ $user->date_of_birth ? \Carbon\Carbon::parse($user->date_of_birth)->format('d M Y') : '-' }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="rounded-lg border border-slate-200 bg-white p-4">
                                        <h6 class="text-xs font-semibold text-slate-600 uppercase tracking-wider mb-3">Informasi Institusi</h6>
                                        <div class="space-y-2 text-sm">
                                            <div class="flex justify-between">
                                                <span class="text-slate-500">Institusi:</span>
                                                <span class="font-medium text-slate-900">{{ $user->institution ?? $user->instansi ?? '-' }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-slate-500">NPSN:</span>
                                                <span class="font-medium text-slate-900">{{ $user->npsn ?? '-' }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-slate-500">Provinsi:</span>
                                                <span class="font-medium text-slate-900">{{ $user->province ?? '-' }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-slate-500">Kabupaten/Kota:</span>
                                                <span class="font-medium text-slate-900">{{ $user->city ?? '-' }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-slate-500">Kecamatan:</span>
                                                <span class="font-medium text-slate-900">{{ $user->district ?? '-' }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="rounded-lg border border-slate-200 bg-white p-4 lg:col-span-2">
                                        <h6 class="text-xs font-semibold text-slate-600 uppercase tracking-wider mb-3">Informasi Akun</h6>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                                            <div class="space-y-1">
                                                <p class="text-xs font-medium text-slate-500">Dibuat</p>
                                                <p class="font-semibold text-slate-900">{{ $user->created_at->format('d M Y H:i') }}</p>
                                            </div>
                                            <div class="space-y-1">
                                                <p class="text-xs font-medium text-slate-500">Update Terakhir</p>
                                                <p class="font-semibold text-slate-900">{{ $user->updated_at->format('d M Y H:i') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if($user->role == 'peserta' || $user->role == 'fasilitator')
                                <!-- Activity Info -->
                                <div class="rounded-lg border border-slate-200 bg-white p-4">
                                    <h6 class="text-xs font-semibold text-slate-600 uppercase tracking-wider mb-3">
                                        {{ $user->role == 'peserta' ? 'Kelas yang Diikuti' : 'Kelas yang Difasilitasi' }}
                                    </h6>
                                    @php
                                        if($user->role == 'peserta') {
                                            $classes = $user->participantMappings()->with('class.activity')->where('status', 'in')->get();
                                        } else {
                                            $classes = $user->fasilitatorMappings()->with('class.activity')->where('status', 'in')->get();
                                        }
                                    @endphp
                                    @if($classes->count() > 0)
                                        <div class="space-y-2">
                                            @foreach($classes as $mapping)
                                                <div class="flex items-center justify-between rounded-lg border border-slate-100 bg-slate-50 p-2 text-sm">
                                                    <div>
                                                        <p class="font-semibold text-slate-900">{{ $mapping->class->name }}</p>
                                                        <p class="text-xs text-slate-600">{{ $mapping->class->activity->name }}</p>
                                                    </div>
                                                    <span class="text-xs text-sky-600">{{ $mapping->enrolled_date ? \Carbon\Carbon::parse($mapping->enrolled_date)->format('d M Y') : '-' }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-sm text-slate-500">Belum ada kelas</p>
                                    @endif
                                </div>
                                @endif
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
            {{ $users->links() }}
        </div>
    </div>

    {{-- Create User Modal --}}
    @include('super-admin.users.partials.create-modal')

    {{-- Edit User Modal --}}
    @include('super-admin.users.partials.edit-modal')

    {{-- Import Users Modal --}}
    @include('super-admin.users.partials.import-modal')
</div>

<script src="{{ asset('js/indonesia-location.js') }}"></script>
@endsection
