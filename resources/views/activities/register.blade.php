@extends('layouts.dashboard')

@section('title', 'Pendaftaran - ' . $activity->name)

@section('sidebar')
    @include('layouts.sekolah')
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Form Pendaftaran Kegiatan</h1>
            <p class="mt-1 text-sm text-slate-500">{{ $activity->name }}</p>
        </div>
        <div>
            <button type="button" onclick="window.location.href='{{ route('sekolah.activities.index') }}'" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Kembali
            </button>
        </div>
    </div>

    @if(session('error'))
        <div class="rounded-lg border border-red-200 bg-red-50 p-4 mb-6">
            <div class="flex">
                <svg class="h-5 w-5 text-red-400 mr-3" fill="none" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293z" clip-rule="evenodd" />
                </svg>
                <div class="text-sm text-red-800">{{ session('error') }}</div>
            </div>
        </div>
    @endif

    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
        <form method="POST" action="{{ route('activities.register', $activity) }}" class="p-6">
            @csrf

            <div class="mb-8">
                <h3 class="text-lg font-semibold text-slate-900 mb-4 pb-2 border-b border-slate-200">Informasi Sekolah</h3>

                <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                    <div class="lg:col-span-2 space-y-6">
                        <div>
                            <label for="nama_sekolah" class="block text-sm font-medium text-slate-700 mb-2">Nama Sekolah <span class="text-red-500">*</span></label>
                            <input type="text"
                                   class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/20 @error('nama_sekolah') is-invalid @enderror"
                                   id="nama_sekolah"
                                   name="nama_sekolah"
                                   value="{{ old('nama_sekolah') }}"
                                   required
                                   placeholder="Contoh: SMA Negeri 1 Jakarta">
                            @error('nama_sekolah')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="alamat_sekolah" class="block text-sm font-medium text-slate-700 mb-2">Alamat Sekolah <span class="text-red-500">*</span></label>
                            <textarea class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/20 @error('alamat_sekolah') is-invalid @enderror"
                                      id="alamat_sekolah"
                                      name="alamat_sekolah"
                                      rows="3"
                                      required
                                      placeholder="Masukkan alamat lengkap sekolah">{{ old('alamat_sekolah') }}</textarea>
                            @error('alamat_sekolah')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="kcd" class="block text-sm font-medium text-slate-700 mb-2">KCD (Kantor Cabang Dinas) <span class="text-red-500">*</span></label>
                            <input type="text"
                                   class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/20 @error('kcd') is-invalid @enderror"
                                   id="kcd"
                                   name="kcd"
                                   value="{{ old('kcd') }}"
                                   required
                                   placeholder="Contoh: KCD Jakarta Selatan">
                            @error('kcd')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label for="provinsi" class="block text-sm font-medium text-slate-700 mb-2">Provinsi <span class="text-red-500">*</span></label>
                            <select class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/20 @error('provinsi') is-invalid @enderror"
                                    id="provinsi"
                                    name="provinsi"
                                    required
                                    onchange="updateCities(this, document.getElementById('kab_kota'), document.getElementById('kecamatan'))">
                                <option value="">Pilih Provinsi</option>
                                <option value="Jawa Barat" {{ old('provinsi') == 'Jawa Barat' ? 'selected' : '' }}>Jawa Barat</option>
                                <option value="Bengkulu" {{ old('provinsi') == 'Bengkulu' ? 'selected' : '' }}>Bengkulu</option>
                                <option value="Lampung" {{ old('provinsi') == 'Lampung' ? 'selected' : '' }}>Lampung</option>
                            </select>
                            @error('provinsi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="kab_kota" class="block text-sm font-medium text-slate-700 mb-2">Kabupaten/Kota <span class="text-red-500">*</span></label>
                            <select class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/20 @error('kab_kota') is-invalid @enderror"
                                    id="kab_kota"
                                    name="kab_kota"
                                    required
                                    onchange="updateDistricts(document.getElementById('provinsi'), this, document.getElementById('kecamatan'))">
                                <option value="">Pilih Kabupaten/Kota</option>
                            </select>
                            @error('kab_kota')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="kecamatan" class="block text-sm font-medium text-slate-700 mb-2">Kecamatan <span class="text-red-500">*</span></label>
                            <select class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/20 @error('kecamatan') is-invalid @enderror"
                                    id="kecamatan"
                                    name="kecamatan"
                                    required>
                                <option value="">Pilih Kecamatan</option>
                            </select>
                            @error('kecamatan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-8">
                <h3 class="text-lg font-semibold text-slate-900 mb-4 pb-2 border-b border-slate-200">Informasi Kontak</h3>

                <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                    <div>
                        <label for="nama_kepala_sekolah" class="block text-sm font-medium text-slate-700 mb-2">Nama Kepala Sekolah <span class="text-red-500">*</span></label>
                        <input type="text"
                               class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/20 @error('nama_kepala_sekolah') is-invalid @enderror"
                               id="nama_kepala_sekolah"
                               name="nama_kepala_sekolah"
                               value="{{ old('nama_kepala_sekolah') }}"
                               required
                               placeholder="Masukkan nama lengkap kepala sekolah">
                        @error('nama_kepala_sekolah')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nomor_telp" class="block text-sm font-medium text-slate-700 mb-2">Nomor yang Dapat Dihubungi <span class="text-red-500">*</span></label>
                        <input type="tel"
                               class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/20 @error('nomor_telp') is-invalid @enderror"
                               id="nomor_telp"
                               name="nomor_telp"
                               value="{{ old('nomor_telp') }}"
                               required
                               placeholder="Contoh: 081234567890">
                        @error('nomor_telp')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email (Opsional)</label>
                        <input type="email"
                               class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/20 @error('email') is-invalid @enderror"
                               id="email"
                               name="email"
                               value="{{ old('email') }}"
                               placeholder="email@sekolah.com">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-slate-500">Email untuk konfirmasi (jika ada)</p>
                    </div>
                </div>
            </div>

            <div class="mb-8">
                <h3 class="text-lg font-semibold text-slate-900 mb-4 pb-2 border-b border-slate-200">Jumlah Peserta</h3>

                @if($activity->registration_fee > 0)
                <div class="rounded-lg border border-amber-200 bg-amber-50 p-4 mb-6">
                    <div class="flex">
                        <svg class="h-5 w-5 text-amber-400 mr-3" fill="none" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0v4a1 1 0 102 0V6a1 1 0 012 0z" clip-rule="evenodd" />
                        </svg>
                        <div>
                            <p class="text-sm text-amber-800"><strong>Biaya Kegiatan:</strong> Rp {{ number_format($activity->registration_fee, 0, ',', '.') }} per peserta</p>
                            <p class="text-sm text-amber-700">Total biaya akan dihitung berdasarkan jumlah peserta yang didaftarkan.</p>
                        </div>
                    </div>
                </div>
                @endif

                <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                    <div>
                        <label for="jumlah_peserta" class="block text-sm font-medium text-slate-700 mb-2">Jumlah Peserta <span class="text-red-500">*</span></label>
                        <input type="number"
                               class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/20 @error('jumlah_peserta') is-invalid @enderror"
                               id="jumlah_peserta"
                               name="jumlah_peserta"
                               value="{{ old('jumlah_peserta', 0) }}"
                               min="0"
                               required
                               placeholder="0"
                               onchange="calculateTotal()">
                        @error('jumlah_peserta')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-slate-500">Total semua peserta</p>
                    </div>

                    <div>
                        <label for="jumlah_kepala_sekolah" class="block text-sm font-medium text-slate-700 mb-2">Kepala Sekolah <span class="text-red-500">*</span></label>
                        <input type="number"
                               class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/20 @error('jumlah_kepala_sekolah') is-invalid @enderror"
                               id="jumlah_kepala_sekolah"
                               name="jumlah_kepala_sekolah"
                               value="{{ old('jumlah_kepala_sekolah', 0) }}"
                               min="0"
                               required
                               placeholder="0"
                               onchange="calculateTotal()">
                        @error('jumlah_kepala_sekolah')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-slate-500">Berapa orang</p>
                    </div>

                    <div>
                        <label for="jumlah_guru" class="block text-sm font-medium text-slate-700 mb-2">Guru <span class="text-red-500">*</span></label>
                        <input type="number"
                               class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/20 @error('jumlah_guru') is-invalid @enderror"
                               id="jumlah_guru"
                               name="jumlah_guru"
                               value="{{ old('jumlah_guru', 0) }}"
                               min="0"
                               required
                               placeholder="0"
                               onchange="calculateTotal()">
                        @error('jumlah_guru')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-slate-500">Berapa orang</p>
                    </div>
                </div>

                @if($activity->registration_fee > 0)
                <div class="rounded-lg border border-sky-200 bg-sky-50 p-4">
                    <h6 class="text-sm font-semibold text-slate-800 mb-2">Estimasi Biaya Total:</h6>
                    <h3 class="text-2xl font-bold text-sky-700 mb-0" id="total-biaya">Rp 0</h3>
                    <p class="text-sm text-slate-600">Total biaya = Jumlah peserta × Rp {{ number_format($activity->registration_fee, 0, ',', '.') }}</p>
                </div>
                @endif
            </div>

            <div class="rounded-lg border border-blue-200 bg-blue-50 p-4 mb-6">
                <div class="flex">
                    <svg class="h-5 w-5 text-blue-400 mr-3" fill="none" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0v4a1 1 0 102 0V6a1 1 0 012 0z" clip-rule="evenodd" />
                    </svg>
                    <div>
                        <p class="text-sm text-blue-800"><strong>Pendaftaran Per Sekolah:</strong> Sistem ini adalah pendaftaran per sekolah. Anda dapat mendaftarkan beberapa peserta (kepala sekolah dan guru) dari sekolah Anda dalam satu pendaftaran. Pembayaran akan dihitung berdasarkan total peserta yang didaftarkan.</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                <button type="button" onclick="window.location.href='{{ route('sekolah.activities.index') }}'" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-6 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                    Batal
                </button>
                <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-sky-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-500/20">
                    <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Daftar Sekarang
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function calculateTotal() {
    const biayaPerPeserta = {{ $activity->registration_fee }};
    const jumlahPeserta = parseInt(document.getElementById('jumlah_peserta').value) || 0;
    const jumlahKepalaSekolah = parseInt(document.getElementById('jumlah_kepala_sekolah').value) || 0;
    const jumlahGuru = parseInt(document.getElementById('jumlah_guru').value) || 0;

    // If jumlah_peserta is filled, use it; otherwise use sum of kepala sekolah + guru
    const totalPeserta = jumlahPeserta > 0 ? jumlahPeserta : (jumlahKepalaSekolah + jumlahGuru);
    const totalBiaya = totalPeserta * biayaPerPeserta;

    document.getElementById('total-biaya').textContent = 'Rp ' + totalBiaya.toLocaleString('id-ID');
}

// Initialize dropdowns on page load
document.addEventListener('DOMContentLoaded', function() {
    const provinceSelect = document.getElementById('provinsi');
    const citySelect = document.getElementById('kab_kota');
    const districtSelect = document.getElementById('kecamatan');

    const savedProvince = "{{ old('provinsi') }}";
    const savedCity = "{{ old('kab_kota') }}";
    const savedDistrict = "{{ old('kecamatan') }}";

    if (savedProvince) {
        updateCities(provinceSelect, citySelect, districtSelect);
        if (savedCity) {
            setTimeout(() => {
                citySelect.value = savedCity;
                updateDistricts(provinceSelect, citySelect, districtSelect);
                if (savedDistrict) {
                    setTimeout(() => {
                        districtSelect.value = savedDistrict;
                    }, 100);
                }
            }, 100);
        }
    }

    // Calculate on page load if values exist
    calculateTotal();
});
</script>

<script src="{{ asset('js/indonesia-location.js') }}"></script>
@endsection
