<?php $__env->startSection('title', 'Kelas & Nilai Saya'); ?>

<?php $__env->startSection('sidebar'); ?>
<nav class="nav flex-column">
    <a class="nav-link" href="<?php echo e(route('peserta.dashboard')); ?>">Dashboard</a>
    <a class="nav-link" href="<?php echo e(route('peserta.profile')); ?>">Profil</a>
    <a class="nav-link" href="<?php echo e(route('peserta.biodata')); ?>">Biodata</a>
    <a class="nav-link active" href="<?php echo e(route('peserta.classes')); ?>">Kelas & Nilai Saya</a>
    <a class="nav-link" href="<?php echo e(route('peserta.documents')); ?>">Dokumen</a>
</nav>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Kelas & Nilai Saya</h1>
    </div>

    <?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <div class="row">
        <?php $__empty_1 = true; $__currentLoopData = $mappings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mapping): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php
            $classGrades = $grades->get($mapping->class_id, collect());
            $averageScore = $classGrades->count() > 0 ? $classGrades->avg('score') : null;
        ?>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><?php echo e($mapping->class->name); ?></h5>
                </div>
                <div class="card-body">
                    <p class="card-text">
                        <strong>Kegiatan:</strong><br>
                        <?php echo e($mapping->class->activity->name ?? '-'); ?>

                    </p>
                    
                    <?php if($mapping->class->description): ?>
                    <p class="card-text text-muted">
                        <?php echo e(Str::limit($mapping->class->description, 100)); ?>

                    </p>
                    <?php endif; ?>

                    <!-- Nilai Section -->
                    <div class="mb-3">
                        <strong>Nilai:</strong>
                        <?php if($classGrades->count() > 0): ?>
                        <div class="mt-2">
                            <?php $__currentLoopData = $classGrades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="badge bg-primary me-1 mb-1">
                                <?php echo e($grade->assessment_type); ?>: <?php echo e(number_format($grade->score, 1)); ?>

                            </span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <div class="mt-2">
                                <strong>Rata-rata: 
                                    <span class="badge bg-info"><?php echo e(number_format($averageScore, 2)); ?></span>
                                </strong>
                            </div>
                        </div>
                        <?php else: ?>
                        <div class="text-muted">
                            <small>Belum ada nilai</small>
                        </div>
                        <?php endif; ?>
                    </div>

                    <p class="card-text">
                        <small class="text-muted">
                            <i class="bi bi-calendar"></i> Terdaftar: <?php echo e($mapping->created_at->format('d M Y')); ?><br>
                            <?php if($mapping->assignedBy): ?>
                            <i class="bi bi-person"></i> Oleh: <?php echo e($mapping->assignedBy->name); ?>

                            <?php endif; ?>
                        </small>
                    </p>

                    <a href="<?php echo e(route('peserta.classes.detail', $mapping->class)); ?>" class="btn btn-sm btn-primary">
                        <i class="bi bi-eye"></i> Detail Kelas
                    </a>
                </div>
                <div class="card-footer text-muted">
                    <small>
                        Status: 
                        <?php if($mapping->class->status == 'open'): ?>
                        <span class="badge bg-success">Buka</span>
                        <?php elseif($mapping->class->status == 'closed'): ?>
                        <span class="badge bg-warning">Tutup</span>
                        <?php else: ?>
                        <span class="badge bg-secondary">Selesai</span>
                        <?php endif; ?>
                    </small>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-12">
            <div class="alert alert-info text-center">
                <p class="mb-0">Anda belum terdaftar di kelas manapun.</p>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <?php if($mappings->hasPages()): ?>
    <div class="d-flex justify-content-center mt-3">
        <?php echo e($mappings->links()); ?>

    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\LMS\resources\views/peserta/classes/index.blade.php ENDPATH**/ ?>