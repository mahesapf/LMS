@extends('layouts.dashboard')

@section('title', 'Detail Tugas - ' . $class->name)

@section('sidebar')
    @include('fasilitator.partials.sidebar')
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Detail Tugas</h1>
            <p class="mt-1 text-sm text-slate-500">{{ $class->name }}</p>
        </div>
        <a href="{{ route('fasilitator.classes.detail', $class) }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Kembali
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-5">
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Total Peserta</p>
            <p class="mt-2 text-2xl font-bold text-slate-900">{{ $stats['total_participants'] }}</p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Total Tugas</p>
            <p class="mt-2 text-2xl font-bold text-slate-900">{{ $stats['total_tasks'] }}</p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Dikumpulkan</p>
            <p class="mt-2 text-2xl font-bold text-emerald-600">{{ $stats['total_submissions'] }}</p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Diharapkan</p>
            <p class="mt-2 text-2xl font-bold text-amber-600">{{ $stats['expected_submissions'] }}</p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Persentase</p>
            <p class="mt-2 text-2xl font-bold text-purple-600">{{ $stats['overall_percentage'] }}%</p>
        </div>
    </div>

    <!-- Submissions by Stage -->
    @if(count($submissionsByStage) > 0)
        @foreach($submissionsByStage as $stageData)
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 bg-gradient-to-r from-purple-50 to-purple-100 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mb-1 inline-block h-5 w-5 text-purple-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2H6zm1 2a1 1 0 000 2h6a1 1 0 100-2H7zm0 4a1 1 0 100 2h6a1 1 0 100-2H7zm0 4a1 1 0 100 2h3a1 1 0 100-2H7z" clip-rule="evenodd" />
                            </svg>
                            {{ $stageData['stage']->name }}
                        </h2>
                        @if($stageData['stage']->description)
                        <p class="mt-1 text-sm text-slate-600">{{ $stageData['stage']->description }}</p>
                        @endif
                    </div>
                    <span class="rounded-full bg-purple-100 px-3 py-1 text-sm font-semibold text-purple-700">
                        {{ count($stageData['requirements']) }} Tugas
                    </span>
                </div>
            </div>

            <div class="p-6">
                @if(count($stageData['requirements']) > 0)
                    <div class="space-y-6">
                        @foreach($stageData['requirements'] as $reqData)
                        <div class="rounded-lg border border-slate-200 bg-slate-50">
                            <!-- Requirement Header -->
                            <div class="border-b border-slate-200 px-4 py-3" x-data="{ expanded: false }">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 text-blue-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div>
                                                <h3 class="font-semibold text-slate-900">{{ $reqData['requirement']->document_name }}</h3>
                                                @if($reqData['requirement']->description)
                                                <p class="text-sm text-slate-600">{{ $reqData['requirement']->description }}</p>
                                                @endif
                                                <div class="mt-1 flex items-center gap-3 text-xs text-slate-500">
                                                    <span class="flex items-center gap-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                                        </svg>
                                                        {{ $reqData['requirement']->document_type }}
                                                    </span>
                                                    <span class="flex items-center gap-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                        </svg>
                                                        Max: {{ $reqData['requirement']->max_file_size }}KB
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <div class="text-right">
                                            <div class="text-2xl font-bold text-emerald-600">{{ $reqData['total_submitted'] }}</div>
                                            <div class="text-xs text-slate-500">dari {{ $reqData['total_participants'] }}</div>
                                            <div class="mt-1">
                                                @if($reqData['percentage'] >= 80)
                                                <span class="inline-flex items-center rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-semibold text-emerald-700">
                                                    {{ $reqData['percentage'] }}%
                                                </span>
                                                @elseif($reqData['percentage'] >= 50)
                                                <span class="inline-flex items-center rounded-full bg-amber-100 px-2 py-0.5 text-xs font-semibold text-amber-700">
                                                    {{ $reqData['percentage'] }}%
                                                </span>
                                                @else
                                                <span class="inline-flex items-center rounded-full bg-rose-100 px-2 py-0.5 text-xs font-semibold text-rose-700">
                                                    {{ $reqData['percentage'] }}%
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <button @click="expanded = !expanded" class="rounded-lg p-2 hover:bg-slate-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition" :class="expanded ? 'rotate-180' : ''" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <!-- Submissions List -->
                                <div x-show="expanded" x-collapse class="mt-4">
                                    @if(count($reqData['submissions']) > 0)
                                    <div class="overflow-x-auto rounded-lg border border-slate-200 bg-white">
                                        <table class="min-w-full divide-y divide-slate-200">
                                            <thead class="bg-slate-50">
                                                <tr>
                                                    <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">#</th>
                                                    <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Nama Peserta</th>
                                                    <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Email</th>
                                                    <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">File</th>
                                                    <th class="px-4 py-2 text-left text-xs font-semibold text-slate-600">Tanggal Upload</th>
                                                    <th class="px-4 py-2 text-right text-xs font-semibold text-slate-600">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-slate-100 bg-white">
                                                @foreach($reqData['submissions'] as $index => $submission)
                                                <tr class="hover:bg-slate-50">
                                                    <td class="px-4 py-2 text-sm text-slate-700">{{ $index + 1 }}</td>
                                                    <td class="px-4 py-2">
                                                        <div class="font-semibold text-slate-900">{{ $submission['participant_name'] }}</div>
                                                    </td>
                                                    <td class="px-4 py-2 text-sm text-slate-600">{{ $submission['participant_email'] }}</td>
                                                    <td class="px-4 py-2">
                                                        <div class="flex items-center gap-2 text-sm text-slate-700">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd" />
                                                            </svg>
                                                            <span class="max-w-xs truncate">{{ $submission['file_name'] }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-2 text-sm text-slate-600">
                                                        {{ $submission['uploaded_at']->format('d/m/Y H:i') }}
                                                    </td>
                                                    <td class="px-4 py-2 text-right">
                                                        @if($submission['file_path'])
                                                        <a href="{{ route('documents.download', $submission['id']) }}" class="inline-flex items-center gap-1.5 rounded-lg border border-purple-300 bg-white px-3 py-1.5 text-xs font-semibold text-purple-700 hover:bg-purple-50">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                            </svg>
                                                            Download
                                                        </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @else
                                    <div class="rounded-lg border border-amber-200 bg-amber-50 p-4 text-center text-sm text-amber-800">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-2 h-8 w-8 text-amber-600" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                        </svg>
                                        Belum ada peserta yang mengumpulkan tugas ini
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="rounded-lg border border-blue-200 bg-blue-50 p-6 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-3 h-12 w-12 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                        </svg>
                        <p class="font-medium text-blue-900">Belum ada tugas di tahap ini</p>
                        <p class="mt-1 text-sm text-blue-700">Silakan tambahkan tugas dari halaman detail kelas</p>
                    </div>
                @endif
            </div>
        </div>
        @endforeach
    @else
    <div class="rounded-xl border border-amber-200 bg-amber-50 px-6 py-12 text-center">
        <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-amber-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-amber-600" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
            </svg>
        </div>
        <h3 class="text-lg font-semibold text-slate-900">Belum Ada Tahap</h3>
        <p class="mt-2 text-sm text-slate-600">Belum ada tahap (stage) yang dibuat untuk kelas ini</p>
    </div>
    @endif
</div>
@endsection
