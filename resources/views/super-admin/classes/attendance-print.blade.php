<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - Cetak Daftar Hadir</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-slate-900">
    <style>
        @media print {
            @page { size: A4 portrait; margin: 14mm; }
            .no-print { display: none !important; }
            .print-container { box-shadow: none !important; border: none !important; }

            table { table-layout: fixed !important; width: 100% !important; }
            .print-container { max-width: none !important; width: 100% !important; }

            colgroup col:nth-child(1) { width: 10mm !important; }
            colgroup col:nth-child(2) { width: 52mm !important; }
            colgroup col:nth-child(3) { width: 50mm !important; }
            colgroup col:nth-child(4) { width: 30mm !important; }
            colgroup col:nth-child(5) { width: 40mm !important; }

            th, td { overflow-wrap: normal; word-break: normal; }
            td { overflow-wrap: anywhere; word-break: break-word; }
            thead th { white-space: nowrap; }
            thead th:first-child, tbody td:first-child { white-space: nowrap; }
        }

        table { border-collapse: collapse; width: 100%; table-layout: fixed; }
        th, td { border: 1px solid #0f172a; padding: 8px; vertical-align: top; }
        th { background: #f1f5f9; }
    </style>

    <div class="no-print mx-auto max-w-4xl px-4 py-4">
        <div class="flex items-center justify-between rounded-lg border border-slate-200 bg-slate-50 px-4 py-3">
            <p class="text-sm text-slate-700">Halaman ini khusus untuk cetak (print). Gunakan tombol di kanan untuk mencetak.</p>
            <button type="button" onclick="window.print()" class="inline-flex items-center gap-2 rounded-lg bg-[#0284c7] px-4 py-2 text-sm font-semibold text-white hover:bg-[#0369a1]">
                Cetak
            </button>
        </div>
    </div>

    <div class="print-container mx-auto max-w-4xl px-4 pb-8 pt-4">
        <div class="mb-4">
            <p class="text-sm font-semibold">DAFTAR HADIR</p>
            <p class="text-sm">Kelas: <span class="font-semibold">{{ $class->name }}</span></p>
            <p class="text-sm">Kegiatan: <span class="font-semibold">{{ $class->activity->name ?? '-' }}</span></p>
            <p class="text-sm">Tanggal cetak: <span class="font-semibold">{{ now()->format('d M Y H:i') }}</span></p>
        </div>

        <table>
            <colgroup>
                <col style="width: 10mm;">
                <col style="width: 52mm;">
                <col style="width: 50mm;">
                <col style="width: 30mm;">
                <col style="width: 40mm;">
            </colgroup>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Sekolah/Instansi</th>
                    <th>Jabatan</th>
                    <th>Tanda Tangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($participants as $index => $p)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $p['nama_lengkap'] }}</td>
                        <td>{{ $p['nama_sekolah'] ?? '-' }}</td>
                        <td>{{ $p['jabatan'] ?? '-' }}</td>
                        <td style="height: 42px;"></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada peserta.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-6 text-sm">
            <div class="flex items-start justify-between gap-6">
                <div>
                    <p class="font-semibold">Catatan:</p>
                    <p>1. Silakan tanda tangan pada kolom yang tersedia.</p>
                    <p>2. Dokumen ini hanya untuk kebutuhan daftar hadir (di luar sistem).</p>
                </div>
                <div class="text-right">
                    <p>{{ now()->format('d M Y') }}</p>
                    <p class="mt-12">(__________________________)</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
