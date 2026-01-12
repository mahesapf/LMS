<!-- Modal Import Users -->
<div x-show="showImportModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" @keydown.escape.window="showImportModal = false">
    <div class="fixed inset-0 bg-slate-900/70" @click="showImportModal = false"></div>
    <div class="relative z-10 flex min-h-screen items-center justify-center p-4">
        <div @click.away="showImportModal = false" class="relative w-full max-w-3xl overflow-hidden rounded-2xl bg-white shadow-2xl ring-1 ring-slate-200">
            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Formulir</p>
                    <h2 class="text-lg font-semibold text-slate-900">Import Pengguna dari CSV</h2>
                </div>
                <button type="button" class="rounded-md p-2 text-slate-500 hover:bg-slate-100" @click="showImportModal = false">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <?php if(session('error')): ?>
                <div class="border-l-4 border-red-600 bg-red-50 p-4 text-red-700">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>

            <?php if(session('success')): ?>
                <div class="border-l-4 border-emerald-600 bg-emerald-50 p-4 text-emerald-700">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('super-admin.users.import.process')); ?>" enctype="multipart/form-data" class="divide-y divide-slate-100">
                <?php echo csrf_field(); ?>

                <div class="space-y-6 px-6 py-6">
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                        <h3 class="text-sm font-semibold text-slate-900">Data Import</h3>
                        <div class="mt-4 grid gap-4 sm:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Role <span class="text-red-600">*</span></label>
                                <select name="role" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                    <option value="">Pilih Role</option>
                                    <option value="admin" <?php echo e(old('role') == 'admin' ? 'selected' : ''); ?>>Admin</option>
                                    <option value="fasilitator" <?php echo e(old('role') == 'fasilitator' ? 'selected' : ''); ?>>Fasilitator</option>
                                    <option value="peserta" <?php echo e(old('role') == 'peserta' ? 'selected' : ''); ?>>Peserta</option>
                                </select>
                                <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700">File CSV <span class="text-red-600">*</span></label>
                                <input type="file" name="file" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm file:mr-2 file:rounded file:border-0 file:bg-sky-100 file:px-2 file:py-1 file:text-sm file:font-semibold file:text-sky-700 hover:file:bg-sky-200 <?php $__errorArgs = ['file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" accept=".csv" required>
                                <?php $__errorArgs = ['file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <p class="mt-1 text-xs text-slate-500">Format CSV (Comma Separated Values), Max 2MB</p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-xl border border-blue-200 bg-blue-50 p-4">
                        <h3 class="text-sm font-semibold text-slate-900">Panduan Format CSV</h3>
                        <div class="mt-3 space-y-2 text-sm text-slate-700">
                            <p><strong>Header (baris pertama):</strong></p>
                            <p class="font-mono bg-white p-2 rounded text-xs">nama_lengkap,nik,email</p>

                            <p class="mt-2"><strong>Keterangan Kolom:</strong></p>
                            <ul class="ml-4 space-y-1 list-disc">
                                <li><strong>nama_lengkap</strong> <span class="text-red-600">*</span>: Nama lengkap pengguna</li>
                                <li><strong>nik</strong>: Nomor Induk Kependudukan 16 digit (juga sebagai password)</li>
                                <li><strong>email</strong> <span class="text-red-600">*</span>: Email unik untuk login</li>
                            </ul>

                            <p class="mt-2"><strong>Contoh Data:</strong></p>
                            <p class="font-mono bg-white p-2 rounded text-xs">
                                nama_lengkap,nik,email<br>
                                John Doe,3201234567890123,john.doe@example.com<br>
                                Jane Smith,3301234567890123,jane.smith@example.com<br>
                                Ahmad Yani,,ahmad.yani@example.com
                            </p>

                            <p class="mt-2 text-xs text-slate-600">
                                <strong>Catatan:</strong> Jika NIK kosong, password default akan <code class="bg-white px-1">password123</code>.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 bg-slate-50 px-6 py-4">
                    <button type="button" @click="showImportModal = false" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-white">Batal</button>
                    <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v4a1 1 0 11-2 0V4H5v12h9v-3a1 1 0 112 0v4a1 1 0 01-1 1H4a1 1 0 01-1-1V3zm7 5a1 1 0 011 1v1h2a1 1 0 110 2h-2v1a1 1 0 11-2 0v-1H6a1 1 0 110-2h2V9a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Backdrop -->
<div x-show="showImportModal" @click="showImportModal = false" class="fixed inset-0 z-40 bg-black bg-opacity-50" style="display: none;"></div>
<?php /**PATH C:\laragon\www\LMS\resources\views/super-admin/users/partials/import-modal.blade.php ENDPATH**/ ?>