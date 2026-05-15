@extends('layouts.app')

@section('title', 'Hubungi Kami - SD Negeri Legok III')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/navbar-footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kontak.css') }}">
@endsection

@section('content')

    @include('components.navbar')

    {{-- HERO --}}
    <section class="kontak-hero">
        <div class="kontak-hero-inner">
            <span class="kontak-hero-tag">SD Negeri Legok III</span>
            <h1>Hubungi Kami</h1>
            <p>Kami siap membantu. Jangan ragu untuk menghubungi kami melalui informasi di bawah ini.</p>
        </div>
    </section>

    {{-- KARTU INFO KONTAK --}}
    <section class="kontak-cards-section">
        <div class="kontak-cards-inner">
            <div class="kontak-cards">

                <div class="kontak-card" data-delay="0">
                    <div class="kontak-card-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path
                                d="M6.62 10.79a15.05 15.05 0 006.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1C10.07 21 3 13.93 3 5c0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.24.2 2.45.57 3.57-.11.35-.03.74-.25 1.02l-2.2 2.2z" />
                        </svg>
                    </div>
                    <div class="kontak-card-body">
                        <h4>Telepon / WhatsApp</h4>
                        <a href="https://wa.me/6281292108743" target="_blank" class="kontak-value">+62 812-9210-8743</a>
                        <span class="kontak-note">Tersedia via WhatsApp</span>
                    </div>
                    <a href="https://wa.me/6281292108743" target="_blank" class="kontak-card-cta">
                        Chat Sekarang 
                    </a>
                </div>

                <div class="kontak-card" data-delay="100">
                    <div class="kontak-card-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2z" />
                            <polyline points="22,6 12,13 2,6" />
                        </svg>
                    </div>
                    <div class="kontak-card-body">
                        <h4>Email</h4>
                        <a href="mailto:sdnlegoktiga03@gmail.com" class="kontak-value">sdnlegoktiga03@gmail.com</a>
                        <span class="kontak-note">Kami balas dalam 1×24 jam</span>
                    </div>
                    <a href="mailto:sdnlegoktiga03@gmail.com" class="kontak-card-cta">
                        Kirim Email 
                    </a>
                </div>

                <div class="kontak-card" data-delay="200">
                    <div class="kontak-card-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <circle cx="12" cy="12" r="10" />
                            <polyline points="12 6 12 12 16 14" />
                        </svg>
                    </div>
                    <div class="kontak-card-body">
                        <h4>Jam Operasional</h4>
                        <span class="kontak-value">Senin – Jumat</span>
                        <span class="kontak-note">07.00 – 17.00 WIB</span>
                    </div>
                    <span class="kontak-card-badge">
                        <span class="badge-dot"></span> Buka Hari Ini
                    </span>
                </div>

                <div class="kontak-card" data-delay="300">
                    <div class="kontak-card-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" />
                            <circle cx="12" cy="9" r="2.5" />
                        </svg>
                    </div>
                    <div class="kontak-card-body">
                        <h4>Alamat</h4>
                        <span class="kontak-value">Jl. Manungtung, Desa Legok</span>
                        <span class="kontak-note">Kec. Legok, Kab. Tangerang, Banten 15820</span>
                    </div>
                    <a href="https://maps.google.com/?q=SD+Negeri+Legok+III+Tangerang" target="_blank"
                        class="kontak-card-cta">
                        Lihat Peta
                    </a>
                </div>

            </div>
        </div>
    </section>

    {{-- MAPS --}}
    <section class="kontak-map-section">
        <div class="kontak-map-inner">
            <div class="kontak-map-header">
                <div class="section-tag">Lokasi</div>
                <h2 class="section-title">Temukan Kami di Sini</h2>
            </div>
            <div class="kontak-map-container">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.8047164236073!2d106.58478777499087!3d-6.289379593699597!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e41f8618d6bd051%3A0x19082e1bcedb2811!2sSD%20Negeri%20Legok%20III!5e0!3m2!1sid!2sid!4v1778811896342!5m2!1sid!2sid"
                    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                    width="100%"
                    height="100%"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    title="Lokasi SD Negeri Legok III">
                </iframe>
            </div>
            <div class="kontak-map-footer">
                <div class="kontak-map-address">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" />
                        <circle cx="12" cy="9" r="2.5" />
                    </svg>
                    Kp. Manungtung No.006, RT.003, Legok, Kec. Legok, Kabupaten Tangerang, Banten 15820
                </div>
                <a href="https://maps.google.com/?q=SD+Negeri+Legok+III+Tangerang" target="_blank" class="kontak-map-btn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="15" height="15">
                        <path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6" />
                        <polyline points="15 3 21 3 21 9" />
                        <line x1="10" y1="14" x2="21" y2="3" />
                    </svg>
                    Buka di Google Maps
                </a>
            </div>
        </div>
    </section>

    @include('components.footer')

@endsection

@section('scripts')
    <script>
        // Animasi kartu masuk saat scroll
        const cards = document.querySelectorAll('.kontak-card');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const delay = entry.target.dataset.delay || 0;
                    setTimeout(() => {
                        entry.target.classList.add('visible');
                    }, parseInt(delay));
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        cards.forEach(card => observer.observe(card));

        // Badge jam buka — hide di weekend
        const day = new Date().getDay();
        const badge = document.querySelector('.kontak-card-badge');
        if (badge) {
            if (day === 0 || day === 6) {
                badge.innerHTML = '<span class="badge-dot closed"></span> Tutup Hari Ini';
                badge.classList.add('closed');
            }
        }
    </script>
@endsection