@extends('layouts.app')

@section('title', 'Upload Dokumen Persyaratan')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dokumen.css') }}">
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
                <i class="fa-solid fa-house"></i><span>Dashboard</span>
            </a>
            <a href="{{ route('formulir.index') }}" class="sidebar-nav-item">
                <i class="fa-solid fa-file-pen"></i><span>Formulir Pendaftaran</span>
            </a>
            <a href="{{ route('dokumen.index') }}" class="sidebar-nav-item active">
                <i class="fa-solid fa-file-arrow-up"></i><span>Upload Dokumen</span>
            </a>
            <a href="{{ route('cetak.index') }}" class="sidebar-nav-item">
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

            {{-- WELCOME BANNER --}}
            <div class="welcome-banner">
                <div class="welcome-text">
                    <h1 class="welcome-title">Upload Dokumen Persyaratan</h1>
                    <p class="welcome-sub">Unggah berkas persyaratan pendaftaran siswa baru SDN Legok 3</p>
                </div>
                <div class="welcome-icon"><i class="fas fa-folder-open"></i></div>
            </div>

            {{-- ALERTS --}}
            @if(session('success'))
            <div class="dok-alert dok-alert-success">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
                <button onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
            </div>
            @endif
            @if(session('error'))
            <div class="dok-alert dok-alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
                <button onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
            </div>
            @endif
            @if($errors->any())
            <div class="dok-alert dok-alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                <button onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
            </div>
            @endif

            @if(!$pendaftaran)
            {{-- Belum punya pendaftaran --}}
            <div class="section-card" style="text-align:center;padding:48px 24px;">
                <div style="font-size:48px;color:#e67e22;margin-bottom:16px;"><i class="fas fa-exclamation-triangle"></i></div>
                <p style="font-size:16px;font-weight:700;color:var(--text-dark);margin:0 0 8px;">Formulir Pendaftaran Belum Diisi</p>
                <p style="font-size:13px;color:var(--text-muted);margin:0 0 20px;">Anda harus mengisi formulir pendaftaran terlebih dahulu sebelum dapat mengunggah dokumen.</p>
                <a href="{{ route('pendaftaran.index') }}" class="dok-btn-primary">
                    <i class="fas fa-file-alt"></i> Isi Formulir Pendaftaran
                </a>
            </div>

            @else

            {{-- ===== 2 KOLOM: FORM UPLOAD (kiri) + SYARAT DOKUMEN (kanan) ===== --}}
            <div class="dok-two-col">

                {{-- KOLOM KIRI: Form Upload --}}
                <div class="dok-col-left">
                    <div class="section-card">
                        <h2 class="section-title"><i class="fas fa-cloud-upload-alt"></i> Unggah Berkas</h2>
                        <p class="dok-hint"><i class="fas fa-info-circle"></i> File lama diganti otomatis jika jenis dokumen sama.</p>

                        <form action="{{ route('dokumen.upload') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                            @csrf

                            <div class="dok-form-group">
                                <label class="dok-label" for="jenis_dokumen">
                                    Jenis Dokumen <span class="dok-required">*</span>
                                </label>
                                <div class="dok-select-wrap">
                                    <select name="jenis_dokumen" id="jenis_dokumen"
                                            class="dok-select @error('jenis_dokumen') is-invalid @enderror" required>
                                        <option value="" disabled selected>-- Pilih jenis dokumen --</option>
                                        <option value="kartu_keluarga" {{ old('jenis_dokumen')=='kartu_keluarga'?'selected':'' }}>Kartu Keluarga (KK)</option>
                                        <option value="akta_kelahiran" {{ old('jenis_dokumen')=='akta_kelahiran'?'selected':'' }}>Akta Kelahiran</option>
                                        <option value="ktp_orang_tua"  {{ old('jenis_dokumen')=='ktp_orang_tua' ?'selected':'' }}>KTP Orang Tua / Wali</option>
                                        <option value="ijazah_tk"      {{ old('jenis_dokumen')=='ijazah_tk'     ?'selected':'' }}>Ijazah TK</option>
                                    </select>
                                    <i class="fas fa-chevron-down dok-select-arrow"></i>
                                </div>
                                @error('jenis_dokumen')
                                    <span class="dok-field-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                                @enderror
                            </div>

                            <div class="dok-dropzone" id="dropZone">
                                <input type="file" name="file" id="fileInput" class="dok-dropzone-input"
                                       accept=".jpg,.jpeg,.png,.pdf" required>
                                <div id="dropZoneContent" class="dok-dropzone-body">
                                    <div class="dok-dropzone-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                                    <p class="dok-dropzone-title">Seret &amp; lepas file di sini</p>
                                    <p class="dok-dropzone-sub">atau <span class="dok-dropzone-link">klik untuk memilih</span></p>
                                    <p class="dok-dropzone-hint">JPG, PNG, PDF — Maks. 5MB</p>
                                </div>
                                <div id="dropZonePreview" class="dok-dropzone-preview" style="display:none;">
                                    <div class="dok-prev-icon" id="previewIcon"><i class="fas fa-file"></i></div>
                                    <div class="dok-prev-info">
                                        <span id="previewName" class="dok-prev-name"></span>
                                        <span id="previewSize" class="dok-prev-size"></span>
                                    </div>
                                    <button type="button" id="previewRemove" class="dok-prev-remove"><i class="fas fa-times"></i></button>
                                </div>
                            </div>
                            @error('file')
                                <span class="dok-field-error" style="margin-top:-12px;display:block;">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </span>
                            @enderror

                            <button type="submit" class="dok-btn-primary w-full" id="btnUpload">
                                <i class="fas fa-upload"></i> Upload Dokumen
                            </button>

                        </form>
                    </div>
                </div>

                {{-- KOLOM KANAN: Syarat Dokumen --}}
                <div class="dok-col-right">
                    <div class="section-card">
                        <h2 class="section-title"><i class="fas fa-clipboard-list"></i> Syarat Dokumen</h2>

                        @php
                            $uploaded = $dokumen->pluck('status_verifikasi', 'jenis_dokumen');
                            $syarat = [
                                ['key'=>'kartu_keluarga','label'=>'Kartu Keluarga (KK)',  'icon'=>'fa-id-card',        'color'=>'#3b82f6'],
                                ['key'=>'akta_kelahiran','label'=>'Akta Kelahiran',        'icon'=>'fa-certificate',    'color'=>'#10b981'],
                                ['key'=>'ktp_orang_tua', 'label'=>'KTP Orang Tua / Wali', 'icon'=>'fa-address-card',   'color'=>'#f59e0b'],
                                ['key'=>'ijazah_tk',     'label'=>'Ijazah TK (jika ada)',  'icon'=>'fa-graduation-cap', 'color'=>'#8b5cf6'],
                            ];
                        @endphp

                        <div class="dok-syarat-list">
                            @foreach($syarat as $s)
                            @php $st = $uploaded[$s['key']] ?? null; @endphp
                            <div class="dok-syarat-item {{ $st === 'valid' ? 'is-valid' : ($st ? 'is-uploaded' : '') }}">
                                <div class="dok-syarat-icon" style="background:{{ $s['color'] }}20;color:{{ $s['color'] }};">
                                    <i class="fas {{ $s['icon'] }}"></i>
                                </div>
                                <div class="dok-syarat-info">
                                    <span class="dok-syarat-name">{{ $s['label'] }}</span>
                                    <span class="dok-syarat-sub">JPG, PNG, PDF Maks. 5MB</span>
                                </div>
                                <div class="dok-syarat-status">
                                    @if($st === 'valid')
                                        <span class="dok-badge dok-badge-valid"><i class="fas fa-check"></i> Valid</span>
                                    @elseif($st === 'pending')
                                        <span class="dok-badge dok-badge-pending"><i class="fas fa-clock"></i> Menunggu</span>
                                    @elseif($st === 'tidak_valid')
                                        <span class="dok-badge dok-badge-invalid"><i class="fas fa-times"></i> Ditolak</span>
                                    @else
                                        <span class="dok-badge dok-badge-empty"> Belum</span>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>

                        @php $total = count($syarat); $done = $dokumen->count(); @endphp
                        <div class="dok-progress-wrap">
                            <div class="dok-progress-bar">
                                <div class="dok-progress-fill" style="width:{{ $total > 0 ? ($done/$total)*100 : 0 }}%"></div>
                            </div>
                            <span class="dok-progress-label">{{ $done }}/{{ $total }}</span>
                        </div>
                    </div>
                </div>

            </div>{{-- end dok-two-col --}}

            {{-- ===== DAFTAR DOKUMEN TERUNGGAH ===== --}}
            <div class="section-card">
                <h2 class="section-title">
                    <i class="fas fa-folder-open"></i> Dokumen Terunggah
                    <span class="dok-count-badge">{{ $dokumen->count() }}</span>
                </h2>

                @if($dokumen->isEmpty())
                    <div class="dok-empty">
                        <div class="dok-empty-icon"><i class="fas fa-file-upload"></i></div>
                        <p class="dok-empty-title">Belum ada dokumen</p>
                        <p class="dok-empty-sub">Unggah dokumen persyaratan di atas untuk memulai.</p>
                    </div>
                @else
                    <div class="dok-list">
                        @foreach($dokumen as $item)
                        <div class="dok-list-item">
                            <div class="dok-list-icon {{ $item->ekstensi === 'pdf' ? 'dok-icon-red' : 'dok-icon-blue' }}">
                                <i class="fas {{ $item->ekstensi === 'pdf' ? 'fa-file-pdf' : 'fa-file-image' }}"></i>
                            </div>
                            <div class="dok-list-info">
                                <span class="dok-list-jenis">{{ $item->jenis_label }}</span>
                                <span class="dok-list-fname">{{ $item->nama_asli }}</span>
                                <div class="dok-list-meta">
                                    <i class="fas fa-calendar-alt"></i> {{ $item->tanggal_upload->format('d M Y') }}
                                    &middot;
                                    @if($item->status_verifikasi === 'valid')
                                        <span class="dok-badge dok-badge-valid">✓ Valid</span>
                                    @elseif($item->status_verifikasi === 'pending')
                                        <span class="dok-badge dok-badge-pending">⏳ Menunggu</span>
                                    @else
                                        <span class="dok-badge dok-badge-invalid">✗ Ditolak</span>
                                    @endif
                                </div>
                            </div>
                            <div class="dok-list-actions">
                                <a href="{{ asset($item->file_path) }}" target="_blank"
                                   class="dok-action-btn dok-action-view" title="Lihat">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ asset($item->file_path) }}" download
                                   class="dok-action-btn dok-action-download" title="Unduh">
                                    <i class="fas fa-download"></i>
                                </a>
                                @if($item->status_verifikasi !== 'valid')
                                <form action="{{ route('dokumen.destroy', $item->id_dokumen) }}" method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus dokumen ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="dok-action-btn dok-action-delete" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                                @else
                                <span class="dok-action-btn" style="background:var(--primary-pale);color:var(--text-muted);cursor:default;">
                                    <i class="fas fa-lock"></i>
                                </span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>

            @endif

        </div>
    </main>
</div>

<script>
    document.getElementById('sidebarToggle').addEventListener('click', () => {
        document.getElementById('sidebar').classList.toggle('sidebar-open');
    });
</script>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const dropZone    = document.getElementById('dropZone');
    const fileInput   = document.getElementById('fileInput');
    const dzContent   = document.getElementById('dropZoneContent');
    const dzPreview   = document.getElementById('dropZonePreview');
    const previewName = document.getElementById('previewName');
    const previewSize = document.getElementById('previewSize');
    const previewIcon = document.getElementById('previewIcon');
    const prevRemove  = document.getElementById('previewRemove');

    ['dragenter','dragover'].forEach(e => dropZone.addEventListener(e, ev => {
        ev.preventDefault(); dropZone.classList.add('drag-over');
    }));
    ['dragleave','drop'].forEach(e => dropZone.addEventListener(e, ev => {
        ev.preventDefault(); dropZone.classList.remove('drag-over');
    }));
    dropZone.addEventListener('drop', ev => {
        if (ev.dataTransfer.files.length) {
            fileInput.files = ev.dataTransfer.files;
            showPreview(ev.dataTransfer.files[0]);
        }
    });
    fileInput.addEventListener('change', function () {
        if (this.files.length) showPreview(this.files[0]);
    });
    prevRemove.addEventListener('click', function (e) {
        e.stopPropagation();
        fileInput.value = '';
        dzContent.style.display = '';
        dzPreview.style.display = 'none';
    });

    function showPreview(file) {
        const ext   = file.name.split('.').pop().toLowerCase();
        const isPdf = ext === 'pdf';
        const isImg = ['jpg','jpeg','png'].includes(ext);
        previewIcon.className = 'dok-prev-icon' + (isPdf ? ' pdf' : (isImg ? ' image' : ''));
        previewIcon.innerHTML = `<i class="fas ${isPdf ? 'fa-file-pdf' : (isImg ? 'fa-file-image' : 'fa-file')}"></i>`;
        previewName.textContent = file.name;
        previewSize.textContent = formatBytes(file.size);
        dzContent.style.display = 'none';
        dzPreview.style.display = 'flex';
    }

    function formatBytes(b) {
        if (b < 1024) return b + ' B';
        if (b < 1048576) return (b / 1024).toFixed(1) + ' KB';
        return (b / 1048576).toFixed(2) + ' MB';
    }

    document.getElementById('uploadForm').addEventListener('submit', function () {
        const btn = document.getElementById('btnUpload');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengunggah...';
    });
});
</script>
@endpush