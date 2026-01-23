@php
    $linkBase = 'group flex items-center gap-3 rounded-xl px-3 py-2 text-[15px] font-semibold text-slate-800 hover:bg-[#0284c7]/10 hover:text-[#0284c7] transition';
    $iconBase = 'h-5 w-5 text-slate-500 group-hover:text-[#0284c7] transition';
    $iconActive = 'h-5 w-5 text-[#0284c7]';
    $activeBase = $linkBase . ' bg-[#0284c7]/10 text-[#0284c7] shadow-sm';

    $currentRoute = Route::currentRouteName();
@endphp

<div class="space-y-3">
    <p class="px-3 text-xs font-semibold uppercase tracking-[0.14em] text-slate-500">Navigasi utama</p>
    <li>
        <a href="{{ route('admin.dashboard') }}" class="{{ $currentRoute === 'admin.dashboard' ? $activeBase : $linkBase }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="{{ $currentRoute === 'admin.dashboard' ? $iconActive : $iconBase }}" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
            </svg>
            Dashboard
        </a>
    </li>
    <li>
        <a href="{{ route('admin.activities') }}" class="{{ Str::startsWith($currentRoute, 'admin.activities') ? $activeBase : $linkBase }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="{{ Str::startsWith($currentRoute, 'admin.activities') ? $iconActive : $iconBase }}" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
            </svg>
            Kegiatan
        </a>
    </li>
</div>

<div class="mt-4 space-y-3">
    <p class="px-3 text-xs font-semibold uppercase tracking-[0.14em] text-slate-500">Operasional</p>
    <li>
        <a href="{{ route('admin.classes.index') }}" class="{{ Str::startsWith($currentRoute, 'admin.classes') ? $activeBase : $linkBase }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="{{ Str::startsWith($currentRoute, 'admin.classes') ? $iconActive : $iconBase }}" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0z" />
            </svg>
            Kelas
        </a>
    </li>
    <li>
        <a href="{{ route('admin.registrations.index') }}" class="{{ Str::startsWith($currentRoute, 'admin.registrations') ? $activeBase : $linkBase }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="{{ Str::startsWith($currentRoute, 'admin.registrations') ? $iconActive : $iconBase }}" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd" />
            </svg>
            Kelola Pendaftaran
        </a>
    </li>
    <li>
        <a href="{{ route('admin.users') }}" class="{{ Str::startsWith($currentRoute, 'admin.users') ? $activeBase : $linkBase }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="{{ Str::startsWith($currentRoute, 'admin.users') ? $iconActive : $iconBase }}" viewBox="0 0 20 20" fill="currentColor">
                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
            </svg>
            Manajemen Pengguna
        </a>
    </li>
    <li>
        <a href="{{ route('admin.sekolah.index') }}" class="{{ Str::startsWith($currentRoute, 'admin.sekolah') ? $activeBase : $linkBase }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="{{ Str::startsWith($currentRoute, 'admin.sekolah') ? $iconActive : $iconBase }}" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
            </svg>
            Manajemen Sekolah
        </a>
    </li>
    <li>
        <a href="{{ route('admin.class-reports.index') }}" class="{{ Str::startsWith($currentRoute, 'admin.class-reports') ? $activeBase : $linkBase }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="{{ Str::startsWith($currentRoute, 'admin.class-reports') ? $iconActive : $iconBase }}" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
            </svg>
            Laporan Kelas
        </a>
    </li>
</div>
