

<?php $__env->startSection('sidebar'); ?>
    <li>
        <a href="<?php echo e(route('sekolah.dashboard')); ?>" class="<?php echo e(request()->routeIs('sekolah.dashboard') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-700' : 'text-slate-700 hover:bg-slate-50'); ?> flex items-center gap-3 px-4 py-3 rounded-r-lg transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
            </svg>
            Dashboard
        </a>
    </li>
    <li>
        <a href="<?php echo e(route('sekolah.profile')); ?>" class="<?php echo e(request()->routeIs('sekolah.profile') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-700' : 'text-slate-700 hover:bg-slate-50'); ?> flex items-center gap-3 px-4 py-3 rounded-r-lg transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
            </svg>
            Profil Sekolah
        </a>
    </li>
    <li>
        <a href="<?php echo e(route('activities.index')); ?>" class="<?php echo e(request()->routeIs('activities.*') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-700' : 'text-slate-700 hover:bg-slate-50'); ?> flex items-center gap-3 px-4 py-3 rounded-r-lg transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
            </svg>
            Daftar Kegiatan
        </a>
    </li>
    <li>
        <a href="<?php echo e(route('sekolah.registrations')); ?>" class="<?php echo e(request()->routeIs('sekolah.registrations') ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-700' : 'text-slate-700 hover:bg-slate-50'); ?> flex items-center gap-3 px-4 py-3 rounded-r-lg transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
            </svg>
            Pendaftaran Saya
        </a>
    </li>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\LMS\resources\views/layouts/sekolah.blade.php ENDPATH**/ ?>