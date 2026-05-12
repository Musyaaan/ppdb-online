@extends('layouts.app')

@section('title', 'Beranda - SD Negeri Legok III')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/homepage.css') }}">
@endsection

@section('content')

    @include('components.navbar')

    <!-- Hero -->
    <div class="hero">
        <div class="hero-grid">
            <div class="hero-photo hp-1">
                <div class="hp-illustration">
                    <svg width="120" height="80" viewBox="0 0 120 80" fill="white">
                        <rect x="10" y="40" width="10" height="30" rx="2" />
                        <rect x="25" y="30" width="10" height="40" rx="2" />
                        <rect x="40" y="35" width="10" height="35" rx="2" />
                        <rect x="55" y="25" width="10" height="45" rx="2" />
                        <rect x="70" y="38" width="10" height="32" rx="2" />
                        <rect x="85" y="28" width="10" height="42" rx="2" />
                        <rect x="100" y="33" width="10" height="37" rx="2" />
                        <circle cx="15" cy="32" r="7" />
                        <circle cx="30" cy="22" r="7" />
                        <circle cx="45" cy="27" r="7" />
                        <circle cx="60" cy="17" r="7" />
                        <circle cx="75" cy="30" r="7" />
                        <circle cx="90" cy="20" r="7" />
                        <circle cx="105" cy="25" r="7" />
                    </svg>
                </div>
                <div class="hp-label">Wisuda &amp; Kelulusan</div>
            </div>
            <div class="hero-photo hp-2">
                <div class="hp-illustration">
                    <svg width="140" height="90" viewBox="0 0 140 90" fill="white">
                        <rect x="10" y="30" width="120" height="55" rx="3" />
                        <rect x="20" y="10" width="100" height="25" rx="2" />
                        <rect x="40" y="0" width="60" height="14" rx="2" />
                        <rect x="15" y="45" width="18" height="20" fill="rgba(0,0,0,0.3)" rx="1" />
                        <rect x="40" y="45" width="18" height="20" fill="rgba(0,0,0,0.3)" rx="1" />
                        <rect x="65" y="45" width="18" height="20" fill="rgba(0,0,0,0.3)" rx="1" />
                        <rect x="90" y="45" width="18" height="20" fill="rgba(0,0,0,0.3)" rx="1" />
                        <rect x="55" y="60" width="30" height="25" fill="rgba(0,0,0,0.25)" rx="1" />
                    </svg>
                </div>
                <div class="hp-label">Wisuda &amp; Kelulusan</div>
            </div>
            <div class="hero-photo hp-3">
                <div class="hp-illustration">
                    <svg width="160" height="80" viewBox="0 0 160 80" fill="white">
                        <rect x="10" y="30" width="140" height="30" rx="4" fill="rgba(255,255,255,0.3)" />
                        <rect x="10" y="30" width="140" height="8" rx="2" fill="rgba(255,255,255,0.6)" />
                        <line x1="10" y1="43" x2="150" y2="43" stroke="white" stroke-width="1" stroke-dasharray="6,4" />
                        <line x1="10" y1="53" x2="150" y2="53" stroke="white" stroke-width="1" stroke-dasharray="6,4" />
                        <rect x="0" y="20" width="160" height="12" rx="0" />
                        <rect x="20" y="0" width="15" height="22" rx="2" />
                        <rect x="60" y="0" width="15" height="22" rx="2" />
                        <rect x="100" y="0" width="15" height="22" rx="2" />
                        <rect x="130" y="0" width="15" height="22" rx="2" />
                    </svg>
                </div>
                <div class="hp-label">Wisuda &amp; Kelulusan</div>
            </div>
            <div class="hero-photo hp-4"
                style="flex-direction: column; align-items: flex-start; justify-content: flex-end; padding: 0;">
                <div class="hp-illustration" style="opacity:0.2;">
                    <svg width="120" height="100" viewBox="0 0 120 100" fill="white">
                        <circle cx="40" cy="25" r="18" />
                        <rect x="20" y="48" width="40" height="40" rx="4" />
                        <circle cx="85" cy="30" r="14" />
                        <rect x="68" y="50" width="32" height="36" rx="4" />
                    </svg>
                </div>
                <div style="position: relative; z-index: 2; padding: 20px; width: 100%;">
                    <div style="font-size: 22px; font-weight: 800; color: #fff; text-transform: uppercase; letter-spacing: 2px; line-height: 1.15; text-shadow: 0 2px 6px rgba(0,0,0,0.2);">
                        THE BEST IS<br>YET TO BE
                    </div>
                </div>
            </div>
        </div>
        <div class="hero-btns">
            <button class="btn-hero-primary" onclick="window.location='{{ route('ppdb.index') }}'">
                Daftar Sekarang
            </button>
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
                <p>Selamat datang di SD Negeri Legok III. Kami berkomitmen untuk memberikan pendidikan terbaik bagi setiap siswa
                    dengan mengedepankan nilai karakter, kedisiplinan, dan semangat belajar.</p>
                <p>Dengan dukungan tenaga pendidik yang profesional serta lingkungan belajar yang kondusif, kami berharap dapat
                    membentuk generasi yang cerdas, berakhlak mulia, dan siap menghadapi masa depan.</p>
                <div class="kepsek-name">
                    <strong>Deni Wirata, S.Pd., M.MPd.</strong>
                    <span>Kepala Sekolah SDN Legok III</span>
                </div>
            </div>
            <div class="kepsek-img">
                <img src="{{ asset('image/kepsek.jpg') }}" alt="Kepala Sekolah">
            </div>
        </div>
    </div>

    <!-- About -->
    <div class="section about-section">
        <div class="about-inner">
            <div class="about-img">
                <div class="about-img-overlay"></div>
                <img src="{{ asset('image/foto-sekolah.jpg') }}" alt="Gedung Sekolah"
                    style="width:100%; height:100%; object-fit:cover; position:absolute; inset:0;">
                <span class="about-caption">SD Negeri Legok III</span>
            </div>
            <div class="about-text">
                <div class="section-tag">Tentang Sekolah Kami</div>
                <h2>SDN Legok III: Membangun Masa Depan Gemilang dengan Pendidikan Berkualitas dan Karakter Unggul</h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse eveniet ipsum dolor cumque ipsam ullam ratione
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
                    <p>Terwujudnya peserta didik yang beriman, bertakwa, berakhlak mulia, berprestasi, berbudaya, dan berwawasan
                        lingkungan.</p>
                </div>
                <div class="vm-divider"></div>
                <div class="misi-box">
                    <h3>Misi</h3>
                    <ul class="misi-list">
                        <li>Menumbuhkan penghayatan dan pengamalan ajaran agama serta budaya bangsa sebagai sumber kearifan dalam bertindak.</li>
                        <li>Melaksanakan pembelajaran aktif, kreatif, efektif, dan menyenangkan (PAKEM) untuk mengembangkan potensi siswa secara optimal.</li>
                        <li>Meningkatkan prestasi akademik dan non-akademik melalui kegiatan pembelajaran dan ekstrakurikuler yang berkualitas.</li>
                        <li>Membangun lingkungan sekolah yang bersih, sehat, aman, dan kondusif bagi seluruh warga sekolah.</li>
                        <li>Menjalin kerjasama yang harmonis antara sekolah, orang tua, dan masyarakat demi kemajuan pendidikan.</li>
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
                    <p>Setiap Jumat pagi, seluruh siswa SDN Legok III mengikuti pembiasaan shalat berjamaah di lingkungan sekolah.</p>
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
                    <p>Siswa SD Negeri Legok III berpartisipasi dalam ajang Olimpiade Olahraga Siswa Nasional (O2SN) sebagai wadah
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
            <a href="{{ route('ppdb.index') }}" class="btn-cta-white">
                Daftar Sekarang
            </a>
        </div>
    </div>

    @include('components.footer')

@endsection

@section('scripts')
    <script src="{{ asset('js/homepage.js') }}"></script>
@endsection