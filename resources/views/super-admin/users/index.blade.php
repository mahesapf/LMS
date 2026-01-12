@extends('layouts.dashboard')

@section('title', 'Manajemen Pengguna')

@section('sidebar')
    @include('super-admin.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6" x-data="{ showCreateModal: false, showEditModal: {{ request('edit') ? 'true' : 'false' }}, showImportModal: false }">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Manajemen Pengguna</h1>
            <p class="mt-1 text-sm text-slate-500">Kelola akun, status, dan peran pengguna.</p>
        </div>
        <div class="flex items-center gap-2">
            <button @click="showImportModal = true" class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v4a1 1 0 11-2 0V4H5v12h9v-3a1 1 0 112 0v4a1 1 0 01-1 1H4a1 1 0 01-1-1V3zm7 5a1 1 0 011 1v1h2a1 1 0 110 2h-2v1a1 1 0 11-2 0v-1H6a1 1 0 110-2h2V9a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Import CSV
            </button>
            <button @click="showCreateModal = true" class="inline-flex items-center gap-2 rounded-lg bg-sky-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-sky-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Pengguna
            </button>
        </div>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
        <form method="GET" class="mb-4">
            <div class="grid gap-3 sm:grid-cols-2 md:grid-cols-4">
                <div>
                    <label class="mb-1 block text-xs font-medium text-slate-600">Filter peran</label>
                    <select name="role" class="select select-bordered w-full" onchange="this.form.submit()">
                        <option value="all" {{ $role == 'all' ? 'selected' : '' }}>Semua Role</option>
                        <option value="admin" {{ $role == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="fasilitator" {{ $role == 'fasilitator' ? 'selected' : '' }}>Fasilitator</option>
                        <option value="peserta" {{ $role == 'peserta' ? 'selected' : '' }}>Peserta</option>
                    </select>
                </div>
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
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
                        <td class="px-4 py-2 text-sm text-slate-900">{{ $user->degree }} {{ $user->name }}</td>
                        <td class="px-4 py-2 text-sm text-slate-700">{{ $user->email }}</td>
                        <td class="px-4 py-2 text-sm">
                            <span class="inline-flex rounded-full bg-sky-100 px-2.5 py-0.5 text-xs font-semibold text-sky-700">{{ ucfirst($user->role) }}</span>
                        </td>
                        <td class="px-4 py-2 text-sm text-slate-700">{{ $user->phone }}</td>
                        <td class="px-4 py-2 text-sm">
                            @if($user->status == 'active')
                                <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-semibold text-emerald-700">Aktif</span>
                            @elseif($user->status == 'suspended')
                                <span class="inline-flex rounded-full bg-rose-100 px-2.5 py-0.5 text-xs font-semibold text-rose-700">Suspended</span>
                            @else
                                <span class="inline-flex rounded-full bg-slate-200 px-2.5 py-0.5 text-xs font-semibold text-slate-700">Tidak Aktif</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-sm">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('super-admin.users') }}?edit={{ $user->id }}" class="inline-flex items-center rounded-md bg-amber-500 px-2.5 py-1.5 text-xs font-semibold text-white shadow-sm hover:bg-amber-600">Edit</a>
                                @if($user->status == 'active')
                                    <form method="POST" action="{{ route('super-admin.users.suspend', $user) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center rounded-md bg-rose-600 px-2.5 py-1.5 text-xs font-semibold text-white shadow-sm hover:bg-rose-700" onclick="return confirm('Suspend user ini?')">Suspend</button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('super-admin.users.activate', $user) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center rounded-md bg-emerald-600 px-2.5 py-1.5 text-xs font-semibold text-white shadow-sm hover:bg-emerald-700">Aktifkan</button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('super-admin.users.delete', $user) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center rounded-md bg-rose-600 px-2.5 py-1.5 text-xs font-semibold text-white shadow-sm hover:bg-rose-700" onclick="return confirm('Hapus user ini?')">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-sm text-slate-500">Tidak ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $users->links() }}</div>
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
