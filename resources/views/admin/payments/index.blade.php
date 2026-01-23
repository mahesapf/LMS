@extends('layouts.dashboard')

@section('title', 'Validasi Pembayaran')

@section('sidebar')
@include('super-admin.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6" x-data="{
    openHistoryId: null,
    openPendingId: null,
    showRejectModal: false,
    rejectPaymentId: null,
    rejectPaymentUrl: '',
    selectedSchools: [],
    selectAll: false,
    toggleAll() {
        if (this.selectAll) {
            this.selectedSchools = Array.from(document.querySelectorAll('.school-checkbox')).map(cb => parseInt(cb.value));
        } else {
            this.selectedSchools = [];
        }
    },
    toggleSchool(id) {
        if (this.selectedSchools.includes(id)) {
            this.selectedSchools = this.selectedSchools.filter(s => s !== id);
        } else {
            this.selectedSchools.push(id);
        }
        this.selectAll = this.selectedSchools.length === document.querySelectorAll('.school-checkbox').length;
    },
    exportSelected() {
        if (this.selectedSchools.length === 0) {
            alert('Pilih minimal satu data untuk diekspor');
            return;
        }
        
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route('super-admin.payments.export-selected') }}';
        
        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';
        form.appendChild(csrf);
        
        this.selectedSchools.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'school_ids[]';
            input.value = id;
            form.appendChild(input);
        });
        
        @if(request('activity_id'))
            const activityInput = document.createElement('input');
            activityInput.type = 'hidden';
            activityInput.name = 'activity_id';
            activityInput.value = '{{ request('activity_id') }}';
            form.appendChild(activityInput);
        @endif
        
        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    }
}">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Validasi Pembayaran</h1>
            <p class="mt-1 text-sm text-slate-500">Periksa bukti pembayaran, validasi atau tolak dengan alasan.</p>
        </div>
    </div>

    <!-- Pending Payments -->
    <div class="rounded-xl border border-orange-200 bg-white shadow-sm">
        <div class="border-b border-orange-200 bg-orange-50 px-4 py-3">
            <h2 class="text-sm font-semibold text-orange-800">Pembayaran Menunggu Validasi ({{ $payments->count() }})</h2>
        </div>
        <div class="p-4">
            @if($payments->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Tanggal Upload</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Sekolah</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Kegiatan</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Peserta</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Jumlah</th>
                                <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Tgl Bayar</th>
                                <th class="px-4 py-2 text-right text-xs font-semibold text-slate-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @foreach($payments as $payment)
                            @php
                                $totalPeserta = $payment->registration->jumlah_peserta > 0
                                    ? $payment->registration->jumlah_peserta
                                    : ($payment->registration->jumlah_kepala_sekolah + $payment->registration->jumlah_guru);
                            @endphp
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-2 text-sm text-slate-700">{{ $payment->created_at->format('d M Y H:i') }}</td>
                                <td class="px-4 py-2 text-sm">
                                    <div class="text-slate-900 font-semibold">{{ $payment->registration->nama_sekolah }}</div>
                                    <div class="text-xs text-slate-500">
                                        {{ $payment->registration->kecamatan ? $payment->registration->kecamatan . ', ' : '' }}{{ $payment->registration->kab_kota }}, {{ $payment->registration->provinsi }}
                                    </div>
                                </td>
                                <td class="px-4 py-2 text-sm text-slate-700">
                                    {{ $payment->registration->activity->name }}
                                    @if($payment->registration->activity->program)
                                        <div class="text-xs text-slate-500">{{ $payment->registration->activity->program->name }}</div>
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-sm text-slate-700">
                                    <span class="font-semibold">{{ $totalPeserta }}</span> orang
                                    <div class="text-xs text-slate-500">KS: {{ $payment->registration->jumlah_kepala_sekolah }}, Guru: {{ $payment->registration->jumlah_guru }}</div>
                                </td>
                                <td class="px-4 py-2 text-sm text-slate-700">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                <td class="px-4 py-2 text-sm text-slate-700">{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</td>
                                <td class="px-4 py-2 text-sm">
                                    <div class="flex items-center gap-1">
                                        <button @click="openPendingId = openPendingId === {{ $payment->id }} ? null : {{ $payment->id }}"
                                                class="inline-flex items-center rounded-md border border-sky-300 bg-white px-3 py-1.5 text-xs font-semibold text-sky-700 shadow-sm hover:bg-sky-50">
                                            <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Detail
                                        </button>
                                        <form action="{{ route('super-admin.payments.destroy', $payment) }}" method="POST" onsubmit="return confirm('Hapus pembayaran ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center rounded-md border border-red-300 bg-white px-3 py-1.5 text-xs font-semibold text-red-700 shadow-sm hover:bg-red-50">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <!-- Detail Row -->
                            <tr x-show="openPendingId === {{ $payment->id }}"
                                x-transition
                                class="bg-white border-b border-slate-200">
                                <td colspan="7" class="px-4 py-4">
                                    <div class="max-w-6xl space-y-4">
                                        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                                            <div>
                                                <p class="text-sm font-semibold text-slate-900">Detail Pembayaran</p>
                                                <p class="text-xs text-slate-500">Upload {{ $payment->created_at->format('d M Y H:i') }}</p>
                                            </div>
                                            <div class="flex items-center gap-1.5 w-fit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-orange-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                                </svg>
                                                <div class="flex flex-col">
                                                    <span class="text-xs font-medium text-orange-700">Pending</span>
                                                    <span class="text-[10px] text-orange-600">Menunggu validasi</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Summary Cards Row -->
                                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
                                            <div class="rounded-lg border border-slate-200 bg-white p-3">
                                                <p class="text-xs font-medium text-slate-500">Jumlah Transfer</p>
                                                <p class="mt-1 text-base font-semibold text-slate-900">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                                            </div>
                                            <div class="rounded-lg border border-slate-200 bg-white p-3">
                                                <p class="text-xs font-medium text-slate-500">Tanggal Transfer</p>
                                                <p class="mt-1 text-sm font-semibold text-slate-900">{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</p>
                                            </div>
                                            <div class="rounded-lg border border-slate-200 bg-white p-3">
                                                <p class="text-xs font-medium text-slate-500">Total Peserta</p>
                                                <p class="mt-1 text-sm font-semibold text-slate-900">{{ $totalPeserta }} orang</p>
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-1 gap-3 lg:grid-cols-5">
                                            <div class="lg:col-span-3">
                                                <!-- Info Grid -->
                                                <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                                                    <div class="rounded-lg border border-slate-200 bg-white p-3">
                                                        <h6 class="text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Sekolah</h6>
                                                        <div class="space-y-1.5 text-sm">
                                                            <p class="font-semibold text-slate-900">{{ $payment->registration->nama_sekolah }}</p>
                                                            <p class="text-xs text-slate-600">{{ $payment->registration->kecamatan ? $payment->registration->kecamatan . ', ' : '' }}{{ $payment->registration->kab_kota }}{{ $payment->registration->provinsi ? ', ' . $payment->registration->provinsi : '' }}</p>
                                                            <p class="text-xs text-slate-600">KS: {{ $payment->registration->nama_kepala_sekolah ?? '-' }}</p>
                                                        </div>
                                                    </div>

                                                    <div class="rounded-lg border border-slate-200 bg-white p-3">
                                                        <h6 class="text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Kegiatan</h6>
                                                        <div class="space-y-1.5 text-sm">
                                                            <p class="font-semibold text-slate-900">{{ $payment->registration->activity->name }}</p>
                                                            <p class="text-xs text-slate-600">Program: {{ $payment->registration->activity->program->name ?? '-' }}</p>
                                                            <p class="text-xs font-semibold text-emerald-700">Rp {{ number_format($payment->registration->activity->registration_fee, 0, ',', '.') }}/peserta</p>
                                                        </div>
                                                    </div>

                                                    <div class="rounded-lg border border-slate-200 bg-white p-3 md:col-span-2">
                                                        <h6 class="text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Peserta</h6>
                                                        <div class="space-y-1 text-xs">
                                                            @if($payment->registration->jumlah_kepala_sekolah > 0)
                                                                <p class="text-slate-700"><span class="font-semibold">KS:</span> {{ $payment->registration->jumlah_kepala_sekolah }} orang</p>
                                                            @endif
                                                            @if($payment->registration->jumlah_guru > 0 && $payment->registration->teacherParticipants->count() > 0)
                                                                <p class="text-slate-700"><span class="font-semibold">Guru:</span> {{ $payment->registration->teacherParticipants->count() }} orang</p>
                                                                <div class="mt-2 max-h-24 overflow-y-auto rounded bg-slate-50 p-2 text-xs text-slate-600">
                                                                    @foreach($payment->registration->teacherParticipants as $teacher)
                                                                        <div class="flex items-center justify-between gap-2">
                                                                            <p class="truncate">• {{ $teacher->nama_lengkap }}</p>
                                                                            @if(!empty($teacher->surat_tugas))
                                                                                <a href="{{ Storage::url($teacher->surat_tugas) }}" target="_blank" rel="noopener"
                                                                                   class="shrink-0 inline-flex items-center text-slate-500 hover:text-slate-800"
                                                                                   title="Lihat Surat Tugas" aria-label="Lihat Surat Tugas">
                                                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                                                    </svg>
                                                                                </a>
                                                                            @endif
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="lg:col-span-2">
                                                <!-- Proof Image (if exists) -->
                                                @if($payment->proof_file)
                                                <div class="rounded-lg border border-slate-200 bg-white p-3">
                                                    <h6 class="text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Bukti Pembayaran</h6>
                                                    <a href="{{ Storage::url($payment->proof_file) }}" target="_blank" rel="noopener" class="block">
                                                        <img src="{{ Storage::url($payment->proof_file) }}" alt="Bukti Transfer" class="w-full max-h-72 object-contain rounded border border-slate-200 bg-slate-50">
                                                    </a>
                                                    <p class="mt-2 text-xs text-slate-500">Klik gambar untuk membuka ukuran penuh.</p>
                                                </div>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="flex flex-col sm:flex-row gap-2 justify-end pt-2 border-t border-slate-200">
                                            <button type="button"
                                                    @click="showRejectModal = true; rejectPaymentId = {{ $payment->id }}; rejectPaymentUrl = '{{ route('super-admin.payments.reject', $payment) }}'"
                                                    class="inline-flex items-center justify-center gap-2 rounded-lg border border-red-300 bg-white px-4 py-2 text-sm font-semibold text-red-700 hover:bg-red-50 transition">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                Tolak
                                            </button>
                                            <form action="{{ route('super-admin.payments.approve', $payment) }}" method="POST" class="flex-1 sm:flex-none">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700 transition"
                                                        onclick="return confirm('Validasi pembayaran ini?')">
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    Validasi
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-sm text-slate-500">Tidak ada pembayaran yang menunggu validasi.</p>
            @endif
        </div>
    </div>

    <!-- History -->
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 bg-slate-50 px-4 py-3">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-sm font-semibold text-slate-800">Riwayat Validasi</h2>
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:gap-2">
                    <form method="GET" action="{{ route('super-admin.payments.index') }}" class="flex flex-1 flex-col gap-2 sm:flex-row sm:items-end sm:gap-2">
                        <div class="flex-1">
                            <label class="mb-1 hidden text-xs font-medium text-slate-600">Filter Kegiatan</label>
                            <select name="activity_id" id="activity_filter"
                                    class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 shadow-sm transition focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500/20"
                                    onchange="this.form.submit()">
                                <option value="">Semua Kegiatan</option>
                                @foreach($activities as $activity)
                                <option value="{{ $activity->id }}" {{ request('activity_id') == $activity->id ? 'selected' : '' }}>
                                    {{ $activity->name }}
                                    @if($activity->program)
                                        - {{ $activity->program->name }}
                                    @endif
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @if(request('activity_id'))
                        <a href="{{ route('super-admin.payments.index') }}"
                           class="inline-flex items-center rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                            <svg class="mr-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Reset
                        </a>
                        @endif
                    </form>
                    <button type="button" 
                            @click="exportSelected()"
                            class="inline-flex items-center rounded-lg border border-emerald-300 bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700 disabled:opacity-50 disabled:cursor-not-allowed"
                            :disabled="selectedSchools.length === 0">
                        <svg class="mr-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Export CSV (<span x-text="selectedSchools.length">0</span>)
                    </button>
                    <form method="GET" action="{{ route('super-admin.payments.export-participants') }}" class="flex-shrink-0">
                        @if(request('activity_id'))
                            <input type="hidden" name="activity_id" value="{{ request('activity_id') }}">
                        @endif
                        <button type="submit" class="inline-flex items-center rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                            <svg class="mr-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Export Semua
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="p-4">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-2 text-left">
                                <input type="checkbox"
                                       x-model="selectAll"
                                       @change="toggleAll()"
                                       class="rounded border-slate-300 text-sky-600 focus:ring-sky-500">
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Tanggal Validasi</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Sekolah</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Kegiatan</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Peserta</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Jumlah</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Status</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Validator</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse($validatedPayments as $payment)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-2">
                                <input type="checkbox"
                                       class="school-checkbox rounded border-slate-300 text-sky-600 focus:ring-sky-500"
                                       :checked="selectedSchools.includes({{ $payment->id }})"
                                       @change="toggleSchool({{ $payment->id }})"
                                       value="{{ $payment->id }}">
                            </td>
                            <td class="px-4 py-2 text-sm text-slate-700">{{ $payment->validated_at->format('d M Y H:i') }}</td>
                            <td class="px-4 py-2 text-sm">
                                <div class="text-slate-900 font-semibold">{{ $payment->registration->nama_sekolah }}</div>
                                <div class="text-xs text-slate-500">
                                    {{ $payment->registration->kecamatan ? $payment->registration->kecamatan . ', ' : '' }}{{ $payment->registration->kab_kota }}{{ $payment->registration->provinsi ? ', ' . $payment->registration->provinsi : '' }}
                                </div>
                            </td>
                            <td class="px-4 py-2 text-sm text-slate-700">
                                {{ $payment->registration->activity->name }}
                                @if($payment->registration->activity->program)
                                    <div class="text-xs text-slate-500">{{ $payment->registration->activity->program->name }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-sm text-slate-700">
                                @php
                                    $totalPeserta = $payment->registration->jumlah_peserta > 0
                                        ? $payment->registration->jumlah_peserta
                                        : ($payment->registration->jumlah_kepala_sekolah + $payment->registration->jumlah_guru);
                                @endphp
                                {{ $totalPeserta }} orang
                            </td>
                            <td class="px-4 py-2 text-sm text-slate-700">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 text-sm">
                                <div class="flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#0284c7] flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <div class="flex flex-col">
                                        <span class="text-xs font-medium text-[#0284c7]">Tervalidasi</span>
                                        <span class="text-[10px] text-sky-600">Sudah disetujui</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-2 text-sm text-slate-700">{{ $payment->validator->name ?? '-' }}</td>
                            <td class="px-4 py-2 text-sm">
                                <div class="flex items-center gap-1">
                                    <button @click="openHistoryId = openHistoryId === {{ $payment->id }} ? null : {{ $payment->id }}"
                                            class="inline-flex items-center rounded-md border border-sky-300 bg-white px-2.5 py-1.5 text-xs font-semibold text-sky-700 shadow-sm hover:bg-sky-50">
                                        <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Detail
                                    </button>
                                    <form action="{{ route('super-admin.payments.destroy', $payment) }}" method="POST" onsubmit="return confirm('Hapus pembayaran ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center rounded-md border border-red-300 bg-white px-2.5 py-1.5 text-xs font-semibold text-red-700 shadow-sm hover:bg-red-50">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Detail Row -->
                        <tr x-show="openHistoryId === {{ $payment->id }}"
                            x-transition
                            class="bg-white border-b border-slate-200">
                            <td colspan="9" class="px-4 py-4">
                                <div class="max-w-6xl space-y-4">
                                    <!-- Status Banner -->
                                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between rounded-lg border border-emerald-200 bg-emerald-50 p-3">
                                        <div class="flex items-center gap-2">
                                            <svg class="h-5 w-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                            <p class="text-sm font-semibold text-emerald-900">Tervalidasi</p>
                                        </div>
                                        <p class="text-xs text-emerald-800">{{ $payment->validated_at->format('d M Y H:i') }} oleh {{ $payment->validator->name ?? '-' }}</p>
                                    </div>

                                    <!-- Summary Cards -->
                                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-4">
                                        <div class="rounded-lg border border-slate-200 bg-white p-3">
                                            <p class="text-xs font-medium text-slate-500">Jumlah Transfer</p>
                                            <p class="mt-1 text-base font-semibold text-slate-900">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                                        </div>
                                        <div class="rounded-lg border border-slate-200 bg-white p-3">
                                            <p class="text-xs font-medium text-slate-500">Tanggal Bayar</p>
                                            <p class="mt-1 text-sm font-semibold text-slate-900">{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</p>
                                        </div>
                                        <div class="rounded-lg border border-slate-200 bg-white p-3">
                                            <p class="text-xs font-medium text-slate-500">Total Peserta</p>
                                            <p class="mt-1 text-sm font-semibold text-slate-900">{{ $totalPeserta }} orang</p>
                                        </div>
                                        <div class="rounded-lg border border-slate-200 bg-white p-3">
                                            <p class="text-xs font-medium text-slate-500">Upload</p>
                                            <p class="mt-1 text-xs font-semibold text-slate-900">{{ $payment->created_at->format('d M Y H:i') }}</p>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 gap-3 lg:grid-cols-5">
                                        <div class="lg:col-span-3">
                                            <!-- Info Grid -->
                                            <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                                                <div class="rounded-lg border border-slate-200 bg-white p-3">
                                                    <h6 class="text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Sekolah</h6>
                                                    <div class="space-y-1 text-sm">
                                                        <p class="font-semibold text-slate-900">{{ $payment->registration->nama_sekolah }}</p>
                                                        <p class="text-xs text-slate-600">{{ $payment->registration->kecamatan ? $payment->registration->kecamatan . ', ' : '' }}{{ $payment->registration->kab_kota }}{{ $payment->registration->provinsi ? ', ' . $payment->registration->provinsi : '' }}</p>
                                                        <p class="text-xs text-slate-600">KS: {{ $payment->registration->nama_kepala_sekolah ?? '-' }}</p>
                                                    </div>
                                                </div>

                                                <div class="rounded-lg border border-slate-200 bg-white p-3">
                                                    <h6 class="text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Kegiatan</h6>
                                                    <div class="space-y-1 text-sm">
                                                        <p class="font-semibold text-slate-900">{{ $payment->registration->activity->name }}</p>
                                                        <p class="text-xs text-slate-600">{{ $payment->registration->activity->program->name ?? '-' }}</p>
                                                        @if($payment->registration->classes)
                                                        <p class="text-xs text-slate-600">Kelas: {{ $payment->registration->classes->name }}</p>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="rounded-lg border border-slate-200 bg-white p-3 md:col-span-2">
                                                    <h6 class="text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Peserta</h6>
                                                    <div class="space-y-1 text-xs">
                                                        @if($payment->registration->jumlah_kepala_sekolah > 0)
                                                        <p class="text-slate-700"><span class="font-semibold">KS:</span> {{ $payment->registration->jumlah_kepala_sekolah }} orang</p>
                                                        @endif
                                                        @if($payment->registration->teacherParticipants->count() > 0)
                                                        <p class="text-slate-700"><span class="font-semibold">Guru:</span> {{ $payment->registration->teacherParticipants->count() }} orang</p>
                                                        <div class="mt-2 max-h-24 overflow-y-auto rounded bg-slate-50 p-2 text-xs text-slate-600">
                                                            @foreach($payment->registration->teacherParticipants as $teacher)
                                                            <div class="flex items-center justify-between gap-2">
                                                                <p class="truncate">• {{ $teacher->nama_lengkap }}</p>
                                                                @if(!empty($teacher->surat_tugas))
                                                                <a href="{{ Storage::url($teacher->surat_tugas) }}" target="_blank" rel="noopener"
                                                                   class="shrink-0 inline-flex items-center text-slate-500 hover:text-slate-800"
                                                                   title="Lihat Surat Tugas" aria-label="Lihat Surat Tugas">
                                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                                    </svg>
                                                                </a>
                                                                @endif
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="lg:col-span-2">
                                            <!-- Proof Image -->
                                            @if($payment->proof_file)
                                            <div class="rounded-lg border border-slate-200 bg-white p-3">
                                                <h6 class="text-xs font-semibold text-slate-600 uppercase tracking-wider mb-2">Bukti Pembayaran</h6>
                                                <a href="{{ Storage::url($payment->proof_file) }}" target="_blank" rel="noopener" class="block">
                                                    <img src="{{ Storage::url($payment->proof_file) }}" alt="Bukti Transfer" class="w-full max-h-72 object-contain rounded border border-slate-200 bg-slate-50">
                                                </a>
                                                <p class="mt-2 text-xs text-slate-500">Klik gambar untuk membuka ukuran penuh.</p>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="8" class="px-4 py-6 text-center text-sm text-slate-500">Belum ada riwayat validasi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $validatedPayments->links() }}</div>
        </div>
    </div>

    <!-- Reject Modal (Alpine.js) -->

    <div x-show="showRejectModal"
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="modal-title"
         role="dialog"
         aria-modal="true">
        <div class="flex min-h-screen items-end justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div x-show="showRejectModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity"
                 @click="showRejectModal = false"></div>

            <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>

            <!-- Modal panel -->
            <div x-show="showRejectModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block transform overflow-hidden rounded-xl bg-white text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:align-middle">

                <form :action="rejectPaymentUrl" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="bg-white px-6 pt-5 pb-4">
                        <div class="flex items-start justify-between pb-3 border-b border-slate-200">
                            <h3 class="text-lg font-semibold text-slate-900" id="modal-title">Tolak Pembayaran</h3>
                            <button type="button" @click="showRejectModal = false" class="rounded-md text-slate-400 hover:text-slate-500">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div class="mt-4">
                            <label for="rejection_reason" class="block text-sm font-medium text-slate-700 mb-2">
                                Alasan Penolakan <span class="text-red-600">*</span>
                            </label>
                            <textarea id="rejection_reason"
                                      name="rejection_reason"
                                      rows="4"
                                      required
                                      class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-rose-500 focus:ring-rose-500"
                                      placeholder="Masukkan alasan penolakan pembayaran..."></textarea>
                        </div>
                    </div>

                    <div class="bg-slate-50 px-6 py-3 flex justify-end gap-2">
                        <button type="button"
                                @click="showRejectModal = false"
                                class="inline-flex items-center rounded-lg bg-white border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                            Batal
                        </button>
                        <button type="submit"
                                class="inline-flex items-center rounded-lg bg-rose-600 px-4 py-2 text-sm font-semibold text-white hover:bg-rose-700">
                            <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Tolak Pembayaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
[x-cloak] { display: none !important; }
</style>
@endsection
