<?php $__env->startSection('title', $newsItem->title); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Beranda</a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('news')); ?>">Berita</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo e(Str::limit($newsItem->title, 50)); ?></li>
        </ol>
    </nav>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <article class="card mb-4">
                <div class="card-body">
                    <!-- Article Header -->
                    <h1 class="mb-3"><?php echo e($newsItem->title); ?></h1>
                    
                    <!-- Meta Information -->
                    <div class="text-muted mb-4 pb-3 border-bottom">
                        <small>
                            <i class="bi bi-calendar"></i> <?php echo e($newsItem->published_at->format('d F Y, H:i')); ?>

                            <?php if($newsItem->author): ?>
                            <span class="ms-3"><i class="bi bi-person"></i> <?php echo e($newsItem->author); ?></span>
                            <?php endif; ?>
                            <?php if($newsItem->category): ?>
                            <span class="ms-3"><i class="bi bi-tag"></i> <?php echo e($newsItem->category); ?></span>
                            <?php endif; ?>
                        </small>
                    </div>

                    <!-- Featured Image -->
                    <?php if($newsItem->image): ?>
                    <div class="mb-4">
                        <img src="<?php echo e(asset('storage/' . $newsItem->image)); ?>" class="img-fluid rounded" alt="<?php echo e($newsItem->title); ?>">
                    </div>
                    <?php endif; ?>

                    <!-- Article Content -->
                    <div class="article-content">
                        <?php echo $newsItem->content; ?>

                    </div>

                    <!-- Article Footer -->
                    <?php if($newsItem->tags): ?>
                    <div class="mt-4 pt-3 border-top">
                        <strong>Tags:</strong>
                        <?php $__currentLoopData = explode(',', $newsItem->tags); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <span class="badge bg-secondary ms-1"><?php echo e(trim($tag)); ?></span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php endif; ?>
                </div>
            </article>

            <!-- Back Button -->
            <div class="mb-4">
                <a href="<?php echo e(route('news')); ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar Berita
                </a>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Related News -->
            <?php if($relatedNews->count() > 0): ?>
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Berita Terkait</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <?php $__currentLoopData = $relatedNews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $related): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('news.detail', $related->id)); ?>" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1"><?php echo e(Str::limit($related->title, 60)); ?></h6>
                                    <small class="text-muted"><?php echo e($related->published_at->format('d M Y')); ?></small>
                                </div>
                                <?php if($related->image): ?>
                                <img src="<?php echo e(asset('storage/' . $related->image)); ?>" alt="<?php echo e($related->title); ?>" style="width: 60px; height: 60px; object-fit: cover;" class="rounded ms-2">
                                <?php endif; ?>
                            </div>
                        </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Latest News Widget -->
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Berita Lainnya</h5>
                </div>
                <div class="card-body">
                    <a href="<?php echo e(route('news')); ?>" class="btn btn-primary w-100">
                        Lihat Semua Berita
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.article-content {
    font-size: 1.1rem;
    line-height: 1.8;
}

.article-content img {
    max-width: 100%;
    height: auto;
    margin: 1rem 0;
}

.article-content p {
    margin-bottom: 1rem;
}

.article-content h2,
.article-content h3,
.article-content h4 {
    margin-top: 1.5rem;
    margin-bottom: 1rem;
}

.article-content ul,
.article-content ol {
    margin-bottom: 1rem;
    padding-left: 2rem;
}
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\LMS\resources\views/news/detail.blade.php ENDPATH**/ ?>