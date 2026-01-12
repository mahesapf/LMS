@extends('layouts.app')

@php
    $hideNavbar = true;
@endphp

@section('content')
<div class="auth-wrapper">
    <div class="auth-left"></div>
    <div class="auth-right">
        <div class="auth-card">
            <div class="auth-card-header">
                <img src="{{ asset('storage/tut-wuri-handayani-kemdikdasmen-masafidhan.svg') }}" alt="Tut Wuri Handayani" class="auth-logo">
                <h4>Registrasi Sekolah</h4>
                <p>Sistem Informasi Penjaminan Mutu</p>
            </div>

    <div class="auth-card-body">
        <form method="POST" action="{{ route('sekolah.register.submit') }}" enctype="multipart/form-data">
            @csrf

            <div class="auth-form-group">
                <label for="nama_sekolah" class="auth-form-label">Nama Sekolah <span class="text-danger">*</span></label>
                <input id="nama_sekolah" type="text" class="auth-form-control @error('nama_sekolah') is-invalid @enderror" name="nama_sekolah" value="{{ old('nama_sekolah') }}" required autofocus placeholder="Masukkan nama sekolah">
                @error('nama_sekolah')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="auth-form-group">
                <label for="npsn" class="auth-form-label">NPSN <span class="text-danger">*</span></label>
                <input id="npsn" type="text" class="auth-form-control @error('npsn') is-invalid @enderror" name="npsn" value="{{ old('npsn') }}" required placeholder="Nomor Pokok Sekolah Nasional">
                @error('npsn')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="auth-form-group">
                <label for="provinsi" class="auth-form-label">Provinsi <span class="text-danger">*</span></label>
                <select id="provinsi" class="auth-form-control @error('provinsi') is-invalid @enderror" name="provinsi" required>
                    <option value="">Pilih Provinsi</option>
                    <option value="Aceh" {{ old('provinsi') == 'Aceh' ? 'selected' : '' }}>Aceh</option>
                    <option value="Sumatera Utara" {{ old('provinsi') == 'Sumatera Utara' ? 'selected' : '' }}>Sumatera Utara</option>
                    <option value="Sumatera Barat" {{ old('provinsi') == 'Sumatera Barat' ? 'selected' : '' }}>Sumatera Barat</option>
                    <option value="Riau" {{ old('provinsi') == 'Riau' ? 'selected' : '' }}>Riau</option>
                    <option value="Kepulauan Riau" {{ old('provinsi') == 'Kepulauan Riau' ? 'selected' : '' }}>Kepulauan Riau</option>
                    <option value="Jambi" {{ old('provinsi') == 'Jambi' ? 'selected' : '' }}>Jambi</option>
                    <option value="Sumatera Selatan" {{ old('provinsi') == 'Sumatera Selatan' ? 'selected' : '' }}>Sumatera Selatan</option>
                    <option value="Kepulauan Bangka Belitung" {{ old('provinsi') == 'Kepulauan Bangka Belitung' ? 'selected' : '' }}>Kepulauan Bangka Belitung</option>
                    <option value="Bengkulu" {{ old('provinsi') == 'Bengkulu' ? 'selected' : '' }}>Bengkulu</option>
                    <option value="Lampung" {{ old('provinsi') == 'Lampung' ? 'selected' : '' }}>Lampung</option>
                    <option value="DKI Jakarta" {{ old('provinsi') == 'DKI Jakarta' ? 'selected' : '' }}>DKI Jakarta</option>
                    <option value="Jawa Barat" {{ old('provinsi') == 'Jawa Barat' ? 'selected' : '' }}>Jawa Barat</option>
                    <option value="Banten" {{ old('provinsi') == 'Banten' ? 'selected' : '' }}>Banten</option>
                    <option value="Jawa Tengah" {{ old('provinsi') == 'Jawa Tengah' ? 'selected' : '' }}>Jawa Tengah</option>
                    <option value="DI Yogyakarta" {{ old('provinsi') == 'DI Yogyakarta' ? 'selected' : '' }}>DI Yogyakarta</option>
                    <option value="Jawa Timur" {{ old('provinsi') == 'Jawa Timur' ? 'selected' : '' }}>Jawa Timur</option>
                    <option value="Bali" {{ old('provinsi') == 'Bali' ? 'selected' : '' }}>Bali</option>
                    <option value="Nusa Tenggara Barat" {{ old('provinsi') == 'Nusa Tenggara Barat' ? 'selected' : '' }}>Nusa Tenggara Barat</option>
                    <option value="Nusa Tenggara Timur" {{ old('provinsi') == 'Nusa Tenggara Timur' ? 'selected' : '' }}>Nusa Tenggara Timur</option>
                    <option value="Kalimantan Barat" {{ old('provinsi') == 'Kalimantan Barat' ? 'selected' : '' }}>Kalimantan Barat</option>
                    <option value="Kalimantan Tengah" {{ old('provinsi') == 'Kalimantan Tengah' ? 'selected' : '' }}>Kalimantan Tengah</option>
                    <option value="Kalimantan Selatan" {{ old('provinsi') == 'Kalimantan Selatan' ? 'selected' : '' }}>Kalimantan Selatan</option>
                    <option value="Kalimantan Timur" {{ old('provinsi') == 'Kalimantan Timur' ? 'selected' : '' }}>Kalimantan Timur</option>
                    <option value="Kalimantan Utara" {{ old('provinsi') == 'Kalimantan Utara' ? 'selected' : '' }}>Kalimantan Utara</option>
                    <option value="Sulawesi Utara" {{ old('provinsi') == 'Sulawesi Utara' ? 'selected' : '' }}>Sulawesi Utara</option>
                    <option value="Gorontalo" {{ old('provinsi') == 'Gorontalo' ? 'selected' : '' }}>Gorontalo</option>
                    <option value="Sulawesi Tengah" {{ old('provinsi') == 'Sulawesi Tengah' ? 'selected' : '' }}>Sulawesi Tengah</option>
                    <option value="Sulawesi Barat" {{ old('provinsi') == 'Sulawesi Barat' ? 'selected' : '' }}>Sulawesi Barat</option>
                    <option value="Sulawesi Selatan" {{ old('provinsi') == 'Sulawesi Selatan' ? 'selected' : '' }}>Sulawesi Selatan</option>
                    <option value="Sulawesi Tenggara" {{ old('provinsi') == 'Sulawesi Tenggara' ? 'selected' : '' }}>Sulawesi Tenggara</option>
                    <option value="Maluku" {{ old('provinsi') == 'Maluku' ? 'selected' : '' }}>Maluku</option>
                    <option value="Maluku Utara" {{ old('provinsi') == 'Maluku Utara' ? 'selected' : '' }}>Maluku Utara</option>
                    <option value="Papua" {{ old('provinsi') == 'Papua' ? 'selected' : '' }}>Papua</option>
                    <option value="Papua Barat" {{ old('provinsi') == 'Papua Barat' ? 'selected' : '' }}>Papua Barat</option>
                    <option value="Papua Tengah" {{ old('provinsi') == 'Papua Tengah' ? 'selected' : '' }}>Papua Tengah</option>
                    <option value="Papua Pegunungan" {{ old('provinsi') == 'Papua Pegunungan' ? 'selected' : '' }}>Papua Pegunungan</option>
                    <option value="Papua Selatan" {{ old('provinsi') == 'Papua Selatan' ? 'selected' : '' }}>Papua Selatan</option>
                    <option value="Papua Barat Daya" {{ old('provinsi') == 'Papua Barat Daya' ? 'selected' : '' }}>Papua Barat Daya</option>
                </select>
                @error('provinsi')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="auth-form-group">
                <label for="kabupaten" class="auth-form-label">Kabupaten/Kota <span class="text-danger">*</span></label>
                <select id="kabupaten" class="auth-form-control @error('kabupaten') is-invalid @enderror" name="kabupaten" required disabled>
                    <option value="">Pilih Provinsi Terlebih Dahulu</option>
                </select>
                @error('kabupaten')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="auth-form-group">
                <label for="nama_kepala_sekolah" class="auth-form-label">Nama Kepala Sekolah <span class="text-danger">*</span></label>
                <input id="nama_kepala_sekolah" type="text" class="auth-form-control @error('nama_kepala_sekolah') is-invalid @enderror" name="nama_kepala_sekolah" value="{{ old('nama_kepala_sekolah') }}" required placeholder="Masukkan nama kepala sekolah">
                @error('nama_kepala_sekolah')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="auth-form-group">
                <label for="email_belajar_id" class="auth-form-label">Email Belajar.id <span class="text-danger">*</span></label>
                <input id="email_belajar_id" type="email" class="auth-form-control @error('email_belajar_id') is-invalid @enderror" name="email_belajar_id" value="{{ old('email_belajar_id') }}" required placeholder="namaanda@belajar.id">
                @error('email_belajar_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="auth-form-group">
                <label for="no_wa" class="auth-form-label">Nomor WhatsApp <span class="text-danger">*</span></label>
                <input id="no_wa" type="text" class="auth-form-control @error('no_wa') is-invalid @enderror" name="no_wa" value="{{ old('no_wa') }}" required placeholder="08xxxxxxxxxx">
                @error('no_wa')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="auth-form-group">
                <label for="pendaftar" class="auth-form-label">Nama Pendaftar <span class="text-danger">*</span></label>
                <input id="pendaftar" type="text" class="auth-form-control @error('pendaftar') is-invalid @enderror" name="pendaftar" value="{{ old('pendaftar') }}" required placeholder="Masukkan nama pendaftar">
                @error('pendaftar')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="auth-form-group">
                <label for="jabatan_pendaftar" class="auth-form-label">Jabatan Pendaftar <span class="text-danger">*</span></label>
                <select id="jabatan_pendaftar" class="auth-form-control @error('jabatan_pendaftar') is-invalid @enderror" name="jabatan_pendaftar" required>
                    <option value="">Pilih Jabatan</option>
                    <option value="Wakasek Kurikulum" {{ old('jabatan_pendaftar') == 'Wakasek Kurikulum' ? 'selected' : '' }}>Wakasek Kurikulum</option>
                    <option value="Wakasek Hubin/Humas" {{ old('jabatan_pendaftar') == 'Wakasek Hubin/Humas' ? 'selected' : '' }}>Wakasek Hubin/Humas</option>
                </select>
                @error('jabatan_pendaftar')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="auth-form-group">
                <label for="sk_pendaftar" class="auth-form-label">Upload SK Pendaftar <span class="text-danger">*</span></label>
                <input id="sk_pendaftar" type="file" class="auth-form-control @error('sk_pendaftar') is-invalid @enderror" name="sk_pendaftar" required accept=".pdf,.jpg,.jpeg,.png">
                <small class="text-muted">Format: PDF, JPG, JPEG, PNG (Max: 2MB)</small>
                @error('sk_pendaftar')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit" class="auth-btn-primary">
                Daftar Sekolah
            </button>

            <div class="auth-footer-text">
                Sudah punya akun? <a href="{{ route('login') }}" class="auth-link">Login di sini</a>
            </div>
        </form>
    </div>
        </div>
    </div>
</div>

<script>
// Data kabupaten/kota per provinsi
const kabupatenData = {
    'Aceh': ['Aceh Barat', 'Aceh Barat Daya', 'Aceh Besar', 'Aceh Jaya', 'Aceh Selatan', 'Aceh Singkil', 'Aceh Tamiang', 'Aceh Tengah', 'Aceh Tenggara', 'Aceh Timur', 'Aceh Utara', 'Bener Meriah', 'Bireuen', 'Gayo Lues', 'Nagan Raya', 'Pidie', 'Pidie Jaya', 'Simeulue', 'Kota Banda Aceh', 'Kota Langsa', 'Kota Lhokseumawe', 'Kota Sabang', 'Kota Subulussalam'],
    'Sumatera Utara': ['Asahan', 'Batubara', 'Dairi', 'Deli Serdang', 'Humbang Hasundutan', 'Karo', 'Labuhanbatu', 'Labuhanbatu Selatan', 'Labuhanbatu Utara', 'Langkat', 'Mandailing Natal', 'Nias', 'Nias Barat', 'Nias Selatan', 'Nias Utara', 'Padang Lawas', 'Padang Lawas Utara', 'Pakpak Bharat', 'Samosir', 'Serdang Bedagai', 'Simalungun', 'Tapanuli Selatan', 'Tapanuli Tengah', 'Tapanuli Utara', 'Toba Samosir', 'Kota Binjai', 'Kota Gunungsitoli', 'Kota Medan', 'Kota Padangsidimpuan', 'Kota Pematangsiantar', 'Kota Sibolga', 'Kota Tanjungbalai', 'Kota Tebing Tinggi'],
    'Sumatera Barat': ['Agam', 'Dharmasraya', 'Kepulauan Mentawai', 'Lima Puluh Kota', 'Padang Pariaman', 'Pasaman', 'Pasaman Barat', 'Pesisir Selatan', 'Sijunjung', 'Solok', 'Solok Selatan', 'Tanah Datar', 'Kota Bukittinggi', 'Kota Padang', 'Kota Padangpanjang', 'Kota Pariaman', 'Kota Payakumbuh', 'Kota Sawahlunto', 'Kota Solok'],
    'Riau': ['Bengkalis', 'Indragiri Hilir', 'Indragiri Hulu', 'Kampar', 'Kepulauan Meranti', 'Kuantan Singingi', 'Pelalawan', 'Rokan Hilir', 'Rokan Hulu', 'Siak', 'Kota Dumai', 'Kota Pekanbaru'],
    'Kepulauan Riau': ['Bintan', 'Karimun', 'Kepulauan Anambas', 'Lingga', 'Natuna', 'Kota Batam', 'Kota Tanjung Pinang'],
    'Jambi': ['Batang Hari', 'Bungo', 'Kerinci', 'Merangin', 'Muaro Jambi', 'Sarolangun', 'Tanjung Jabung Barat', 'Tanjung Jabung Timur', 'Tebo', 'Kota Jambi', 'Kota Sungai Penuh'],
    'Sumatera Selatan': ['Banyuasin', 'Empat Lawang', 'Lahat', 'Muara Enim', 'Musi Banyuasin', 'Musi Rawas', 'Musi Rawas Utara', 'Ogan Ilir', 'Ogan Komering Ilir', 'Ogan Komering Ulu', 'Ogan Komering Ulu Selatan', 'Ogan Komering Ulu Timur', 'Penukal Abab Lematang Ilir', 'Kota Lubuklinggau', 'Kota Pagar Alam', 'Kota Palembang', 'Kota Prabumulih'],
    'Kepulauan Bangka Belitung': ['Bangka', 'Bangka Barat', 'Bangka Selatan', 'Bangka Tengah', 'Belitung', 'Belitung Timur', 'Kota Pangkal Pinang'],
    'Bengkulu': ['Bengkulu Selatan', 'Bengkulu Tengah', 'Bengkulu Utara', 'Kaur', 'Kepahiang', 'Lebong', 'Mukomuko', 'Rejang Lebong', 'Seluma', 'Kota Bengkulu'],
    'Lampung': ['Lampung Barat', 'Lampung Selatan', 'Lampung Tengah', 'Lampung Timur', 'Lampung Utara', 'Mesuji', 'Pesawaran', 'Pesisir Barat', 'Pringsewu', 'Tanggamus', 'Tulang Bawang', 'Tulang Bawang Barat', 'Way Kanan', 'Kota Bandar Lampung', 'Kota Metro'],
    'DKI Jakarta': ['Jakarta Barat', 'Jakarta Pusat', 'Jakarta Selatan', 'Jakarta Timur', 'Jakarta Utara', 'Kepulauan Seribu'],
    'Jawa Barat': ['Bandung', 'Bandung Barat', 'Bekasi', 'Bogor', 'Ciamis', 'Cianjur', 'Cirebon', 'Garut', 'Indramayu', 'Karawang', 'Kuningan', 'Majalengka', 'Pangandaran', 'Purwakarta', 'Subang', 'Sukabumi', 'Sumedang', 'Tasikmalaya', 'Kota Bandung', 'Kota Banjar', 'Kota Bekasi', 'Kota Bogor', 'Kota Cimahi', 'Kota Cirebon', 'Kota Depok', 'Kota Sukabumi', 'Kota Tasikmalaya'],
    'Banten': ['Lebak', 'Pandeglang', 'Serang', 'Tangerang', 'Kota Cilegon', 'Kota Serang', 'Kota Tangerang', 'Kota Tangerang Selatan'],
    'Jawa Tengah': ['Banjarnegara', 'Banyumas', 'Batang', 'Blora', 'Boyolali', 'Brebes', 'Cilacap', 'Demak', 'Grobogan', 'Jepara', 'Karanganyar', 'Kebumen', 'Kendal', 'Klaten', 'Kudus', 'Magelang', 'Pati', 'Pekalongan', 'Pemalang', 'Purbalingga', 'Purworejo', 'Rembang', 'Semarang', 'Sragen', 'Sukoharjo', 'Tegal', 'Temanggung', 'Wonogiri', 'Wonosobo', 'Kota Magelang', 'Kota Pekalongan', 'Kota Salatiga', 'Kota Semarang', 'Kota Surakarta', 'Kota Tegal'],
    'DI Yogyakarta': ['Bantul', 'Gunungkidul', 'Kulon Progo', 'Sleman', 'Kota Yogyakarta'],
    'Jawa Timur': ['Bangkalan', 'Banyuwangi', 'Blitar', 'Bojonegoro', 'Bondowoso', 'Gresik', 'Jember', 'Jombang', 'Kediri', 'Lamongan', 'Lumajang', 'Madiun', 'Magetan', 'Malang', 'Mojokerto', 'Nganjuk', 'Ngawi', 'Pacitan', 'Pamekasan', 'Pasuruan', 'Ponorogo', 'Probolinggo', 'Sampang', 'Sidoarjo', 'Situbondo', 'Sumenep', 'Trenggalek', 'Tuban', 'Tulungagung', 'Kota Batu', 'Kota Blitar', 'Kota Kediri', 'Kota Madiun', 'Kota Malang', 'Kota Mojokerto', 'Kota Pasuruan', 'Kota Probolinggo', 'Kota Surabaya'],
    'Bali': ['Badung', 'Bangli', 'Buleleng', 'Gianyar', 'Jembrana', 'Karangasem', 'Klungkung', 'Tabanan', 'Kota Denpasar'],
    'Nusa Tenggara Barat': ['Bima', 'Dompu', 'Lombok Barat', 'Lombok Tengah', 'Lombok Timur', 'Lombok Utara', 'Sumbawa', 'Sumbawa Barat', 'Kota Bima', 'Kota Mataram'],
    'Nusa Tenggara Timur': ['Alor', 'Belu', 'Ende', 'Flores Timur', 'Kupang', 'Lembata', 'Malaka', 'Manggarai', 'Manggarai Barat', 'Manggarai Timur', 'Nagekeo', 'Ngada', 'Rote Ndao', 'Sabu Raijua', 'Sikka', 'Sumba Barat', 'Sumba Barat Daya', 'Sumba Tengah', 'Sumba Timur', 'Timor Tengah Selatan', 'Timor Tengah Utara', 'Kota Kupang'],
    'Kalimantan Barat': ['Bengkayang', 'Kapuas Hulu', 'Kayong Utara', 'Ketapang', 'Kubu Raya', 'Landak', 'Melawi', 'Mempawah', 'Sambas', 'Sanggau', 'Sekadau', 'Sintang', 'Kota Pontianak', 'Kota Singkawang'],
    'Kalimantan Tengah': ['Barito Selatan', 'Barito Timur', 'Barito Utara', 'Gunung Mas', 'Kapuas', 'Katingan', 'Kotawaringin Barat', 'Kotawaringin Timur', 'Lamandau', 'Murung Raya', 'Pulang Pisau', 'Seruyan', 'Sukamara', 'Kota Palangka Raya'],
    'Kalimantan Selatan': ['Balangan', 'Banjar', 'Barito Kuala', 'Hulu Sungai Selatan', 'Hulu Sungai Tengah', 'Hulu Sungai Utara', 'Kotabaru', 'Tabalong', 'Tanah Bumbu', 'Tanah Laut', 'Tapin', 'Kota Banjarbaru', 'Kota Banjarmasin'],
    'Kalimantan Timur': ['Berau', 'Kutai Barat', 'Kutai Kartanegara', 'Kutai Timur', 'Mahakam Ulu', 'Paser', 'Penajam Paser Utara', 'Kota Balikpapan', 'Kota Bontang', 'Kota Samarinda'],
    'Kalimantan Utara': ['Bulungan', 'Malinau', 'Nunukan', 'Tana Tidung', 'Kota Tarakan'],
    'Sulawesi Utara': ['Bolaang Mongondow', 'Bolaang Mongondow Selatan', 'Bolaang Mongondow Timur', 'Bolaang Mongondow Utara', 'Kepulauan Sangihe', 'Kepulauan Siau Tagulandang Biaro', 'Kepulauan Talaud', 'Minahasa', 'Minahasa Selatan', 'Minahasa Tenggara', 'Minahasa Utara', 'Kota Bitung', 'Kota Kotamobagu', 'Kota Manado', 'Kota Tomohon'],
    'Gorontalo': ['Boalemo', 'Bone Bolango', 'Gorontalo', 'Gorontalo Utara', 'Pohuwato', 'Kota Gorontalo'],
    'Sulawesi Tengah': ['Banggai', 'Banggai Kepulauan', 'Banggai Laut', 'Buol', 'Donggala', 'Morowali', 'Morowali Utara', 'Parigi Moutong', 'Poso', 'Sigi', 'Tojo Una-Una', 'Toli-Toli', 'Kota Palu'],
    'Sulawesi Barat': ['Majene', 'Mamasa', 'Mamuju', 'Mamuju Tengah', 'Pasangkayu', 'Polewali Mandar'],
    'Sulawesi Selatan': ['Bantaeng', 'Barru', 'Bone', 'Bulukumba', 'Enrekang', 'Gowa', 'Jeneponto', 'Kepulauan Selayar', 'Luwu', 'Luwu Timur', 'Luwu Utara', 'Maros', 'Pangkajene dan Kepulauan', 'Pinrang', 'Sidenreng Rappang', 'Sinjai', 'Soppeng', 'Takalar', 'Tana Toraja', 'Toraja Utara', 'Wajo', 'Kota Makassar', 'Kota Palopo', 'Kota Parepare'],
    'Sulawesi Tenggara': ['Bombana', 'Buton', 'Buton Selatan', 'Buton Tengah', 'Buton Utara', 'Kolaka', 'Kolaka Timur', 'Kolaka Utara', 'Konawe', 'Konawe Kepulauan', 'Konawe Selatan', 'Konawe Utara', 'Muna', 'Muna Barat', 'Wakatobi', 'Kota Bau-Bau', 'Kota Kendari'],
    'Maluku': ['Buru', 'Buru Selatan', 'Kepulauan Aru', 'Maluku Barat Daya', 'Maluku Tengah', 'Maluku Tenggara', 'Maluku Tenggara Barat', 'Seram Bagian Barat', 'Seram Bagian Timur', 'Kota Ambon', 'Kota Tual'],
    'Maluku Utara': ['Halmahera Barat', 'Halmahera Selatan', 'Halmahera Tengah', 'Halmahera Timur', 'Halmahera Utara', 'Kepulauan Sula', 'Pulau Morotai', 'Pulau Taliabu', 'Kota Ternate', 'Kota Tidore Kepulauan'],
    'Papua': ['Asmat', 'Biak Numfor', 'Boven Digoel', 'Deiyai', 'Dogiyai', 'Intan Jaya', 'Jayapura', 'Jayawijaya', 'Keerom', 'Kepulauan Yapen', 'Lanny Jaya', 'Mamberamo Raya', 'Mamberamo Tengah', 'Mappi', 'Merauke', 'Mimika', 'Nabire', 'Nduga', 'Paniai', 'Pegunungan Bintang', 'Puncak', 'Puncak Jaya', 'Sarmi', 'Supiori', 'Tolikara', 'Waropen', 'Yahukimo', 'Yalimo', 'Kota Jayapura'],
    'Papua Barat': ['Fakfak', 'Kaimana', 'Manokwari', 'Manokwari Selatan', 'Maybrat', 'Pegunungan Arfak', 'Raja Ampat', 'Sorong', 'Sorong Selatan', 'Tambrauw', 'Teluk Bintuni', 'Teluk Wondama', 'Kota Sorong'],
    'Papua Tengah': ['Deiyai', 'Dogiyai', 'Intan Jaya', 'Mimika', 'Nabire', 'Paniai', 'Puncak', 'Puncak Jaya'],
    'Papua Pegunungan': ['Jayawijaya', 'Lanny Jaya', 'Mamberamo Tengah', 'Nduga', 'Pegunungan Bintang', 'Tolikara', 'Yahukimo', 'Yalimo'],
    'Papua Selatan': ['Asmat', 'Boven Digoel', 'Mappi', 'Merauke'],
    'Papua Barat Daya': ['Fakfak', 'Kaimana', 'Maybrat', 'Raja Ampat', 'Sorong', 'Sorong Selatan', 'Tambrauw', 'Teluk Bintuni', 'Teluk Wondama']
};

document.addEventListener('DOMContentLoaded', function() {
    const provinsiSelect = document.getElementById('provinsi');
    const kabupatenSelect = document.getElementById('kabupaten');
    
    provinsiSelect.addEventListener('change', function() {
        const selectedProvinsi = this.value;
        
        // Clear existing options
        kabupatenSelect.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';
        
        if (selectedProvinsi && kabupatenData[selectedProvinsi]) {
            // Enable kabupaten dropdown
            kabupatenSelect.disabled = false;
            
            // Add kabupaten options
            kabupatenData[selectedProvinsi].forEach(function(kabupaten) {
                const option = document.createElement('option');
                option.value = kabupaten;
                option.textContent = kabupaten;
                
                // Restore old value if exists
                if (kabupaten === '{{ old("kabupaten") }}') {
                    option.selected = true;
                }
                
                kabupatenSelect.appendChild(option);
            });
        } else {
            // Disable kabupaten dropdown
            kabupatenSelect.disabled = true;
        }
    });
    
    // Trigger change event if old provinsi exists
    @if(old('provinsi'))
        provinsiSelect.value = '{{ old("provinsi") }}';
        provinsiSelect.dispatchEvent(new Event('change'));
    @endif
});
</script>
@endsection
