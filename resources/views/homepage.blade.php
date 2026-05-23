@extends('layouts.app')

@section('title', 'SD Negeri Legok III')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/navbar-footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/homepage.css') }}">
@endsection

@section('content')

    @include('components.navbar')

    <!-- Hero -->
    <div class="hero">
        <div class="hero-bg" id="heroBg1" style="background-image: url('{{ asset('image/fotobersama.jpeg') }}');"></div>
        <div class="hero-bg" id="heroBg2" style="background-image: url('{{ asset('image/fotobersama2.jpeg') }}');"></div>
        <div class="hero-bg" id="heroBg3" style="background-image: url('{{ asset('image/kartini.jpeg') }}');"></div>
        <div class="hero-bg" id="heroBg4" style="background-image: url('{{ asset('image/pramuka.jpeg') }}');"></div>
        <div class="hero-overlay"></div>
        <div class="hero-inner">
            <div class="hero-text">
                <span class="hero-sub">Selamat Datang di SD Negeri Legok III</span>
                <h1 class="hero-title">Pendidikan Terbaik<br>untuk Generasi<br>Gemilang</h1>
                <button class="hero-cta" onclick="window.location='{{ route('login') }}'">Daftar Sekarang</button>
            </div>
        </div>
    </div>

    <!-- Stats Bar -->
    <div class="stats-bar">
        <div class="stat-item">
            <div class="stat-num">28+</div>
            <div class="stat-label">Tahun Berdiri</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">550+</div>
            <div class="stat-label">Total Siswa</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">15+</div>
            <div class="stat-label">Ruang Kelas</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">19+</div>
            <div class="stat-label">Guru & Staf</div>
        </div>
    </div>

    <!-- Kepala Sekolah -->
    <div class="section">
        <div class="section-header">
            <div class="section-tag">Sambutan</div>
            <div class="section-title">Apa Kata Kepala Sekolah?</div>
        </div>
        <div class="kepsek-wrapper">
            <div class="kepsek-text">
                <span class="kepsek-quote">&ldquo;</span>
                <p>Selamat datang di SD Negeri Legok III. Kami berkomitmen untuk memberikan pendidikan terbaik bagi setiap
                    siswa
                    dengan mengedepankan nilai karakter, kedisiplinan, dan semangat belajar.</p>
                <p>Dengan dukungan tenaga pendidik yang profesional serta lingkungan belajar yang kondusif, kami berharap
                    dapat
                    membentuk generasi yang cerdas, berakhlak mulia, dan siap menghadapi masa depan.</p>
                <div class="kepsek-name">
                    <strong>Deni Wirata, S.Pd., M.MPd.</strong>
                    <span>Kepala Sekolah SDN Legok III</span>
                </div>
            </div>
            <div class="kepsek-img">
                <img src="{{ asset('image/sekolahh.jpg') }}" alt="Kepala Sekolah">
            </div>
        </div>
    </div>

    <!-- About -->
    <div class="section about-section">
        <div class="about-inner">
            <div class="about-img">
                <div class="about-img-overlay"></div>
                <img src="{{ asset('image/sekolahh.jpg') }}" alt="Gedung Sekolah"
                    style="width:100%; height:100%; object-fit:cover; position:absolute; inset:0;">
                <span class="about-caption">SD Negeri Legok III</span>
            </div>
            <div class="about-text">
                <div class="section-tag">Tentang Sekolah Kami</div>
                <h2>SDN Legok III: Membangun Masa Depan Gemilang dengan Pendidikan Berkualitas dan Karakter Unggul</h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse eveniet ipsum dolor cumque ipsam ullam
                    ratione
                    officia suscipit eaque architecto?</p>
                <p>Lorem, ipsum dolor.</p>
            </div>
        </div>
    </div>

    <!-- Visi Misi -->
    <div class="visi-misi-section">
        <div class="visi-misi-inner">
            <div class="section-header" style="text-align: center;">
                <div class="section-tag">Landasan Kami</div>
                <div class="section-title">Visi <span class="amp">&amp;</span> Misi</div>
            </div>
            <div class="visi-misi-wrapper">
                <div class="visi-box">
                    <h3>Visi</h3>
                    <p>Terwujudnya peserta didik yang beriman, bertakwa, berakhlak mulia, berprestasi, berbudaya, dan
                        berwawasan
                        lingkungan.</p>
                </div>
                <div class="vm-divider"></div>
                <div class="misi-box">
                    <h3>Misi</h3>
                    <ul class="misi-list">
                        <li>Menumbuhkan penghayatan dan pengamalan ajaran agama serta budaya bangsa sebagai sumber kearifan
                            dalam bertindak.</li>
                        <li>Melaksanakan pembelajaran aktif, kreatif, efektif, dan menyenangkan (PAKEM) untuk mengembangkan
                            potensi siswa secara optimal.</li>
                        <li>Meningkatkan prestasi akademik dan non-akademik melalui kegiatan pembelajaran dan
                            ekstrakurikuler yang berkualitas.</li>
                        <li>Membangun lingkungan sekolah yang bersih, sehat, aman, dan kondusif bagi seluruh warga sekolah.
                        </li>
                        <li>Menjalin kerjasama yang harmonis antara sekolah, orang tua, dan masyarakat demi kemajuan
                            pendidikan.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- News -->
    <div class="section">
        <div class="section-header">
            <div class="section-tag">Berita Terkini</div>
            <div class="section-title">Highlight Sekolah</div>
        </div>
        <div class="news-grid">
            <div class="news-card">
                <div class="news-img">
                    <img src="{{ asset('image/shalat-berjamaah.jpeg') }}" alt="Kegiatan 1">
                </div>
                <div class="news-body">
                    <div class="news-tag">Akademik</div>
                    <h4>Pembiasaan Shalat Berjamaah</h4>
                    <p>Setiap Jumat pagi, seluruh siswa SDN Legok III mengikuti pembiasaan shalat berjamaah di lingkungan
                        sekolah.</p>
                </div>
            </div>
            <div class="news-card">
                <div class="news-img">
                    <img src="{{ asset('image/acara-senam.jpeg') }}" alt="Kegiatan 2">
                </div>
                <div class="news-body">
                    <div class="news-tag">Akademik</div>
                    <h4>Pembiasaan Senam Anak Indonesia Hebat</h4>
                    <p>Senam pagi di lingkungan sekolah.</p>
                </div>
            </div>
            <div class="news-card">
                <div class="news-img">
                    <img src="{{ asset('image/o2sn.jpeg') }}" alt="Kegiatan 3">
                </div>
                <div class="news-body">
                    <div class="news-tag">Acara</div>
                    <h4>Olimpiade Olahraga Siswa Nasional</h4>
                    <p>Siswa SD Negeri Legok III berpartisipasi dalam ajang Olimpiade Olahraga Siswa Nasional (O2SN) sebagai
                        wadah
                        pengembangan bakat dan prestasi di bidang olahraga.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Testimonials -->
    <div class="testimonial-section">
        <div class="testi-inner">
            <div class="section-header-testi">
                <div class="section-tag-testi">Feedback</div>
                <div class="section-title-testi">Apa Kata Orang Tua?</div>
            </div>
            <div class="testimonials-slider">
                <div class="testi-card">
                    <div class="testi-quote">&ldquo;</div>
                    <div class="testi-text" id="testi-text-1"></div>
                    <div class="testi-author" id="testi-author-1"></div>
                    <div class="testi-role" id="testi-role-1"></div>
                </div>
                <div class="testi-card">
                    <div class="testi-quote">&ldquo;</div>
                    <div class="testi-text" id="testi-text-2"></div>
                    <div class="testi-author" id="testi-author-2"></div>
                    <div class="testi-role" id="testi-role-2"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA -->
    <div class="cta-section">
        <h2></h2>
        <p>Pendaftaran terbuka untuk tahun ajaran 2025–2026.</p>
        <div class="cta-btns">
            <a href="{{ route('register') }}" class="btn-cta-white">
                Daftar Sekarang
            </a>
        </div>
    </div>

    @include('components.footer')

@endsection

@section('scripts')
    <script src="{{ asset('js/homepage.js') }}"></script>
@endsection