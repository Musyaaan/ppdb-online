@extends('layouts.app')

@section('title', 'Cetak Bukti Pendaftaran - PPDB SD Negeri Legok III')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
@endsection

@section('content')
<div class="dashboard-wrapper">

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
                <i class="fa-solid fa-house"></i><span>Dashboard</span>
            </a>
            <a href="{{ route('formulir.index') }}" class="sidebar-nav-item">
                <i class="fa-solid fa-file-pen"></i><span>Formulir Pendaftaran</span>
            </a>
            <a href="{{ route('dokumen.index') }}" class="sidebar-nav-item">
                <i class="fa-solid fa-file-arrow-up"></i><span>Upload Dokumen</span>
            </a>
            <a href="{{ route('cetak.index') }}" class="sidebar-nav-item active">
                <i class="fa-solid fa-print"></i><span>Cetak Bukti</span>
            </a>
        </nav>
        <div class="sidebar-footer">
            <a href="{{ route('profil') }}" class="sidebar-nav-item">
                <i class="fa-solid fa-circle-user"></i><span>Profil</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-logout">
                    <i class="fa-solid fa-right-from-bracket"></i><span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

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
            <div class="page-title-bar">
                <div>
                    <h1 class="page-title">Cetak Bukti Pendaftaran</h1>
                    <p class="page-subtitle">Simpan atau cetak bukti pendaftaran Anda.</p>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="section-card" style="padding:32px;">

                {{-- Status Badge --}}
                <div style="text-align:center; margin-bottom:24px;">
                    <span class="status-badge status-{{ $pendaftaran->status }}" style="font-size:14px; padding:8px 20px;">
                        <i class="fa-solid fa-circle-dot"></i>
                        {{ ucfirst($pendaftaran->status) }}
                    </span>
                </div>

                {{-- Header Bukti --}}
                <div style="text-align:center; border-bottom:2px solid #e0e0e0; padding-bottom:20px; margin-bottom:24px;">
                    <img src="{{ asset('image/Logo4.png') }}" style="height:64px; margin-bottom:8px;">
                    <h2 style="margin:0; font-size:18px; font-weight:700;">BUKTI PENDAFTARAN PPDB</h2>
                    <p style="margin:4px 0 0; color:#666; font-size:13px;">SD Negeri Legok III — Tahun Ajaran {{ date('Y') }}/{{ date('Y') + 1 }}</p>
                </div>

                {{-- Nomor Pendaftaran --}}
                <div style="background:#f0f9f6; border:1.5px solid #18bc9c; border-radius:10px; padding:16px; text-align:center; margin-bottom:24px;">
                    <div style="font-size:12px; color:#666; text-transform:uppercase; letter-spacing:1px;">Nomor Pendaftaran</div>
                    <div style="font-size:24px; font-weight:700; color:#0e6655; letter-spacing:2px;">
                        #{{ str_pad($pendaftaran->id_pendaftaran, 5, '0', STR_PAD_LEFT) }}
                    </div>
                    <div style="font-size:12px; color:#666; margin-top:4px;">
                        Tanggal Daftar: {{ \Carbon\Carbon::parse($pendaftaran->tanggal_daftar)->format('d F Y') }}
                    </div>
                </div>

                {{-- Data Siswa --}}
                <h3 style="font-size:14px; font-weight:700; color:#666; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:12px;">
                    <i class="fa-solid fa-user" style="color:#18bc9c;"></i> Data Siswa
                </h3>
                <table style="width:100%; font-size:14px; margin-bottom:24px; border-collapse:collapse;">
                    <tr><td style="padding:6px 0; color:#666; width:40%;">Nama Lengkap</td><td style="font-weight:600;">{{ $siswa->nama_siswa ?? '-' }}</td></tr>
                    <tr><td style="padding:6px 0; color:#666;">Tempat, Tanggal Lahir</td><td style="font-weight:600;">{{ $siswa->tempat_lahir ?? '-' }}, {{ isset($siswa->tanggal_lahir) ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d F Y') : '-' }}</td></tr>
                    <tr><td style="padding:6px 0; color:#666;">Jenis Kelamin</td><td style="font-weight:600;">{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td></tr>
                    <tr><td style="padding:6px 0; color:#666;">Agama</td><td style="font-weight:600;">{{ $siswa->agama ?? '-' }}</td></tr>
                    <tr><td style="padding:6px 0; color:#666;">Alamat</td><td style="font-weight:600;">{{ $siswa->alamat ?? '-' }}</td></tr>
                </table>

                {{-- Data Orang Tua --}}
                <h3 style="font-size:14px; font-weight:700; color:#666; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:12px;">
                    <i class="fa-solid fa-users" style="color:#18bc9c;"></i> Data Orang Tua
                </h3>
                <table style="width:100%; font-size:14px; margin-bottom:32px; border-collapse:collapse;">
                    <tr><td style="padding:6px 0; color:#666; width:40%;">Nama Ayah</td><td style="font-weight:600;">{{ $orangtua->nama_ayah ?? '-' }}</td></tr>
                    <tr><td style="padding:6px 0; color:#666;">Nama Ibu</td><td style="font-weight:600;">{{ $orangtua->nama_ibu ?? '-' }}</td></tr>
                    <tr><td style="padding:6px 0; color:#666;">No. HP / WA</td><td style="font-weight:600;">{{ $orangtua->no_hp ?? '-' }}</td></tr>
                </table>

                {{-- Tombol --}}
                <div style="display:flex; gap:12px; justify-content:center;">
                    <button onclick="window.print()" class="btn btn-primary">
                        <i class="fa-solid fa-print"></i> Cetak / Simpan PDF
                    </button>
                </div>

            </div>
        </div>
    </main>
</div>
@endsection

@push('scripts')
<script>
    var toggle = document.getElementById('sidebarToggle');
    if (toggle) toggle.addEventListener('click', function () {
        document.getElementById('sidebar').classList.toggle('sidebar-open');
    });
</script>
@endpush