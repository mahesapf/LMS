<?php if(isset($editUser)): ?>
<div x-show="showEditModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" @keydown.escape.window="showEditModal = false">
    <div class="fixed inset-0 bg-slate-900/70" @click="showEditModal = false"></div>
    <div class="relative z-10 flex min-h-screen items-center justify-center p-4">
        <div @click.away="showEditModal = false" class="relative w-full max-w-5xl overflow-hidden rounded-2xl bg-white shadow-2xl ring-1 ring-slate-200 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Formulir</p>
                <h2 class="text-lg font-semibold text-slate-900">Edit Pengguna</h2>
            </div>
            <button type="button" class="rounded-md p-2 text-slate-500 hover:bg-slate-100" @click="showEditModal = false">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form method="POST" action="<?php echo e(route('super-admin.users.update', $editUser)); ?>" enctype="multipart/form-data" class="divide-y divide-slate-100">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="space-y-6 px-6 py-6">
                <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                    <h3 class="text-sm font-semibold text-slate-900">Data Akun</h3>
                    <div class="mt-4 grid gap-4 sm:grid-cols-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Email <span class="text-red-600">*</span></label>
                            <input type="email" name="email" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('email', $editUser->email)); ?>" required>
                            <?php $__errorArgs = ['email'];
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
                            <label class="block text-sm font-medium text-slate-700">Password</label>
                            <input type="password" name="password" placeholder="Kosongkan jika tidak diubah" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <?php $__errorArgs = ['password'];
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
                                <option value="admin" <?php echo e(old('role', $editUser->role) == 'admin' ? 'selected' : ''); ?>>Admin</option>
                                <option value="fasilitator" <?php echo e(old('role', $editUser->role) == 'fasilitator' ? 'selected' : ''); ?>>Fasilitator</option>
                                <option value="peserta" <?php echo e(old('role', $editUser->role) == 'peserta' ? 'selected' : ''); ?>>Peserta</option>
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
                            <label class="block text-sm font-medium text-slate-700">Status <span class="text-red-600">*</span></label>
                            <select name="status" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                <option value="active" <?php echo e(old('status', $editUser->status) == 'active' ? 'selected' : ''); ?>>Active</option>
                                <option value="suspended" <?php echo e(old('status', $editUser->status) == 'suspended' ? 'selected' : ''); ?>>Suspended</option>
                                <option value="inactive" <?php echo e(old('status', $editUser->status) == 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                            </select>
                            <?php $__errorArgs = ['status'];
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
                    </div>
                </div>

                <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                    <h3 class="text-sm font-semibold text-slate-900">Data Pribadi</h3>
                    <div class="mt-4 grid gap-4 sm:grid-cols-3">
                        <div>
                            <label class="block text-sm font-medium text-slate-700">NIK</label>
                            <input type="text" name="nik" maxlength="16" pattern="[0-9]{16}" placeholder="16 digit NIK" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm <?php $__errorArgs = ['nik'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('nik', $editUser->nik)); ?>">
                            <?php $__errorArgs = ['nik'];
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
                            <label class="block text-sm font-medium text-slate-700">Nama Lengkap <span class="text-red-600">*</span></label>
                            <input type="text" name="name" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('name', $editUser->name)); ?>" required>
                            <?php $__errorArgs = ['name'];
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
                            <label class="block text-sm font-medium text-slate-700">Gelar</label>
                            <input type="text" name="gelar" placeholder="S.Pd, M.Pd" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm <?php $__errorArgs = ['gelar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('gelar', $editUser->gelar)); ?>">
                            <?php $__errorArgs = ['gelar'];
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
                            <label class="block text-sm font-medium text-slate-700">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm <?php $__errorArgs = ['jenis_kelamin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value="">Pilih</option>
                                <option value="Laki-laki" <?php echo e(old('jenis_kelamin', $editUser->jenis_kelamin) == 'Laki-laki' ? 'selected' : ''); ?>>Laki-laki</option>
                                <option value="Perempuan" <?php echo e(old('jenis_kelamin', $editUser->jenis_kelamin) == 'Perempuan' ? 'selected' : ''); ?>>Perempuan</option>
                            </select>
                            <?php $__errorArgs = ['jenis_kelamin'];
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
                            <label class="block text-sm font-medium text-slate-700">No HP</label>
                            <input type="text" name="no_hp" placeholder="08xxxxxxxxxx" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm <?php $__errorArgs = ['no_hp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('no_hp', $editUser->no_hp)); ?>">
                            <?php $__errorArgs = ['no_hp'];
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
                            <label class="block text-sm font-medium text-slate-700">Email Belajar.id</label>
                            <input type="email" name="email_belajar_id" placeholder="nama@belajar.id" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm <?php $__errorArgs = ['email_belajar_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('email_belajar_id', $editUser->email_belajar_id)); ?>">
                            <?php $__errorArgs = ['email_belajar_id'];
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
                    </div>
                </div>

                <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                    <h3 class="text-sm font-semibold text-slate-900">Data Kepegawaian</h3>
                    <div class="mt-4 grid gap-4 sm:grid-cols-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Jabatan</label>
                            <input type="text" name="jabatan" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm <?php $__errorArgs = ['jabatan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('jabatan', $editUser->jabatan)); ?>">
                            <?php $__errorArgs = ['jabatan'];
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
                            <label class="block text-sm font-medium text-slate-700">NIP/NIPY</label>
                            <input type="text" name="nip_nipy" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm <?php $__errorArgs = ['nip_nipy'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('nip_nipy', $editUser->nip_nipy)); ?>">
                            <?php $__errorArgs = ['nip_nipy'];
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
                            <label class="block text-sm font-medium text-slate-700">Pangkat</label>
                            <input type="text" name="pangkat" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm <?php $__errorArgs = ['pangkat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('pangkat', $editUser->pangkat)); ?>">
                            <?php $__errorArgs = ['pangkat'];
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
                            <label class="block text-sm font-medium text-slate-700">Golongan</label>
                            <input type="text" name="golongan" placeholder="III/c" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm <?php $__errorArgs = ['golongan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('golongan', $editUser->golongan)); ?>">
                            <?php $__errorArgs = ['golongan'];
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
                    </div>
                </div>

                <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                    <h3 class="text-sm font-semibold text-slate-900">Data Instansi/Sekolah</h3>
                    <div class="mt-4 grid gap-4 sm:grid-cols-3">
                        <div>
                            <label class="block text-sm font-medium text-slate-700">NPSN</label>
                            <input type="text" name="npsn" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm <?php $__errorArgs = ['npsn'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('npsn', $editUser->npsn)); ?>">
                            <?php $__errorArgs = ['npsn'];
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
                            <label class="block text-sm font-medium text-slate-700">Instansi/Nama Sekolah</label>
                            <input type="text" name="instansi" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm <?php $__errorArgs = ['instansi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('instansi', $editUser->instansi)); ?>">
                            <?php $__errorArgs = ['instansi'];
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
                            <label class="block text-sm font-medium text-slate-700">KCD</label>
                            <input type="text" name="kcd" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm <?php $__errorArgs = ['kcd'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('kcd', $editUser->kcd)); ?>">
                            <?php $__errorArgs = ['kcd'];
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
                    </div>
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-slate-700">Alamat Sekolah</label>
                        <textarea name="alamat_sekolah" rows="2" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm <?php $__errorArgs = ['alamat_sekolah'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('alamat_sekolah', $editUser->alamat_sekolah)); ?></textarea>
                        <?php $__errorArgs = ['alamat_sekolah'];
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
                </div>

                <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                    <h3 class="text-sm font-semibold text-slate-900">Alamat Domisili</h3>
                    <div class="mt-4 grid gap-4 sm:grid-cols-3">
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Provinsi</label>
                            <select name="provinsi_peserta" id="provinsi_edit" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm <?php $__errorArgs = ['provinsi_peserta'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" onchange="updateCities(this, document.getElementById('kabupaten_kota_edit'), document.getElementById('kecamatan_edit'))">
                                <option value="">Pilih Provinsi</option>
                                <option value="Jawa Barat" <?php echo e(old('provinsi_peserta', $editUser->provinsi_peserta) == 'Jawa Barat' ? 'selected' : ''); ?>>Jawa Barat</option>
                                <option value="Bengkulu" <?php echo e(old('provinsi_peserta', $editUser->provinsi_peserta) == 'Bengkulu' ? 'selected' : ''); ?>>Bengkulu</option>
                                <option value="Lampung" <?php echo e(old('provinsi_peserta', $editUser->provinsi_peserta) == 'Lampung' ? 'selected' : ''); ?>>Lampung</option>
                            </select>
                            <?php $__errorArgs = ['provinsi_peserta'];
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
                            <label class="block text-sm font-medium text-slate-700">Kabupaten/Kota</label>
                            <select name="kabupaten_kota" id="kabupaten_kota_edit" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm <?php $__errorArgs = ['kabupaten_kota'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" onchange="updateDistricts(document.getElementById('provinsi_edit'), this, document.getElementById('kecamatan_edit'))">
                                <option value="">Pilih Kabupaten/Kota</option>
                            </select>
                            <?php $__errorArgs = ['kabupaten_kota'];
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
                            <label class="block text-sm font-medium text-slate-700">Kecamatan</label>
                            <select name="kecamatan" id="kecamatan_edit" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm <?php $__errorArgs = ['kecamatan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value="">Pilih Kecamatan</option>
                            </select>
                            <?php $__errorArgs = ['kecamatan'];
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
                    </div>
                    <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const editProvince = document.getElementById('provinsi_edit');
                        const editCity = document.getElementById('kabupaten_kota_edit');
                        const editDistrict = document.getElementById('kecamatan_edit');

                        if (editProvince && ("<?php echo e(old('provinsi_peserta', $editUser->provinsi_peserta)); ?>" || "<?php echo e($editUser->province); ?>")) {
                            updateCities(editProvince, editCity, editDistrict);
                            const savedCity = "<?php echo e(old('kabupaten_kota', $editUser->kabupaten_kota)); ?>" || "<?php echo e($editUser->city); ?>";
                            if (savedCity) {
                                setTimeout(() => {
                                    editCity.value = savedCity;
                                    updateDistricts(editProvince, editCity, editDistrict);
                                    const savedDistrict = "<?php echo e(old('kecamatan', $editUser->kecamatan)); ?>" || "<?php echo e($editUser->district); ?>";
                                    if (savedDistrict) {
                                        setTimeout(() => {
                                            editDistrict.value = savedDistrict;
                                        }, 100);
                                    }
                                }, 100);
                            }
                        }
                    });
                    </script>
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-slate-700">Alamat Lengkap</label>
                        <textarea name="alamat_lengkap" rows="2" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm <?php $__errorArgs = ['alamat_lengkap'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('alamat_lengkap', $editUser->alamat_lengkap)); ?></textarea>
                        <?php $__errorArgs = ['alamat_lengkap'];
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
                </div>

                <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                    <h3 class="text-sm font-semibold text-slate-900">Riwayat Pendidikan</h3>
                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Pendidikan Terakhir</label>
                            <select name="pendidikan_terakhir" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm <?php $__errorArgs = ['pendidikan_terakhir'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value="">Pilih</option>
                                <option value="SMA/SMK" <?php echo e(old('pendidikan_terakhir', $editUser->pendidikan_terakhir) == 'SMA/SMK' ? 'selected' : ''); ?>>SMA/SMK</option>
                                <option value="D3" <?php echo e(old('pendidikan_terakhir', $editUser->pendidikan_terakhir) == 'D3' ? 'selected' : ''); ?>>D3</option>
                                <option value="S1" <?php echo e(old('pendidikan_terakhir', $editUser->pendidikan_terakhir) == 'S1' ? 'selected' : ''); ?>>S1</option>
                                <option value="S2" <?php echo e(old('pendidikan_terakhir', $editUser->pendidikan_terakhir) == 'S2' ? 'selected' : ''); ?>>S2</option>
                                <option value="S3" <?php echo e(old('pendidikan_terakhir', $editUser->pendidikan_terakhir) == 'S3' ? 'selected' : ''); ?>>S3</option>
                            </select>
                            <?php $__errorArgs = ['pendidikan_terakhir'];
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
                            <label class="block text-sm font-medium text-slate-700">Jurusan</label>
                            <input type="text" name="jurusan" class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm <?php $__errorArgs = ['jurusan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('jurusan', $editUser->jurusan)); ?>">
                            <?php $__errorArgs = ['jurusan'];
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
                    </div>
                </div>

                <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                    <h3 class="text-sm font-semibold text-slate-900">Upload Dokumen</h3>
                    <div class="mt-4 grid gap-4 sm:grid-cols-3">
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Foto 3x4</label>
                            <?php if($editUser->foto_3x4): ?>
                                <div class="mb-2">
                                    <img src="<?php echo e(Storage::url($editUser->foto_3x4)); ?>" alt="Foto" class="h-24 w-auto rounded border">
                                    <p class="mt-1 text-xs text-slate-600">File saat ini</p>
                                </div>
                            <?php endif; ?>
                            <input type="file" name="foto_3x4" accept="image/*" class="mt-1 w-full rounded-lg border border-dashed border-slate-300 px-3 py-2 text-sm <?php $__errorArgs = ['foto_3x4'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <p class="mt-1 text-xs text-slate-500">Max 2MB</p>
                            <?php $__errorArgs = ['foto_3x4'];
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
                            <label class="block text-sm font-medium text-slate-700">Surat Tugas</label>
                            <?php if($editUser->surat_tugas): ?>
                                <div class="mb-2">
                                    <a href="<?php echo e(Storage::url($editUser->surat_tugas)); ?>" target="_blank" class="text-xs text-sky-600 hover:underline">Lihat file saat ini →</a>
                                </div>
                            <?php endif; ?>
                            <input type="file" name="surat_tugas" accept=".pdf,.jpg,.jpeg,.png" class="mt-1 w-full rounded-lg border border-dashed border-slate-300 px-3 py-2 text-sm <?php $__errorArgs = ['surat_tugas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <p class="mt-1 text-xs text-slate-500">PDF/Gambar, Max 2MB</p>
                            <?php $__errorArgs = ['surat_tugas'];
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
                            <label class="block text-sm font-medium text-slate-700">Tanda Tangan Digital</label>
                            <?php if($editUser->tanda_tangan): ?>
                                <div class="mb-2">
                                    <img src="<?php echo e(Storage::url($editUser->tanda_tangan)); ?>" alt="TTD" class="h-16 w-auto rounded border bg-white">
                                    <p class="mt-1 text-xs text-slate-600">File saat ini</p>
                                </div>
                            <?php endif; ?>
                            <input type="file" name="tanda_tangan" accept="image/*" class="mt-1 w-full rounded-lg border border-dashed border-slate-300 px-3 py-2 text-sm <?php $__errorArgs = ['tanda_tangan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <p class="mt-1 text-xs text-slate-500">PNG, Max 1MB</p>
                            <?php $__errorArgs = ['tanda_tangan'];
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
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 bg-slate-50 px-6 py-4">
                <button type="button" @click="showEditModal = false" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-white">Batal</button>
                <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-sky-600 px-4 py-2 text-sm font-semibold text-white hover:bg-sky-700">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Update Pengguna
                </button>
            </div>
        </form>
    </div>
    </div>
</div>
<?php endif; ?>
<?php /**PATH C:\laragon\www\LMS\resources\views/super-admin/users/partials/edit-modal.blade.php ENDPATH**/ ?>