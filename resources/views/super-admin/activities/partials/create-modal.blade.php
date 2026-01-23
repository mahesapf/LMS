<div x-show="showCreateModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" @keydown.escape.window="showCreateModal = false">
    <div class="fixed inset-0 bg-slate-900/70" @click="showCreateModal = false"></div>
    <div class="relative z-10 flex min-h-screen items-center justify-center p-4">
        <div @click.away="showCreateModal = false" class="relative w-full max-w-4xl overflow-hidden rounded-2xl bg-white shadow-2xl ring-1 ring-slate-200 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Formulir</p>
                <h2 class="text-lg font-semibold text-slate-900">Tambah Kegiatan</h2>
            </div>
            <button type="button" class="rounded-md p-2 text-slate-500 hover:bg-slate-100" @click="showCreateModal = false">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form method="POST" action="{{ route($routePrefix . '.activities.store') }}" class="divide-y divide-slate-100">
            @csrf

            <div class="space-y-6 px-6 py-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Program</label>
                    <select name="program_id" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('program_id') border-red-500 @enderror">
                        <option value="">Pilih Program (Opsional)</option>
                        @foreach($programs as $program)
                            <option value="{{ $program->id }}" {{ old('program_id') == $program->id ? 'selected' : '' }}>{{ $program->name }}</option>
                        @endforeach
                    </select>
                    @error('program_id')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Nama Kegiatan <span class="text-red-600">*</span></label>
                    <input type="text" name="name" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('name') border-red-500 @enderror" value="{{ old('name') }}" required>
                    @error('name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Deskripsi</label>
                    <textarea name="description" rows="4" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Batch</label>
                        <input type="text" name="batch" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('batch') border-red-500 @enderror" value="{{ old('batch') }}" placeholder="Contoh: Batch 1, Angkatan 2024">
                        @error('batch')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Biaya Pendaftaran</label>
                        <input type="number" name="registration_fee" min="0" step="0.01" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('registration_fee') border-red-500 @enderror" value="{{ old('registration_fee', 0) }}">
                        @error('registration_fee')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-3">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Jenis Pembiayaan</label>
                        <select name="financing_type" id="create_financing_type" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('financing_type') border-red-500 @enderror">
                            <option value="">Pilih Jenis</option>
                            <option value="APBN" {{ old('financing_type') == 'APBN' ? 'selected' : '' }}>APBN</option>
                            <option value="Non-APBN" {{ old('financing_type') == 'Non-APBN' ? 'selected' : '' }}>Non-APBN</option>
                        </select>
                        @error('financing_type')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Tipe APBN</label>
                        <select name="apbn_type" id="create_apbn_type" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('apbn_type') border-red-500 @enderror">
                            <option value="">Pilih Tipe</option>
                            <option value="BOS Reguler" {{ old('apbn_type') == 'BOS Reguler' ? 'selected' : '' }}>BOS Reguler</option>
                            <option value="BOS Kinerja" {{ old('apbn_type') == 'BOS Kinerja' ? 'selected' : '' }}>BOS Kinerja</option>
                            <option value="DIPA" {{ old('apbn_type') == 'DIPA' ? 'selected' : '' }}>DIPA</option>
                        </select>
                        @error('apbn_type')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Status <span class="text-red-600">*</span></label>
                        <select name="status" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('status') border-red-500 @enderror" required>
                            <option value="planned" {{ old('status') == 'planned' ? 'selected' : '' }}>Direncanakan</option>
                            <option value="ongoing" {{ old('status') == 'ongoing' ? 'selected' : '' }}>Berlangsung</option>
                            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                            <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Tanggal Mulai <span class="text-red-600">*</span></label>
                        <input type="date" name="start_date" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('start_date') border-red-500 @enderror" value="{{ old('start_date') }}" required>
                        @error('start_date')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Tanggal Selesai <span class="text-red-600">*</span></label>
                        <input type="date" name="end_date" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('end_date') border-red-500 @enderror" value="{{ old('end_date') }}" required>
                        @error('end_date')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 bg-slate-50 px-6 py-4">
                <button type="button" @click="showCreateModal = false" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-white">Batal</button>
                <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-[#0284c7] px-4 py-2 text-sm font-semibold text-white hover:bg-[#0369a1]">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Simpan Kegiatan
                </button>
            </div>
        </form>
    </div>
    </div>
</div>
