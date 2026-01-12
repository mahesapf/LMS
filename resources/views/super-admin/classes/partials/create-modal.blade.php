<div x-show="showCreateModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" @keydown.escape.window="showCreateModal = false">
    <div class="fixed inset-0 bg-slate-900/70" @click="showCreateModal = false"></div>
    <div class="relative z-10 flex min-h-screen items-center justify-center p-4">
        <div @click.away="showCreateModal = false" class="relative w-full max-w-3xl overflow-hidden rounded-2xl bg-white shadow-2xl ring-1 ring-slate-200 max-h-[90vh] overflow-y-auto"
             x-data="{
                 stageCount: 0,
                 stages: []
             }">
        <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Formulir</p>
                <h2 class="text-lg font-semibold text-slate-900">Tambah Kelas</h2>
            </div>
            <button type="button" class="rounded-md p-2 text-slate-500 hover:bg-slate-100" @click="showCreateModal = false">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form action="{{ route($routePrefix . '.classes.store') }}" method="POST" class="divide-y divide-slate-100">
            @csrf

            <div class="space-y-6 px-6 py-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Kegiatan <span class="text-red-600">*</span></label>
                    <select name="activity_id" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('activity_id') border-red-500 @enderror" required>
                        <option value="">Pilih Kegiatan</option>
                        @foreach($activities as $activity)
                        <option value="{{ $activity->id }}" {{ old('activity_id') == $activity->id ? 'selected' : '' }}>{{ $activity->name }}</option>
                        @endforeach
                    </select>
                    @error('activity_id')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Nama Kelas <span class="text-red-600">*</span></label>
                    <input type="text" name="name" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('name') border-red-500 @enderror" value="{{ old('name') }}" required>
                    @error('name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-slate-500">Contoh: Kelas A, Kelas B, Angkatan 1, dll.</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Deskripsi</label>
                    <textarea name="description" rows="3" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Tanggal Mulai</label>
                        <input type="date" name="start_date" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('start_date') border-red-500 @enderror" value="{{ old('start_date') }}">
                        @error('start_date')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Tanggal Selesai</label>
                        <input type="date" name="end_date" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('end_date') border-red-500 @enderror" value="{{ old('end_date') }}">
                        @error('end_date')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-slate-500">Harus sama atau setelah tanggal mulai</p>
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Maksimal Peserta</label>
                        <input type="number" name="max_participants" min="1" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('max_participants') border-red-500 @enderror" value="{{ old('max_participants') }}">
                        <p class="mt-1 text-xs text-slate-500">Kosongkan jika tidak ada batasan</p>
                        @error('max_participants')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Status <span class="text-red-600">*</span></label>
                        <select name="status" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm @error('status') border-red-500 @enderror" required>
                            <option value="open" {{ old('status') == 'open' ? 'selected' : '' }}>Buka</option>
                            <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>Tutup</option>
                            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Jumlah Tahap -->
                <div class="border-t border-slate-200 pt-6">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700">Jumlah Tahap Kegiatan</label>
                        <input type="number"
                               x-model.number="stageCount"
                               @input="
                                   stages = [];
                                   for(let i = 0; i < stageCount; i++) {
                                       stages.push({
                                           name: '',
                                           description: '',
                                           order: i + 1,
                                           start_date: '',
                                           end_date: '',
                                           status: 'not_started'
                                       });
                                   }
                               "
                               min="0" max="10"
                               class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"
                               placeholder="Masukkan jumlah tahap (0-10)">
                        <p class="mt-1 text-xs text-slate-500">Tentukan berapa tahap dalam kelas ini (contoh: 3 untuk Tahap 1, Tahap 2, Tahap 3)</p>
                    </div>

                    <!-- Dynamic Stage Forms -->
                    <div x-show="stageCount > 0" class="space-y-4 mt-4">
                        <template x-for="(stage, index) in stages" :key="index">
                            <div class="p-4 border border-slate-200 rounded-lg bg-slate-50">
                                <h4 class="font-semibold text-sm text-slate-700 mb-3" x-text="'Tahap ' + (index + 1)"></h4>

                                <div class="space-y-3">
                                    <div>
                                        <label class="block text-xs font-medium text-slate-600">Nama Tahap <span class="text-red-600">*</span></label>
                                        <input type="text"
                                               :name="'stages[' + index + '][name]'"
                                               x-model="stage.name"
                                               class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"
                                               placeholder="Contoh: Tahap Persiapan"
                                               required>
                                        <input type="hidden" :name="'stages[' + index + '][order]'" x-model="stage.order">
                                    </div>

                                    <div>
                                        <label class="block text-xs font-medium text-slate-600">Deskripsi</label>
                                        <textarea :name="'stages[' + index + '][description]'"
                                                  x-model="stage.description"
                                                  rows="2"
                                                  class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"
                                                  placeholder="Jelaskan tahap ini..."></textarea>
                                    </div>

                                    <div class="grid gap-3 sm:grid-cols-2">
                                        <div>
                                            <label class="block text-xs font-medium text-slate-600">Tanggal Mulai</label>
                                            <input type="date"
                                                   :name="'stages[' + index + '][start_date]'"
                                                   x-model="stage.start_date"
                                                   class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-slate-600">Tanggal Selesai</label>
                                            <input type="date"
                                                   :name="'stages[' + index + '][end_date]'"
                                                   x-model="stage.end_date"
                                                   class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-medium text-slate-600">Status Tahap</label>
                                        <select :name="'stages[' + index + '][status]'"
                                                x-model="stage.status"
                                                class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                                            <option value="not_started">Belum Dimulai</option>
                                            <option value="ongoing">Sedang Berjalan</option>
                                            <option value="completed">Selesai</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 bg-slate-50 px-6 py-4">
                <button type="button" @click="showCreateModal = false" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-white">Batal</button>
                <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-sky-600 px-4 py-2 text-sm font-semibold text-white hover:bg-sky-700">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Simpan Kelas
                </button>
            </div>
        </form>
    </div>
    </div>
</div>
