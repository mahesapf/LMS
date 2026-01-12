

<?php $__env->startSection('title', 'Manajemen Sekolah'); ?>

<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
    <!-- Header -->
    <div class="page-header">
        <h3 class="page-title">Manajemen Sekolah</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(route('super-admin.dashboard')); ?>">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Manajemen Sekolah</li>
            </ol>
        </nav>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo e(session('error')); ?>

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <!-- Filter Status -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="card-title mb-0">Daftar Sekolah</h4>
                        </div>
                        <div class="btn-group" role="group">
                            <a href="<?php echo e(route('super-admin.sekolah.index', ['status' => 'all'])); ?>" 
                               class="btn btn-sm <?php echo e(request('status', 'all') == 'all' ? 'btn-primary' : 'btn-outline-primary'); ?>">
                                Semua
                            </a>
                            <a href="<?php echo e(route('super-admin.sekolah.index', ['status' => 'pending'])); ?>" 
                               class="btn btn-sm <?php echo e(request('status') == 'pending' ? 'btn-warning' : 'btn-outline-warning'); ?>">
                                Pending
                            </a>
                            <a href="<?php echo e(route('super-admin.sekolah.index', ['status' => 'approved'])); ?>" 
                               class="btn btn-sm <?php echo e(request('status') == 'approved' ? 'btn-success' : 'btn-outline-success'); ?>">
                                Disetujui
                            </a>
                            <a href="<?php echo e(route('super-admin.sekolah.index', ['status' => 'rejected'])); ?>" 
                               class="btn btn-sm <?php echo e(request('status') == 'rejected' ? 'btn-danger' : 'btn-outline-danger'); ?>">
                                Ditolak
                            </a>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Sekolah</th>
                                    <th>NPSN</th>
                                    <th>Provinsi</th>
                                    <th>Kabupaten</th>
                                    <th>Email Belajar.id</th>
                                    <th>Pendaftar</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $sekolahs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $sekolah): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($sekolahs->firstItem() + $index); ?></td>
                                        <td><?php echo e($sekolah->nama_sekolah); ?></td>
                                        <td><?php echo e($sekolah->npsn); ?></td>
                                        <td><?php echo e($sekolah->provinsi); ?></td>
                                        <td><?php echo e($sekolah->kabupaten); ?></td>
                                        <td><?php echo e($sekolah->email_belajar_id); ?></td>
                                        <td><?php echo e($sekolah->pendaftar); ?></td>
                                        <td>
                                            <?php if($sekolah->approval_status == 'pending'): ?>
                                                <span class="badge badge-warning">Pending</span>
                                            <?php elseif($sekolah->approval_status == 'approved'): ?>
                                                <span class="badge badge-success">Disetujui</span>
                                            <?php else: ?>
                                                <span class="badge badge-danger">Ditolak</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo e(route('super-admin.sekolah.show', $sekolah->id)); ?>" 
                                               class="btn btn-sm btn-info" title="Detail">
                                                <i class="mdi mdi-eye"></i>
                                            </a>
                                            
                                            <?php if($sekolah->approval_status == 'pending'): ?>
                                                <form action="<?php echo e(route('super-admin.sekolah.approve', $sekolah->id)); ?>" 
                                                      method="POST" class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('PATCH'); ?>
                                                    <button type="submit" class="btn btn-sm btn-success" 
                                                            title="Setujui"
                                                            onclick="return confirm('Apakah Anda yakin ingin menyetujui pendaftaran sekolah ini?')">
                                                        <i class="mdi mdi-check"></i>
                                                    </button>
                                                </form>
                                                
                                                <form action="<?php echo e(route('super-admin.sekolah.reject', $sekolah->id)); ?>" 
                                                      method="POST" class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('PATCH'); ?>
                                                    <button type="submit" class="btn btn-sm btn-warning" 
                                                            title="Tolak"
                                                            onclick="return confirm('Apakah Anda yakin ingin menolak pendaftaran sekolah ini?')">
                                                        <i class="mdi mdi-close"></i>
                                                    </button>
                                                </form>
                                            <?php endif; ?>

                                            <form action="<?php echo e(route('super-admin.sekolah.destroy', $sekolah->id)); ?>" 
                                                  method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-danger" 
                                                        title="Hapus"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus akun sekolah ini?')">
                                                    <i class="mdi mdi-delete"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="9" class="text-center">Tidak ada data sekolah</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        <?php echo e($sekolahs->appends(request()->query())->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\LMS\resources\views/super-admin/sekolah/index.blade.php ENDPATH**/ ?>