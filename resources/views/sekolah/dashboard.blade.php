@extends('layouts.sekolah')

@section('title', 'Dashboard Sekolah')

@section('content')
<div class="space-y-6">
    <div class="rounded-2xl bg-gradient-to-br from-sky-600 to-blue-700 px-6 py-8 text-white shadow-sm">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-sm uppercase tracking-[0.12em] text-white/80">Sekolah</p>
                <h1 class="mt-2 text-3xl font-semibold">Dashboard utama</h1>
                <p class="mt-2 text-white/80">Pantau pendaftaran, pembayaran, dan kegiatan yang tersedia.</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('sekolah.activities.index') }}" class="inline-flex items-center gap-2 rounded-lg bg-white/20 px-4 py-2 text-sm font-semibold backdrop-blur transition hover:bg-white/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Daftar kegiatan
                </a>
                <a href="{{ route('sekolah.registrations') }}" class="inline-flex items-center gap-2 rounded-lg bg-white text-sky-700 px-4 py-2 text-sm font-semibold shadow-sm transition hover:shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m-8 4h10a2 2 0 002-2V6a2 2 0 00-2-2H8l-4 4v10a2 2 0 002 2h1" />
                    </svg>
                    Pendaftaran saya
                </a>
            </div>
        </div>
    </div>

    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-sky-100 text-sky-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1z" clip-rule="evenodd" />
                    </svg>
                </span>
                <div>
                    <p class="text-sm text-slate-500">Total pendaftaran</p>
                    <p class="text-2xl font-semibold text-slate-900">{{ $stats['total_registrations'] }}</p>
                </div>
            </div>
            <p class="mt-3 text-sm text-slate-500">Riwayat pendaftaran sekolah</p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-sky-100 text-sky-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                    </svg>
                </span>
                <div>
                    <p class="text-sm text-slate-500">Menunggu</p>
                    <p class="text-2xl font-semibold text-slate-900">{{ $stats['pending_registrations'] }}</p>
                </div>
            </div>
            <p class="mt-3 text-sm text-slate-500">Menunggu proses lanjutan</p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-sky-100 text-sky-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </span>
                <div>
                    <p class="text-sm text-slate-500">Disetujui</p>
                    <p class="text-2xl font-semibold text-slate-900">{{ $stats['approved_registrations'] }}</p>
                </div>
            </div>
            <p class="mt-3 text-sm text-slate-500">Pendaftaran tervalidasi</p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-sky-100 text-sky-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                    </svg>
                </span>
                <div>
                    <p class="text-sm text-slate-500">Kegiatan tersedia</p>
                    <p class="text-2xl font-semibold text-slate-900">{{ $stats['available_activities'] }}</p>
                </div>
            </div>
            <p class="mt-3 text-sm text-slate-500">Dapat didaftarkan saat ini</p>
        </div>
    </div>

    <div class="grid gap-4 lg:grid-cols-3">
        <div class="lg:col-span-2 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm font-medium text-slate-500">Pendaftaran terakhir</p>
                    <h2 class="mt-1 text-2xl font-semibold text-slate-900">{{ $recentRegistrations->count() }} data terbaru</h2>
                    <p class="mt-2 text-sm text-slate-500">Pantau status pendaftaran & pembayaran secara ringkas.</p>
                </div>
                <a href="{{ route('sekolah.registrations') }}" class="inline-flex items-center gap-2 rounded-lg bg-[#0284c7] px-3 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-[#0369a1]">
                    Lihat semua
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <div class="mt-5 overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Kegiatan</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Program</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Tanggal</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Status</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse($recentRegistrations as $registration)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-2 text-sm text-slate-900">{{ $registration->activity->name ?? '-' }}</td>
                                <td class="px-4 py-2 text-sm text-slate-700">{{ $registration->activity->program->name ?? '-' }}</td>
                                <td class="px-4 py-2 text-sm text-slate-700">{{ $registration->created_at->format('d M Y') }}</td>
                                <td class="px-4 py-2 text-sm">
                                    @if($registration->status == 'pending')
                                        <div class="flex items-center gap-1.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                            </svg>
                                            <div class="flex flex-col">
                                                <span class="text-xs font-medium text-amber-700">Pending</span>
                                                <span class="text-[10px] text-amber-600">Menunggu</span>
                                            </div>
                                        </div>
                                    @elseif($registration->status == 'approved')
                                        <div class="flex items-center gap-1.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-sky-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                            <div class="flex flex-col">
                                                <span class="text-xs font-medium text-sky-700">Disetujui</span>
                                                <span class="text-[10px] text-sky-600">Tervalidasi</span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="flex items-center gap-1.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-rose-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 9.293 8.707 7.293z" clip-rule="evenodd" />
                                            </svg>
                                            <div class="flex flex-col">
                                                <span class="text-xs font-medium text-rose-700">Ditolak</span>
                                                <span class="text-[10px] text-rose-600">Tidak Disetujui</span>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-sm">
                                    @if($registration->payment)
                                        @if($registration->payment->status == 'pending')
                                            <div class="flex items-center gap-1.5">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                                </svg>
                                                <div class="flex flex-col">
                                                    <span class="text-xs font-medium text-amber-700">Menunggu</span>
                                                    <span class="text-[10px] text-amber-600">Verifikasi</span>
                                                </div>
                                            </div>
                                        @elseif($registration->payment->status == 'approved')
                                            <div class="flex items-center gap-1.5">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                                <div class="flex flex-col">
                                                    <span class="text-xs font-medium text-emerald-700">Sudah Dibayar</span>
                                                    <span class="text-[10px] text-emerald-600">Lunas</span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="flex items-center gap-1.5">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-rose-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 9.293 8.707 7.293z" clip-rule="evenodd" />
                                                </svg>
                                                <div class="flex flex-col">
                                                    <span class="text-xs font-medium text-rose-700">Ditolak</span>
                                                    <span class="text-[10px] text-rose-600">Tidak Disetujui</span>
                                                </div>
                                            </div>
                                        @endif
                                    @else
                                        <div class="flex items-center gap-1.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                            </svg>
                                            <div class="flex flex-col">
                                                <span class="text-xs font-medium text-slate-700">Belum Bayar</span>
                                                <span class="text-[10px] text-slate-600">Menunggu Pembayaran</span>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-sm text-slate-500">Belum ada pendaftaran</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <p class="text-sm font-medium text-slate-500">Snapshot ringkas</p>
                    <h3 class="mt-1 text-xl font-semibold text-slate-900">Kalender</h3>
                </div>
            </div>

            <div x-data="{
                currentDate: new Date(),
                currentMonth: new Date().getMonth(),
                currentYear: new Date().getFullYear(),
                days: [],
                activitiesByDate: @js($activitiesByDate ?? []),
                monthNames: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                dayNames: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                init() {
                    this.generateCalendar();
                },
                generateCalendar() {
                    const firstDay = new Date(this.currentYear, this.currentMonth, 1);
                    const lastDay = new Date(this.currentYear, this.currentMonth + 1, 0);
                    const daysInMonth = lastDay.getDate();
                    const startingDayOfWeek = firstDay.getDay();

                    this.days = [];

                    // Add empty cells for days before the month starts
                    for (let i = 0; i < startingDayOfWeek; i++) {
                        this.days.push({ day: '', isCurrentMonth: false });
                    }

                    // Add days of the month
                    for (let i = 1; i <= daysInMonth; i++) {
                        const isToday = i === this.currentDate.getDate() &&
                                      this.currentMonth === this.currentDate.getMonth() &&
                                      this.currentYear === this.currentDate.getFullYear();

                        // Check if there are activities on this date
                        const dateStr = this.currentYear + '-' +
                                      String(this.currentMonth + 1).padStart(2, '0') + '-' +
                                      String(i).padStart(2, '0');
                        const activities = this.activitiesByDate[dateStr] || [];

                        this.days.push({
                            day: i,
                            isCurrentMonth: true,
                            isToday,
                            activities: activities,
                            hasActivities: activities.length > 0
                        });
                    }
                },
                previousMonth() {
                    this.currentMonth--;
                    if (this.currentMonth < 0) {
                        this.currentMonth = 11;
                        this.currentYear--;
                    }
                    this.generateCalendar();
                },
                nextMonth() {
                    this.currentMonth++;
                    if (this.currentMonth > 11) {
                        this.currentMonth = 0;
                        this.currentYear++;
                    }
                    this.generateCalendar();
                }
            }">
                <!-- Calendar Header -->
                <div class="flex items-center justify-between mb-4">
                    <button @click="previousMonth()" class="rounded-lg p-1.5 hover:bg-slate-100 text-slate-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <h4 class="text-sm font-semibold text-slate-900" x-text="monthNames[currentMonth] + ' ' + currentYear"></h4>
                    <button @click="nextMonth()" class="rounded-lg p-1.5 hover:bg-slate-100 text-slate-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>

                <!-- Day Names -->
                <div class="grid grid-cols-7 gap-1 mb-2">
                    <template x-for="dayName in dayNames" :key="dayName">
                        <div class="text-center text-xs font-semibold text-slate-500" x-text="dayName"></div>
                    </template>
                </div>

                <!-- Calendar Days -->
                <div class="grid grid-cols-7 gap-1">
                    <template x-for="(dayObj, index) in days" :key="index">
                        <div class="aspect-square flex items-center justify-center relative">
                            <div
                                x-show="dayObj.isCurrentMonth"
                                class="w-full h-full flex items-center justify-center rounded-lg text-sm transition-colors relative group"
                                :class="{
                                    'bg-sky-600 text-white font-semibold': dayObj.isToday,
                                    'bg-emerald-100 text-emerald-700 font-semibold': dayObj.hasActivities && !dayObj.isToday,
                                    'text-slate-700 hover:bg-slate-100 cursor-pointer': !dayObj.isToday && !dayObj.hasActivities && dayObj.isCurrentMonth
                                }">
                                <span x-text="dayObj.day"></span>

                                <!-- Tooltip -->
                                <div
                                    x-show="dayObj.hasActivities"
                                    class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 hidden group-hover:block z-10 w-48">
                                    <div class="bg-slate-900 text-white text-xs rounded-lg p-2 shadow-lg">
                                        <div class="font-semibold mb-1">Kegiatan:</div>
                                        <template x-for="activity in dayObj.activities" :key="activity.name">
                                            <div class="py-1 border-t border-slate-700 first:border-t-0 first:pt-0">
                                                <div class="font-medium" x-text="activity.name"></div>
                                                <div class="text-slate-300 mt-0.5">
                                                    <span x-text="activity.status === 'validated' ? 'Tervalidasi' :
                                                                  activity.status === 'pending' ? 'Pending' :
                                                                  activity.status === 'payment_pending' ? 'Menunggu Pembayaran' :
                                                                  activity.status === 'payment_uploaded' ? 'Menunggu Validasi' :
                                                                  activity.status === 'rejected' ? 'Ditolak' : activity.status">
                                                    </span>
                                                </div>
                                            </div>
                                        </template>
                                        <!-- Tooltip arrow -->
                                        <div class="absolute top-full left-1/2 transform -translate-x-1/2 -mt-px">
                                            <div class="border-4 border-transparent border-t-slate-900"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
