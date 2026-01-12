@extends('layouts.dashboard')

@section('title', 'Peserta Kelas - ' . $class->name)

@section('sidebar')
<nav class="nav flex-column">
    <a class="nav-link" href="{{ route('fasilitator.dashboard') }}">Dashboard</a>
    <a class="nav-link" href="{{ route('fasilitator.profile') }}">Edit Biodata</a>
    <a class="nav-link" href="{{ route('fasilitator.classes') }}">Input Nilai</a>
    <a class="nav-link active" href="{{ route('fasilitator.mappings.index') }}">Pemetaan Peserta</a>
</nav>
@endsection

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold mb-2">Pemetaan Peserta</h1>
            <p class="text-gray-500">Kelas: <strong>{{ $class->name }}</strong> - {{ $class->activity->name ?? '-' }}</p>
        </div>
        <a href="{{ route('fasilitator.mappings.index') }}" class="btn btn-secondary">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            Kembali
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success shadow-lg mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form Add Participant -->
        <div class="lg:col-span-1" x-data="{
            selectedProvince: '',
            selectedCity: '',
            selectedDistrict: '',
            participants: {{ json_encode($availableParticipants->map(function($p) {
                return [
                    'id' => $p->id,
                    'name' => $p->name,
                    'institution' => $p->institution,
                    'province' => $p->province,
                    'city' => $p->city,
                    'district' => $p->district
                ];
            })->values()) }},
            get filteredParticipants() {
                return this.participants.filter(p => {
                    if (this.selectedProvince && p.province !== this.selectedProvince) return false;
                    if (this.selectedCity && p.city !== this.selectedCity) return false;
                    if (this.selectedDistrict && p.district !== this.selectedDistrict) return false;
                    return true;
                });
            },
            get provinces() {
                return [...new Set(this.participants.map(p => p.province).filter(Boolean))].sort();
            },
            get cities() {
                return [...new Set(
                    this.participants
                        .filter(p => !this.selectedProvince || p.province === this.selectedProvince)
                        .map(p => p.city)
                        .filter(Boolean)
                )].sort();
            },
            get districts() {
                return [...new Set(
                    this.participants
                        .filter(p => !this.selectedProvince || p.province === this.selectedProvince)
                        .filter(p => !this.selectedCity || p.city === this.selectedCity)
                        .map(p => p.district)
                        .filter(Boolean)
                )].sort();
            }
        }">
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Tambah Peserta
                    </h2>
                    <form method="POST" action="{{ route('fasilitator.classes.participants.assign', $class) }}">
                        @csrf

                        <!-- Filter Lokasi -->
                        <div class="mb-4 p-4 bg-base-200 rounded-lg">
                            <p class="text-sm font-semibold mb-3">Filter Lokasi</p>

                            <div class="form-control w-full mb-2">
                                <label class="label"><span class="label-text text-xs">Provinsi</span></label>
                                <select x-model="selectedProvince" @change="selectedCity = ''; selectedDistrict = ''" class="select select-bordered select-sm w-full">
                                    <option value="">Semua Provinsi</option>
                                    <template x-for="prov in provinces" :key="prov">
                                        <option :value="prov" x-text="prov"></option>
                                    </template>
                                </select>
                            </div>

                            <div class="form-control w-full mb-2">
                                <label class="label"><span class="label-text text-xs">Kabupaten/Kota</span></label>
                                <select x-model="selectedCity" @change="selectedDistrict = ''" class="select select-bordered select-sm w-full">
                                    <option value="">Semua Kabupaten/Kota</option>
                                    <template x-for="city in cities" :key="city">
                                        <option :value="city" x-text="city"></option>
                                    </template>
                                </select>
                            </div>

                            <div class="form-control w-full">
                                <label class="label"><span class="label-text text-xs">Kecamatan</span></label>
                                <select x-model="selectedDistrict" class="select select-bordered select-sm w-full">
                                    <option value="">Semua Kecamatan</option>
                                    <template x-for="dist in districts" :key="dist">
                                        <option :value="dist" x-text="dist"></option>
                                    </template>
                                </select>
                            </div>

                            <div class="mt-2 text-xs text-gray-500" x-show="selectedProvince || selectedCity || selectedDistrict">
                                <span x-text="filteredParticipants.length"></span> peserta ditemukan
                            </div>

                            <div class="mt-2 text-xs text-info" x-show="!selectedProvince && !selectedCity && !selectedDistrict">
                                Pilih provinsi, kabupaten/kota, atau kecamatan untuk memfilter peserta
                            </div>
                        </div>

                        <div class="form-control w-full mb-4">
                            <label class="label">
                                <span class="label-text">Pilih Peserta <span class="text-error">*</span></span>
                            </label>
                            <select name="participant_id" id="participant_id" class="select select-bordered w-full @error('participant_id') select-error @enderror" required>
                                <option value="">-- Pilih Peserta --</option>
                                <template x-for="participant in filteredParticipants" :key="participant.id">
                                    <option :value="participant.id">
                                        <span x-text="participant.name"></span>
                                        <span x-text="participant.institution ? ' (' + participant.institution + ')' : ''"></span>
                                        <span x-show="participant.district" x-text="' - ' + participant.district"></span>
                                    </option>
                                </template>
                            </select>
                            @error('participant_id')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control w-full mb-4">
                            <label class="label">
                                <span class="label-text">Tanggal Masuk</span>
                            </label>
                            <input type="date" name="enrolled_date" id="enrolled_date" class="input input-bordered w-full @error('enrolled_date') input-error @enderror" value="{{ old('enrolled_date', date('Y-m-d')) }}">
                            @error('enrolled_date')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control w-full mb-4">
                            <label class="label">
                                <span class="label-text">Catatan</span>
                            </label>
                            <textarea name="notes" id="notes" rows="2" class="textarea textarea-bordered @error('notes') textarea-error @enderror" placeholder="Catatan tambahan (opsional)">{{ old('notes') }}</textarea>
                            @error('notes')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            Tambahkan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- List Participants -->
        <div class="lg:col-span-2">
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title text-primary mb-4">Daftar Peserta</h2>
                    <div class="overflow-x-auto">
                        <table class="table table-zebra w-full">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Peserta</th>
                                    <th>Email</th>
                                    <th>Institusi</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($mappings as $mapping)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <strong>{{ $mapping->participant->name ?? '-' }}</strong>
                                        @if($mapping->notes)
                                        <br><small class="text-muted">{{ $mapping->notes }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $mapping->participant->email ?? '-' }}</td>
                                    <td>{{ $mapping->participant->institution ?? '-' }}</td>
                                    <td>{{ $mapping->enrolled_date ? $mapping->enrolled_date->format('d/m/Y') : '-' }}</td>
                                    <td>
                                        @if($mapping->status == 'in')
                                        <span class="badge badge-success">Aktif</span>
                                        @elseif($mapping->status == 'move')
                                        <span class="badge badge-warning">Pindah</span>
                                        @else
                                        <span class="badge badge-error">Keluar</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($mapping->status == 'in')
                                        <div class="flex gap-2">
                                            <label for="modal-move-{{ $mapping->id }}" class="btn btn-warning btn-sm" title="Pindah Kelas">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                                            </label>
                                            <form action="{{ route('fasilitator.mappings.remove', $mapping) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin mengeluarkan peserta ini dari kelas?')">
                                                @csrf
                                                <button type="submit" class="btn btn-error btn-sm" title="Hapus">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                </button>
                                            </form>
                                        </div>

                                        <!-- Move Modal -->
                                        <input type="checkbox" id="modal-move-{{ $mapping->id }}" class="modal-toggle" />
                                        <div class="modal">
                                            <div class="modal-box relative">
                                                <label for="modal-move-{{ $mapping->id }}" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
                                                <h3 class="font-bold text-lg mb-4">Pindah Kelas</h3>

                                                <form action="{{ route('fasilitator.mappings.move', $mapping) }}" method="POST">
                                                    @csrf
                                                    <p class="mb-4">Pindahkan <strong>{{ $mapping->participant->name }}</strong> ke kelas:</p>

                                                    <div class="form-control w-full mb-4">
                                                        <label class="label">
                                                            <span class="label-text">Pilih Kelas Baru <span class="text-error">*</span></span>
                                                        </label>
                                                        <select name="new_class_id" class="select select-bordered w-full" required>
                                                            <option value="">-- Pilih Kelas --</option>
                                                            @foreach($availableClasses as $availableClass)
                                                            <option value="{{ $availableClass->id }}">{{ $availableClass->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="form-control w-full mb-4">
                                                        <label class="label">
                                                            <span class="label-text">Catatan</span>
                                                        </label>
                                                        <textarea name="notes" rows="2" class="textarea textarea-bordered" placeholder="Alasan pemindahan"></textarea>
                                                    </div>

                                                    <div class="modal-action">
                                                        <label for="modal-move-{{ $mapping->id }}" class="btn btn-ghost">Batal</label>
                                                        <button type="submit" class="btn btn-warning">Pindahkan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Belum ada peserta di kelas ini</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Info Box -->
            <div class="alert alert-info mt-6">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <h3 class="font-bold">Info:</h3>
                    <ul class="mt-2 list-disc list-inside">
                        <li><strong>Tambah:</strong> Menambahkan peserta baru ke kelas</li>
                        <li><strong>Pindah:</strong> Memindahkan peserta ke kelas lain yang Anda handle</li>
                        <li><strong>Hapus:</strong> Mengeluarkan peserta dari kelas (status menjadi OUT)</li>
                        <li>Hanya peserta dengan status AKTIF yang dapat dipindah/dihapus</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
