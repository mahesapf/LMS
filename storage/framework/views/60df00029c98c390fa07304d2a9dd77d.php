<?php $__env->startSection('title', $activity->name); ?>
<?php $__env->startSection('content'); ?>
<?php
    $statusStyles = [
        'planned' => 'bg-sky-100 text-sky-800 ring-sky-200',
        'ongoing' => 'bg-emerald-100 text-emerald-800 ring-emerald-200',
        'completed' => 'bg-slate-100 text-slate-700 ring-slate-200',
        'cancelled' => 'bg-rose-100 text-rose-800 ring-rose-200',
    ];

    $statusLabels = [
        'planned' => 'Direncanakan',
        'ongoing' => 'Berlangsung',
        'completed' => 'Selesai',
        'cancelled' => 'Dibatalkan',
    ];

    $statusKey = $activity->status ?? 'planned';
    $badgeClass = $statusStyles[$statusKey] ?? 'bg-slate-100 text-slate-700 ring-slate-200';
    $badgeLabel = $statusLabels[$statusKey] ?? ucfirst($statusKey);
?>

<div class="bg-slate-50" x-data="{ showRegistrationModal: <?php echo e((old('nama_sekolah') || old('email')) ? 'true' : 'false'); ?> }">
    <div class="max-w-6xl mx-auto px-4 py-10">
        <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
            <a href="<?php echo e(route('activities.index')); ?>" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-700 hover:text-slate-900">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke daftar kegiatan
            </a>

            <div class="flex items-center gap-2 text-xs text-slate-500">
                <?php if($activity->program): ?>
                    <span class="inline-flex items-center gap-1 rounded-full bg-blue-50 px-3 py-1 font-semibold text-blue-700 ring-1 ring-blue-100"><?php echo e($activity->program->name); ?></span>
                <?php endif; ?>
                <?php if($activity->batch): ?>
                    <span class="inline-flex items-center gap-1 rounded-full bg-indigo-50 px-3 py-1 font-semibold text-indigo-700 ring-1 ring-indigo-100">Batch <?php echo e($activity->batch); ?></span>
                <?php endif; ?>
            </div>
        </div>

        <?php if(session('success')): ?>
            <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="mb-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <div class="grid gap-6 lg:grid-cols-[2fr,1fr]">
            <div class="space-y-6">
                <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
                    <div class="p-6">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                            <div class="space-y-2">
                                <p class="text-xs uppercase tracking-wide text-slate-500">Kegiatan</p>
                                <h1 class="text-2xl font-semibold text-slate-900"><?php echo e($activity->name); ?></h1>
                                <div class="flex flex-wrap gap-2 text-sm text-slate-600">
                                    <span class="inline-flex items-center gap-2 rounded-full <?php echo e($badgeClass); ?> px-3 py-1 font-semibold ring-1">
                                        <span class="h-2 w-2 rounded-full bg-current opacity-70"></span>
                                        <?php echo e($badgeLabel); ?>

                                    </span>
                                    <span class="inline-flex items-center gap-2 rounded-full bg-amber-50 px-3 py-1 font-semibold text-amber-800 ring-1 ring-amber-100">
                                        Mulai <?php echo e($activity->start_date->format('d F Y')); ?>

                                    </span>
                                </div>
                            </div>
                            <div class="rounded-xl bg-gradient-to-br from-sky-50 to-white px-4 py-3 text-sm text-sky-900 ring-1 ring-sky-100 shadow-inner">
                                <p class="text-xs font-semibold uppercase tracking-wide text-sky-600">Biaya pendaftaran</p>
                                <?php if($activity->registration_fee > 0): ?>
                                    <p class="text-xl font-bold mt-1">Rp <?php echo e(number_format($activity->registration_fee, 0, ',', '.')); ?> <span class="text-sm font-semibold text-slate-500">/peserta</span></p>
                                <?php else: ?>
                                    <p class="text-xl font-bold mt-1 text-emerald-600">Gratis</p>
                                <?php endif; ?>
                                <p class="text-xs text-slate-500 mt-1">Pendaftaran dilakukan per sekolah.</p>
                            </div>
                        </div>

                        <?php if($activity->description): ?>
                            <div class="mt-6 border-t border-slate-100 pt-6">
                                <h2 class="text-lg font-semibold text-slate-900">Deskripsi</h2>
                                <p class="mt-2 text-slate-700 leading-relaxed"><?php echo e($activity->description); ?></p>
                            </div>
                        <?php endif; ?>

                        <div class="mt-6 grid gap-4 sm:grid-cols-2">
                            <div class="rounded-xl border border-slate-100 bg-slate-50 p-4">
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Informasi Kegiatan</p>
                                <dl class="mt-3 space-y-2 text-sm text-slate-700">
                                    <div class="flex justify-between">
                                        <dt class="text-slate-500">Tanggal Mulai</dt>
                                        <dd class="font-semibold"><?php echo e($activity->start_date->format('d F Y')); ?></dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-slate-500">Tanggal Selesai</dt>
                                        <dd class="font-semibold"><?php echo e($activity->end_date->format('d F Y')); ?></dd>
                                    </div>
                                    <?php if($activity->batch): ?>
                                        <div class="flex justify-between">
                                            <dt class="text-slate-500">Batch</dt>
                                            <dd class="font-semibold"><?php echo e($activity->batch); ?></dd>
                                        </div>
                                    <?php endif; ?>
                                </dl>
                            </div>

                            <div class="rounded-xl border border-slate-100 bg-slate-50 p-4">
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Informasi Pembiayaan</p>
                                <dl class="mt-3 space-y-2 text-sm text-slate-700">
                                    <?php if($activity->financing_type): ?>
                                        <div class="flex justify-between">
                                            <dt class="text-slate-500">Jenis Pembiayaan</dt>
                                            <dd class="font-semibold"><?php echo e($activity->financing_type); ?></dd>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($activity->apbn_type): ?>
                                        <div class="flex justify-between">
                                            <dt class="text-slate-500">Tipe APBN</dt>
                                            <dd class="font-semibold"><?php echo e($activity->apbn_type); ?></dd>
                                        </div>
                                    <?php endif; ?>
                                    <div class="flex justify-between">
                                        <dt class="text-slate-500">Biaya Pendaftaran</dt>
                                        <dd class="font-semibold">
                                            <?php if($activity->registration_fee > 0): ?>
                                                Rp <?php echo e(number_format($activity->registration_fee, 0, ',', '.')); ?> / peserta
                                            <?php else: ?>
                                                Gratis
                                            <?php endif; ?>
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-amber-100 bg-amber-50 px-5 py-4 text-sm text-amber-900 ring-1 ring-amber-100">
                    <div class="flex items-start gap-3">
                        <svg class="h-5 w-5 mt-0.5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <p class="font-semibold">Pendaftaran per sekolah</p>
                            <p class="mt-1 text-slate-700">Satu sekolah dapat mendaftarkan beberapa peserta (kepala sekolah dan guru) dalam satu kali pendaftaran. Biaya dihitung berdasarkan total peserta.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
                    <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Pendaftaran</p>
                            <h3 class="text-lg font-semibold text-slate-900">Per Sekolah</h3>
                        </div>
                        <svg class="h-10 w-10 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0-1.105.895-2 2-2h4m-2-2v4M7 15h3m-3 4h3m-3-8h3m4 4h3m-3 4h3m-3-8h3M5 5h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z" />
                        </svg>
                    </div>

                    <div class="px-5 py-4 text-sm text-slate-700">
                        <?php if($existingRegistration): ?>
                            <div class="mb-3 rounded-xl bg-sky-50 px-4 py-3 text-sky-900 ring-1 ring-sky-100">
                                Sekolah Anda sudah terdaftar pada kegiatan ini.
                            </div>

                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Status Pendaftaran</p>
                            <div class="mt-2 space-y-3">
                                <?php if($existingRegistration->status == 'payment_pending'): ?>
                                    <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800 ring-1 ring-amber-200">Menunggu Pembayaran</span>
                                    <p>Silakan upload bukti pembayaran untuk melanjutkan.</p>
                                    <a href="<?php echo e(route('payment.create', $existingRegistration)); ?>" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-sky-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-500">
                                        Upload Pembayaran
                                    </a>
                                <?php elseif($existingRegistration->status == 'payment_uploaded'): ?>
                                    <span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-800 ring-1 ring-blue-200">Menunggu Validasi</span>
                                    <p>Bukti pembayaran Anda sedang divalidasi oleh admin.</p>
                                <?php elseif($existingRegistration->status == 'validated'): ?>
                                    <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-800 ring-1 ring-emerald-200">Tervalidasi</span>
                                    <p>Pendaftaran Anda telah divalidasi. Anda adalah peserta kegiatan ini.</p>
                                <?php elseif($existingRegistration->status == 'rejected'): ?>
                                    <span class="inline-flex rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-800 ring-1 ring-rose-200">Ditolak</span>
                                    <p>Pembayaran Anda ditolak. Silakan hubungi admin untuk informasi lebih lanjut.</p>
                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <div class="rounded-xl bg-slate-50 px-4 py-3 text-slate-700 ring-1 ring-slate-100">
                                <p class="font-semibold text-slate-900">Pendaftaran per sekolah</p>
                                <p class="mt-1 text-sm">Satu sekolah dapat mendaftarkan beberapa peserta dalam satu pengajuan. Total biaya mengikuti jumlah peserta.</p>
                            </div>

                            <button type="button" @click="showRegistrationModal = true" class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-lg bg-sky-600 px-4 py-3 text-sm font-semibold text-white shadow-sm hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-500">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m6-6H6" />
                                </svg>
                                Daftarkan Sekolah
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Form Pendaftaran -->
    <div x-show="showRegistrationModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-end justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showRegistrationModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity"
                 @click="showRegistrationModal = false"></div>

            <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>

            <div x-show="showRegistrationModal"
                 @click.stop
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block transform overflow-hidden rounded-xl bg-white text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-3xl sm:align-middle">

                <form method="POST" action="<?php echo e(route('activities.register', $activity)); ?>" id="registrationForm">
                    <?php echo csrf_field(); ?>
                    <div class="bg-white px-6 pt-5 pb-4">
                        <div class="flex items-start justify-between border-b border-slate-200 pb-3">
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900" id="modal-title">Form Pendaftaran Kegiatan</h3>
                                <p class="mt-1 text-sm text-slate-600"><?php echo e($activity->name); ?></p>
                            </div>
                            <button type="button" @click.stop="showRegistrationModal = false" class="rounded-md text-slate-400 hover:text-slate-500 focus:outline-none">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div class="mt-5">
                            <div class="mb-5 rounded-lg border border-blue-200 bg-blue-50 p-4">
                                <div class="flex items-start gap-3">
                                    <svg class="h-5 w-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <div class="text-sm text-blue-800">
                                        <strong>Petunjuk Pengisian:</strong>
                                        <p class="mt-1">Isi data sekolah dan jumlah peserta yang akan mengikuti kegiatan ini. Pastikan semua data terisi dengan benar.</p>
                                    </div>
                                </div>
                            </div>

                            <h6 class="mb-3 border-b border-slate-200 pb-2 text-sm font-semibold text-slate-900">📋 Informasi Sekolah</h6>
                            <div class="mb-4 grid gap-4 sm:grid-cols-2">
                                <div class="sm:col-span-2">
                                    <label class="block text-sm font-medium text-slate-700">Nama Sekolah <span class="text-red-600">*</span></label>
                                    <input type="text"
                                           class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-sky-500 <?php $__errorArgs = ['nama_sekolah'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           name="nama_sekolah"
                                           value="<?php echo e(old('nama_sekolah')); ?>"
                                           required
                                           placeholder="Contoh: SMA Negeri 1 Jakarta">
                                    <?php $__errorArgs = ['nama_sekolah'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="block text-sm font-medium text-slate-700">Alamat Sekolah <span class="text-red-600">*</span></label>
                                    <textarea class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-sky-500 <?php $__errorArgs = ['alamat_sekolah'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                              name="alamat_sekolah"
                                              rows="2"
                                              required
                                              placeholder="Masukkan alamat lengkap sekolah"><?php echo e(old('alamat_sekolah')); ?></textarea>
                                    <?php $__errorArgs = ['alamat_sekolah'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Provinsi <span class="text-red-600">*</span></label>
                                    <select class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-sky-500 <?php $__errorArgs = ['provinsi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="provinsi_show"
                                           name="provinsi"
                                           required
                                           onchange="updateCities(this, document.getElementById('kab_kota_show'), document.getElementById('kecamatan_show'))">
                                        <option value="">Pilih Provinsi</option>
                                        <option value="Jawa Barat" <?php echo e(old('provinsi') == 'Jawa Barat' ? 'selected' : ''); ?>>Jawa Barat</option>
                                        <option value="Bengkulu" <?php echo e(old('provinsi') == 'Bengkulu' ? 'selected' : ''); ?>>Bengkulu</option>
                                        <option value="Lampung" <?php echo e(old('provinsi') == 'Lampung' ? 'selected' : ''); ?>>Lampung</option>
                                    </select>
                                    <?php $__errorArgs = ['provinsi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Kabupaten/Kota <span class="text-red-600">*</span></label>
                                    <select class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-sky-500 <?php $__errorArgs = ['kab_kota'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="kab_kota_show"
                                           name="kab_kota"
                                           required
                                           onchange="updateDistricts(document.getElementById('provinsi_show'), this, document.getElementById('kecamatan_show'))">
                                        <option value="">Pilih Kabupaten/Kota</option>
                                    </select>
                                    <?php $__errorArgs = ['kab_kota'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Kecamatan <span class="text-red-600">*</span></label>
                                    <select class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-sky-500 <?php $__errorArgs = ['kecamatan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="kecamatan_show"
                                           name="kecamatan"
                                           required>
                                        <option value="">Pilih Kecamatan</option>
                                    </select>
                                    <?php $__errorArgs = ['kecamatan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="block text-sm font-medium text-slate-700">KCD (Kantor Cabang Dinas) <span class="text-red-600">*</span></label>
                                    <input type="text"
                                           class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-sky-500 <?php $__errorArgs = ['kcd'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           name="kcd"
                                           value="<?php echo e(old('kcd')); ?>"
                                           required
                                           placeholder="Contoh: KCD Jakarta Selatan">
                                    <?php $__errorArgs = ['kcd'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <h6 class="mt-6 mb-3 border-b border-slate-200 pb-2 text-sm font-semibold text-slate-900">📞 Informasi Kontak</h6>
                            <div class="mb-4 grid gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Nama Kepala Sekolah <span class="text-red-600">*</span></label>
                                    <input type="text"
                                           class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-sky-500 <?php $__errorArgs = ['nama_kepala_sekolah'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           name="nama_kepala_sekolah"
                                           value="<?php echo e(old('nama_kepala_sekolah')); ?>"
                                           required
                                           placeholder="Masukkan nama lengkap kepala sekolah">
                                    <?php $__errorArgs = ['nama_kepala_sekolah'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700">NIK Kepala Sekolah <span class="text-red-600">*</span></label>
                                    <input type="text"
                                           class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-sky-500 <?php $__errorArgs = ['nik_kepala_sekolah'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           name="nik_kepala_sekolah"
                                           value="<?php echo e(old('nik_kepala_sekolah')); ?>"
                                           required
                                           maxlength="16"
                                           pattern="[0-9]{16}"
                                           placeholder="Masukkan NIK 16 digit">
                                    <?php $__errorArgs = ['nik_kepala_sekolah'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <p class="mt-1 text-xs text-slate-500">Nomor Induk Kependudukan 16 digit</p>
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="block text-sm font-medium text-slate-700">Email (Opsional)</label>
                                    <input type="email"
                                           class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-sky-500 <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           name="email"
                                           value="<?php echo e(old('email')); ?>"
                                           placeholder="email@sekolah.com">
                                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <p class="mt-1 text-xs text-slate-500">Email untuk konfirmasi (jika ada)</p>
                                </div>
                            </div>

                            <h6 class="mt-6 mb-3 border-b border-slate-200 pb-2 text-sm font-semibold text-slate-900">👥 Jumlah Peserta</h6>

                            <?php if($activity->registration_fee > 0): ?>
                                <div class="mb-4 rounded-lg border border-amber-200 bg-amber-50 p-4">
                                    <div class="flex items-start gap-3">
                                        <svg class="mt-0.5 h-5 w-5 flex-shrink-0 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <div class="text-sm text-amber-800">
                                            <strong class="font-semibold">Biaya Kegiatan:</strong>
                                            <p class="mt-1">Rp <?php echo e(number_format($activity->registration_fee, 0, ',', '.')); ?> per peserta. Total biaya dihitung dari jumlah peserta yang didaftarkan.</p>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="mb-4 grid gap-4 sm:grid-cols-3">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Jumlah Peserta <span class="text-red-600">*</span></label>
                                    <input type="number"
                                           class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-sky-500 <?php $__errorArgs = ['jumlah_peserta'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           name="jumlah_peserta"
                                           id="jumlah_peserta"
                                           value="<?php echo e(old('jumlah_peserta', 0)); ?>"
                                           min="0"
                                           required
                                           placeholder="0"
                                           onchange="calculateTotal()">
                                    <?php $__errorArgs = ['jumlah_peserta'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <p class="mt-1 text-xs text-slate-500">Total semua peserta</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Kepala Sekolah <span class="text-red-600">*</span></label>
                                    <input type="number"
                                           class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-sky-500 <?php $__errorArgs = ['jumlah_kepala_sekolah'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           name="jumlah_kepala_sekolah"
                                           id="jumlah_kepala_sekolah"
                                           value="<?php echo e(old('jumlah_kepala_sekolah', 0)); ?>"
                                           min="0"
                                           required
                                           placeholder="0"
                                           onchange="calculateTotal()">
                                    <?php $__errorArgs = ['jumlah_kepala_sekolah'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <p class="mt-1 text-xs text-slate-500">Berapa orang</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Guru <span class="text-red-600">*</span></label>
                                    <input type="number"
                                           class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-sky-500 focus:ring-sky-500 <?php $__errorArgs = ['jumlah_guru'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           name="jumlah_guru"
                                           id="jumlah_guru"
                                           value="<?php echo e(old('jumlah_guru', 0)); ?>"
                                           min="0"
                                           required
                                           placeholder="0"
                                           onchange="calculateTotal()">
                                    <?php $__errorArgs = ['jumlah_guru'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <p class="mt-1 text-xs text-slate-500">Berapa orang</p>
                                </div>
                            </div>

                            <?php if($activity->registration_fee > 0): ?>
                                <div class="mb-4 rounded-lg border-2 border-sky-300 bg-gradient-to-br from-sky-50 to-blue-50 p-5 shadow-sm">
                                    <div class="mb-2 flex items-center gap-2">
                                        <svg class="h-5 w-5 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                        <h6 class="text-sm font-semibold text-sky-900">Estimasi Biaya Total:</h6>
                                    </div>
                                    <h3 class="mb-2 text-2xl font-bold text-sky-700" id="total-biaya">Rp 0</h3>
                                    <p class="text-xs text-sky-800">Total biaya = Jumlah peserta × Rp <?php echo e(number_format($activity->registration_fee, 0, ',', '.')); ?></p>
                                </div>
                            <?php endif; ?>

                            <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                                <div class="flex items-start gap-3">
                                    <svg class="mt-0.5 h-5 w-5 flex-shrink-0 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    <div class="text-sm text-slate-700">
                                        <strong class="font-semibold">ℹ️ Pendaftaran Per Sekolah</strong>
                                        <p class="mt-1">Anda dapat mendaftarkan beberapa peserta (kepala sekolah dan guru) dari sekolah Anda dalam satu pendaftaran. Pembayaran akan dihitung berdasarkan total peserta yang didaftarkan.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 border-t border-slate-200 bg-slate-50 px-6 py-4">
                        <button type="button" @click.stop="showRegistrationModal = false" class="inline-flex items-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition-colors hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-slate-500">
                            <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Batal
                        </button>
                        <button type="submit" class="inline-flex items-center rounded-lg bg-sky-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            Daftar Sekarang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Modal Form Pendaftaran -->

</div>

<script>
window.calculateTotal = function() {
    const biayaPerPeserta = <?php echo e($activity->registration_fee); ?>;
    const jumlahPeserta = parseInt(document.getElementById('jumlah_peserta')?.value) || 0;
    const jumlahKepalaSekolah = parseInt(document.getElementById('jumlah_kepala_sekolah')?.value) || 0;
    const jumlahGuru = parseInt(document.getElementById('jumlah_guru')?.value) || 0;

    const totalPeserta = jumlahPeserta > 0 ? jumlahPeserta : (jumlahKepalaSekolah + jumlahGuru);
    const totalBiaya = totalPeserta * biayaPerPeserta;

    const totalBiayaElement = document.getElementById('total-biaya');
    if (totalBiayaElement) {
        totalBiayaElement.textContent = 'Rp ' + totalBiaya.toLocaleString('id-ID');
    }
};

document.addEventListener('DOMContentLoaded', function() {
    calculateTotal();

    // Initialize location dropdowns
    const provinceSelect = document.getElementById('provinsi_show');
    const citySelect = document.getElementById('kab_kota_show');
    const districtSelect = document.getElementById('kecamatan_show');

    if (provinceSelect && citySelect && districtSelect) {
        const savedProvince = "<?php echo e(old('provinsi')); ?>";
        const savedCity = "<?php echo e(old('kab_kota')); ?>";
        const savedDistrict = "<?php echo e(old('kecamatan')); ?>";

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
    }
});
</script>

<script src="<?php echo e(asset('js/indonesia-location.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\LMS\resources\views/activities/show.blade.php ENDPATH**/ ?>