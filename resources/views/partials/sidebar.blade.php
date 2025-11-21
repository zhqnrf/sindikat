{{-- Sidebar --}}
<div class="sidebar">
    <div>
        <div class="sidebar-header">
            {{-- Pastikan file 'icon.png' ada di public folder --}}
            <img class="image-sidebar" src="{{ asset('icon.png') }}" alt="Logo">
            <button class="sidebar-toggle" id="sidebarToggle">
                <i class="bi bi-chevron-left"></i>
            </button>
        </div>

        <div class="sidebar-search">
            <div class="search-container">
                <input type="text" class="search-input" placeholder="Cari menu...">
                <i class="bi bi-search search-icon"></i>
            </div>
        </div>

        <nav class="nav flex-column sidebar-nav-container">

            {{-- GRUP 1: MENU UTAMA --}}
            <div class="sidebar-heading">
                <span class="sidebar-text">Menu Utama</span>
            </div>

            <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="bi bi-house-door"></i>
                <span class="sidebar-text">Dashboard</span>
            </a>

            {{-- ========================================== --}}
            {{-- MENU KHUSUS ADMIN (Tidak Diubah)           --}}
            {{-- ========================================== --}}
            @if (auth()->check() && auth()->user()->role === 'admin')
                <div class="sidebar-heading">
                    <span class="sidebar-text">Administrasi</span>
                </div>

                <a class="nav-link {{ request()->is('users*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                    <i class="bi bi-person-gear"></i>
                    <span class="sidebar-text">Manajemen User</span>
                </a>

                <a class="nav-link {{ request()->is('pengajuan*') ? 'active' : '' }}"
                    href="{{ route('admin.pengajuan.index') }}">
                    <i class="bi bi-hourglass-split"></i>
                    <span class="sidebar-text">Approval Pengajuan</span>
                </a>

                @php $isMouActive = request()->is('mou*'); @endphp
                <div class="nav-item-dropdown">
                    <a class="nav-link {{ $isMouActive ? 'active-parent' : '' }}" data-bs-toggle="collapse"
                        href="#menuMou" role="button" aria-expanded="{{ $isMouActive ? 'true' : 'false' }}">
                        <i class="bi bi-file-earmark-text"></i>
                        <span class="sidebar-text">MOU</span>
                        <i class="bi bi-chevron-down sidebar-arrow"></i>
                    </a>
                    <div class="collapse sub-menu {{ $isMouActive ? 'show' : '' }}" id="menuMou">
                        <a class="nav-link {{ request()->is('mou') ? 'active' : '' }}"
                            href="{{ route('mou.index') }}">
                            <span class="sidebar-text">List MOU</span>
                        </a>
                    </div>
                </div>

                @php
                    $isPendidikanActive =
                        request()->is('mahasiswa*') || request()->is('ruangan*') || request()->is('absensi*');
                @endphp
                <div class="nav-item-dropdown">
                    <a class="nav-link {{ $isPendidikanActive ? 'active-parent' : '' }}" data-bs-toggle="collapse"
                        href="#menuPendidikan" role="button"
                        aria-expanded="{{ $isPendidikanActive ? 'true' : 'false' }}">
                        <i class="bi bi-mortarboard"></i>
                        <span class="sidebar-text">Pendidikan</span>
                        <i class="bi bi-chevron-down sidebar-arrow"></i>
                    </a>
                    <div class="collapse sub-menu {{ $isPendidikanActive ? 'show' : '' }}" id="menuPendidikan">
                        <a class="nav-link {{ request()->is('mahasiswa*') ? 'active' : '' }}"
                            href="{{ route('mahasiswa.index') }}">
                            <span class="sidebar-text">Mahasiswa</span>
                        </a>
                        <a class="nav-link {{ request()->is('ruangan*') ? 'active' : '' }}"
                            href="{{ route('ruangan.index') }}">
                            <span class="sidebar-text">Ruangan</span>
                        </a>
                        <a class="nav-link {{ request()->is('absensi*') ? 'active' : '' }}"
                            href="{{ route('absensi.index') }}">
                            <span class="sidebar-text">Riwayat Absensi</span>
                        </a>
                    </div>
                </div>

                <a class="nav-link {{ request()->is('surat-balasan*') ? 'active' : '' }}"
                    href="{{ route('surat-balasan.index') }}">
                    <i class="bi bi-envelope-paper"></i>
                    <span class="sidebar-text">Surat Balasan</span>
                </a>

                @php $isPelatihanActive = request()->is('pelatihan*'); @endphp
                <div class="nav-item-dropdown">
                    <a class="nav-link {{ $isPelatihanActive ? 'active-parent' : '' }}" data-bs-toggle="collapse"
                        href="#menuPelatihan" role="button"
                        aria-expanded="{{ $isPelatihanActive ? 'true' : 'false' }}">
                        <i class="bi bi-people"></i>
                        <span class="sidebar-text">Pelatihan</span>
                        <i class="bi bi-chevron-down sidebar-arrow"></i>
                    </a>
                    <div class="collapse sub-menu {{ $isPelatihanActive ? 'show' : '' }}" id="menuPelatihan">
                        <a class="nav-link {{ request()->is('pelatihan') ? 'active' : '' }}"
                            href="{{ route('pelatihan.index') }}">
                            <span class="sidebar-text">List Pelatihan</span>
                        </a>
                        <a class="nav-link {{ request()->is('pelatihan') ? 'active' : '' }}"
                            href="{{ route('public.pelatihan.index') }}">
                            <span class="sidebar-text">Search Pelatihan</span>
                        </a>
                    </div>
                </div>

                @php $isPenelitianActive = request()->is('penelitian*'); @endphp
                <div class="nav-item-dropdown">
                    <a class="nav-link {{ $isPenelitianActive ? 'active-parent' : '' }}" data-bs-toggle="collapse"
                        href="#menuPenelitian" role="button"
                        aria-expanded="{{ $isPenelitianActive ? 'true' : 'false' }}">
                        <i class="bi bi-journal-richtext"></i>
                        <span class="sidebar-text">Penelitian</span>
                        <i class="bi bi-chevron-down sidebar-arrow"></i>
                    </a>
                    <div class="collapse sub-menu {{ $isPenelitianActive ? 'show' : '' }}" id="menuPenelitian">
                        <a class="nav-link {{ request()->is('penelitian*') ? 'active' : '' }}"
                            href="{{ route('pra-penelitian.index') }}">
                            <span class="sidebar-text">Pra-Penelitian</span>
                        </a>
                    </div>
                </div>
            @endif

            {{-- ========================================== --}}
            {{-- MENU KHUSUS USER (LOGIKA BARU)             --}}
            {{-- ========================================== --}}
            @if (auth()->check() && auth()->user()->role === 'user')

                @php
                    // PERBAIKAN: Jangan pakai 'use' di sini.
                    // Gunakan langsung \App\Models\Pengajuan (pakai backslash)

                    $userId = auth()->id();

                    // Ambil data spesifik
                    $pra = \App\Models\Pengajuan::where('user_id', $userId)
                        ->where('jenis', 'pra_penelitian')
                        ->latest()
                        ->first();
                    $magang = \App\Models\Pengajuan::where('user_id', $userId)
                        ->where('jenis', 'magang')
                        ->latest()
                        ->first();

                    // Cek apakah user sudah punya akses (status approved)
                    $hasPraAccess = $pra && $pra->status === 'approved';
                    $hasMagangAccess = $magang && $magang->status === 'approved';
                @endphp

                <div class="sidebar-heading">
                    <span class="sidebar-text">Layanan</span>
                </div>

                {{-- 1. MENU STATUS & PENGAJUAN (Selalu Muncul) --}}
                <a class="nav-link {{ request()->is('pengajuan*') ? 'active' : '' }}"
                    href="{{ route('pengajuan.index') }}">
                    <i class="bi bi-grid-1x2"></i>
                    <span class="sidebar-text">Pengajuan & Status</span>
                </a>

                {{-- 2. MENU AKSES (Hanya muncul jika Approved) --}}

                {{-- Akses Magang --}}
                @if ($hasMagangAccess)
                    <div class="sidebar-heading mt-2">
                        <span class="sidebar-text">Aktivitas Magang</span>
                    </div>
                    <a class="nav-link {{ request()->routeIs('mahasiswa.create') ? 'active' : '' }}"
                        href="{{ route('mahasiswa.create') }}">
                        <i class="bi bi-briefcase"></i>
                        <span class="sidebar-text">Biodata Magang</span>
                    </a>
                @endif

                {{-- Akses Pra-Penelitian --}}
                @if ($hasPraAccess)
                    <div class="sidebar-heading mt-2">
                        <span class="sidebar-text">Aktivitas Penelitian</span>
                    </div>
                    <a class="nav-link {{ request()->routeIs('pra-penelitian.create') ? 'active' : '' }}"
                        href="{{ route('pra-penelitian.create') }}">
                        <i class="bi bi-journal-check"></i>
                        <span class="sidebar-text">Data Pra-Penelitian</span>
                    </a>
                @endif

            @endif

        </nav>
    </div>

    {{-- User Profile di Bawah (Tetap sama) --}}
    <div class="p-3 sidebar-user-profile">
        <a class="nav-link logout-link" href="#"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-right"></i>
            <span class="sidebar-text">Logout</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

        <hr class="logout-divider">

        <div class="d-flex align-items-center">
            @if (auth()->check())
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=7c1316&color=fff"
                    class="rounded-circle me-2" width="40" height="40" alt="User">
                <div class="sidebar-text">
                    <div class="fw-bold text-truncate" style="max-width: 140px;">{{ auth()->user()->name }}</div>
                    <small>{{ ucfirst(auth()->user()->role ?? 'user') }}</small>
                </div>
            @else
                <img src="https://ui-avatars.com/api/?name=Guest&background=7c1316&color=fff"
                    class="rounded-circle me-2" width="40" height="40" alt="User">
                <div class="sidebar-text">
                    <div class="fw-bold">Guest</div>
                    <small>Visitor</small>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Fitur Search Sidebar
        const searchInput = document.querySelector('.sidebar-search .search-input');
        if (searchInput) {
            searchInput.addEventListener('input', function(e) {
                filterSidebar(e.target.value);
            });
        }

        // 2. Toggle Sidebar
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.querySelector('.sidebar');

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
            });
        }
    });

    function filterSidebar(filterText) {
        const text = filterText.toLowerCase();
        const navContainer = document.querySelector('.sidebar-nav-container');
        const headings = navContainer.querySelectorAll('.sidebar-heading');
        const items = navContainer.querySelectorAll(
            '.sidebar-nav-container > .nav-link, .sidebar-nav-container > .nav-item-dropdown');
        const allSubLinks = navContainer.querySelectorAll('.sub-menu .nav-link');

        // RESET STATE
        if (text === '') {
            headings.forEach(h => h.style.display = 'block');
            items.forEach(item => item.style.display = 'block');
            allSubLinks.forEach(sub => sub.style.display = '');

            navContainer.querySelectorAll('.sub-menu').forEach(sub => {
                const parentLink = sub.closest('.nav-item-dropdown').querySelector(
                    '[data-bs-toggle="collapse"]');
                if (!parentLink.classList.contains('active-parent')) {
                    sub.classList.remove('show');
                    parentLink.setAttribute('aria-expanded', 'false');
                }
            });
            return;
        }

        // FILTERING
        headings.forEach(h => h.style.display = 'none');
        allSubLinks.forEach(sub => sub.style.display = 'none');

        items.forEach(item => {
            let groupHasMatch = false;
            const mainLink = item.matches('.nav-link') ? item : item.querySelector(
                '[data-bs-toggle="collapse"]');
            const mainText = mainLink.querySelector('.sidebar-text')?.textContent.toLowerCase() || '';

            if (mainText.includes(text)) {
                groupHasMatch = true;
            }

            if (item.matches('.nav-item-dropdown')) {
                const subLinks = item.querySelectorAll('.sub-menu .nav-link');
                subLinks.forEach(subLink => {
                    const subText = subLink.textContent.toLowerCase();
                    if (subText.includes(text)) {
                        groupHasMatch = true;
                        subLink.style.display = '';
                    }
                });
            }

            if (groupHasMatch) {
                item.style.display = 'block';
                if (item.matches('.nav-item-dropdown')) {
                    item.querySelector('.sub-menu').classList.add('show');
                    item.querySelector('[data-bs-toggle="collapse"]').setAttribute('aria-expanded', 'true');
                }
                // Show Heading
                let heading = item.previousElementSibling;
                while (heading) {
                    if (heading.classList.contains('sidebar-heading')) {
                        heading.style.display = 'block';
                        break;
                    }
                    heading = heading.previousElementSibling;
                }
            } else {
                item.style.display = 'none';
            }
        });
    }
</script>

<style>
    /* ========================================= */
    /* --- STYLING SIDEBAR (PILL UI/UX) --- */
    /* ========================================= */
    :root {
        --maroon: #7c1316;
        --maroon-light: #a3191d;
        --sidebar-bg: var(--maroon);
        --sidebar-text-color: #e0e0e0;
        --sidebar-text-active: #ffffff;
        --sidebar-pill-hover: rgba(255, 255, 255, 0.1);
        --sidebar-pill-active: var(--maroon-light);
        --sidebar-heading-color: rgba(255, 255, 255, 0.5);
        --transition-speed: 0.25s;
        text-decoration: none !important;
    }

    .sidebar {
        width: 250px;
        min-height: 100vh;
        background: var(--sidebar-bg);
        color: var(--sidebar-text-color);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        position: fixed;
        top: 0;
        left: 0;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        z-index: 1000;
        transition: width var(--transition-speed) ease;
    }

    .sidebar.collapsed {
        width: 80px;
    }

    /* --- Header & Logo --- */
    .sidebar-header {
        text-align: center;
        padding: 1.5rem 1rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        position: relative;
        height: 121px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .image-sidebar {
        width: 77%;
        height: 90px;
        object-fit: cover;
        border-radius: 8px;
        transition: opacity 0.1s;
    }

    .sidebar.collapsed .image-sidebar {
        opacity: 0;
        display: none;
    }

    .sidebar-toggle {
        position: absolute;
        right: -15px;
        top: 30px;
        transform: translateY(-50%);
        background: #fff;
        border: 1px solid #e0e0e0;
        color: var(--maroon);
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all var(--transition-speed);
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        z-index: 1001;
    }

    .sidebar.collapsed .sidebar-toggle {
        right: -15px;
    }

    .sidebar-toggle:hover {
        background: var(--maroon);
        color: white;
        border-color: var(--maroon);
        transform: scale(1.1);
    }

    .sidebar-toggle i {
        transition: transform var(--transition-speed) ease;
    }

    .sidebar.collapsed .sidebar-toggle i {
        transform: rotate(180deg);
    }

    /* --- Search Bar --- */
    .sidebar-search {
        padding: 1rem;
    }

    .search-container {
        position: relative;
    }

    .search-input {
        width: 100%;
        padding: 0.6rem 2.2rem 0.6rem 1rem;
        border-radius: 8px;
        border: none;
        background: rgba(0, 0, 0, 0.15);
        color: white;
        transition: all var(--transition-speed);
        font-size: 0.9rem;
    }

    .search-input::placeholder {
        color: rgba(255, 255, 255, 0.6);
    }

    .search-input:focus {
        outline: none;
        background: rgba(0, 0, 0, 0.3);
        box-shadow: 0 0 0 2px var(--maroon-light);
    }

    .search-icon {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: rgba(255, 255, 255, 0.6);
    }

    .sidebar.collapsed .sidebar-search {
        display: none;
    }

    /* --- Navigasi Container --- */
    .sidebar-nav-container {
        flex-grow: 1;
        overflow-y: auto;
        overflow-x: hidden;
        padding: 0 1rem;
    }

    /* Judul Grup */
    .sidebar-heading {
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--sidebar-heading-color);
        padding: 1.5rem 0.5rem 0.5rem;
        white-space: nowrap;
        overflow: hidden;
        transition: opacity var(--transition-speed);
    }

    .sidebar.collapsed .sidebar-heading {
        padding-top: 1rem;
        padding-bottom: 0;
    }

    .sidebar.collapsed .sidebar-heading .sidebar-text {
        display: none;
    }

    /* --- Link Navigasi (Pill Style) --- */
    .nav-link {
        color: var(--sidebar-text-color);
        padding: 0.7rem 0.8rem;
        display: flex;
        align-items: center;
        border-radius: 8px;
        margin: 0.15rem 0;
        transition: all var(--transition-speed) ease;
        position: relative;
        white-space: nowrap;
        overflow: hidden;
    }

    .nav-link i {
        margin-right: 12px;
        font-size: 1.2rem;
        min-width: 24px;
        text-align: center;
        transition: all var(--transition-speed) ease;
    }

    .nav-link:hover {
        background: var(--sidebar-pill-hover);
        color: var(--sidebar-text-active);
    }

    .nav-link.active {
        background: var(--sidebar-pill-active);
        color: var(--sidebar-text-active);
        font-weight: 500;
    }

    .nav-link.active-parent {
        color: var(--sidebar-text-active);
    }

    /* --- Style Saat Collapsed --- */
    .sidebar.collapsed .nav-link {
        padding: 0.7rem 0;
        justify-content: center;
    }

    .sidebar.collapsed .nav-link i {
        margin-right: 0;
        font-size: 1.3rem;
    }

    .sidebar.collapsed .sidebar-text {
        display: none;
    }

    .sidebar.collapsed .sidebar-arrow {
        display: none;
    }

    .sidebar.collapsed .sub-menu {
        display: none !important;
    }

    /* --- Dropdown Arrow --- */
    .sidebar-arrow {
        font-size: 0.8rem;
        margin-left: auto;
        transition: transform var(--transition-speed) ease;
    }

    .nav-link[aria-expanded="true"] .sidebar-arrow {
        transform: rotate(180deg);
    }

    /* --- Sub-Menu (Line-and-Dot Style) --- */
    .sub-menu {
        position: relative;
        padding-left: 2.1rem;
        margin-left: 0.8rem;
    }

    .sub-menu::before {
        content: '';
        position: absolute;
        left: 0;
        top: 10px;
        bottom: 10px;
        width: 2px;
        background: rgba(255, 255, 255, 0.15);
        border-radius: 2px;
    }

    .sub-menu .nav-link {
        padding: 0.5rem 0.5rem;
        font-size: 0.9rem;
        position: relative;
        background: transparent !important;
    }

    .sub-menu .nav-link::before {
        content: '';
        position: absolute;
        left: -1.3rem;
        top: 50%;
        transform: translateY(-50%);
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.4);
        transition: all var(--transition-speed);
    }

    .sub-menu .nav-link:hover {
        color: var(--sidebar-text-active);
    }

    .sub-menu .nav-link:hover::before {
        background: var(--sidebar-text-active);
    }

    .sub-menu .nav-link.active {
        color: var(--sidebar-text-active);
        font-weight: 500;
        background: transparent !important;
    }

    .sub-menu .nav-link.active::before {
        background: var(--sidebar-text-active);
        transform: translateY(-50%) scale(1.3);
    }

    /* --- User Profile & Logout --- */
    .sidebar-user-profile {
        padding: 1rem;
        background: rgba(0, 0, 0, 0.1);
    }

    .sidebar.collapsed .sidebar-user-profile {
        padding: 0.5rem;
    }

    .sidebar.collapsed .sidebar-user-profile .sidebar-text,
    .sidebar.collapsed .sidebar-user-profile .logout-divider {
        display: none;
    }

    .sidebar.collapsed .sidebar-user-profile .logout-link {
        justify-content: center;
    }

    .sidebar.collapsed .sidebar-user-profile .logout-link .sidebar-text {
        display: none;
    }

    .logout-link {
        padding: 0.5rem;
        color: var(--sidebar-text-color);
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .logout-link:hover {
        background: var(--sidebar-pill-hover);
        color: var(--sidebar-text-active);
    }

    .logout-divider {
        border-color: rgba(255, 255, 255, 0.1);
        margin: 0.5rem 0 1rem;
    }
</style>
