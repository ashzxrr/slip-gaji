<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Karyawan — PT Walet Abdillah Jabli</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
</head>
<body class="bg-[#fdfbf5] font-sans">

<!-- Loading Overlay -->
<div id="loadingOverlay" 
     class="fixed inset-0 z-[9999] flex flex-col items-center justify-center
            bg-white transition-opacity duration-300"
     style="opacity:0; pointer-events:none;">
    <div class="mb-6">
        <div class="w-16 h-16 rounded-2xl flex items-center justify-center
                    bg-gradient-to-br from-amber-500 to-amber-600 shadow-lg">
            <span class="text-white font-bold text-2xl">W</span>
        </div>
    </div>
    <div class="relative w-12 h-12 mb-4">
        <div class="absolute inset-0 rounded-full border-4 border-amber-100"></div>
        <div class="absolute inset-0 rounded-full border-4 border-transparent border-t-amber-500 animate-spin"></div>
    </div>
    <p class="text-sm text-gray-400 animate-pulse">Memuat halaman...</p>
</div>

{{-- Desktop Sidebar Layout --}}
<div class="hidden md:flex h-screen overflow-hidden">
    <aside class="w-64 bg-gradient-to-tr from-[#78350f] via-[#b45309] to-[#fcd34d] text-white flex flex-col flex-shrink-0 shadow-xl">
        <div class="p-5 border-b border-white/20">
            <h1 class="font-bold text-lg leading-tight text-white">Portal Karyawan</h1>
            <p class="text-amber-100 text-xs mt-1">PT Walet Abdillah Jabli</p>
        </div>

        @php
            $unreadCount = session('portal_karyawan_id') ? \App\Models\Notifikasi::where('karyawan_id', session('portal_karyawan_id'))->where('dibaca', false)->count() : 0;
        @endphp
        <nav class="flex-1 p-4 space-y-1">
            <a href="{{ route('portal.dashboard') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm transition-all duration-200
                      {{ request()->routeIs('portal.dashboard') ? 'bg-white/20 text-white ring-1 ring-white/20' : 'hover:bg-white/10 text-white/90' }}">
                <i class="fa fa-file-alt w-4"></i> Slip Gaji Saya
            </a>
            <a href="{{ route('portal.notifikasi.index') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm transition-all duration-200
                      {{ request()->routeIs('portal.notifikasi.*') ? 'bg-white/20 text-white ring-1 ring-white/20' : 'hover:bg-white/10 text-white/90' }}">
                <i class="fa fa-bell w-4"></i> Notifikasi
                @if($unreadCount > 0)
                    <span class="ml-auto bg-red-500 text-white text-[10px] font-bold rounded-full w-5 h-5 flex items-center justify-center">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                @endif
            </a>
            <a href="{{ route('portal.profile') }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm transition-all duration-200
                      {{ request()->routeIs('portal.profile') ? 'bg-white/20 text-white ring-1 ring-white/20' : 'hover:bg-white/10 text-white/90' }}">
                <i class="fa fa-user w-4"></i> Profil Saya
            </a>
        </nav>

        <div class="p-4 border-t border-white/20">
            @php $k = session_karyawan(); @endphp
            <div class="flex items-center gap-3 mb-4">
                <div class="bg-white/30 border border-white/40 rounded-full w-10 h-10 flex items-center justify-center text-xs font-bold text-white">
                    {{ strtoupper(substr($k->nama, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-medium text-white truncate">{{ $k->nama }}</p>
                    <p class="text-xs text-amber-100 truncate">{{ $k->nip }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('portal.logout') }}">
                @csrf
                <button class="text-xs text-red-200 hover:text-red-100 flex items-center gap-2 transition-colors w-full">
                    <i class="fa fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 overflow-y-auto">
        <header class="bg-white border-b border-amber-100 px-6 py-4 shadow-sm flex items-center justify-between">
            <h2 class="text-gray-700 font-semibold text-lg">@yield('title')</h2>
            <div class="flex items-center gap-3">
                <a href="{{ route('portal.notifikasi.index') }}" class="relative p-2 rounded-xl hover:bg-amber-50 transition-all">
                    <i class="fa fa-bell text-amber-600 text-lg"></i>
                    @if($unreadCount > 0)
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold rounded-full w-5 h-5 flex items-center justify-center">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                    @endif
                </a>
            </div>
            <div class="h-[2px] bg-gradient-to-r from-amber-300 via-amber-500 to-amber-300 absolute left-0 right-0 top-0"></div>
        </header>

        <div class="p-6">
            @yield('content')
        </div>
    </main>
</div>

{{-- Mobile Layout --}}
<div class="md:hidden h-screen overflow-hidden flex flex-col">
    <header class="bg-gradient-to-r from-[#78350f] via-[#b45309] to-[#d97706] text-white px-4 py-3 shadow-lg flex items-center justify-between">
        <h2 class="font-semibold text-base">@yield('title')</h2>
        <div class="flex items-center gap-2">
            <a href="{{ route('portal.notifikasi.index') }}" class="relative p-2 rounded-xl hover:bg-amber-600/20">
                <i class="fa fa-bell text-white text-lg"></i>
                @if($unreadCount > 0)
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold rounded-full w-5 h-5 flex items-center justify-center">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                @endif
            </a>
        </div>
    </header>

    <main class="flex-1 overflow-y-auto pb-20">
        <div class="p-4">
            @yield('content')
        </div>
    </main>

    {{-- Mobile Bottom Nav --}}
    <nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-amber-100 shadow-lg md:hidden">
        <div class="flex">
            <a href="{{ route('portal.dashboard') }}"
               class="flex-1 py-3 text-center flex flex-col items-center gap-1 {{ request()->routeIs('portal.dashboard') ? 'text-amber-700 border-t-2 border-amber-600' : 'text-gray-600' }}">
                <i class="fa fa-file-alt text-lg"></i>
                <span class="text-xs">Slip Gaji</span>
            </a>
            <a href="{{ route('portal.profile') }}"
               class="flex-1 py-3 text-center flex flex-col items-center gap-1 {{ request()->routeIs('portal.profile') ? 'text-amber-700 border-t-2 border-amber-600' : 'text-gray-600' }}">
                <i class="fa fa-user text-lg"></i>
                <span class="text-xs">Profil</span>
            </a>
            <a href="{{ route('portal.notifikasi.index') }}"
               class="flex-1 py-3 text-center flex flex-col items-center gap-1 {{ request()->routeIs('portal.notifikasi.*') ? 'text-amber-700 border-t-2 border-amber-600' : 'text-gray-600' }}">
                <i class="fa fa-bell text-lg"></i>
                <span class="text-xs">Notifikasi</span>
                @if($unreadCount > 0)
                    <span class="absolute mt-1 bg-red-500 text-white text-[10px] font-bold rounded-full w-5 h-5 flex items-center justify-center">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                @endif
            </a>
            <button onclick="confirmLogout()"
                    class="flex-1 py-3 text-center flex flex-col items-center gap-1 text-red-600">
                <i class="fa fa-sign-out-alt text-lg"></i>
                <span class="text-xs">Logout</span>
            </button>
        </div>
    </nav>

    <form id="logoutForm" method="POST" action="{{ route('portal.logout') }}" class="hidden">
        @csrf
    </form>
    <script>
        function confirmLogout() {
            if (confirm('Yakin ingin logout?')) {
                document.getElementById('logoutForm').submit();
            }
        }
    </script>
</div>

<!-- Toast Container -->
<div id="toastContainer" class="fixed bottom-6 right-6 z-50 flex flex-col gap-3 pointer-events-none"></div>

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

// Toasts (amber success)
function showToast(message, type = 'success') {
    const container = document.getElementById('toastContainer');
    const colors = { success: 'bg-amber-600 text-white', error: 'bg-red-600 text-white', info: 'bg-blue-600 text-white' };
    const icons = { success: '✓', error: '✕', info: 'ℹ' };
    const toast = document.createElement('div');
    toast.className = `pointer-events-auto flex items-center gap-3 px-5 py-3 rounded-xl shadow-lg text-sm font-medium transform translate-y-4 opacity-0 transition-all duration-300 ${colors[type]}`;
    toast.innerHTML = `<span class="text-lg font-bold">${icons[type]}</span><span>${message}</span>`;
    container.appendChild(toast);
    requestAnimationFrame(() => { requestAnimationFrame(() => { toast.classList.remove('translate-y-4', 'opacity-0'); }); });
    setTimeout(() => { toast.classList.add('translate-y-4', 'opacity-0'); setTimeout(() => toast.remove(), 300); }, 4000);
}

@if(session('success'))
    showToast("{{ session('success') }}", 'success');
@endif
@if(session('error'))
    showToast("{{ session('error') }}", 'error');
@endif
</script>

</body>
</html>
*** End Patch