

<?php $__env->startSection('title', 'Kegiatan Tersedia'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <h1 class="mb-4">Kegiatan Tersedia</h1>

    <?php if(!Auth::check()): ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="bi bi-info-circle"></i>
            <strong>Informasi:</strong> Anda dapat mendaftar kegiatan tanpa harus login. Cukup isi formulir pendaftaran sekolah dan lakukan pembayaran.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(session('info')): ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <?php echo e(session('info')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- My Registrations -->
    <?php if($myRegistrations->count() > 0): ?>
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Kegiatan Saya</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Kegiatan</th>
                            <th>Sekolah</th>
                            <th>Peserta</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $myRegistrations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $registration): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($registration->activity->name); ?></td>
                            <td><?php echo e($registration->nama_sekolah); ?></td>
                            <td>
                                <?php echo e($registration->jumlah_peserta > 0 ? $registration->jumlah_peserta : ($registration->jumlah_kepala_sekolah + $registration->jumlah_guru)); ?> orang
                            </td>
                            <td><?php echo e($registration->activity->start_date->format('d M Y')); ?></td>
                            <td>
                                <?php if($registration->status == 'pending'): ?>
                                    <span class="badge bg-secondary">Pending</span>
                                <?php elseif($registration->status == 'payment_pending'): ?>
                                    <span class="badge bg-warning">Menunggu Pembayaran</span>
                                <?php elseif($registration->status == 'payment_uploaded'): ?>
                                    <span class="badge bg-info">Menunggu Validasi</span>
                                <?php elseif($registration->status == 'validated'): ?>
                                    <span class="badge bg-success">Tervalidasi</span>
                                <?php elseif($registration->status == 'rejected'): ?>
                                    <span class="badge bg-danger">Ditolak</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($registration->status == 'payment_pending' && !$registration->payment): ?>
                                    <a href="<?php echo e(route('payment.create', $registration)); ?>" class="btn btn-sm btn-primary">
                                        Upload Pembayaran
                                    </a>
                                <?php else: ?>
                                    <a href="<?php echo e(route('activities.show', $registration->activity)); ?>" class="btn btn-sm btn-outline-primary">
                                        Lihat Detail
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Available Activities -->
    <div class="row">
        <div class="col-12 mb-4">
            <h3>Kegiatan Tersedia untuk Pendaftaran</h3>
        </div>
        
        <?php $__empty_1 = true; $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title"><?php echo e($activity->name); ?></h5>
                    <?php if($activity->program): ?>
                        <p class="text-muted small mb-2">
                            <i class="bi bi-folder"></i> <?php echo e($activity->program->name); ?>

                        </p>
                    <?php endif; ?>
                    <?php if($activity->description): ?>
                        <p class="card-text"><?php echo e(Str::limit($activity->description, 100)); ?></p>
                    <?php endif; ?>
                    
                    <ul class="list-unstyled small">
                        <li class="mb-1">
                            <i class="bi bi-calendar"></i> 
                            <strong>Mulai:</strong> <?php echo e($activity->start_date->format('d M Y')); ?>

                        </li>
                        <li class="mb-1">
                            <i class="bi bi-calendar-check"></i> 
                            <strong>Selesai:</strong> <?php echo e($activity->end_date->format('d M Y')); ?>

                        </li>
                        <?php if($activity->batch): ?>
                        <li class="mb-1">
                            <i class="bi bi-tag"></i> 
                            <strong>Batch:</strong> <?php echo e($activity->batch); ?>

                        </li>
                        <?php endif; ?>
                        <?php if($activity->registration_fee > 0): ?>
                        <li class="mb-1">
                            <i class="bi bi-cash"></i> 
                            <strong>Biaya:</strong> Rp <?php echo e(number_format($activity->registration_fee, 0, ',', '.')); ?> <small class="text-muted">per peserta</small>
                        </li>
                        <?php endif; ?>
                        <?php if($activity->financing_type): ?>
                        <li class="mb-1">
                            <i class="bi bi-wallet2"></i> 
                            <strong>Pembiayaan:</strong> <?php echo e($activity->financing_type); ?>

                            <?php if($activity->apbn_type): ?> - <?php echo e($activity->apbn_type); ?><?php endif; ?>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="card-footer bg-white border-top-0">
                    <a href="<?php echo e(route('activities.show', $activity)); ?>" class="btn btn-primary btn-sm w-100">
                        <i class="bi bi-eye"></i> Lihat Detail & Daftar
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-12">
            <div class="alert alert-info">
                Saat ini belum ada kegiatan yang tersedia untuk pendaftaran.
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\LMS\resources\views/activities/index.blade.php ENDPATH**/ ?>