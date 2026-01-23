@extends('layouts.dashboard')

@section('sidebar')
    @php
        $linkBase = 'group flex items-center gap-3 rounded-xl px-3 py-2 text-[15px] font-semibold text-slate-800 hover:bg-sky-100 hover:text-sky-900 transition';
        $iconBase = 'h-5 w-5 text-slate-500 group-hover:text-sky-800';
        $activeBase = $linkBase . ' bg-sky-100 text-sky-900 shadow-sm';

        $currentRoute = Route::currentRouteName();
    @endphp

    <div class="space-y-3">
        <p class="px-3 text-xs font-semibold uppercase tracking-[0.14em] text-slate-500">Navigasi utama</p>
        <li>
            <a href="{{ route('sekolah.dashboard') }}" class="{{ $currentRoute === 'sekolah.dashboard' ? $activeBase : $linkBase }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconBase }}" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                </svg>
                Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('sekolah.activities.index') }}" class="{{ Str::startsWith($currentRoute, 'sekolah.activities') ? $activeBase : $linkBase }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconBase }}" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                </svg>
                Daftar Kegiatan
            </a>
        </li>
        <li>
            <a href="{{ route('sekolah.registrations') }}" class="{{ $currentRoute === 'sekolah.registrations' ? $activeBase : $linkBase }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconBase }}" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                </svg>
                Pendaftaran Saya
            </a>
        </li>
        <li>
            <a href="{{ route('sekolah.profile') }}" class="{{ $currentRoute === 'sekolah.profile' ? $activeBase : $linkBase }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconBase }}" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                </svg>
                Profil Sekolah
            </a>
        </li>
        <li>
            <a href="{{ route('sekolah.account-info') }}" class="{{ $currentRoute === 'sekolah.account-info' ? $activeBase : $linkBase }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="{{ $iconBase }}" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 2a5 5 0 100 10 5 5 0 000-10zM4 17a6 6 0 1112 0v1H4v-1z" clip-rule="evenodd" />
                </svg>
                Informasi Akun
            </a>
        </li>
    </div>

    <!-- Kontak Person -->
    <div class="mt-6 rounded-xl border border-slate-200 bg-gradient-to-br from-sky-50 to-blue-50 p-4">
        <div class="mb-3 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-sky-600" viewBox="0 0 20 20" fill="currentColor">
                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
            </svg>
            <h4 class="text-sm font-semibold text-slate-900">Butuh Bantuan?</h4>
        </div>
        <p class="text-xs text-slate-600 mb-3">Hubungi kami untuk pertanyaan atau dukungan teknis</p>
        <div class="space-y-2">
            <a href="mailto:support@sipm.id" class="flex items-center gap-2 rounded-lg bg-white px-3 py-2 text-xs font-medium text-slate-700 transition hover:bg-sky-100 hover:text-sky-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                </svg>
                support@sipm.id
            </a>
            <a href="https://wa.me/6281234567890" target="_blank" class="flex items-center gap-2 rounded-lg bg-white px-3 py-2 text-xs font-medium text-slate-700 transition hover:bg-emerald-100 hover:text-emerald-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                </svg>
                WhatsApp Support
            </a>
        </div>
    </div>
@endsection
