

<?php
    $hideNavbar = true;
?>

<?php $__env->startSection('content'); ?>
<div class="auth-wrapper">
    <div class="auth-left"></div>
    <div class="auth-right">
        <div class="auth-card">
            <div class="auth-card-header">
                <img src="<?php echo e(asset('storage/tut-wuri-handayani-kemdikdasmen-masafidhan.svg')); ?>" alt="Tut Wuri Handayani" class="auth-logo">
                <h4>Registrasi Sekolah</h4>
                <p>Sistem Informasi Penjaminan Mutu</p>
            </div>

    <div class="auth-card-body">
        <form method="POST" action="<?php echo e(route('sekolah.register.submit')); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>

            <div class="auth-form-group">
                <label for="nama_sekolah" class="auth-form-label">Nama Sekolah <span class="text-danger">*</span></label>
                <input id="nama_sekolah" type="text" class="auth-form-control <?php $__errorArgs = ['nama_sekolah'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="nama_sekolah" value="<?php echo e(old('nama_sekolah')); ?>" required autofocus placeholder="Masukkan nama sekolah">
                <?php $__errorArgs = ['nama_sekolah'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="invalid-feedback" role="alert">
                        <strong><?php echo e($message); ?></strong>
                    </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="auth-form-group">
                <label for="npsn" class="auth-form-label">NPSN <span class="text-danger">*</span></label>
                <input id="npsn" type="text" class="auth-form-control <?php $__errorArgs = ['npsn'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="npsn" value="<?php echo e(old('npsn')); ?>" required placeholder="Nomor Pokok Sekolah Nasional">
                <?php $__errorArgs = ['npsn'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="invalid-feedback" role="alert">
                        <strong><?php echo e($message); ?></strong>
                    </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="auth-form-group">
                <label for="provinsi" class="auth-form-label">Provinsi <span class="text-danger">*</span></label>
                <select id="provinsi" class="auth-form-control <?php $__errorArgs = ['provinsi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="provinsi" required>
                    <option value="">Pilih Provinsi</option>
                    <option value="Aceh" <?php echo e(old('provinsi') == 'Aceh' ? 'selected' : ''); ?>>Aceh</option>
                    <option value="Sumatera Utara" <?php echo e(old('provinsi') == 'Sumatera Utara' ? 'selected' : ''); ?>>Sumatera Utara</option>
                    <option value="Sumatera Barat" <?php echo e(old('provinsi') == 'Sumatera Barat' ? 'selected' : ''); ?>>Sumatera Barat</option>
                    <option value="Riau" <?php echo e(old('provinsi') == 'Riau' ? 'selected' : ''); ?>>Riau</option>
                    <option value="Kepulauan Riau" <?php echo e(old('provinsi') == 'Kepulauan Riau' ? 'selected' : ''); ?>>Kepulauan Riau</option>
                    <option value="Jambi" <?php echo e(old('provinsi') == 'Jambi' ? 'selected' : ''); ?>>Jambi</option>
                    <option value="Sumatera Selatan" <?php echo e(old('provinsi') == 'Sumatera Selatan' ? 'selected' : ''); ?>>Sumatera Selatan</option>
                    <option value="Kepulauan Bangka Belitung" <?php echo e(old('provinsi') == 'Kepulauan Bangka Belitung' ? 'selected' : ''); ?>>Kepulauan Bangka Belitung</option>
                    <option value="Bengkulu" <?php echo e(old('provinsi') == 'Bengkulu' ? 'selected' : ''); ?>>Bengkulu</option>
                    <option value="Lampung" <?php echo e(old('provinsi') == 'Lampung' ? 'selected' : ''); ?>>Lampung</option>
                    <option value="DKI Jakarta" <?php echo e(old('provinsi') == 'DKI Jakarta' ? 'selected' : ''); ?>>DKI Jakarta</option>
                    <option value="Jawa Barat" <?php echo e(old('provinsi') == 'Jawa Barat' ? 'selected' : ''); ?>>Jawa Barat</option>
                    <option value="Banten" <?php echo e(old('provinsi') == 'Banten' ? 'selected' : ''); ?>>Banten</option>
                    <option value="Jawa Tengah" <?php echo e(old('provinsi') == 'Jawa Tengah' ? 'selected' : ''); ?>>Jawa Tengah</option>
                    <option value="DI Yogyakarta" <?php echo e(old('provinsi') == 'DI Yogyakarta' ? 'selected' : ''); ?>>DI Yogyakarta</option>
                    <option value="Jawa Timur" <?php echo e(old('provinsi') == 'Jawa Timur' ? 'selected' : ''); ?>>Jawa Timur</option>
                    <option value="Bali" <?php echo e(old('provinsi') == 'Bali' ? 'selected' : ''); ?>>Bali</option>
                    <option value="Nusa Tenggara Barat" <?php echo e(old('provinsi') == 'Nusa Tenggara Barat' ? 'selected' : ''); ?>>Nusa Tenggara Barat</option>
                    <option value="Nusa Tenggara Timur" <?php echo e(old('provinsi') == 'Nusa Tenggara Timur' ? 'selected' : ''); ?>>Nusa Tenggara Timur</option>
                    <option value="Kalimantan Barat" <?php echo e(old('provinsi') == 'Kalimantan Barat' ? 'selected' : ''); ?>>Kalimantan Barat</option>
                    <option value="Kalimantan Tengah" <?php echo e(old('provinsi') == 'Kalimantan Tengah' ? 'selected' : ''); ?>>Kalimantan Tengah</option>
                    <option value="Kalimantan Selatan" <?php echo e(old('provinsi') == 'Kalimantan Selatan' ? 'selected' : ''); ?>>Kalimantan Selatan</option>
                    <option value="Kalimantan Timur" <?php echo e(old('provinsi') == 'Kalimantan Timur' ? 'selected' : ''); ?>>Kalimantan Timur</option>
                    <option value="Kalimantan Utara" <?php echo e(old('provinsi') == 'Kalimantan Utara' ? 'selected' : ''); ?>>Kalimantan Utara</option>
                    <option value="Sulawesi Utara" <?php echo e(old('provinsi') == 'Sulawesi Utara' ? 'selected' : ''); ?>>Sulawesi Utara</option>
                    <option value="Gorontalo" <?php echo e(old('provinsi') == 'Gorontalo' ? 'selected' : ''); ?>>Gorontalo</option>
                    <option value="Sulawesi Tengah" <?php echo e(old('provinsi') == 'Sulawesi Tengah' ? 'selected' : ''); ?>>Sulawesi Tengah</option>
                    <option value="Sulawesi Barat" <?php echo e(old('provinsi') == 'Sulawesi Barat' ? 'selected' : ''); ?>>Sulawesi Barat</option>
                    <option value="Sulawesi Selatan" <?php echo e(old('provinsi') == 'Sulawesi Selatan' ? 'selected' : ''); ?>>Sulawesi Selatan</option>
                    <option value="Sulawesi Tenggara" <?php echo e(old('provinsi') == 'Sulawesi Tenggara' ? 'selected' : ''); ?>>Sulawesi Tenggara</option>
                    <option value="Maluku" <?php echo e(old('provinsi') == 'Maluku' ? 'selected' : ''); ?>>Maluku</option>
                    <option value="Maluku Utara" <?php echo e(old('provinsi') == 'Maluku Utara' ? 'selected' : ''); ?>>Maluku Utara</option>
                    <option value="Papua" <?php echo e(old('provinsi') == 'Papua' ? 'selected' : ''); ?>>Papua</option>
                    <option value="Papua Barat" <?php echo e(old('provinsi') == 'Papua Barat' ? 'selected' : ''); ?>>Papua Barat</option>
                    <option value="Papua Tengah" <?php echo e(old('provinsi') == 'Papua Tengah' ? 'selected' : ''); ?>>Papua Tengah</option>
                    <option value="Papua Pegunungan" <?php echo e(old('provinsi') == 'Papua Pegunungan' ? 'selected' : ''); ?>>Papua Pegunungan</option>
                    <option value="Papua Selatan" <?php echo e(old('provinsi') == 'Papua Selatan' ? 'selected' : ''); ?>>Papua Selatan</option>
                    <option value="Papua Barat Daya" <?php echo e(old('provinsi') == 'Papua Barat Daya' ? 'selected' : ''); ?>>Papua Barat Daya</option>
                </select>
                <?php $__errorArgs = ['provinsi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="invalid-feedback" role="alert">
                        <strong><?php echo e($message); ?></strong>
                    </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="auth-form-group">
                <label for="kabupaten" class="auth-form-label">Kabupaten/Kota <span class="text-danger">*</span></label>
                <select id="kabupaten" class="auth-form-control <?php $__errorArgs = ['kabupaten'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="kabupaten" required disabled>
                    <option value="">Pilih Provinsi Terlebih Dahulu</option>
                </select>
                <?php $__errorArgs = ['kabupaten'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="invalid-feedback" role="alert">
                        <strong><?php echo e($message); ?></strong>
                    </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="auth-form-group">
                <label for="nama_kepala_sekolah" class="auth-form-label">Nama Kepala Sekolah <span class="text-danger">*</span></label>
                <input id="nama_kepala_sekolah" type="text" class="auth-form-control <?php $__errorArgs = ['nama_kepala_sekolah'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="nama_kepala_sekolah" value="<?php echo e(old('nama_kepala_sekolah')); ?>" required placeholder="Masukkan nama kepala sekolah">
                <?php $__errorArgs = ['nama_kepala_sekolah'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="invalid-feedback" role="alert">
                        <strong><?php echo e($message); ?></strong>
                    </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="auth-form-group">
                <label for="email_belajar_id" class="auth-form-label">Email Belajar.id <span class="text-danger">*</span></label>
                <input id="email_belajar_id" type="email" class="auth-form-control <?php $__errorArgs = ['email_belajar_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email_belajar_id" value="<?php echo e(old('email_belajar_id')); ?>" required placeholder="namaanda@belajar.id">
                <?php $__errorArgs = ['email_belajar_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="invalid-feedback" role="alert">
                        <strong><?php echo e($message); ?></strong>
                    </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="auth-form-group">
                <label for="no_wa" class="auth-form-label">Nomor WhatsApp <span class="text-danger">*</span></label>
                <input id="no_wa" type="text" class="auth-form-control <?php $__errorArgs = ['no_wa'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="no_wa" value="<?php echo e(old('no_wa')); ?>" required placeholder="08xxxxxxxxxx">
                <?php $__errorArgs = ['no_wa'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="invalid-feedback" role="alert">
                        <strong><?php echo e($message); ?></strong>
                    </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="auth-form-group">
                <label for="pendaftar" class="auth-form-label">Nama Pendaftar <span class="text-danger">*</span></label>
                <input id="pendaftar" type="text" class="auth-form-control <?php $__errorArgs = ['pendaftar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="pendaftar" value="<?php echo e(old('pendaftar')); ?>" required placeholder="Masukkan nama pendaftar">
                <?php $__errorArgs = ['pendaftar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="invalid-feedback" role="alert">
                        <strong><?php echo e($message); ?></strong>
                    </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="auth-form-group">
                <label for="jabatan_pendaftar" class="auth-form-label">Jabatan Pendaftar <span class="text-danger">*</span></label>
                <select id="jabatan_pendaftar" class="auth-form-control <?php $__errorArgs = ['jabatan_pendaftar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="jabatan_pendaftar" required>
                    <option value="">Pilih Jabatan</option>
                    <option value="Wakasek Kurikulum" <?php echo e(old('jabatan_pendaftar') == 'Wakasek Kurikulum' ? 'selected' : ''); ?>>Wakasek Kurikulum</option>
                    <option value="Wakasek Hubin/Humas" <?php echo e(old('jabatan_pendaftar') == 'Wakasek Hubin/Humas' ? 'selected' : ''); ?>>Wakasek Hubin/Humas</option>
                </select>
                <?php $__errorArgs = ['jabatan_pendaftar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="invalid-feedback" role="alert">
                        <strong><?php echo e($message); ?></strong>
                    </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="auth-form-group">
                <label for="sk_pendaftar" class="auth-form-label">Upload SK Pendaftar <span class="text-danger">*</span></label>
                <input id="sk_pendaftar" type="file" class="auth-form-control <?php $__errorArgs = ['sk_pendaftar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="sk_pendaftar" required accept=".pdf,.jpg,.jpeg,.png">
                <small class="text-muted">Format: PDF, JPG, JPEG, PNG (Max: 2MB)</small>
                <?php $__errorArgs = ['sk_pendaftar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="invalid-feedback" role="alert">
                        <strong><?php echo e($message); ?></strong>
                    </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <button type="submit" class="auth-btn-primary">
                Daftar Sekolah
            </button>

            <div class="auth-footer-text">
                Sudah punya akun? <a href="<?php echo e(route('login')); ?>" class="auth-link">Login di sini</a>
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
                if (kabupaten === '<?php echo e(old("kabupaten")); ?>') {
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
    <?php if(old('provinsi')): ?>
        provinsiSelect.value = '<?php echo e(old("provinsi")); ?>';
        provinsiSelect.dispatchEvent(new Event('change'));
    <?php endif; ?>
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\LMS\resources\views/auth/register-sekolah.blade.php ENDPATH**/ ?>