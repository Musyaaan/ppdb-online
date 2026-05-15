<style>
    * {
        text-decoration: none;
    }
</style>
<nav class="navbar" id="navbar">
    <div class="nav-container">
        <div class="logo-area">
            <img src="{{ asset('image/Logo4.png') }}" alt="Logo Legok 3" class="logo-img">
            <div class="logo-text">
                <div class="main">SD Negeri Legok III</div>
            </div>
        </div>
        <div class="nav-links">
            <a href="{{ route('home') }}" {{ request()->routeIs('home') ? 'class=active' : '' }}>
                Beranda
            </a>
            <a href="{{ route('ppdb') }}" {{ request()->routeIs('ppdb') ? 'class=active' : '' }}>
                Penerimaan Siswa Baru
            </a>
            <a href="{{ route('galeri') }}" {{ request()->routeIs('galeri') ? 'class=active' : '' }}>
                Galeri
            </a>
            <a href="{{ route('kontak') }}" {{ request()->routeIs('kontak') ? 'class=active' : '' }}>
                Hubungi Kami
            </a>
        </div>
        <div class="nav-actions">
            <div class="nav-actions">
                <a href="{{ route('login') }}" class="btn-apply">
                    Register/Login
                </a>
            </div>
        </div>
    </div>
</nav>