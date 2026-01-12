<?php $__env->startSection('title', 'Program'); ?>

<?php $__env->startSection('sidebar'); ?>
    <?php echo $__env->make('super-admin.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Daftar Program</h1>
            <p class="mt-1 text-sm text-slate-500">Kelola informasi program, jadwal, dan status publikasi.</p>
        </div>
        <a href="<?php echo e(route('super-admin.programs.create')); ?>" class="inline-flex items-center gap-2 rounded-lg bg-sky-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-sky-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Program
        </a>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Nama Program</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Deskripsi</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Tanggal Mulai</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Tanggal Selesai</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Status</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Dibuat Oleh</th>
                        <th class="px-4 py-2 text-right text-xs font-semibold text-slate-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    <?php $__empty_1 = true; $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-2 text-sm font-semibold text-slate-900"><?php echo e($program->name); ?></td>
                        <td class="px-4 py-2 text-sm text-slate-700"><?php echo e(Str::limit($program->description, 80)); ?></td>
                        <td class="px-4 py-2 text-sm text-slate-700"><?php echo e($program->start_date ? $program->start_date->format('d/m/Y') : '-'); ?></td>
                        <td class="px-4 py-2 text-sm text-slate-700"><?php echo e($program->end_date ? $program->end_date->format('d/m/Y') : '-'); ?></td>
                        <td class="px-4 py-2 text-sm">
                            <?php if($program->status == 'active'): ?>
                                <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-semibold text-emerald-700">Aktif</span>
                            <?php elseif($program->status == 'completed'): ?>
                                <span class="inline-flex rounded-full bg-sky-100 px-2.5 py-0.5 text-xs font-semibold text-sky-700">Selesai</span>
                            <?php else: ?>
                                <span class="inline-flex rounded-full bg-slate-200 px-2.5 py-0.5 text-xs font-semibold text-slate-700">Tidak Aktif</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-2 text-sm text-slate-700"><?php echo e($program->creator->name); ?></td>
                        <td class="px-4 py-2 text-sm">
                            <div class="flex justify-end gap-2">
                                <a href="<?php echo e(route('super-admin.programs.edit', $program)); ?>" class="inline-flex items-center rounded-md bg-amber-500 px-2.5 py-1.5 text-xs font-semibold text-white shadow-sm hover:bg-amber-600">Edit</a>
                                <form method="POST" action="<?php echo e(route('super-admin.programs.delete', $program)); ?>" onsubmit="return confirm('Hapus program ini?')">
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

        <div class="mt-4"><?php echo e($programs->links()); ?></div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\LMS\resources\views/super-admin/programs/index.blade.php ENDPATH**/ ?>