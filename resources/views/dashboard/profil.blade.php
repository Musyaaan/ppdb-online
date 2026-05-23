@extends('layouts.app')

@section('title', 'Profil - PPDB SD Negeri Legok III')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profil.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
@endsection

@section('content')

<div class="dashboard-wrapper">

    {{-- SIDEBAR --}}
    <aside class="sidebar" id="sidebar">

        <div class="sidebar-header">
            <img src="{{ asset('image/Logo4.png') }}" alt="Logo" class="sidebar-logo">
            <div class="sidebar-brand">
                <span class="sidebar-brand-title">PPDB Online</span>
                <span class="sidebar-brand-sub">SD Negeri Legok III</span>
            </div>
        </div>

        <nav class="sidebar-nav">
            <a href="{{ route('dashboard.orangtua') }}" class="sidebar-nav-item">
                <i class="fa-solid fa-house"></i>
                <span>Dashboard</span>
            </a>
            <a href="#" class="sidebar-nav-item">
                <i class="fa-solid fa-file-pen"></i>
                <span>Formulir Pendaftaran</span>
            </a>
            <a href="#" class="sidebar-nav-item">
                <i class="fa-solid fa-file-arrow-up"></i>
                <span>Upload Dokumen</span>
            </a>
            <a href="#" class="sidebar-nav-item">
                <i class="fa-solid fa-print"></i>
                <span>Cetak Bukti</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <a href="{{ route('profil') }}" class="sidebar-nav-item active">
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

    {{-- MAIN --}}
    <main class="dashboard-main">

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
                    <h1 class="welcome-title">Profil Saya</h1>
                    <p class="welcome-sub">Kelola informasi akun dan data diri Anda di sini.</p>
                </div>
                <div class="welcome-icon">
                    <i class="fa-solid fa-circle-user"></i>
                </div>
            </div>

            {{-- ALERT --}}
            @if(session('success'))
                <div class="alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert-error">
                    <i class="fa-solid fa-circle-xmark"></i>
                    {{ session('error') }}
                </div>
            @endif

            <div class="profil-grid">

                {{-- KARTU AVATAR --}}
                <div class="profil-avatar-card section-card">
                    <div class="profil-avatar-circle">
                        {{ strtoupper(substr(Auth::user()->nama, 0, 1)) }}
                    </div>
                    <h3 class="profil-avatar-name">{{ Auth::user()->nama }}</h3>
                    <span class="profil-avatar-role">
                        <i class="fa-solid fa-shield-halved"></i>
                        Orang Tua / Wali Murid
                    </span>
                    <div class="profil-avatar-meta">
                        <div class="profil-meta-item">
                            <i class="fa-solid fa-envelope"></i>
                            <span>{{ Auth::user()->email }}</span>
                        </div>
                        <div class="profil-meta-item">
                            <i class="fa-solid fa-phone"></i>
                            <span>{{ Auth::user()->no_hp ?? 'Belum diisi' }}</span>
                        </div>
                    </div>
                </div>

                {{-- FORM EDIT --}}
                <div class="profil-form-col">

                    {{-- DATA DIRI --}}
                    <div class="section-card">
                        <h2 class="section-title">
                            <i class="fa-solid fa-user-pen"></i>
                            Edit Data Diri
                        </h2>

                        <form method="POST" action="{{ route('profil.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input
                                        type="text"
                                        name="nama"
                                        class="form-input @error('nama') is-error @enderror"
                                        value="{{ old('nama', Auth::user()->nama) }}"
                                        placeholder="Masukkan nama lengkap"
                                    >
                                    @error('nama')
                                        <span class="form-error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Username</label>
                                    <input
                                        type="text"
                                        name="username"
                                        class="form-input @error('username') is-error @enderror"
                                        value="{{ old('username', Auth::user()->username) }}"
                                        placeholder="Masukkan username"
                                    >
                                    @error('username')
                                        <span class="form-error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Email</label>
                                    <input
                                        type="email"
                                        name="email"
                                        class="form-input @error('email') is-error @enderror"
                                        value="{{ old('email', Auth::user()->email) }}"
                                        placeholder="Masukkan email"
                                    >
                                    @error('email')
                                        <span class="form-error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label">No. HP / WhatsApp</label>
                                    <input
                                        type="text"
                                        name="no_hp"
                                        class="form-input @error('no_hp') is-error @enderror"
                                        value="{{ old('no_hp', Auth::user()->no_hp) }}"
                                        placeholder="Contoh: 08123456789"
                                    >
                                    @error('no_hp')
                                        <span class="form-error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group form-group-full">
                                    <label class="form-label">Role</label>
                                    <input
                                        type="text"
                                        class="form-input form-input-readonly"
                                        value="Orang Tua / Wali Murid"
                                        readonly
                                    >
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn-save">
                                    <i class="fa-solid fa-floppy-disk"></i>
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- GANTI PASSWORD --}}
                    <div class="section-card">
                        <h2 class="section-title">
                            <i class="fa-solid fa-lock"></i>
                            Ganti Password
                        </h2>

                        <form method="POST" action="{{ route('profil.password') }}">
                            @csrf
                            @method('PUT')

                            <div class="form-grid">
                                <div class="form-group form-group-full">
                                    <label class="form-label">Password Lama</label>
                                    <div class="input-password">
                                        <input
                                            type="password"
                                            name="password_lama"
                                            id="passwordLama"
                                            class="form-input @error('password_lama') is-error @enderror"
                                            placeholder="Masukkan password lama"
                                        >
                                        <button type="button" class="toggle-pw" onclick="togglePw('passwordLama', this)">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('password_lama')
                                        <span class="form-error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Password Baru</label>
                                    <div class="input-password">
                                        <input
                                            type="password"
                                            name="password_baru"
                                            id="passwordBaru"
                                            class="form-input @error('password_baru') is-error @enderror"
                                            placeholder="Minimal 8 karakter"
                                        >
                                        <button type="button" class="toggle-pw" onclick="togglePw('passwordBaru', this)">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('password_baru')
                                        <span class="form-error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Konfirmasi Password Baru</label>
                                    <div class="input-password">
                                        <input
                                            type="password"
                                            name="password_baru_confirmation"
                                            id="passwordKonfirmasi"
                                            class="form-input"
                                            placeholder="Ulangi password baru"
                                        >
                                        <button type="button" class="toggle-pw" onclick="togglePw('passwordKonfirmasi', this)">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn-save btn-danger">
                                    <i class="fa-solid fa-key"></i>
                                    Ganti Password
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

        </div>
    </main>

</div>

<script>
    // Sidebar toggle
    const toggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    toggle.addEventListener('click', () => sidebar.classList.toggle('sidebar-open'));

    // Toggle show/hide password
    function togglePw(inputId, btn) {
        const input = document.getElementById(inputId);
        const icon = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }
</script>

@endsection