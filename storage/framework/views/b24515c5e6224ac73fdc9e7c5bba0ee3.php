<?php $__env->startSection('title', 'Kegiatan'); ?>

<?php $__env->startSection('sidebar'); ?>
    <?php echo $__env->make('super-admin.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6" x-data="{ showCreateModal: false, showEditModal: <?php echo e(request('edit') ? 'true' : 'false'); ?> }">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Daftar Kegiatan</h1>
            <p class="mt-1 text-sm text-slate-500">Kelola jadwal kegiatan, sumber dana, dan status pelaksanaan.</p>
        </div>
        <button @click="showCreateModal = true" class="inline-flex items-center gap-2 rounded-lg bg-sky-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-sky-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Kegiatan
        </button>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Nama Kegiatan</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Program</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Batch</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Tanggal</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Sumber Dana</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Status</th>
                        <th class="px-4 py-2 text-right text-xs font-semibold text-slate-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    <?php $__empty_1 = true; $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-2 text-sm font-semibold text-slate-900"><?php echo e($activity->name); ?></td>
                        <td class="px-4 py-2 text-sm text-slate-700"><?php echo e($activity->program ? $activity->program->name : '-'); ?></td>
                        <td class="px-4 py-2 text-sm text-slate-700"><?php echo e($activity->batch ?? '-'); ?></td>
                        <td class="px-4 py-2 text-sm text-slate-700"><?php echo e($activity->start_date->format('d/m/Y')); ?> - <?php echo e($activity->end_date->format('d/m/Y')); ?></td>
                        <td class="px-4 py-2 text-sm text-slate-700">
                            <?php if($activity->funding_source == 'Other'): ?>
                                <?php echo e($activity->funding_source_other); ?>

                            <?php else: ?>
                                <?php echo e($activity->funding_source); ?>

                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-2 text-sm">
                            <?php if($activity->status == 'planned'): ?>
                                <span class="inline-flex rounded-full bg-slate-200 px-2.5 py-0.5 text-xs font-semibold text-slate-700">Direncanakan</span>
                            <?php elseif($activity->status == 'ongoing'): ?>
                                <span class="inline-flex rounded-full bg-sky-100 px-2.5 py-0.5 text-xs font-semibold text-sky-700">Berlangsung</span>
                            <?php elseif($activity->status == 'completed'): ?>
                                <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-semibold text-emerald-700">Selesai</span>
                            <?php else: ?>
                                <span class="inline-flex rounded-full bg-rose-100 px-2.5 py-0.5 text-xs font-semibold text-rose-700">Dibatalkan</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-2 text-sm">
                            <div class="flex justify-end gap-2">
                                <a href="<?php echo e(route($routePrefix . '.activities')); ?>?edit=<?php echo e($activity->id); ?>" class="inline-flex items-center rounded-md bg-amber-500 px-2.5 py-1.5 text-xs font-semibold text-white shadow-sm hover:bg-amber-600">Edit</a>
                                <form method="POST" action="<?php echo e(route($routePrefix . '.activities.delete', $activity)); ?>" onsubmit="return confirm('Hapus kegiatan ini?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="inline-flex items-center rounded-md bg-rose-600 px-2.5 py-1.5 text-xs font-semibold text-white shadow-sm hover:bg-rose-700">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="px-4 py-6 text-center text-sm text-slate-500">Tidak ada data</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-4"><?php echo e($activities->links()); ?></div>
    </div>

    
    <?php echo $__env->make('super-admin.activities.partials.create-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <?php echo $__env->make('super-admin.activities.partials.edit-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\LMS\resources\views/super-admin/activities/index.blade.php ENDPATH**/ ?>