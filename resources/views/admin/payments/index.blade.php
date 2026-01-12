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
    }
}">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Validasi Pembayaran</h1>
            <p class="mt-1 text-sm text-slate-500">Periksa bukti pembayaran, validasi atau tolak dengan alasan.</p>
        </div>
    </div>

    <!-- Pending Payments -->
    <div class="rounded-xl border border-amber-200 bg-white shadow-sm">
        <div class="border-b border-amber-200 bg-amber-50 px-4 py-3">
            <h2 class="text-sm font-semibold text-amber-800">Pembayaran Menunggu Validasi ({{ $payments->count() }})</h2>
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
                                    <button @click="openPendingId = openPendingId === {{ $payment->id }} ? null : {{ $payment->id }}"
                                            class="inline-flex items-center rounded-md border border-sky-300 bg-white px-3 py-1.5 text-xs font-semibold text-sky-700 shadow-sm hover:bg-sky-50">
                                        <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Detail
                                    </button>
                                </td>
                            </tr>

                            <!-- Detail Row -->
                            <tr x-show="openPendingId === {{ $payment->id }}"
                                x-transition
                                class="bg-slate-50">
                                <td colspan="7" class="px-4 py-6">
                                    <div class="space-y-5">
                                        <!-- Top: Amount & Date Cards -->
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div class="p-4 rounded-xl bg-gradient-to-br from-amber-50 to-amber-100 border border-amber-200">
                                                <p class="text-xs font-medium text-amber-700 mb-1">Jumlah Transfer</p>
                                                <p class="text-2xl font-bold text-amber-900">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                                            </div>
                                            <div class="p-4 rounded-xl bg-gradient-to-br from-sky-50 to-sky-100 border border-sky-200">
                                                <p class="text-xs font-medium text-sky-700 mb-1">Tanggal Transfer</p>
                                                <p class="text-lg font-semibold text-sky-900">{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</p>
                                            </div>
                                        </div>

                                        <!-- School & Activity Info -->
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div class="p-4 rounded-lg border border-slate-200 bg-white">
                                                <h6 class="text-sm font-semibold text-slate-900 mb-3 flex items-center">
                                                    <svg class="h-5 w-5 mr-2 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                    </svg>
                                                    Sekolah
                                                </h6>
                                                <div class="space-y-2">
                                                    <div>
                                                        <p class="text-xs font-medium text-slate-500">Nama</p>
                                                        <p class="text-sm font-semibold text-slate-900">{{ $payment->registration->nama_sekolah }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="text-xs font-medium text-slate-500">Lokasi</p>
                                                        <p class="text-sm text-slate-900">
                                                            {{ $payment->registration->kecamatan ? $payment->registration->kecamatan . ', ' : '' }}{{ $payment->registration->kab_kota }}, {{ $payment->registration->provinsi }}
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <p class="text-xs font-medium text-slate-500">Kepala Sekolah</p>
                                                        <p class="text-sm font-semibold text-slate-900">{{ $payment->registration->nama_kepala_sekolah ?? '-' }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="text-xs font-medium text-slate-500">KCD</p>
                                                        <p class="text-sm text-slate-900">{{ $payment->registration->kcd ?? '-' }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="p-4 rounded-lg border border-slate-200 bg-white">
                                                <h6 class="text-sm font-semibold text-slate-900 mb-3 flex items-center">
                                                    <svg class="h-5 w-5 mr-2 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    Kegiatan
                                                </h6>
                                                <div class="space-y-2">
                                                    <div>
                                                        <p class="text-xs font-medium text-slate-500">Program</p>
                                                        <p class="text-sm font-semibold text-slate-900">{{ $payment->registration->activity->program->name ?? '-' }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="text-xs font-medium text-slate-500">Nama Kegiatan</p>
                                                        <p class="text-sm font-semibold text-slate-900">{{ $payment->registration->activity->name }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="text-xs font-medium text-slate-500">Biaya & Peserta</p>
                                                        <p class="text-sm text-slate-900">Rp {{ number_format($payment->registration->activity->registration_fee, 0, ',', '.') }} × {{ $totalPeserta }} orang</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Participants Summary -->
                                        <div class="p-4 rounded-lg border border-slate-200 bg-white">
                                            <h6 class="text-sm font-semibold text-slate-900 mb-3 flex items-center">
                                                <svg class="h-5 w-5 mr-2 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                                Daftar Peserta
                                            </h6>
                                            <div class="space-y-2">
                                                @if($payment->registration->jumlah_kepala_sekolah > 0)
                                                <div class="flex items-center justify-between p-3 rounded-lg bg-emerald-50 border border-emerald-200">
                                                    <div>
                                                        <p class="text-sm font-semibold text-emerald-900">{{ $payment->registration->kepala_sekolah }}</p>
                                                        <p class="text-xs text-emerald-700">Kepala Sekolah</p>
                                                    </div>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-200 text-emerald-800">1</span>
                                                </div>
                                                @endif
                                                @if($payment->registration->teacherParticipants->count() > 0)
                                                <div class="p-3 rounded-lg bg-sky-50 border border-sky-200">
                                                    <div class="flex items-center justify-between mb-2">
                                                        <p class="text-sm font-semibold text-sky-900">Guru-Guru</p>
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-sky-200 text-sky-800">{{ $payment->registration->teacherParticipants->count() }}</span>
                                                    </div>
                                                    <div class="space-y-1">
                                                        @foreach($payment->registration->teacherParticipants as $teacher)
                                                        <p class="text-xs text-sky-700">• {{ $teacher->nama_lengkap }}</p>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Proof Image -->
                                        @if($payment->proof_file)
                                        <div class="p-4 rounded-lg border border-slate-200 bg-white">
                                            <h6 class="text-sm font-semibold text-slate-900 mb-3 flex items-center">
                                                <svg class="h-5 w-5 mr-2 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                Bukti Pembayaran
                                            </h6>
                                            <img src="{{ Storage::url($payment->proof_file) }}" alt="Bukti Transfer" class="rounded border border-slate-300 shadow-sm w-full max-h-80 object-contain">
                                        </div>
                                        @endif

                                        <!-- Action Buttons -->
                                        <div class="flex gap-3 justify-end pt-2 border-t border-slate-200">
                                            <form action="{{ route('super-admin.payments.approve', $payment) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 shadow-sm"
                                                        onclick="return confirm('Apakah Anda yakin ingin memvalidasi pembayaran ini?')">
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    Validasi
                                                </button>
                                            </form>
                                            <button type="button"
                                                    @click="showRejectModal = true; rejectPaymentId = {{ $payment->id }}; rejectPaymentUrl = '{{ route('super-admin.payments.reject', $payment) }}'"
                                                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-rose-600 rounded-lg hover:bg-rose-700 shadow-sm">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                Tolak
                                            </button>
                                        </div>
                                    </div>
                                </td>
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
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-semibold text-slate-800">Riwayat Validasi</h2>
                <div class="flex items-center gap-2">
                    <form method="GET" action="{{ route('super-admin.payments.index') }}" class="flex items-center gap-2">
                        <select name="activity_id" id="activity_filter"
                                class="form-select form-select-sm border-slate-300 rounded-md text-sm"
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
                        @if(request('activity_id'))
                        <a href="{{ route('super-admin.payments.index') }}"
                           class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-slate-600 bg-white border border-slate-300 rounded-md hover:bg-slate-50">
                            <svg class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Reset
                        </a>
                        @endif
                    </form>

                    <!-- Bulk Export by Selected Schools -->
                    <div class="flex items-center gap-2">
                        <button @click="if(selectedSchools.length === 0) { alert('Pilih minimal 1 sekolah untuk di ekspor'); return; }
                                        const form = document.createElement('form');
                                        form.method = 'POST';
                                        form.action = '{{ route('super-admin.payments.export-by-schools') }}';
                                        const csrf = document.createElement('input');
                                        csrf.type = 'hidden';
                                        csrf.name = '_token';
                                        csrf.value = '{{ csrf_token() }}';
                                        form.appendChild(csrf);
                                        selectedSchools.forEach(id => {
                                            const input = document.createElement('input');
                                            input.type = 'hidden';
                                            input.name = 'school_ids[]';
                                            input.value = id;
                                            form.appendChild(input);
                                        });
                                        document.body.appendChild(form);
                                        form.submit();"
                                x-show="selectedSchools.length > 0"
                                class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-white bg-sky-600 rounded-md hover:bg-sky-700 shadow-sm">
                            <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Ekspor Terpilih (<span x-text="selectedSchools.length"></span>)
                        </button>

                        <a href="{{ route('super-admin.payments.export-participants', ['activity_id' => request('activity_id')]) }}"
                           class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-white bg-emerald-600 rounded-md hover:bg-emerald-700 shadow-sm">
                            <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Ekspor Semua
                        </a>
                    </div>
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
                                <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-semibold text-emerald-700">Tervalidasi</span>
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
                                    <a href="{{ route('super-admin.payments.export-single', $payment) }}"
                                       class="inline-flex items-center rounded-md border border-emerald-300 bg-white px-2.5 py-1.5 text-xs font-semibold text-emerald-700 shadow-sm hover:bg-emerald-50"
                                       title="Ekspor data validasi pembayaran ini">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <!-- Detail Row -->
                        <tr x-show="openHistoryId === {{ $payment->id }}"
                            x-transition
                            class="bg-slate-50">
                            <td colspan="8" class="px-4 py-4">
                                <div class="bg-white rounded-lg border border-slate-200 p-4">
                                    <!-- Validation Status -->
                                    <div class="mb-4 p-4 rounded-lg bg-emerald-50 border border-emerald-200">
                                        <div class="flex items-start gap-3">
                                            <div class="flex-1">
                                                <h6 class="font-semibold text-emerald-900 mb-1">
                                                    Status: Tervalidasi
                                                </h6>
                                                <p class="text-sm text-emerald-700">
                                                    Validator: {{ $payment->validator->name ?? '-' }} | {{ $payment->validated_at->format('d M Y H:i') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Payment Info -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                                        <div class="p-3 bg-sky-50 rounded-lg border border-sky-200">
                                            <p class="text-xs font-medium text-sky-700 mb-1">Jumlah Transfer</p>
                                            <p class="text-lg font-bold text-sky-900">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                                        </div>
                                        <div class="p-3 bg-slate-50 rounded-lg border border-slate-200">
                                            <p class="text-xs font-medium text-slate-600 mb-1">Tanggal Transfer</p>
                                            <p class="text-sm font-semibold text-slate-900">{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</p>
                                        </div>
                                        <div class="p-3 bg-slate-50 rounded-lg border border-slate-200">
                                            <p class="text-xs font-medium text-slate-600 mb-1">Kontak</p>
                                            <p class="text-sm font-semibold text-slate-900">{{ $payment->contact_number ?? '-' }}</p>
                                        </div>
                                        <div class="p-3 bg-slate-50 rounded-lg border border-slate-200">
                                            <p class="text-xs font-medium text-slate-600 mb-1">Waktu Upload</p>
                                            <p class="text-sm font-semibold text-slate-900">{{ $payment->created_at->format('d M Y H:i') }}</p>
                                        </div>
                                    </div>

                                    <!-- School and Activity Info -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div class="p-4 bg-slate-50 rounded-lg border border-slate-200">
                                            <h6 class="text-sm font-semibold text-slate-800 mb-3 flex items-center">
                                                <svg class="h-5 w-5 mr-2 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                </svg>
                                                Data Sekolah
                                            </h6>
                                            <div class="space-y-2">
                                                <div>
                                                    <p class="text-xs text-slate-600">Nama Sekolah</p>
                                                    <p class="text-sm font-semibold text-slate-900">{{ $payment->registration->nama_sekolah }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-xs text-slate-600">Alamat</p>
                                                    <p class="text-sm text-slate-900">{{ $payment->registration->alamat_sekolah }}</p>
                                                </div>
                                                    <div>
                                                        <p class="text-xs text-slate-600">Kepala Sekolah</p>
                                                        <p class="text-sm font-semibold text-slate-900">{{ $payment->registration->nama_kepala_sekolah ?? '-' }}</p>
                                                    </div>
                                                <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                                                    <div>
                                                        <p class="text-xs text-slate-600">Provinsi</p>
                                                        <p class="text-sm text-slate-900">{{ $payment->registration->provinsi }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="text-xs text-slate-600">Kab/Kota</p>
                                                        <p class="text-sm text-slate-900">{{ $payment->registration->kab_kota }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="text-xs text-slate-600">Kecamatan</p>
                                                        <p class="text-sm text-slate-900">{{ $payment->registration->kecamatan ?? '-' }}</p>
                                                    </div>
                                                </div>
                                                <div>
                                                    <p class="text-xs text-slate-600">KCD</p>
                                                    <p class="text-sm text-slate-900">{{ $payment->registration->kcd }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-4 bg-slate-50 rounded-lg border border-slate-200">
                                            <h6 class="text-sm font-semibold text-slate-800 mb-3 flex items-center">
                                                <svg class="h-5 w-5 mr-2 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                Informasi Kegiatan
                                            </h6>
                                            <div class="space-y-2">
                                                <div>
                                                    <p class="text-xs text-slate-600">Program</p>
                                                    <p class="text-sm font-semibold text-slate-900">{{ $payment->registration->activity->program->name ?? '-' }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-xs text-slate-600">Kegiatan</p>
                                                    <p class="text-sm font-semibold text-slate-900">{{ $payment->registration->activity->name }}</p>
                                                </div>
                                                @if($payment->registration->classes)
                                                <div>
                                                    <p class="text-xs text-slate-600">Kelas</p>
                                                    <p class="text-sm text-slate-900">{{ $payment->registration->classes->name }}</p>
                                                </div>
                                                @endif
                                                <div>
                                                    <p class="text-xs text-slate-600">Total Peserta</p>
                                                    <p class="text-sm font-semibold text-slate-900">
                                                        {{ $totalPeserta }} orang
                                                        <span class="text-xs text-slate-600">(KS: {{ $payment->registration->jumlah_kepala_sekolah }}, Guru: {{ $payment->registration->jumlah_guru }})</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Payment Proof -->
                                    @if($payment->proof_file)
                                    <div class="mb-4 p-4 bg-slate-50 rounded-lg border border-slate-200">
                                        <h6 class="text-sm font-semibold text-slate-800 mb-3 flex items-center">
                                            <svg class="h-5 w-5 mr-2 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            Bukti Pembayaran
                                        </h6>
                                        <img src="{{ Storage::url($payment->proof_file) }}" alt="Bukti Transfer" class="rounded border border-slate-300 shadow-sm" style="max-height: 400px;">
                                    </div>
                                    @endif

                                    <!-- Detail Peserta -->
                                    <div>
                                        <h6 class="text-sm font-semibold text-slate-800 mb-3 flex items-center">
                                            <svg class="h-5 w-5 mr-2 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            Daftar Peserta dari {{ $payment->registration->nama_sekolah }}
                                        </h6>

                                        <div class="space-y-3">
                                            <!-- Kepala Sekolah -->
                                            @if($payment->registration->jumlah_kepala_sekolah > 0)
                                            <div class="border border-emerald-200 bg-emerald-50 rounded-lg p-3">
                                                <div class="flex items-start justify-between">
                                                    <div class="flex-1">
                                                        <div class="flex items-center gap-2 mb-2">
                                                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-emerald-600 text-white font-semibold text-sm">
                                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>
                                                            </span>
                                                            <div>
                                                                <h4 class="text-sm font-semibold text-emerald-900">{{ $payment->registration->kepala_sekolah }}</h4>
                                                                <p class="text-xs text-emerald-700 font-medium">Kepala Sekolah</p>
                                                            </div>
                                                        </div>
                                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 ml-12">
                                                            <div>
                                                                <span class="text-xs font-medium text-emerald-700">NIK:</span>
                                                                <p class="text-sm text-emerald-900">{{ $payment->registration->nik_kepala_sekolah ?? '-' }}</p>
                                                            </div>
                                                            <div>
                                                                <span class="text-xs font-medium text-emerald-700">Email:</span>
                                                                <p class="text-sm text-emerald-900">{{ $payment->registration->email ?? '-' }}</p>
                                                            </div>
                                                            <div>
                                                                <span class="text-xs font-medium text-emerald-700">Surat Tugas:</span>
                                                                @if($payment->registration->surat_tugas_kepala_sekolah)
                                                                <a href="{{ Storage::url($payment->registration->surat_tugas_kepala_sekolah) }}" target="_blank"
                                                                   class="inline-flex items-center text-sm text-emerald-700 hover:text-emerald-800 font-medium">
                                                                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                                    </svg>
                                                                    Lihat File
                                                                </a>
                                                                @else
                                                                <p class="text-sm text-emerald-600">-</p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            <!-- Guru-guru -->
                                            @if($payment->registration->teacherParticipants->count() > 0)
                                            @foreach($payment->registration->teacherParticipants as $index => $teacher)
                                            <div class="border border-slate-200 rounded-lg p-3 hover:border-sky-300 transition-colors">
                                                <div class="flex items-start justify-between">
                                                    <div class="flex-1">
                                                        <div class="flex items-center gap-2 mb-2">
                                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-sky-100 text-sky-700 font-semibold text-sm">
                                                                {{ $index + 1 }}
                                                            </span>
                                                            <div>
                                                                <h4 class="text-sm font-semibold text-slate-900">{{ $teacher->nama_lengkap }}</h4>
                                                                <p class="text-xs text-slate-500">Guru</p>
                                                            </div>
                                                        </div>
                                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 ml-10">
                                                            <div>
                                                                <span class="text-xs font-medium text-slate-500">NIK:</span>
                                                                <p class="text-sm text-slate-900">{{ $teacher->nik ?? '-' }}</p>
                                                            </div>
                                                            <div>
                                                                <span class="text-xs font-medium text-slate-500">Email:</span>
                                                                <p class="text-sm text-slate-900">{{ $teacher->email ?? '-' }}</p>
                                                            </div>
                                                            <div>
                                                                <span class="text-xs font-medium text-slate-500">Surat Tugas:</span>
                                                                @if($teacher->surat_tugas)
                                                                <a href="{{ Storage::url($teacher->surat_tugas) }}" target="_blank"
                                                                   class="inline-flex items-center text-sm text-sky-600 hover:text-sky-700">
                                                                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                                    </svg>
                                                                    Lihat File
                                                                </a>
                                                                @else
                                                                <p class="text-sm text-slate-400">-</p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
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
