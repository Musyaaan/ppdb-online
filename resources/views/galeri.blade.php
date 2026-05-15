@extends('layouts.app')

@section('title', 'Beranda - SD Negeri Legok III')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/navbar-footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/galeri.css') }}">
@endsection

@section('content')

    @include('components.navbar')

    {{-- HERO --}}
    <div class="hero" style="text-align: center; padding: 64px 40px;">
        <div class="section-tag" style="color: var(--secondary);">Dokumentasi</div>
        <h1
            style="font-family: 'Playfair Display', serif; font-size: 36px; font-weight: 700; color: var(--white); margin: 10px 0 12px;">
            Galeri Foto</h1>
        <p style="font-size: 14px; color: rgba(255,255,255,0.75);">Kumpulan momen kegiatan dan prestasi SD Negeri Legok III
        </p>
    </div>

    {{-- GALERI --}}
    <div class="galeri-section">
        <div class="galeri-inner">

            {{-- FILTER --}}
            <div class="galeri-filter">
                <button class="filter-btn active" data-filter="all">Semua</button>
                <button class="filter-btn" data-filter="kegiatan">Kegiatan</button>
                <button class="filter-btn" data-filter="prestasi">Prestasi</button>
            </div>

            {{-- GRID --}}
            <div class="galeri-grid">

                {{-- KEGIATAN --}}
                <div class="galeri-item" data-category="kegiatan">
                    <img src="{{ asset('image/galeri/kegiatan-1.jpg') }}" alt="Kegiatan 1">
                    <div class="galeri-overlay">
                        <span class="galeri-label">Kegiatan</span>
                        <p class="galeri-caption">Upacara Bendera</p>
                    </div>
                </div>

                <div class="galeri-item" data-category="kegiatan">
                    <img src="{{ asset('image/galeri/kegiatan-2.jpg') }}" alt="Kegiatan 2">
                    <div class="galeri-overlay">
                        <span class="galeri-label">Kegiatan</span>
                        <p class="galeri-caption">Pramuka</p>
                    </div>
                </div>

                <div class="galeri-item" data-category="kegiatan">
                    <img src="{{ asset('image/galeri/kegiatan-3.jpg') }}" alt="Kegiatan 3">
                    <div class="galeri-overlay">
                        <span class="galeri-label">Kegiatan</span>
                        <p class="galeri-caption">Olahraga</p>
                    </div>
                </div>

                <div class="galeri-item" data-category="kegiatan">
                    <img src="{{ asset('image/galeri/kegiatan-4.jpg') }}" alt="Kegiatan 4">
                    <div class="galeri-overlay">
                        <span class="galeri-label">Kegiatan</span>
                        <p class="galeri-caption">Belajar Bersama</p>
                    </div>
                </div>

                <div class="galeri-item" data-category="kegiatan">
                    <img src="{{ asset('image/galeri/kegiatan-5.jpg') }}" alt="Kegiatan 5">
                    <div class="galeri-overlay">
                        <span class="galeri-label">Kegiatan</span>
                        <p class="galeri-caption">Seni Budaya</p>
                    </div>
                </div>

                <div class="galeri-item" data-category="kegiatan">
                    <img src="{{ asset('image/galeri/kegiatan-6.jpg') }}" alt="Kegiatan 6">
                    <div class="galeri-overlay">
                        <span class="galeri-label">Kegiatan</span>
                        <p class="galeri-caption">Kemah</p>
                    </div>
                </div>

                {{-- PRESTASI --}}
                <div class="galeri-item" data-category="prestasi">
                    <img src="{{ asset('image/galeri/prestasi-1.jpg') }}" alt="Prestasi 1">
                    <div class="galeri-overlay">
                        <span class="galeri-label prestasi">Prestasi</span>
                        <p class="galeri-caption">Juara Lomba Matematika</p>
                    </div>
                </div>

                <div class="galeri-item" data-category="prestasi">
                    <img src="{{ asset('image/galeri/prestasi-2.jpg') }}" alt="Prestasi 2">
                    <div class="galeri-overlay">
                        <span class="galeri-label prestasi">Prestasi</span>
                        <p class="galeri-caption">Juara Olahraga</p>
                    </div>
                </div>

                <div class="galeri-item" data-category="prestasi">
                    <img src="{{ asset('image/galeri/prestasi-3.jpg') }}" alt="Prestasi 3">
                    <div class="galeri-overlay">
                        <span class="galeri-label prestasi">Prestasi</span>
                        <p class="galeri-caption">Juara Seni</p>
                    </div>
                </div>

                <div class="galeri-item" data-category="prestasi">
                    <img src="{{ asset('image/galeri/prestasi-4.jpg') }}" alt="Prestasi 4">
                    <div class="galeri-overlay">
                        <span class="galeri-label prestasi">Prestasi</span>
                        <p class="galeri-caption">Penghargaan Sekolah</p>
                    </div>
                </div>

                <div class="galeri-item" data-category="prestasi">
                    <img src="{{ asset('image/galeri/prestasi-5.jpg') }}" alt="Prestasi 5">
                    <div class="galeri-overlay">
                        <span class="galeri-label prestasi">Prestasi</span>
                        <p class="galeri-caption">Penghargaan Sekolah</p>
                    </div>
                </div>

                <div class="galeri-item" data-category="prestasi">
                    <img src="{{ asset('image/galeri/prestasi-6.jpg') }}" alt="Prestasi 6">
                    <div class="galeri-overlay">
                        <span class="galeri-label prestasi">Prestasi</span>
                        <p class="galeri-caption">Penghargaan Sekolah</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- LIGHTBOX --}}
    <div class="lightbox" id="lightbox">
        <div class="lightbox-backdrop" onclick="closeLightbox()"></div>
        <div class="lightbox-content">
            <button class="lightbox-close" onclick="closeLightbox()">&times;</button>
            <button class="lightbox-prev" onclick="changePhoto(-1)">&#8249;</button>
            <img src="" alt="" id="lightbox-img">
            <p class="lightbox-caption" id="lightbox-caption"></p>
            <button class="lightbox-next" onclick="changePhoto(1)">&#8250;</button>
        </div>
    </div>

    @include('components.footer')

@endsection

@section('scripts')
    <script>
        // FILTER
        const filterBtns = document.querySelectorAll('.filter-btn');
        const items = document.querySelectorAll('.galeri-item');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                filterBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                const filter = btn.dataset.filter;
                items.forEach(item => {
                    if (filter === 'all' || item.dataset.category === filter) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });

        // LIGHTBOX
        let currentIndex = 0;
        let visibleItems = [];

        items.forEach(item => {
            item.addEventListener('click', () => {
                visibleItems = [...items].filter(i => i.style.display !== 'none');
                currentIndex = visibleItems.indexOf(item);
                openLightbox(visibleItems[currentIndex]);
            });
        });

        function openLightbox(item) {
            const img = item.querySelector('img');
            const caption = item.querySelector('.galeri-caption').textContent;
            document.getElementById('lightbox-img').src = img.src;
            document.getElementById('lightbox-caption').textContent = caption;
            document.getElementById('lightbox').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            document.getElementById('lightbox').classList.remove('active');
            document.body.style.overflow = '';
        }

        function changePhoto(dir) {
            currentIndex = (currentIndex + dir + visibleItems.length) % visibleItems.length;
            openLightbox(visibleItems[currentIndex]);
        }

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowLeft') changePhoto(-1);
            if (e.key === 'ArrowRight') changePhoto(1);
        });

        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 10) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
@endsection