@extends('layouts.app')

@section('title', 'Dashboard - PPDB SD Negeri Legok III')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
@endsection

@section('content')

    <div class="dashboard-wrapper">

        {{-- ======================================================= --}}
        {{-- SIDEBAR --}}
        {{-- ======================================================= --}}
        <aside class="sidebar" id="sidebar">

            <div class="sidebar-header">
                <img src="{{ asset('image/Logo4.png') }}" alt="Logo" class="sidebar-logo">
                <div class="sidebar-brand">
                    <span class="sidebar-brand-title">PPDB Online</span>
                    <span class="sidebar-brand-sub">SD Negeri Legok III</span>
                </div>
            </div>

            <nav class="sidebar-nav">
                <a href="{{ route('dashboard.orangtua') }}" class="sidebar-nav-item active">
                    <i class="fa-solid fa-house"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('formulir.index') }}" class="sidebar-nav-item">
                    <i class="fa-solid fa-file-pen"></i>
                    <span>Formulir Pendaftaran</span>
                </a>
                <a href="{{ route('dokumen.index') }}" class="sidebar-nav-item">
                    <i class="fa-solid fa-file-arrow-up"></i>
                    <span>Upload Dokumen</span>
                </a>
                <a href="{{ route('cetak.index') }}" class="sidebar-nav-item">
                    <i class="fa-solid fa-print"></i>
                    <span>Cetak Bukti</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <a href="{{ route('profil') }}" class="sidebar-nav-item">
                    <i class="fa-solid fa-circle-user"></i>
                    <span>Profil</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="sidebar-logout">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>

        </aside>

        {{-- ======================================================= --}}
        {{-- MAIN CONTENT --}}
        {{-- ======================================================= --}}
        <main class="dashboard-main">

            {{-- TOP BAR --}}
            <header class="topbar">
                <button class="topbar-toggle" id="sidebarToggle">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <a href="{{ route('profil') }}" class="topbar-user" style="text-decoration:none;">
                    <div class="topbar-user-info">
                        <span class="topbar-user-name">{{ Auth::user()->nama }}</span>
                        <span class="topbar-user-role">Orang Tua / Wali Murid</span>
                    </div>
                    <div class="topbar-avatar">
                        {{ strtoupper(substr(Auth::user()->nama, 0, 1)) }}
                    </div>
                </a>
            </header>

            <div class="dashboard-content">

                {{-- WELCOME --}}
                <div class="welcome-banner">
                    <div class="welcome-text">
                        <h1 class="welcome-title">Selamat Datang, {{ explode(' ', Auth::user()->nama)[0] }}!</h1>
                        <p class="welcome-sub">
                            Silakan daftarkan anak Anda melalui tombol di bawah ini.
                        </p>
                    </div>
                </div>

                {{-- PROGRESS TRACKER --}}
                <div class="section-card">
                    <h2 class="section-title">
                        <i class="fa-solid fa-list-check"></i>
                        Progress Pendaftaran
                    </h2>
                    <div class="progress-tracker">

    {{-- Step 1: Formulir --}}
    <div class="progress-step {{ $progressStep >= 1 ? 'done' : '' }} {{ $progressStep == 0 ? 'active' : '' }}">
        <div class="step-circle">
            @if($progressStep >= 1) <i class="fa-solid fa-check"></i>
            @else <span>1</span> @endif
        </div>
        <div class="step-info">
            <span class="step-label">Formulir Pendaftaran</span>
            <span class="step-status">
                @if($progressStep >= 1) Selesai @else Belum dimulai @endif
            </span>
        </div>
    </div>

    <div class="progress-line {{ $progressStep >= 2 ? 'done' : '' }}"></div>

    {{-- Step 2: Upload Dokumen --}}
    <div class="progress-step {{ $progressStep >= 2 ? 'done' : '' }} {{ $progressStep == 1 ? 'active' : '' }}">
        <div class="step-circle">
            @if($progressStep >= 2) <i class="fa-solid fa-check"></i>
            @else <span>2</span> @endif
        </div>
        <div class="step-info">
            <span class="step-label">Upload Dokumen</span>
            <span class="step-status">
                @if($progressStep >= 2) Selesai
                @elseif($progressStep == 1) Perlu dilengkapi
                @else Menunggu @endif
            </span>
        </div>
    </div>

    <div class="progress-line {{ $progressStep >= 3 ? 'done' : '' }}"></div>

    {{-- Step 3: Cetak Bukti --}}
    <div class="progress-step {{ $progressStep >= 3 ? 'done' : '' }} {{ $progressStep == 2 ? 'active' : '' }}">
        <div class="step-circle">
            @if($progressStep >= 3) <i class="fa-solid fa-check"></i>
            @else <span>3</span> @endif
        </div>
        <div class="step-info">
            <span class="step-label">Cetak Bukti</span>
            <span class="step-status">
                @if($progressStep >= 3) Selesai
                @elseif($progressStep == 2) Siap dicetak
                @else Menunggu @endif
            </span>
        </div>
    </div>

    <div class="progress-line {{ $progressStep >= 4 ? 'done' : '' }}"></div>

    {{-- Step 4: Verifikasi Admin --}}
    <div class="progress-step {{ $progressStep >= 4 ? 'done' : '' }} {{ $progressStep == 3 ? 'active' : '' }}">
        <div class="step-circle">
            @if($progressStep >= 4) <i class="fa-solid fa-check"></i>
            @else <span>4</span> @endif
        </div>
        <div class="step-info">
            <span class="step-label">Verifikasi Admin</span>
            <span class="step-status">
                @if($progressStep >= 4) Selesai
                @elseif($progressStep == 3) Sedang diproses
                @else Menunggu @endif
            </span>
        </div>
    </div>

    <div class="progress-line {{ $progressStep >= 5 ? 'done' : '' }}"></div>

    {{-- Step 5: Status Penerimaan --}}
    <div class="progress-step {{ $progressStep >= 5 ? 'done' : '' }} {{ $progressStep == 4 ? 'active' : '' }}">
        <div class="step-circle">
            @if($progressStep >= 5)
                @if($pendaftaran && $pendaftaran->status === 'ditolak')
                    <i class="fa-solid fa-xmark"></i>
                @else
                    <i class="fa-solid fa-check"></i>
                @endif
            @else <span>5</span> @endif
        </div>
        <div class="step-info">
            <span class="step-label">Status Penerimaan</span>
            <span class="step-status">
                @if($progressStep >= 5)
                    @if($pendaftaran && $pendaftaran->status === 'diterima') Diterima
                    @elseif($pendaftaran && $pendaftaran->status === 'ditolak') Ditolak
                    @else Selesai @endif
                @elseif($progressStep == 4) Menunggu keputusan
                @else Menunggu @endif
            </span>
        </div>
    </div>

</div>
                </div>

                {{-- STATUS PENDAFTARAN --}}
                @if($pendaftaran)
                    <div class="section-card">
                        <h2 class="section-title">
                            <i class="fa-solid fa-circle-info"></i>
                            Status Pendaftaran
                        </h2>
                        <div class="status-grid">
                            <div class="status-item">
                                <span class="status-label">No. Pendaftaran</span>
                                <span
                                    class="status-value">#{{ str_pad($pendaftaran->id_pendaftaran, 5, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            <div class="status-item">
                                <span class="status-label">Nama Calon Siswa</span>
                                <span class="status-value">{{ $siswa->nama_siswa ?? '-' }}</span>
                            </div>
                            <div class="status-item">
                                <span class="status-label">Tanggal Daftar</span>
                                <span
                                    class="status-value">{{ \Carbon\Carbon::parse($pendaftaran->tanggal_daftar)->format('d M Y') }}</span>
                            </div>
                            <div class="status-item">
                                <span class="status-label">Status Pendaftaran</span>
                                <span class="status-badge status-{{ $pendaftaran->status }}">
                                    {{ ucfirst($pendaftaran->status) }}
                                </span>
                            </div>
                        </div>

                        @if($pendaftaran->catatan_admin)
                            <div class="catatan-admin">
                                <i class="fa-solid fa-comment-dots"></i>
                                <div>
                                    <strong>Catatan Admin:</strong>
                                    <p>{{ $pendaftaran->catatan_admin }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

                {{-- MENU AKSI --}}
                <div class="menu-grid">

                    {{-- FORMULIR --}}
                    <div class="menu-card">
                        <div class="menu-card-icon icon-blue">
                            <i class="fa-solid fa-file-pen"></i>
                        </div>
                        <div class="menu-card-body">
                            <h3 class="menu-card-title">Formulir Pendaftaran</h3>
                            <p class="menu-card-desc">
                                Isi data diri calon siswa, data orang tua, dan data pendidikan sebelumnya.
                            </p>
                            <div class="menu-card-meta">
                                @if($progressStep >= 1)
                                    <span class="badge-done"><i class="fa-solid fa-check"></i> Sudah diisi</span>
                                @else
                                    <span class="badge-pending">Belum diisi</span>
                                @endif
                            </div>
                        </div>
                        <a href="{{ route('formulir.index') }}" class="menu-card-btn">
                            {{ $progressStep >= 1 ? 'Lihat / Edit' : 'Mulai Isi' }}
                        </a>
                    </div>

                    {{-- UPLOAD DOKUMEN --}}
                    <div class="menu-card {{ $progressStep < 1 ? 'menu-card-disabled' : '' }}">
                        <div class="menu-card-icon icon-green">
                            <i class="fa-solid fa-file-arrow-up"></i>
                        </div>
                        <div class="menu-card-body">
                            <h3 class="menu-card-title">Upload Dokumen</h3>
                            <p class="menu-card-desc">
                                Upload KK, Akta Kelahiran, Ijazah TK, dan Pas Foto calon siswa.
                            </p>
                            <div class="menu-card-meta">
                                @if($progressStep >= 2)
                                    <span class="badge-done"><i class="fa-solid fa-check"></i> {{ $dokumen->count() }} dokumen
                                        terupload</span>
                                @elseif($progressStep == 1)
                                    <span class="badge-pending">{{ $dokumen->count() }}/4 dokumen</span>
                                @else
                                    <span class="badge-locked"><i class="fa-solid fa-lock"></i> Isi formulir dulu</span>
                                @endif
                            </div>
                        </div>
                        <a href="{{ route('dokumen.index') }}" class="menu-card-btn {{ $progressStep < 1 ? 'btn-disabled' : '' }}">
                            {{ $progressStep >= 2 ? 'Lihat Dokumen' : 'Upload Sekarang' }}
                        </a>
                    </div>

                    {{-- CETAK BUKTI --}}
                    <div class="menu-card {{ $progressStep < 2 ? 'menu-card-disabled' : '' }}">
                        <div class="menu-card-icon icon-orange">
                            <i class="fa-solid fa-print"></i>
                        </div>
                        <div class="menu-card-body">
                            <h3 class="menu-card-title">Cetak Bukti Pendaftaran</h3>
                            <p class="menu-card-desc">
                                Download bukti pendaftaran agar step 3 bisa selesai dan pendaftaran dianggap sah.
                            </p>
                            <div class="menu-card-meta">
                                @if($progressStep >= 3)
                                    <span class="badge-done"><i class="fa-solid fa-check"></i> Sudah dicetak</span>
                                @elseif($progressStep == 2)
                                    <span class="badge-ready"><i class="fa-solid fa-circle-check"></i> Siap dicetak</span>
                                @else
                                    <span class="badge-locked"><i class="fa-solid fa-lock"></i> Upload dokumen dulu</span>
                                @endif
                            </div>
                        </div>
                        <a href="{{ route('cetak.index') }}" class="menu-card-btn {{ $progressStep < 2 ? 'btn-disabled' : '' }}">
                            {{ $progressStep >= 3 ? 'Unduh Lagi' : 'Cetak Sekarang' }}
                        </a>
                    </div>

                </div>

            </div>
        </main>

    </div>

    <script>
        // SIDEBAR TOGGLE (mobile)
        const toggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');

        toggle.addEventListener('click', () => {
            sidebar.classList.toggle('sidebar-open');
        });
    </script>

@endsection