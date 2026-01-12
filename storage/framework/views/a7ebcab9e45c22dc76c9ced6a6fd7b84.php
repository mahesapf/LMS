

<?php $__env->startSection('title', 'Upload Bukti Pembayaran'); ?>

<?php $__env->startPush('styles'); ?>
<style>
[x-cloak] { display: none !important; }
.teacher-card {
    transition: all 0.3s ease;
}
.teacher-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4" x-data="paymentForm()">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="mb-4">
                <a href="<?php echo e(route('activities.index')); ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="card shadow-sm">
                <div class="card-header bg-gradient-to-r from-sky-600 to-blue-600 text-white py-3">
                    <h4 class="mb-0"><i class="bi bi-credit-card me-2"></i>Upload Bukti Pembayaran</h4>
                </div>
                <div class="card-body p-4"
                    <!-- Activity Info -->
                    <div class="rounded-lg border border-blue-200 bg-blue-50 p-4 mb-4">
                        <h5 class="text-blue-900 mb-3"><i class="bi bi-info-circle me-2"></i>Informasi Kegiatan</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-2"><strong class="text-blue-900">Kegiatan:</strong><br>
                                    <span class="text-blue-800"><?php echo e($registration->activity->name); ?></span>
                                </p>
                                <p class="mb-0"><strong class="text-blue-900">Program:</strong><br>
                                    <span class="text-blue-800"><?php echo e($registration->activity->program->name ?? '-'); ?></span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-0"><strong class="text-blue-900">Biaya per Peserta:</strong><br>
                                    <span class="text-blue-800 fs-5 fw-bold">
                                        <?php if($registration->activity->registration_fee > 0): ?>
                                            Rp <?php echo e(number_format($registration->activity->registration_fee, 0, ',', '.')); ?>

                                        <?php else: ?>
                                            Gratis
                                        <?php endif; ?>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- School Payment Calculation -->
                    <?php
                        $totalPeserta = $registration->jumlah_peserta > 0 
                            ? $registration->jumlah_peserta 
                            : ($registration->jumlah_kepala_sekolah + $registration->jumlah_guru);
                        $totalBiaya = $registration->calculateTotalPayment();
                    ?>
                    <div class="card mb-4 border-2 border-sky-300 shadow-sm">
                        <div class="card-header bg-gradient-to-r from-sky-600 to-blue-600 text-white">
                            <h5 class="mb-0"><i class="bi bi-calculator me-2"></i>Rincian Pembayaran Sekolah</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm mb-3">
                                <tr>
                                    <td class="text-slate-700">Biaya per Peserta</td>
                                    <td class="text-end fw-semibold">Rp <?php echo e(number_format($registration->activity->registration_fee, 0, ',', '.')); ?></td>
                                </tr>
                                <tr>
                                    <td class="text-slate-700">Jumlah Kepala Sekolah</td>
                                    <td class="text-end"><?php echo e($registration->jumlah_kepala_sekolah); ?> orang</td>
                                </tr>
                                <tr>
                                    <td class="text-slate-700">Jumlah Guru</td>
                                    <td class="text-end"><?php echo e($registration->jumlah_guru); ?> orang</td>
                                </tr>
                                <tr class="border-top">
                                    <td class="fw-bold text-slate-900">Total Peserta</td>
                                    <td class="text-end fw-bold text-slate-900"><?php echo e($totalPeserta); ?> orang</td>
                                </tr>
                            </table>
                            <div class="rounded-lg bg-gradient-to-br from-sky-50 to-blue-50 p-3 border-2 border-sky-400">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-sky-900">TOTAL PEMBAYARAN</span>
                                    <h4 class="mb-0 fw-bold text-sky-700">Rp <?php echo e(number_format($totalBiaya, 0, ',', '.')); ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- School Registration Info -->
                    <div class="card mb-4 border-slate-200">
                        <div class="card-header bg-slate-50">
                            <h5 class="mb-0 text-slate-900"><i class="bi bi-building me-2"></i>Data Sekolah</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <strong class="text-slate-700 d-block mb-1">Nama Sekolah</strong>
                                    <span class="text-slate-900"><?php echo e($registration->nama_sekolah); ?></span>
                                </div>
                                <div class="col-md-6">
                                    <strong class="text-slate-700 d-block mb-1">Kepala Sekolah</strong>
                                    <span class="text-slate-900"><?php echo e($registration->nama_kepala_sekolah); ?></span>
                                </div>
                                <div class="col-md-12">
                                    <strong class="text-slate-700 d-block mb-1">Alamat</strong>
                                    <span class="text-slate-900"><?php echo e($registration->alamat_sekolah); ?></span>
                                </div>
                                <div class="col-md-4">
                                    <strong class="text-slate-700 d-block mb-1">Provinsi</strong>
                                    <span class="text-slate-900"><?php echo e($registration->provinsi); ?></span>
                                </div>
                                <div class="col-md-4">
                                    <strong class="text-slate-700 d-block mb-1">Kab/Kota</strong>
                                    <span class="text-slate-900"><?php echo e($registration->kab_kota); ?></span>
                                </div>
                                <div class="col-md-4">
                                    <strong class="text-slate-700 d-block mb-1">NIK Kepala Sekolah</strong>
                                    <span class="text-slate-900"><?php echo e($registration->nik_kepala_sekolah); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Form -->
                    <form action="<?php echo e(route('payment.store', $registration)); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>

                        <!-- Informasi Pembayaran -->
                        <h5 class="text-slate-900 mb-3 pb-2 border-bottom"><i class="bi bi-wallet2 me-2"></i>Informasi Pembayaran</h5>
                        
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Bukti Transfer <span class="text-danger">*</span></label>
                                <input type="file" name="proof_file" class="form-control <?php $__errorArgs = ['proof_file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       accept="image/*" required>
                                <?php $__errorArgs = ['proof_file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <small class="form-text text-muted">
                                    Format: JPG, PNG (Max: 2MB)
                                </small>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Jumlah Transfer <span class="text-danger">*</span></label>
                                <input type="number" name="amount" class="form-control <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       value="<?php echo e(old('amount', $totalBiaya)); ?>" 
                                       min="0" step="1" required>
                                <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Tanggal Transfer <span class="text-danger">*</span></label>
                                <input type="date" name="payment_date" class="form-control <?php $__errorArgs = ['payment_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       value="<?php echo e(old('payment_date', date('Y-m-d'))); ?>" max="<?php echo e(date('Y-m-d')); ?>" required>
                                <?php $__errorArgs = ['payment_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nomor yang Bisa Dihubungi <span class="text-danger">*</span></label>
                                <input type="tel" name="contact_number" class="form-control <?php $__errorArgs = ['contact_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       value="<?php echo e(old('contact_number', $registration->nomor_telp)); ?>" 
                                       placeholder="Contoh: 081234567890" required>
                                <?php $__errorArgs = ['contact_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <!-- Data Kepala Sekolah -->
                        <?php if($registration->jumlah_kepala_sekolah > 0): ?>
                        <div class="mt-5 mb-4">
                            <h5 class="text-slate-900 mb-3 pb-2 border-bottom">
                                <i class="bi bi-person-badge me-2"></i>Data Kepala Sekolah
                                <span class="badge bg-emerald-600"><?php echo e($registration->jumlah_kepala_sekolah); ?> Kepala Sekolah</span>
                            </h5>
                            
                            <div class="card border-slate-300 shadow-sm">
                                <div class="card-header bg-emerald-50 py-2">
                                    <h6 class="mb-0 text-slate-700">
                                        <i class="bi bi-person-badge-fill me-2"></i>Kepala Sekolah
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <div class="rounded-lg border border-blue-200 bg-blue-50 p-3">
                                                <div class="d-flex align-items-start gap-2">
                                                    <svg class="flex-shrink-0 mt-0.5" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <div class="text-sm text-blue-800">
                                                        <strong>Data dari pendaftaran:</strong> <?php echo e($registration->nama_kepala_sekolah); ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <label class="form-label fw-semibold">Surat Tugas Kepala Sekolah <span class="text-danger">*</span></label>
                                            <input type="file" name="surat_tugas_kepala_sekolah" 
                                                   class="form-control <?php $__errorArgs = ['surat_tugas_kepala_sekolah'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                   accept=".pdf,.jpg,.jpeg,.png" required>
                                            <?php $__errorArgs = ['surat_tugas_kepala_sekolah'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            <small class="form-text text-muted">Upload surat tugas untuk <?php echo e($registration->nama_kepala_sekolah); ?>. Format: PDF, JPG, PNG (Max: 2MB)</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Data Guru -->
                        <?php if($registration->jumlah_guru > 0): ?>
                        <div class="mt-5 mb-4">
                            <h5 class="text-slate-900 mb-3 pb-2 border-bottom">
                                <i class="bi bi-people me-2"></i>Data Guru Peserta 
                                <span class="badge bg-sky-600"><?php echo e($registration->jumlah_guru); ?> Guru</span>
                            </h5>
                            
                            <div class="rounded-lg border border-blue-200 bg-blue-50 p-3 mb-4">
                                <div class="d-flex align-items-start gap-2">
                                    <svg class="flex-shrink-0 mt-0.5" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <div class="text-sm text-blue-800">
                                        <strong>Informasi:</strong> Silakan lengkapi data untuk <strong><?php echo e($registration->jumlah_guru); ?> guru</strong> yang akan mengikuti kegiatan ini.
                                    </div>
                                </div>
                            </div>

                            <div id="teachers-container">
                                <?php for($i = 0; $i < $registration->jumlah_guru; $i++): ?>
                                <div class="card teacher-card mb-3 border-slate-300 shadow-sm">
                                    <div class="card-header bg-slate-100 py-2">
                                        <h6 class="mb-0 text-slate-700">
                                            <i class="bi bi-person-badge me-2"></i>Guru <?php echo e($i + 1); ?>

                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                                <input type="text" name="teachers[<?php echo e($i); ?>][nama_lengkap]" 
                                                       class="form-control <?php $__errorArgs = ["teachers.$i.nama_lengkap"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                       value="<?php echo e(old("teachers.$i.nama_lengkap")); ?>"
                                                       placeholder="Nama lengkap guru" required>
                                                <?php $__errorArgs = ["teachers.$i.nama_lengkap"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">NIK</label>
                                                <input type="text" name="teachers[<?php echo e($i); ?>][nik]" 
                                                       class="form-control <?php $__errorArgs = ["teachers.$i.nik"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                       value="<?php echo e(old("teachers.$i.nik")); ?>"
                                                       maxlength="16"
                                                       pattern="[0-9]{16}"
                                                       placeholder="Nomor Induk Kependudukan 16 digit">
                                                <?php $__errorArgs = ["teachers.$i.nik"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                <small class="form-text text-muted">16 digit NIK (opsional)</small>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Email</label>
                                                <input type="email" name="teachers[<?php echo e($i); ?>][email]" 
                                                       class="form-control <?php $__errorArgs = ["teachers.$i.email"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                       value="<?php echo e(old("teachers.$i.email")); ?>"
                                                       placeholder="email@example.com">
                                                <?php $__errorArgs = ["teachers.$i.email"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Surat Tugas</label>
                                                <input type="file" name="teachers[<?php echo e($i); ?>][surat_tugas]" 
                                                       class="form-control <?php $__errorArgs = ["teachers.$i.surat_tugas"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                       accept=".pdf,.jpg,.jpeg,.png">
                                                <?php $__errorArgs = ["teachers.$i.surat_tugas"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                <small class="form-text text-muted">Format: PDF, JPG, PNG (Max: 2MB)</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="rounded-lg border border-amber-200 bg-amber-50 p-4 mb-4">
                            <div class="d-flex align-items-start gap-3">
                                <svg class="flex-shrink-0 mt-1" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <div class="text-amber-900">
                                    <strong class="d-block mb-2">Perhatian:</strong>
                                    <ul class="mb-0 ps-3">
                                        <li>Pastikan bukti transfer yang diupload jelas dan dapat dibaca</li>
                                        <li>Pembayaran untuk <strong><?php echo e($registration->nama_sekolah); ?></strong> dengan total <strong><?php echo e($totalPeserta); ?> peserta</strong></li>
                                        <li>Total yang harus dibayar: <strong class="text-amber-800">Rp <?php echo e(number_format($totalBiaya, 0, ',', '.')); ?></strong></li>
                                        <?php if($registration->jumlah_guru > 0): ?>
                                        <li>Lengkapi data <strong><?php echo e($registration->jumlah_guru); ?> guru</strong> yang akan mengikuti kegiatan</li>
                                        <?php endif; ?>
                                        <li>Pembayaran akan divalidasi oleh admin</li>
                                        <li>Sekolah Anda akan menjadi peserta setelah pembayaran divalidasi</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-3 justify-content-end">
                            <a href="<?php echo e(route('activities.index')); ?>" class="btn btn-secondary px-4">
                                <i class="bi bi-x-circle me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-upload me-2"></i>Upload Bukti Pembayaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function paymentForm() {
    return {
        // Add any Alpine.js functionality here if needed
    }
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\LMS\resources\views/payment/create.blade.php ENDPATH**/ ?>