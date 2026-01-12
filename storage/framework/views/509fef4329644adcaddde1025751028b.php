<?php $__env->startSection('title', 'Peserta Dashboard'); ?>

<?php $__env->startSection('sidebar'); ?>
<nav class="nav flex-column">
    <a class="nav-link active" href="<?php echo e(route('peserta.dashboard')); ?>">Dashboard</a>
    <a class="nav-link" href="<?php echo e(route('peserta.profile')); ?>">Profil</a>
    <a class="nav-link" href="<?php echo e(route('peserta.biodata')); ?>">Biodata</a>
    <a class="nav-link" href="<?php echo e(route('peserta.classes')); ?>">Kelas & Nilai Saya</a>
    <a class="nav-link" href="<?php echo e(route('peserta.documents')); ?>">Dokumen</a>
</nav>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <h1 class="mb-4">Dashboard Peserta</h1>
    
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Kelas yang Diikuti</h5>
                    <h2 class="mb-0"><?php echo e($stats['total_classes']); ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Nilai</h5>
                    <h2 class="mb-0"><?php echo e($stats['total_grades']); ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Dokumen Terupload</h5>
                    <h2 class="mb-0"><?php echo e($stats['total_documents']); ?></h2>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\LMS\resources\views/peserta/dashboard.blade.php ENDPATH**/ ?>