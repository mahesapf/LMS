

<?php $__env->startSection('title', 'Dashboard Sekolah'); ?>

<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">Dashboard Sekolah</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-md-3 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title text-md-center text-xl-left">Total Pendaftaran</p>
                    <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                        <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0"><?php echo e($stats['total_registrations']); ?></h3>
                        <i class="mdi mdi-file-document icon-md text-muted mb-0 mb-md-3 mb-xl-0"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title text-md-center text-xl-left">Menunggu Persetujuan</p>
                    <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                        <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0"><?php echo e($stats['pending_registrations']); ?></h3>
                        <i class="mdi mdi-clock-outline icon-md text-warning mb-0 mb-md-3 mb-xl-0"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title text-md-center text-xl-left">Disetujui</p>
                    <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                        <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0"><?php echo e($stats['approved_registrations']); ?></h3>
                        <i class="mdi mdi-check-circle icon-md text-success mb-0 mb-md-3 mb-xl-0"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title text-md-center text-xl-left">Kegiatan Tersedia</p>
                    <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                        <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0"><?php echo e($stats['available_activities']); ?></h3>
                        <i class="mdi mdi-calendar-check icon-md text-info mb-0 mb-md-3 mb-xl-0"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title mb-0">Pendaftaran Terakhir</h4>
                        <a href="<?php echo e(route('activities.index')); ?>" class="btn btn-primary btn-sm">
                            <i class="mdi mdi-plus"></i> Daftar Kegiatan Baru
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Kegiatan</th>
                                    <th>Program</th>
                                    <th>Tanggal Daftar</th>
                                    <th>Status</th>
                                    <th>Pembayaran</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $recentRegistrations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $registration): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($registration->activity->name ?? '-'); ?></td>
                                        <td><?php echo e($registration->activity->program->name ?? '-'); ?></td>
                                        <td><?php echo e($registration->created_at->format('d M Y')); ?></td>
                                        <td>
                                            <?php if($registration->status == 'pending'): ?>
                                                <span class="badge badge-warning">Pending</span>
                                            <?php elseif($registration->status == 'approved'): ?>
                                                <span class="badge badge-success">Disetujui</span>
                                            <?php else: ?>
                                                <span class="badge badge-danger">Ditolak</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($registration->payment): ?>
                                                <?php if($registration->payment->status == 'pending'): ?>
                                                    <span class="badge badge-warning">Menunggu Verifikasi</span>
                                                <?php elseif($registration->payment->status == 'approved'): ?>
                                                    <span class="badge badge-success">Sudah Dibayar</span>
                                                <?php else: ?>
                                                    <span class="badge badge-danger">Ditolak</span>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="badge badge-secondary">Belum Bayar</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="5" class="text-center">Belum ada pendaftaran</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if($recentRegistrations->count() > 0): ?>
                        <div class="mt-3">
                            <a href="<?php echo e(route('sekolah.registrations')); ?>" class="btn btn-link">
                                Lihat Semua Pendaftaran →
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.sekolah', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\LMS\resources\views/sekolah/dashboard.blade.php ENDPATH**/ ?>