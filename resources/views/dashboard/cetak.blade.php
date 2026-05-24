@extends('layouts.app')

@section('title', 'Cetak Bukti Pendaftaran - PPDB SD Negeri Legok III')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/cetak.css') }}">
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
            <a href="{{ route('status.index') }}" class="sidebar-nav-item">
                <i class="fa-solid fa-info-circle"></i><span>Status Pendaftaran</span>
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
                <div class="topbar-avatar">{{ strtoupper(substr(Auth::user()->nama, 0, 1)) }}</div>
            </a>
        </header>

        <div class="dashboard-content">

            {{-- Title + Tombol --}}
            <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
                <div>
                    <h1 style="font-size:20px;font-weight:700;color:var(--text-dark);margin:0 0 4px;">Cetak Bukti Pendaftaran</h1>
                    <p style="font-size:13px;color:var(--text-muted);margin:0;">Simpan atau cetak bukti pendaftaran siswa baru Anda.</p>
                </div>
                @if($pendaftaran)
                <div class="cetak-action-bar">
                    <button class="btn-cetak btn-print" onclick="cetakBukti()">
                        <i class="fa-solid fa-print"></i> Cetak
                    </button>
                    <button class="btn-cetak btn-pdf" onclick="simpanPDF(event)">
                        <i class="fa-solid fa-file-pdf"></i> Simpan PDF
                    </button>
                </div>
                @endif
            </div>

            @if(!$pendaftaran)
            {{-- Belum daftar --}}
            <div class="section-card" style="text-align:center;padding:48px 24px;">
                <div style="font-size:48px;color:#e67e22;margin-bottom:16px;"><i class="fas fa-exclamation-triangle"></i></div>
                <p style="font-size:16px;font-weight:700;color:var(--text-dark);margin:0 0 8px;">Belum Ada Data Pendaftaran</p>
                <p style="font-size:13px;color:var(--text-muted);margin:0 0 20px;">Isi formulir pendaftaran terlebih dahulu untuk mendapatkan bukti pendaftaran.</p>
                <a href="{{ route('formulir.index') }}" class="menu-card-btn" style="display:inline-flex;width:auto;">
                    <i class="fa-solid fa-file-pen"></i> Isi Formulir Pendaftaran
                </a>
            </div>

            @else

            @php
                $siswa   = $pendaftaran->siswa;
                $ortu    = $pendaftaran->dataOrangtua;
                $dokumen = $pendaftaran->dokumen;
                $pddk    = $pendaftaran->pendidikan;

                $statusMap = [
                    'diterima'   => ['label' => 'Diterima',            'cls' => 's-diterima'],
                    'ditolak'    => ['label' => 'Ditolak',             'cls' => 's-ditolak'],
                    'diperbaiki' => ['label' => 'Perlu Diperbaiki',    'cls' => 's-diperbaiki'],
                    'pending'    => ['label' => 'Menunggu Verifikasi', 'cls' => 's-pending'],
                    'draft'      => ['label' => 'Draft',               'cls' => 's-draft'],
                ];
                $st = $statusMap[$pendaftaran->status] ?? $statusMap['draft'];

                $dokumenKeys = [
                    'kartu_keluarga' => 'Kartu Keluarga (KK)',
                    'akta_kelahiran' => 'Akta Kelahiran',
                    'ktp_orang_tua'  => 'KTP Orang Tua / Wali',
                    'ijazah_tk'      => 'Ijazah TK',
                ];
                $uploadedDok = $dokumen->pluck('status_verifikasi', 'jenis_dokumen');

                $noBukti = optional($pendaftaran->buktiPendaftaran)->nomor_bukti
                    ?? 'PPDB-' . str_pad($pendaftaran->id_pendaftaran, 5, '0', STR_PAD_LEFT);

                $val = fn($v) => $v ?? '-';
                $nd  = fn($v) => $v ? '' : 'bukti-val-nd';
            @endphp

            {{-- ══ DOKUMEN BUKTI ══ --}}
            <div class="cetak-preview-wrap bukti-print-area">
                <div class="bukti" id="buktiDokumen">
                    <div class="bukti-watermark">PPDB</div>

                    {{-- ── Header card ── --}}
                    <div class="bukti-header-card">
                        <img src="{{ asset('image/Logo4.png') }}" alt="Logo" class="bukti-logo">
                        <div style="flex:1;">
                            <div class="bukti-header-instansi">Pemerintah Kabupaten Tangerang · Dinas Pendidikan</div>
                            <div class="bukti-header-judul">SD Negeri Legok III</div>
                            <div class="bukti-header-sub">Jl. Legok · Kec. Legok · Kab. Tangerang · Banten</div>
                        </div>
                        <div class="bukti-qr">
                            <i class="fa-solid fa-qrcode" style="font-size:26px;color:rgba(255,255,255,0.35);"></i>
                        </div>
                        <div class="bukti-nomor-box">
                            <div class="bukti-nomor-label">No. Pendaftaran</div>
                            <span class="bukti-nomor-val">{{ $noBukti }}</span>
                            <div class="bukti-nomor-tgl">
                                {{ \Carbon\Carbon::parse($pendaftaran->tanggal_daftar)->locale('id')->translatedFormat('d F Y') }}
                            </div>
                        </div>
                    </div>

                    {{-- ── Title ── --}}
                    <div class="bukti-title-strip">
                        <div class="bukti-title-inner">Bukti Pendaftaran Peserta Didik Baru</div>
                        <div class="bukti-title-sub">Tahun Ajaran {{ date('Y') }}/{{ date('Y') + 1 }}</div>
                    </div>

                    {{-- ── Status ── --}}
                    <div class="bukti-status-bar">
                        <div>
                            <div class="bukti-status-label">Status Pendaftaran</div>
                            <div class="bukti-status-tgl">
                                Tanggal Daftar: {{ \Carbon\Carbon::parse($pendaftaran->tanggal_daftar)->locale('id')->translatedFormat('d F Y') }}
                            </div>
                        </div>
                        <span class="bukti-status-val {{ $st['cls'] }}">{{ $st['label'] }}</span>
                    </div>

                    {{-- ── DATA SISWA ── --}}
                    <div class="bukti-section">
                        <div class="bukti-section-title">
                            <i class="fa-solid fa-user-graduate"></i> Data Calon Siswa
                        </div>
                        <div class="bukti-grid">

                            <div class="bukti-row">
                                <span class="bukti-key">Nama Lengkap</span>
                                <span class="bukti-val">{{ strtoupper($siswa->nama_siswa ?? '-') }}</span>
                            </div>
                            <div class="bukti-row">
                                <span class="bukti-key">NIK Siswa</span>
                                <span class="bukti-val {{ $nd($siswa->nik_siswa ?? null) }}">{{ $siswa->nik_siswa ?? 'Tidak diisi' }}</span>
                            </div>

                            <div class="bukti-row">
                                <span class="bukti-key">Tempat Lahir</span>
                                <span class="bukti-val">{{ $val($siswa->tempat_lahir ?? null) }}</span>
                            </div>
                            <div class="bukti-row">
                                <span class="bukti-key">Tanggal Lahir</span>
                                <span class="bukti-val">
                                    {{ isset($siswa->tanggal_lahir)
                                        ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->locale('id')->translatedFormat('d F Y')
                                        : '-' }}
                                </span>
                            </div>

                            <div class="bukti-row">
                                <span class="bukti-key">Jenis Kelamin</span>
                                <span class="bukti-val">
                                    {{ ($siswa->jenis_kelamin ?? '') === 'L' ? 'Laki-laki'
                                        : (($siswa->jenis_kelamin ?? '') === 'P' ? 'Perempuan' : '-') }}
                                </span>
                            </div>
                            <div class="bukti-row">
                                <span class="bukti-key">Agama</span>
                                <span class="bukti-val">{{ $val($siswa->agama ?? null) }}</span>
                            </div>

                            <div class="bukti-row">
                                <span class="bukti-key">Anak Ke-</span>
                                <span class="bukti-val {{ $nd($siswa->anak_ke ?? null) }}">{{ $siswa->anak_ke ?? 'Tidak diisi' }}</span>
                            </div>
                            <div class="bukti-row">
                                <span class="bukti-key">Jumlah Saudara Kandung</span>
                                <span class="bukti-val {{ $nd(isset($siswa->jml_saudara) ? (string)$siswa->jml_saudara : null) }}">
                                    {{ isset($siswa->jml_saudara) ? $siswa->jml_saudara . ' orang' : 'Tidak diisi' }}
                                </span>
                            </div>

                            <div class="bukti-row full">
                                <span class="bukti-key">Alamat</span>
                                <span class="bukti-val">
                                    {{ implode(', ', array_filter([
                                        $siswa->alamat ?? null,
                                        $siswa->kelurahan ?? null,
                                        ($siswa->kecamatan ?? null) ? 'Kec. ' . $siswa->kecamatan : null,
                                        $siswa->kode_pos ?? null,
                                    ])) ?: '-' }}
                                </span>
                            </div>

                            <div class="bukti-row">
                                <span class="bukti-key">Lulusan TK / PAUD</span>
                                <span class="bukti-val">{{ ($siswa->lulusan_tk ?? '') === 'ya' ? 'Ya' : 'Tidak' }}</span>
                            </div>
                            <div class="bukti-row">
                                <span class="bukti-key">Nama TK / PAUD</span>
                                <span class="bukti-val {{ $nd($siswa->nama_tk ?? null) }}">{{ $siswa->nama_tk ?? 'Tidak diisi' }}</span>
                            </div>

                            @if($pddk)
                            <div class="bukti-row">
                                <span class="bukti-key">Asal Sekolah</span>
                                <span class="bukti-val">{{ $val($pddk->asal_sekolah ?? null) }}</span>
                            </div>
                            <div class="bukti-row">
                                <span class="bukti-key">Tahun Lulus</span>
                                <span class="bukti-val">{{ $val($pddk->tahun_lulus ?? null) }}</span>
                            </div>
                            @endif

                        </div>
                    </div>

                    {{-- ── DATA ORANG TUA ── --}}
                    <div class="bukti-section">
                        <div class="bukti-section-title">
                            <i class="fa-solid fa-people-roof"></i> Data Orang Tua / Wali
                        </div>
                        <div class="bukti-grid">

                            <div class="bukti-row">
                                <span class="bukti-key">Nama Ayah</span>
                                <span class="bukti-val">{{ strtoupper($ortu->nama_ayah ?? '-') }}</span>
                            </div>
                            <div class="bukti-row">
                                <span class="bukti-key">NIK Ayah</span>
                                <span class="bukti-val {{ $nd($ortu->nik_ayah ?? null) }}">{{ $ortu->nik_ayah ?? 'Tidak diisi' }}</span>
                            </div>
                            <div class="bukti-row">
                                <span class="bukti-key">Pekerjaan Ayah</span>
                                <span class="bukti-val">{{ $val($ortu->pekerjaan_ayah ?? null) }}</span>
                            </div>
                            <div class="bukti-row">
                                <span class="bukti-key">Pendidikan Ayah</span>
                                <span class="bukti-val {{ $nd($ortu->pendidikan_ayah ?? null) }}">{{ $ortu->pendidikan_ayah ?? 'Tidak diisi' }}</span>
                            </div>

                            <div class="bukti-row">
                                <span class="bukti-key">Nama Ibu</span>
                                <span class="bukti-val">{{ strtoupper($ortu->nama_ibu ?? '-') }}</span>
                            </div>
                            <div class="bukti-row">
                                <span class="bukti-key">NIK Ibu</span>
                                <span class="bukti-val {{ $nd($ortu->nik_ibu ?? null) }}">{{ $ortu->nik_ibu ?? 'Tidak diisi' }}</span>
                            </div>
                            <div class="bukti-row">
                                <span class="bukti-key">Pekerjaan Ibu</span>
                                <span class="bukti-val">{{ $val($ortu->pekerjaan_ibu ?? null) }}</span>
                            </div>
                            <div class="bukti-row">
                                <span class="bukti-key">Pendidikan Ibu</span>
                                <span class="bukti-val {{ $nd($ortu->pendidikan_ibu ?? null) }}">{{ $ortu->pendidikan_ibu ?? 'Tidak diisi' }}</span>
                            </div>

                            <div class="bukti-row">
                                <span class="bukti-key">No. HP / WhatsApp</span>
                                <span class="bukti-val">{{ $val($ortu->no_hp ?? null) }}</span>
                            </div>
                            <div class="bukti-row">
                                <span class="bukti-key">Email</span>
                                <span class="bukti-val {{ $nd($ortu->email ?? null) }}">{{ $ortu->email ?? 'Tidak diisi' }}</span>
                            </div>

                            @if($ortu->nama_wali ?? false)
                            <div class="bukti-row">
                                <span class="bukti-key">Nama Wali</span>
                                <span class="bukti-val">{{ $ortu->nama_wali }}</span>
                            </div>
                            <div class="bukti-row">
                                <span class="bukti-key">Hubungan Wali</span>
                                <span class="bukti-val">{{ $val($ortu->hub_wali ?? null) }}</span>
                            </div>
                            @endif

                            @if($ortu->alamat_ortu ?? false)
                            <div class="bukti-row full">
                                <span class="bukti-key">Alamat Orang Tua</span>
                                <span class="bukti-val">{{ $ortu->alamat_ortu }}</span>
                            </div>
                            @endif

                        </div>
                    </div>

                    {{-- ── DOKUMEN ── --}}
                    <div class="bukti-section">
                        <div class="bukti-section-title">
                            <i class="fa-solid fa-folder-open"></i> Status Dokumen Persyaratan
                        </div>
                        <div class="bukti-dok-grid">
                            @foreach($dokumenKeys as $key => $label)
                                @php
                                    $stDok  = $uploadedDok[$key] ?? null;
                                    $icoCls = match($stDok) {
                                        'valid'       => 'dok-ok',
                                        'pending'     => 'dok-wait',
                                        'tidak_valid' => 'dok-no',
                                        default       => 'dok-kosong',
                                    };
                                    $icoFa  = match($stDok) {
                                        'valid'       => 'fa-check',
                                        'pending'     => 'fa-clock',
                                        'tidak_valid' => 'fa-times',
                                        default       => 'fa-minus',
                                    };
                                    $stLabel = match($stDok) {
                                        'valid'       => 'Valid',
                                        'pending'     => 'Menunggu Verifikasi',
                                        'tidak_valid' => 'Ditolak',
                                        default       => 'Belum Diunggah',
                                    };
                                @endphp
                                <div class="bukti-dok-item">
                                    <div class="bukti-dok-ico {{ $icoCls }}">
                                        <i class="fa-solid {{ $icoFa }}"></i>
                                    </div>
                                    <div>
                                        <div style="font-size:12px;font-weight:600;color:var(--text-dark);">{{ $label }}</div>
                                        <div style="font-size:10px;color:var(--text-muted);margin-top:1px;">{{ $stLabel }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- ── Catatan Admin ── --}}
                    @if($pendaftaran->catatan_admin)
                    <div class="bukti-catatan">
                        <strong><i class="fa-solid fa-triangle-exclamation" style="margin-right:6px;"></i>Catatan Admin:</strong>
                        {{ $pendaftaran->catatan_admin }}
                    </div>
                    @endif

                    {{-- ── Footer Note ── --}}
                    <div class="bukti-footer-note">
                        <i class="fa-solid fa-circle-info" style="margin-right:5px;"></i>
                        Dokumen ini dicetak otomatis melalui sistem PPDB Online SDN Legok III.
                        Simpan nomor pendaftaran Anda sebagai bukti.
                        Informasi lebih lanjut hubungi sekolah pada jam kerja.
                    </div>

                </div>{{-- end .bukti --}}
            </div>{{-- end .cetak-preview-wrap --}}

            @endif
        </div>
    </main>
</div>

<script>
    document.getElementById('sidebarToggle').addEventListener('click', () => {
        document.getElementById('sidebar').classList.toggle('sidebar-open');
    });

    function cetakBukti() { window.print(); }

    function simpanPDF(e) {
        const el = document.getElementById('buktiDokumen');
        if (!el) return;
        const btn = e.currentTarget;
        const ori = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memproses...';

        function load(src, cb) {
            if (document.querySelector(`script[src="${src}"]`)) { cb(); return; }
            const s = document.createElement('script');
            s.src = src; s.onload = cb;
            document.head.appendChild(s);
        }

        load('https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js', () => {
            load('https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js', () => {
                // Sementara set lebar ke 794px (A4 px) agar capture proporsional
                const oriWidth = el.style.width;
                const oriMinH  = el.style.minHeight;
                el.style.width     = '794px';
                el.style.minHeight = 'auto';

                html2canvas(el, { scale: 2, useCORS: true, logging: false, windowWidth: 794 }).then(canvas => {
                    // Kembalikan style semula
                    el.style.width     = oriWidth;
                    el.style.minHeight = oriMinH;

                    const { jsPDF } = window.jspdf;
                    const doc = new jsPDF({ orientation: 'portrait', unit: 'mm', format: 'a4' });
                    const pageW = doc.internal.pageSize.getWidth();
                    const pageH = doc.internal.pageSize.getHeight();

                    // Hitung tinggi proporsional agar tidak crop / himpitan
                    const ratio    = canvas.width / canvas.height;
                    const imgH     = pageW / ratio;
                    const offsetY  = imgH < pageH ? (pageH - imgH) / 2 : 0;

                    const img = canvas.toDataURL('image/jpeg', 0.95);
                    doc.addImage(img, 'JPEG', 0, offsetY, pageW, Math.min(imgH, pageH));
                    doc.save('Bukti-Pendaftaran-PPDB.pdf');
                    btn.disabled = false;
                    btn.innerHTML = ori;
                });
            });
        });
    }
</script>
@endsection