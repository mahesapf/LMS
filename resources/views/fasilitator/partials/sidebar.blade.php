@php
    $linkBase = 'group flex items-center gap-3 rounded-xl px-3 py-2 text-[15px] font-semibold text-slate-800 hover:bg-purple-100 hover:text-purple-900 transition';
    $iconBase = 'h-5 w-5 text-slate-500 group-hover:text-purple-800';
    $activeBase = $linkBase . ' bg-purple-100 text-purple-900 shadow-sm';

    $currentRoute = Route::currentRouteName();
@endphp

<div class="space-y-3">
    <p class="px-3 text-xs font-semibold uppercase tracking-[0.14em] text-slate-500">Navigasi utama</p>
    <li>
        <a href="{{ route('fasilitator.dashboard') }}" class="{{ $currentRoute === 'fasilitator.dashboard' ? $activeBase : $linkBase }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconBase }}" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
            </svg>
            Dashboard
        </a>
    </li>
    <li>
        <a href="{{ route('fasilitator.classes') }}" class="{{ Str::startsWith($currentRoute, 'fasilitator.classes') ? $activeBase : $linkBase }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconBase }}" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0z" />
            </svg>
            Kelas
        </a>
    </li>
    <li>
        <a href="{{ route('fasilitator.profile') }}" class="{{ $currentRoute === 'fasilitator.profile' ? $activeBase : $linkBase }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconBase }}" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
            </svg>
            Edit Biodata
        </a>
    </li>
</div>
