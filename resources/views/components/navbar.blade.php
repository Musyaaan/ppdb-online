<style>
    * {
        text-decoration: none;
    }
</style>
<nav class="navbar" id="navbar">
    <div class="nav-container">
        <div class="logo-area">
            <img src="{{ asset('image/Logo.png') }}" alt="Logo Legok 3" class="logo-img">
            <div class="logo-text">
                <div class="main">SD Negeri Legok III</div>
            </div>
        </div>
        <div class="nav-links">
            <a href="{{ route('home') }}" {{ request()->routeIs('home') ? 'class=active' : '' }}>
                Informasi Sekolah
            </a>
            <div class="nav-dropdown">
                <span class="nav-dropdown-toggle {{ request()->routeIs('ppdb.*') ? 'active' : '' }}">
                    Penerimaan Siswa Baru
                </span>
                <ul class="nav-dropdown-menu">
                    <li><a href="{{ route('ppdb.jadwal') }}">Jadwal Pendaftaran</a></li>
                    <li><a href="{{ route('ppdb.persyaratan') }}">Persyaratan Pendaftaran</a></li>
                    <li><a href="{{ route('ppdb.alur') }}">Alur PPDB Online</a></li>
                    <li><a href="{{ route('ppdb.online') }}">PPDB Online</a></li>
                    <li><a href="{{ route('ppdb.faq') }}">FAQ PPDB</a></li>
                </ul>
            </div>
            <a href="#">Hubungi Kami</a>
        </div>
        <div class="nav-actions">
            <div class="nav-actions">
                <a href="{{ route('login') }}" class="btn-apply">
                    Register/Login
                </a>

                <a href="{{ route('register') }}" class="btn-apply">
                    Daftar PPDB
                </a>
            </div>
        </div>
    </div>
</nav>