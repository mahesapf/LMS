<?php $__env->startSection('title', 'Berita'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <h1 class="mb-3">Berita</h1>
            <p class="text-muted">Informasi terbaru seputar program dan kegiatan penjaminan mutu</p>
        </div>
    </div>

    <!-- News Grid -->
    <div class="row">
        <?php $__empty_1 = true; $__currentLoopData = $news; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <?php if($item->image): ?>
                <img src="<?php echo e(asset('storage/' . $item->image)); ?>" class="card-img-top" alt="<?php echo e($item->title); ?>" style="height: 200px; object-fit: cover;">
                <?php else: ?>
                <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                    <span class="text-white display-6">📰</span>
                </div>
                <?php endif; ?>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?php echo e($item->title); ?></h5>
                    <p class="card-text flex-grow-1"><?php echo e(Str::limit(strip_tags($item->content), 150)); ?></p>
                    <div class="mt-auto">
                        <p class="text-muted small mb-2">
                            <i class="bi bi-calendar"></i> <?php echo e($item->published_at->format('d M Y')); ?>

                            <?php if($item->author): ?>
                            <span class="ms-2"><i class="bi bi-person"></i> <?php echo e($item->author); ?></span>
                            <?php endif; ?>
                        </p>
                        <a href="<?php echo e(route('news.detail', $item->id)); ?>" class="btn btn-primary btn-sm">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-12">
            <div class="alert alert-info text-center">
                <p class="mb-0">Belum ada berita yang dipublikasikan.</p>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <?php if($news->hasPages()): ?>
    <div class="row mt-4">
        <div class="col-12">
            <div class="d-flex justify-content-center">
                <?php echo e($news->links()); ?>

            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\LMS\resources\views/news/index.blade.php ENDPATH**/ ?>