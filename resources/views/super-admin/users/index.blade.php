@extends('layouts.dashboard')

@section('title', 'Manajemen Pengguna')

@section('sidebar')
    @include('super-admin.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6" x-data="userManagement()">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Manajemen Pengguna</h1>
            <p class="mt-1 text-sm text-slate-500">Kelola akun, status, dan peran pengguna.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('super-admin.users.import') }}" class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v4a1 1 0 11-2 0V4H5v12h9v-3a1 1 0 112 0v4a1 1 0 01-1 1H4a1 1 0 01-1-1V3zm7 5a1 1 0 011 1v1h2a1 1 0 110 2h-2v1a1 1 0 11-2 0v-1H6a1 1 0 110-2h2V9a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Import CSV
            </a>
            <button @click="openCreateModal()" class="inline-flex items-center gap-2 rounded-lg bg-sky-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-sky-700">
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
                                <button @click="openEditModal({{ $user->id }}, '{{ $user->name }}', '{{ $user->degree }}', '{{ $user->email }}', '{{ $user->phone }}', '{{ $user->role }}', '{{ $user->status }}', '{{ $user->institution }}', '{{ $user->position }}', '{{ $user->address }}')" class="inline-flex items-center rounded-md bg-amber-500 px-2.5 py-1.5 text-xs font-semibold text-white shadow-sm hover:bg-amber-600">Edit</button>
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

    <!-- Create User Modal -->
    <div x-show="showCreateModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-end justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showCreateModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity" @click="showCreateModal = false"></div>

            <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>

            <div x-show="showCreateModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block transform overflow-hidden rounded-xl bg-white text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl sm:align-middle">
                <form method="POST" action="{{ route('super-admin.users.store') }}">
                    @csrf
                    <div class="bg-white px-6 pt-5 pb-4">
                        <div class="flex items-start justify-between pb-3 border-b border-slate-200">
                            <h3 class="text-lg font-semibold text-slate-900" id="modal-title">Tambah Pengguna Baru</h3>
                            <button type="button" @click="showCreateModal = false" class="rounded-md text-slate-400 hover:text-slate-500">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div class="mt-4 grid gap-4 sm:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Nama Lengkap <span class="text-red-600">*</span></label>
                                <input type="text" name="name" value="{{ old('name') }}" required class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-sky-500 @error('name') border-red-500 @enderror">
                                @error('name')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700">Gelar</label>
                                <input type="text" name="degree" value="{{ old('degree') }}" placeholder="S.Pd., M.Pd." class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-sky-500 @error('degree') border-red-500 @enderror">
                                @error('degree')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700">Email <span class="text-red-600">*</span></label>
                                <input type="email" name="email" value="{{ old('email') }}" required class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-sky-500 @error('email') border-red-500 @enderror">
                                @error('email')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700">Nomor WhatsApp <span class="text-red-600">*</span></label>
                                <input type="text" name="phone" value="{{ old('phone') }}" required class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-sky-500 @error('phone') border-red-500 @enderror">
                                @error('phone')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700">Password <span class="text-red-600">*</span></label>
                                <input type="password" name="password" required class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-sky-500 @error('password') border-red-500 @enderror">
                                @error('password')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700">Role <span class="text-red-600">*</span></label>
                                <select name="role" required class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-sky-500 @error('role') border-red-500 @enderror">
                                    <option value="">Pilih Role</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="fasilitator" {{ old('role') == 'fasilitator' ? 'selected' : '' }}>Fasilitator</option>
                                    <option value="peserta" {{ old('role') == 'peserta' ? 'selected' : '' }}>Peserta</option>
                                </select>
                                @error('role')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700">Institusi</label>
                                <input type="text" name="institution" value="{{ old('institution') }}" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-sky-500 @error('institution') border-red-500 @enderror">
                                @error('institution')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700">Jabatan</label>
                                <input type="text" name="position" value="{{ old('position') }}" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-sky-500 @error('position') border-red-500 @enderror">
                                @error('position')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-slate-700">Alamat</label>
                                <textarea name="address" rows="3" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-sky-500 @error('address') border-red-500 @enderror">{{ old('address') }}</textarea>
                                @error('address')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-50 px-6 py-3 flex justify-end gap-2">
                        <button type="button" @click="showCreateModal = false" class="inline-flex items-center rounded-lg bg-white border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Batal</button>
                        <button type="submit" class="inline-flex items-center rounded-lg bg-sky-600 px-4 py-2 text-sm font-semibold text-white hover:bg-sky-700">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div x-show="showEditModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-end justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showEditModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity" @click="showEditModal = false"></div>

            <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>

            <div x-show="showEditModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block transform overflow-hidden rounded-xl bg-white text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl sm:align-middle">
                <form method="POST" :action="`/super-admin/users/${editUser.id}`">
                    @csrf
                    @method('PUT')
                    <div class="bg-white px-6 pt-5 pb-4">
                        <div class="flex items-start justify-between pb-3 border-b border-slate-200">
                            <h3 class="text-lg font-semibold text-slate-900">Edit Pengguna</h3>
                            <button type="button" @click="showEditModal = false" class="rounded-md text-slate-400 hover:text-slate-500">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div class="mt-4 grid gap-4 sm:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Nama Lengkap <span class="text-red-600">*</span></label>
                                <input type="text" name="name" x-model="editUser.name" required class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-sky-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700">Gelar</label>
                                <input type="text" name="degree" x-model="editUser.degree" placeholder="S.Pd., M.Pd." class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-sky-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700">Email <span class="text-red-600">*</span></label>
                                <input type="email" name="email" x-model="editUser.email" required class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-sky-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700">Nomor WhatsApp <span class="text-red-600">*</span></label>
                                <input type="text" name="phone" x-model="editUser.phone" required class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-sky-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700">Role <span class="text-red-600">*</span></label>
                                <select name="role" x-model="editUser.role" required class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-sky-500">
                                    <option value="admin">Admin</option>
                                    <option value="fasilitator">Fasilitator</option>
                                    <option value="peserta">Peserta</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700">Status <span class="text-red-600">*</span></label>
                                <select name="status" x-model="editUser.status" required class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-sky-500">
                                    <option value="active">Aktif</option>
                                    <option value="suspended">Suspended</option>
                                    <option value="inactive">Tidak Aktif</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700">Institusi</label>
                                <input type="text" name="institution" x-model="editUser.institution" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-sky-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700">Jabatan</label>
                                <input type="text" name="position" x-model="editUser.position" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-sky-500">
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-slate-700">Alamat</label>
                                <textarea name="address" x-model="editUser.address" rows="3" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-sky-500"></textarea>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-slate-700">Password Baru</label>
                                <input type="password" name="password" class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-sky-500">
                                <p class="mt-1 text-xs text-slate-500">Kosongkan jika tidak ingin mengubah password</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-50 px-6 py-3 flex justify-end gap-2">
                        <button type="button" @click="showEditModal = false" class="inline-flex items-center rounded-lg bg-white border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Batal</button>
                        <button type="submit" class="inline-flex items-center rounded-lg bg-sky-600 px-4 py-2 text-sm font-semibold text-white hover:bg-sky-700">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function userManagement() {
    return {
        showCreateModal: false,
        showEditModal: false,
        editUser: {
            id: null,
            name: '',
            degree: '',
            email: '',
            phone: '',
            role: '',
            status: '',
            institution: '',
            position: '',
            address: ''
        },
        openCreateModal() {
            this.showCreateModal = true;
        },
        openEditModal(id, name, degree, email, phone, role, status, institution, position, address) {
            this.editUser = {
                id: id,
                name: name,
                degree: degree || '',
                email: email,
                phone: phone,
                role: role,
                status: status,
                institution: institution || '',
                position: position || '',
                address: address || ''
            };
            this.showEditModal = true;
        }
    }
}

// Auto-open modal if there are validation errors
@if($errors->any())
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('modal') === 'create')
            Alpine.store('userManagement').showCreateModal = true;
        @elseif(session('modal') === 'edit')
            Alpine.store('userManagement').showEditModal = true;
        @endif
    });
@endif
</script>

<style>
[x-cloak] { display: none !important; }
</style>
@endsection
