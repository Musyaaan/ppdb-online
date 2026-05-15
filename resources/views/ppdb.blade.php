@extends('layouts.app')

@section('title', 'Penerimaan Siswa Baru - SD Negeri Legok III')

@section('styles')
    <link href="https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/navbar-footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ppdb.css') }}">
@endsection

@section('content')

    @include('components.navbar')

    {{-- HERO --}}
    <section class="ppdb-hero">
        <span class="ppdb-hero-tag">SD Negeri Legok III</span>
        <h1>Penerimaan Peserta Didik Baru</h1>
        <p>Daftarkan putra-putri Anda dan bergabunglah bersama keluarga besar SD Negeri Legok III Tahun Ajaran 2025/2026.
        </p>
    </section>

    {{-- STICKY NAV --}}
    <nav class="ppdb-nav">
        <div class="ppdb-nav-inner">
            <a href="#profil" class="ppdb-nav-link">Profil Sekolah</a>
            <a href="#jadwal" class="ppdb-nav-link">Jadwal</a>
            <a href="#persyaratan" class="ppdb-nav-link">Persyaratan</a>
            <a href="#alur" class="ppdb-nav-link">Alur PPDB</a>
            <a href="#faq" class="ppdb-nav-link">FAQ</a>
        </div>
    </nav>

    {{-- SECTION 1: PROFIL SEKOLAH --}}
    <section id="profil">
        <div class="ppdb-section">
            <div class="section-header">
                <div class="section-tag">Tentang Kami</div>
                <h2 class="section-title">Profil Sekolah</h2>
            </div>
            <div class="profil-grid">
                <div class="profil-img">
                    <img src="{{ asset('image/fotosekolah.jpeg') }}" alt="Foto SD Negeri Legok III">
                </div>
                <div>
                    <ul class="profil-info-list">
                        <li><span>Nama Sekolah</span><span>SD Negeri Legok III</span></li>
                        <li><span>Alamat</span><span>Jalan Manungtung, Desa Legok, Kec. Legok, Kab. Tangerang, Banten
                                15820</span></li>
                        <li><span>Tahun Berdiri</span><span>1983</span></li>
                        <li><span>Status</span><span>Negeri</span></li>
                        <li><span>Jumlah Guru</span><span>19 Tenaga Pengajar</span></li>
                        <li><span>Total Siswa</span><span>542 Siswa</span></li>
                        <li><span>Kepala Sekolah</span><span>Deni Wiratna, S.Pd., M.MPd.</span></li>
                        <li><span>Email</span><span>sdnlegoktiga03@gmail.com</span></li>
                        <li><span>Telepon</span><span>+6281292108743</span></li>
                    </ul>
                    <div class="accred-row">
                        <span class="accred-badge">Sekolah Negeri</span>
                        <span class="accred-badge">Berdiri Sejak 1983</span>
                        <span class="accred-badge">542 Siswa</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- SECTION 2: JADWAL --}}
    <div class="ppdb-section-alt">
        <section id="jadwal">
            <div class="ppdb-section-alt-inner">
                <div class="section-header">
                    <div class="section-tag">Timeline</div>
                    <h2 class="section-title">Jadwal Pendaftaran</h2>
                </div>
                <div class="jadwal-cards">
                    <div class="jadwal-card">
                        <div class="jadwal-card-num">01</div>
                        <h4>Sosialisasi</h4>
                        <div class="date">Mei – Juni 2025</div>
                        <p class="desc">Sosialisasi kepada orang tua calon peserta didik baru mengenai prosedur dan
                            persyaratan PPDB.</p>
                    </div>
                    <div class="jadwal-card">
                        <div class="jadwal-card-num">02</div>
                        <h4>Pendaftaran Online</h4>
                        <div class="date">1 – 14 Juni 2025</div>
                        <p class="desc">Buka akun dan isi formulir pendaftaran secara online. Unggah dokumen persyaratan
                            yang dibutuhkan.</p>
                    </div>
                    <div class="jadwal-card">
                        <div class="jadwal-card-num">03</div>
                        <h4>Verifikasi Berkas</h4>
                        <div class="date">16 – 20 Juni 2025</div>
                        <p class="desc">Panitia memverifikasi kelengkapan dan keabsahan dokumen yang diunggah oleh
                            pendaftar.</p>
                    </div>
                    <div class="jadwal-card">
                        <div class="jadwal-card-num">04</div>
                        <h4>Pengumuman Hasil</h4>
                        <div class="date">25 Juni 2025</div>
                        <p class="desc">Hasil seleksi diumumkan melalui website dan papan pengumuman sekolah. Notifikasi
                            dikirim otomatis.</p>
                    </div>
                    <div class="jadwal-card">
                        <div class="jadwal-card-num">05</div>
                        <h4>Daftar Ulang</h4>
                        <div class="date">26 – 30 Juni 2025</div>
                        <p class="desc">Peserta yang diterima wajib melakukan daftar ulang untuk mengkonfirmasi
                            keikutsertaan.</p>
                    </div>
                    <div class="jadwal-card">
                        <div class="jadwal-card-num">06</div>
                        <h4>Masuk Sekolah</h4>
                        <div class="date">Awal Juli 2025</div>
                        <p class="desc">Peserta didik baru mulai mengikuti kegiatan belajar mengajar tahun ajaran 2025/2026.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- SECTION 3: PERSYARATAN --}}
    <section id="persyaratan">
        <div class="ppdb-section">
            <div class="section-header">
                <div class="section-tag">Dokumen</div>
                <h2 class="section-title">Persyaratan Pendaftaran</h2>
            </div>
            <div class="persyaratan-wrapper">
                <div class="persyaratan-box">
                    <h4>Persyaratan Umum</h4>
                    <ul class="persyaratan-list">
                        <li>Berusia minimal 7 tahun <strong>wajib diterima</strong></li>
                        <li>Berusia minimal 6 tahun 8 bulan jika memiliki ijazah TK</li>
                        <li>Berdomisili sesuai zonasi (jarak rumah ke sekolah)</li>
                        <li>Jika kuota penuh, seleksi berdasarkan urutan waktu mendaftar</li>
                        <li>Kuota maksimal <strong>28 siswa per kelas</strong></li>
                        <li>Tidak dipungut biaya pendaftaran (gratis)</li>
                    </ul>
                </div>
                <div class="persyaratan-box">
                    <h4>Dokumen yang Diperlukan</h4>
                    <ul class="persyaratan-list">
                        <li>Akta Kelahiran (asli + fotokopi)</li>
                        <li>Kartu Keluarga / KK (asli + fotokopi)</li>
                        <li>KTP Orang Tua atau Wali Murid</li>
                        <li>Ijazah / STTB TK (jika ada)</li>
                    </ul>
                    <div style="margin-top:16px; padding:14px 16px; background:var(--primary-pale); border-radius:6px;">
                        <p style="font-size:13px; color:var(--text-muted); line-height:1.65; margin:0;">
                            <strong style="color:var(--text-dark);">Catatan:</strong> Pastikan data KK sesuai dengan data di
                            Dukcapil. Ketidaksesuaian data dapat menghambat proses verifikasi.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- SECTION 4: ALUR PPDB --}}
    <div class="ppdb-section-alt">
        <section id="alur">
            <div class="ppdb-section-alt-inner">
                <div class="section-header">
                    <div class="section-tag">Langkah-Langkah</div>
                    <h2 class="section-title">Alur PPDB Online</h2>
                </div>
                <div class="alur-steps">
                    <div class="alur-step">
                        <div class="step-num">1</div>
                        <div class="step-body">
                            <h4>Buka Website PPDB</h4>
                            <p>Akses halaman ini dan klik tombol "Register/Login" di bagian atas untuk memulai proses
                                pendaftaran.</p>
                        </div>
                    </div>
                    <div class="alur-step">
                        <div class="step-num">2</div>
                        <div class="step-body">
                            <h4>Buat Akun</h4>
                            <p>Daftarkan akun menggunakan email aktif orang tua/wali. Simpan username dan password dengan
                                baik. Jika kesulitan, operator sekolah siap membantu.</p>
                        </div>
                    </div>
                    <div class="alur-step">
                        <div class="step-num">3</div>
                        <div class="step-body">
                            <h4>Isi Formulir Data</h4>
                            <p>Lengkapi data diri calon peserta didik (anak) serta data orang tua atau wali murid secara
                                lengkap dan benar.</p>
                        </div>
                    </div>
                    <div class="alur-step">
                        <div class="step-num">4</div>
                        <div class="step-body">
                            <h4>Upload Dokumen</h4>
                            <p>Unggah scan/foto Akta Kelahiran, KK, KTP orang tua, dan ijazah TK (jika ada). Format JPG/PDF,
                                maks. 2MB per file.</p>
                        </div>
                    </div>
                    <div class="alur-step">
                        <div class="step-num">5</div>
                        <div class="step-body">
                            <h4>Submit & Cetak Bukti</h4>
                            <p>Unduh dan cetak bukti pendaftaran sebagai tanda bahwa proses pendaftaran telah selesai. Simpan baik-baik bukti ini untuk keperluan daftar ulang jika diterima.
                            </p>
                        </div>
                    </div>
                    <div class="alur-step">
                        <div class="step-num">6</div>
                        <div class="step-body">
                            <h4>Pantau Pengumuman</h4>
                            <p>Panitia memverifikasi berkas secara digital. Hasil seleksi akan diumumkan melalui email.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- SECTION 5: FAQ --}}
    <section id="faq">
        <div class="ppdb-section">
            <div class="section-header">
                <div class="section-tag">Pertanyaan Umum</div>
                <h2 class="section-title">FAQ PPDB</h2>
            </div>
            <div class="faq-list">
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFaq(this)">
                        Berapa batas usia untuk mendaftar?
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-answer">
                        Anak berusia minimal 7 tahun wajib diterima. Anak berusia 6 tahun 8 bulan dapat diterima apabila
                        memiliki ijazah TK. Usia dihitung per tanggal 1 Juli 2025.
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFaq(this)">
                        Apakah wajib memiliki ijazah TK?
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-answer">
                        Tidak wajib untuk anak yang sudah berusia 7 tahun. Namun ijazah TK diperlukan jika anak baru berusia
                        6 tahun 8 bulan agar bisa diterima.
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFaq(this)">
                        Bagaimana sistem zonasi di sekolah ini?
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-answer">
                        Seleksi mengutamakan calon peserta yang berdomisili paling dekat dengan sekolah berdasarkan data
                        Kartu Keluarga. Jika kuota sudah penuh, urutan waktu mendaftar menjadi penentu.
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFaq(this)">
                        Berapa kuota penerimaan siswa baru?
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-answer">
                        Kuota maksimal adalah 28 siswa per kelas. Tidak ada jalur afirmasi — semua menggunakan sistem
                        zonasi.
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFaq(this)">
                        Apakah ada biaya pendaftaran?
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-answer">
                        Tidak ada biaya apapun. Seluruh proses pendaftaran PPDB di SD Negeri Legok III adalah gratis.
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFaq(this)">
                        Bagaimana jika data KK tidak sesuai dengan Dukcapil?
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-answer">
                        Segera perbaiki data di kantor Dukcapil setempat sebelum mendaftar. Jika ada kesulitan, hubungi
                        operator sekolah untuk mendapat bantuan langsung.
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFaq(this)">
                        Bagaimana jika kesulitan mendaftar secara online?
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-answer">
                        Orang tua yang mengalami kesulitan teknis dapat datang langsung ke sekolah. Operator sekolah siap
                        membantu proses input data dan pengisian formulir.
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFaq(this)">
                        Apakah saya mendapat konfirmasi setelah mendaftar?
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-answer">
                        Ya. Setelah mendaftar, sistem mengirimkan notifikasi konfirmasi otomatis ke email yang didaftarkan.
                        Anda juga dapat mencetak bukti pendaftaran langsung dari sistem.
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA DAFTAR --}}
    <section class="ppdb-cta">
        <h2>Siap Mendaftarkan Putra-Putri Anda?</h2>
        <p>Pendaftaran online dibuka mulai Juni 2025. Gratis, mudah, dan bisa dilakukan dari rumah.</p>
        <a href="{{ route('register') }}" class="btn-daftar">Daftar Sekarang</a>
    </section>

    @include('components.footer')

@endsection

@section('scripts')
    <script>
        // FAQ Toggle
        function toggleFaq(btn) {
            const answer = btn.nextElementSibling;
            const isOpen = answer.classList.contains('open');
            document.querySelectorAll('.faq-answer').forEach(a => a.classList.remove('open'));
            document.querySelectorAll('.faq-question').forEach(b => b.classList.remove('open'));
            if (!isOpen) {
                answer.classList.add('open');
                btn.classList.add('open');
            }
        }

        // Active Nav Highlight on Scroll
        const sections = document.querySelectorAll('section[id]');
        const navLinks = document.querySelectorAll('.ppdb-nav-link');

        window.addEventListener('scroll', () => {
            let current = '';
            sections.forEach(sec => {
                if (window.scrollY >= sec.offsetTop - 120) current = sec.getAttribute('id');
            });
            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === '#' + current) link.classList.add('active');
            });
        });

        // Smooth Scroll
        document.querySelectorAll('a[href*="#"]').forEach(link => {
            link.addEventListener('click', function (e) {
                const url = new URL(this.getAttribute('href'), window.location.href);
                const isSamePage = url.pathname === window.location.pathname;
                const hash = url.hash;
                if (isSamePage && hash) {
                    e.preventDefault();
                    const target = document.querySelector(hash);
                    if (target) {
                        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        history.pushState(null, '', hash);
                    }
                }
            });
        });

        // Auto-scroll ke hash saat halaman dimuat
        if (window.location.hash) {
            const target = document.querySelector(window.location.hash);
            if (target) setTimeout(() => target.scrollIntoView({ behavior: 'smooth', block: 'start' }), 100);
        }

        // ── REVEAL ON SCROLL ──
        // Tambah class .reveal ke elemen yang mau dianimasikan
        const revealTargets = [
            '.section-header',
            '.profil-grid',
            '.jadwal-card',
            '.persyaratan-box',
            '.alur-step',
            '.faq-item',
            '.ppdb-cta h2',
            '.ppdb-cta p',
            '.btn-daftar',
        ];

        revealTargets.forEach(selector => {
            document.querySelectorAll(selector).forEach((el, i) => {
                el.classList.add('reveal');

                // Staggered delay untuk cards & steps
                if (
                    el.classList.contains('jadwal-card') ||
                    el.classList.contains('alur-step') ||
                    el.classList.contains('faq-item')
                ) {
                    el.style.setProperty('--delay', `${i * 0.08}s`);
                }
            });
        });

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target); // animasi sekali saja
                }
            });
        }, {
            threshold: 0.12,
            rootMargin: '0px 0px -40px 0px'
        });

        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
    </script>
@endsection