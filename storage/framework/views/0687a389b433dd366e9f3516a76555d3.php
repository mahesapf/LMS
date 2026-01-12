<?php $__env->startSection('title', 'Manajemen Kelas'); ?>

<?php $__env->startSection('sidebar'); ?>
    <?php echo $__env->make('super-admin.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6" x-data="{ showCreateModal: false, showEditModal: <?php echo e(request('edit') ? 'true' : 'false'); ?> }">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Manajemen Kelas</h1>
            <p class="mt-1 text-sm text-slate-500">Kelola kelas pada kegiatan, peserta, dan status pendaftaran.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="<?php echo e(route($routePrefix . '.registrations.index')); ?>" class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a7 7 0 100 14A7 7 0 0010 3zm1 10a1 1 0 11-2 0V9a1 1 0 112 0v4zm-1-8a1 1 0 110 2 1 1 0 010-2z" clip-rule="evenodd" />
                </svg>
                Assign Peserta
            </a>
            <button @click="showCreateModal = true" class="inline-flex items-center gap-2 rounded-lg bg-sky-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-sky-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Kelas
            </button>
        </div>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
        <form method="GET" action="<?php echo e(route($routePrefix . '.classes.index')); ?>" class="mb-4">
            <div class="grid gap-3 sm:grid-cols-2 md:grid-cols-4">
                <div>
                    <label class="mb-1 block text-xs font-medium text-slate-600">Filter Kegiatan</label>
                    <select name="activity_id" class="select select-bordered w-full" onchange="this.form.submit()">
                        <option value="">Semua Kegiatan</option>
                        <?php $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($activity->id); ?>" <?php echo e(request('activity_id') == $activity->id ? 'selected' : ''); ?>>
                            <?php echo e($activity->name); ?>

                        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="inline-flex items-center rounded-lg bg-sky-600 px-3 py-2 text-sm font-semibold text-white hover:bg-sky-700">Filter</button>
                    <a href="<?php echo e(route($routePrefix . '.classes.index')); ?>" class="inline-flex items-center rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Reset</a>
                </div>
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">No</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Nama Kelas</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Kegiatan</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Tanggal</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Max Peserta</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Status</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Pembuat</th>
                        <th class="px-4 py-2 text-right text-xs font-semibold text-slate-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    <?php $__empty_1 = true; $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-2 text-sm text-slate-700"><?php echo e($loop->iteration + ($classes->currentPage() - 1) * $classes->perPage()); ?></td>
                        <td class="px-4 py-2 text-sm">
                            <div class="text-slate-900 font-semibold"><?php echo e($class->name); ?></div>
                            <?php if($class->description): ?>
                            <div class="text-xs text-slate-500"><?php echo e(Str::limit($class->description, 70)); ?></div>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-2 text-sm text-slate-700"><?php echo e($class->activity->name ?? '-'); ?></td>
                        <td class="px-4 py-2 text-sm text-slate-700">
                            <?php if($class->start_date && $class->end_date): ?>
                                <div class="text-xs">
                                    <div><?php echo e($class->start_date->format('d/m/Y')); ?></div>
                                    <div class="text-slate-500">s/d <?php echo e($class->end_date->format('d/m/Y')); ?></div>
                                </div>
                            <?php elseif($class->activity && $class->activity->start_date && $class->activity->end_date): ?>
                                <div class="text-xs">
                                    <div><?php echo e($class->activity->start_date->format('d/m/Y')); ?></div>
                                    <div class="text-slate-500">s/d <?php echo e($class->activity->end_date->format('d/m/Y')); ?></div>
                                </div>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-2 text-sm text-slate-700"><?php echo e($class->max_participants ?? 'Unlimited'); ?></td>
                        <td class="px-4 py-2 text-sm">
                            <?php if($class->status == 'open'): ?>
                                <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-semibold text-emerald-700">Buka</span>
                            <?php elseif($class->status == 'closed'): ?>
                                <span class="inline-flex rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-semibold text-amber-700">Tutup</span>
                            <?php else: ?>
                                <span class="inline-flex rounded-full bg-slate-200 px-2.5 py-0.5 text-xs font-semibold text-slate-700">Selesai</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-2 text-sm text-slate-700"><?php echo e($class->creator->name ?? '-'); ?></td>
                        <td class="px-4 py-2 text-sm">
                            <div class="flex justify-end gap-2">
                                <a href="<?php echo e(route($routePrefix . '.classes.show', $class)); ?>" class="inline-flex items-center rounded-md border border-sky-300 bg-white px-2.5 py-1.5 text-xs font-semibold text-sky-700 shadow-sm hover:bg-sky-50">Detail</a>
                                <a href="<?php echo e(route($routePrefix . '.classes.index')); ?>?edit=<?php echo e($class->id); ?>" class="inline-flex items-center rounded-md bg-amber-500 px-2.5 py-1.5 text-xs font-semibold text-white shadow-sm hover:bg-amber-600">Edit</a>
                                <form action="<?php echo e(route($routePrefix . '.classes.delete', $class)); ?>" method="POST" onsubmit="return confirm('Yakin ingin menghapus kelas ini?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="inline-flex items-center rounded-md bg-rose-600 px-2.5 py-1.5 text-xs font-semibold text-white shadow-sm hover:bg-rose-700">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="px-4 py-6 text-center text-sm text-slate-500">Tidak ada data kelas</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if($classes->hasPages()): ?>
        <div class="mt-4">
            <?php echo e($classes->links()); ?>

        </div>
        <?php endif; ?>
    </div>

    
    <?php echo $__env->make('super-admin.classes.partials.create-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <?php echo $__env->make('super-admin.classes.partials.edit-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\LMS\resources\views/super-admin/classes/index.blade.php ENDPATH**/ ?>