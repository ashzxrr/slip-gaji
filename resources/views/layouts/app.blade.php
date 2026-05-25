<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
</head>
<body class="bg-[#f0fdf9] font-sans">

<!-- Loading Overlay -->
<div id="loadingOverlay" 
     class="fixed inset-0 z-[9999] flex flex-col items-center justify-center
            bg-white transition-opacity duration-300"
     style="opacity:0; pointer-events:none;">
    <div class="mb-6">
        <div class="w-16 h-16 rounded-2xl flex items-center justify-center
                    bg-gradient-to-br from-emerald-500 to-emerald-700 shadow-lg">
            <span class="text-white font-bold text-2xl">W</span>
        </div>
    </div>
    <div class="relative w-12 h-12 mb-4">
        <div class="absolute inset-0 rounded-full border-4 border-emerald-100"></div>
        <div class="absolute inset-0 rounded-full border-4 border-transparent border-t-emerald-500 animate-spin"></div>
    </div>
    <p class="text-sm text-gray-400 animate-pulse">Memuat halaman...</p>
</div>

<div class="flex h-screen overflow-hidden">

    {{-- Sidebar --}}
<aside class="w-64 bg-gradient-to-tr from-[#064e3b] via-[#059669] to-[#34d399] text-white flex flex-col flex-shrink-0 shadow-xl">
        <div class="p-5 border-b border-emerald-400/30">
            <div class="flex items-center gap-3">
                <div class="bg-emerald-300 rounded-lg p-2">
                    <i class="fa fa-building text-emerald-800 text-lg"></i>
                </div>
                <div>
                    <h1 class="font-bold text-lg leading-tight text-white">PT Walet Abdillah Jabli</h1>
                    <p class="text-emerald-200 text-xs mt-1">Sistem Slip Gaji</p>
                </div>
            </div>
        </div>

        <nav class="flex-1 p-4 space-y-1">
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm transition-all duration-200
                      {{ request()->routeIs('dashboard') ? 'bg-white/20 text-white ring-1 ring-white/20' : 'hover:bg-white/10 hover:text-white' }}">
                <i class="fa fa-home w-4"></i> Dashboard
            </a>
            <a href="{{ route('karyawan.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm transition-all duration-200
                      {{ request()->routeIs('karyawan.*') ? 'bg-white/20 text-white ring-1 ring-white/20' : 'hover:bg-white/10 hover:text-white' }}">
                <i class="fa fa-users w-4"></i> Data Karyawan
            </a>
            <a href="{{ route('periode.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm transition-all duration-200
                      {{ request()->routeIs('periode.*') ? 'bg-white/20 text-white ring-1 ring-white/20' : 'hover:bg-white/10 hover:text-white' }}">
                <i class="fa fa-calendar w-4"></i> Periode & Slip Gaji
            </a>
        </nav>
       <div class="p-4 border-t border-white/20">
    <a href="{{ route('admin.profile') }}"
       class="flex items-center gap-3 mb-3 p-2 rounded-xl hover:bg-white/15 transition-all">
        <div class="bg-white/30 border border-white/40 rounded-full w-9 h-9 flex items-center 
                    justify-center text-sm font-bold text-white shadow-inner">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
        <div>
            <p class="text-sm font-semibold text-white">{{ auth()->user()->name }}</p>
            <p class="text-xs text-emerald-100 flex items-center gap-1">
                <i class="fa fa-pen text-[10px]"></i> Edit Profil
            </p>
        </div>
    </a>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="w-full flex items-center gap-2 px-3 py-2 rounded-xl
                       bg-red-500/20 hover:bg-red-500/30 border border-red-400/30
                       text-xs font-medium text-red-200 hover:text-white transition-all">
            <i class="fa fa-sign-out-alt"></i> Logout
        </button>
    </form>
</div>
    </aside>

    

    {{-- Main Content --}}
    <main class="flex-1 overflow-y-auto">
        <header class="bg-white border-b border-emerald-100 px-6 py-4 shadow-sm">
            <h2 class="text-gray-700 font-semibold text-lg">@yield('title', 'Dashboard')</h2>
        </header>

        {{-- Accent Bar --}}
        <div class="h-[3px] bg-gradient-to-r from-emerald-300 via-emerald-500 to-emerald-300"></div>

        <div class="p-6">
            @yield('content')
        </div>
    </main>
</div>

<!-- Toast Container (for flash messages) -->
<div id="toastContainer" 
     class="fixed bottom-6 right-6 z-50 flex flex-col gap-3 pointer-events-none">
</div>

<script>
// Loading overlay functions
const overlay = document.getElementById('loadingOverlay');
function showLoading() { overlay.style.opacity = '1'; overlay.style.pointerEvents = 'all'; }
function hideLoading() { overlay.style.opacity = '0'; overlay.style.pointerEvents = 'none'; }
window.addEventListener('load', () => { setTimeout(hideLoading, 300); });
document.addEventListener('click', function(e) {
    const link = e.target.closest('a');
    if (link && link.href && !link.href.startsWith('#') && !link.target && !link.hasAttribute('download') && link.hostname === window.location.hostname) {
        showLoading();
    }
});
document.addEventListener('submit', function(e) { if (!e.target.hasAttribute('data-no-loading')) showLoading(); });
window.addEventListener('pageshow', function(e) { if (e.persisted) hideLoading(); });

// Button loading state
document.addEventListener('click', function(e) {
    const btn = e.target.closest('[data-loading]');
    if (!btn || btn.disabled) return;
    const originalHtml = btn.innerHTML;
    const loadingText  = btn.getAttribute('data-loading') || 'Memproses...';
    btn.disabled  = true;
    btn.innerHTML = `\n        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 inline-block" fill="none" viewBox="0 0 24 24">\n            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>\n            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>\n        </svg>\n        ${loadingText}\n    `;
    setTimeout(() => { btn.disabled = false; btn.innerHTML = originalHtml; }, 8000);
});

// Toasts
function showToast(message, type = 'success') {
    const container = document.getElementById('toastContainer');
    const colors = { success: 'bg-emerald-600 text-white', error: 'bg-red-600 text-white', info: 'bg-blue-600 text-white' };
    const icons = { success: '✓', error: '✕', info: 'ℹ' };
    const toast = document.createElement('div');
    toast.className = `pointer-events-auto flex items-center gap-3 px-5 py-3 rounded-xl shadow-lg text-sm font-medium transform translate-y-4 opacity-0 transition-all duration-300 ${colors[type]}`;
    toast.innerHTML = `<span class="text-lg font-bold">${icons[type]}</span><span>${message}</span>`;
    container.appendChild(toast);
    requestAnimationFrame(() => { requestAnimationFrame(() => { toast.classList.remove('translate-y-4', 'opacity-0'); }); });
    setTimeout(() => { toast.classList.add('translate-y-4', 'opacity-0'); setTimeout(() => toast.remove(), 300); }, 4000);
}

// Trigger toast from session
@if(session('success'))
    showToast("{{ session('success') }}", 'success');
@endif
@if(session('error'))
    showToast("{{ session('error') }}", 'error');
@endif
</script>

</body>
</html>

</body>
</html>