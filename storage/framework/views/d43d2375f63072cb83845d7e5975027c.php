<?php $__env->startSection('title', 'Admin Dashboard'); ?>

<?php $__env->startSection('sidebar'); ?>
<nav class="nav flex-column">
    <a class="nav-link active" href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a>
    <a class="nav-link" href="<?php echo e(route('admin.activities')); ?>">Kegiatan</a>
    <a class="nav-link" href="<?php echo e(route('admin.classes.index')); ?>">Kelas</a>
    <a class="nav-link" href="<?php echo e(route('admin.registrations.index')); ?>">Manajemen Peserta</a>
</nav>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <h1 class="mb-4">Dashboard Admin</h1>

    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Peserta</h5>
                    <h2 class="mb-0"><?php echo e($stats['total_participants']); ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Kegiatan</h5>
                    <h2 class="mb-0"><?php echo e($stats['total_activities']); ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Kelas</h5>
                    <h2 class="mb-0"><?php echo e($stats['total_classes']); ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">Peserta Aktif</h5>
                    <h2 class="mb-0"><?php echo e($stats['active_participants']); ?></h2>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\LMS\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>