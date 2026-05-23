@extends('layouts.app')

@section('title', 'Formulir Pendaftaran - PPDB SD Negeri Legok III')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/formulir.css') }}">
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
                <i class="fa-solid fa-house"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('formulir.index') }}" class="sidebar-nav-item active">
                <i class="fa-solid fa-file-pen"></i>
                <span>Formulir Pendaftaran</span>
            </a>
            <a href="{{ route('dokumen.index') }}" class="sidebar-nav-item">
                <i class="fa-solid fa-file-arrow-up"></i>
                <span>Upload Dokumen</span>
            </a>
            <a href="{{ route('cetak.index') }}" class="sidebar-nav-item">
                <i class="fa-solid fa-print"></i>
                <span>Cetak Bukti</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <a href="{{ route('profil') }}" class="sidebar-nav-item">
                <i class="fa-solid fa-circle-user"></i>
                <span>Profil</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-logout">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Keluar</span>
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
                    <h1 class="page-title">Formulir Pendaftaran</h1>
                    <p class="page-subtitle">Isi data berikut dengan lengkap dan benar sesuai dokumen resmi.</p>
                </div>
                @if(isset($pendaftaran) && $pendaftaran)
                    <span class="status-badge status-{{ $pendaftaran->status }}">
                        <i class="fa-solid fa-circle-dot"></i>
                        {{ ucfirst($pendaftaran->status) }}
                    </span>
                @endif
            </div>

            @if($errors->any())
                <div class="alert alert-danger">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <div>
                        <strong>Terdapat kesalahan pada data yang diisi:</strong>
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            {{-- STEP BAR --}}
            <div class="section-card step-bar-card">
                <div class="step-bar">
                    <div class="step-item active" id="si-1">
                        <div class="step-circle">
                            <i class="fa-solid fa-check step-check"></i>
                            <span class="step-num-text">1</span>
                        </div>
                        <div class="step-info">
                            <span class="step-label">Data Siswa</span>
                            <span class="step-status">Data calon peserta didik</span>
                        </div>
                    </div>
                    <div class="step-line" id="sl-1"></div>
                    <div class="step-item" id="si-2">
                        <div class="step-circle">
                            <i class="fa-solid fa-check step-check"></i>
                            <span class="step-num-text">2</span>
                        </div>
                        <div class="step-info">
                            <span class="step-label">Data Orang Tua</span>
                            <span class="step-status">Wali murid &amp; kontak</span>
                        </div>
                    </div>
                    <div class="step-line" id="sl-2"></div>
                    <div class="step-item" id="si-3">
                        <div class="step-circle">
                            <i class="fa-solid fa-check step-check"></i>
                            <span class="step-num-text">3</span>
                        </div>
                        <div class="step-info">
                            <span class="step-label">Preview &amp; Kirim</span>
                            <span class="step-status">Konfirmasi data</span>
                        </div>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('formulir.submit') }}" id="formPPDB" novalidate>
                @csrf

                {{-- ===== PANEL 1: DATA SISWA ===== --}}
                <div class="step-panel active" id="panel-1">
                    <div class="section-card">

                        <h2 class="section-title">
                            <i class="fa-solid fa-child-reaching"></i>
                            Data Calon Siswa
                        </h2>

                        <div class="info-box info-warning">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                            <div>
                                Usia minimal pendaftaran: <strong>7 tahun</strong> tanpa ijazah TK,
                                atau <strong>6 tahun 8 bulan</strong> dengan ijazah TK
                                (dihitung per 1 Juli {{ date('Y') }}).
                            </div>
                        </div>

                        {{-- Nama --}}
                        <div class="form-row">
                            <div class="form-group">
                                <label for="nama_siswa">Nama Lengkap <span class="req">*</span></label>
                                <input type="text" id="nama_siswa" name="nama_siswa"
                                       class="form-control @error('nama_siswa') is-error @enderror"
                                       value="{{ old('nama_siswa', $siswa->nama_siswa ?? '') }}"
                                       placeholder="Sesuai akta kelahiran, tanpa singkatan">
                                @error('nama_siswa')<span class="err-msg show">{{ $message }}</span>@enderror
                                <span class="err-msg" id="err_nama_siswa">Nama lengkap wajib diisi</span>
                            </div>
                        </div>

                        {{--
                            FIX BUG 1: Tanggal lahir + usia inline di kanan
                            - Hapus #usia-inline dari dalam .tgl-usia-wrapper (lama: usia di bawah/samping date input)
                            - Sekarang: date input & usia badge dalam satu baris via .tgl-usia-row
                            - Field "Usia" readonly dihapus dari form-col-2 sendiri, digabung langsung inline
                        --}}
                        <div class="form-row form-col-2">
                            <div class="form-group">
                                <label for="tempat_lahir">Tempat Lahir <span class="req">*</span></label>
                                <input type="text" id="tempat_lahir" name="tempat_lahir"
                                       class="form-control @error('tempat_lahir') is-error @enderror"
                                       value="{{ old('tempat_lahir', $siswa->tempat_lahir ?? '') }}"
                                       placeholder="Kota / Kabupaten">
                                @error('tempat_lahir')<span class="err-msg show">{{ $message }}</span>@enderror
                                <span class="err-msg" id="err_tempat_lahir">Tempat lahir wajib diisi</span>
                            </div>
                            <div class="form-group">
                                <label for="tgl_lahir">Tanggal Lahir <span class="req">*</span></label>
                                {{-- Wrapper baru: date input + badge usia inline sejajar --}}
                                <div class="tgl-usia-row">
                                    <input type="date" id="tgl_lahir" name="tgl_lahir"
                                           class="form-control @error('tgl_lahir') is-error @enderror"
                                           value="{{ old('tgl_lahir', isset($siswa->tanggal_lahir) ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('Y-m-d') : '') }}"
                                           max="{{ date('Y-m-d') }}">
                                    <div id="usia-inline" class="usia-inline-box" style="display:none;"></div>
                                </div>
                                @error('tgl_lahir')<span class="err-msg show">{{ $message }}</span>@enderror
                                <span class="err-msg" id="err_tgl_lahir">Usia belum memenuhi syarat minimum pendaftaran</span>
                            </div>
                        </div>

                        {{-- Field usia readonly DIHAPUS dari sini, sudah digantikan badge inline di samping kanan --}}

                        {{-- Jenis Kelamin & Agama --}}
                        <div class="form-row form-col-2">
                            <div class="form-group">
                                <label>Jenis Kelamin <span class="req">*</span></label>
                                {{--
                                    FIX BUG 2: Radio button
                                    - Hapus semua atribut checked dari input, cukup pakai class 'selected' di label
                                    - Input radio pakai display:none murni (tidak ada position:absolute)
                                    - Handler klik ada di JS via event delegation yang clean
                                --}}
                                <div class="radio-group-1" id="rg_jenis_kelamin">
                                    <label class="radio-btn-1 {{ old('jenis_kelamin', $siswa->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}" data-value="L">
                                        <input type="radio" name="jenis_kelamin" value="L"
                                               {{ old('jenis_kelamin', $siswa->jenis_kelamin ?? '') == 'L' ? 'checked' : '' }}>
                                        <span class="radio-dot"></span>
                                        <i class="fa-solid fa-mars"></i> Laki-laki
                                    </label>
                                    <label class="radio-btn-1 {{ old('jenis_kelamin', $siswa->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}" data-value="P">
                                        <input type="radio" name="jenis_kelamin" value="P"
                                               {{ old('jenis_kelamin', $siswa->jenis_kelamin ?? '') == 'P' ? 'checked' : '' }}>
                                        <span class="radio-dot"></span>
                                        <i class="fa-solid fa-venus"></i> Perempuan
                                    </label>
                                </div>
                                <span class="err-msg" id="err_jenis_kelamin">Jenis kelamin wajib dipilih</span>
                            </div>
                            <div class="form-group">
                                <label for="agama">Agama <span class="req">*</span></label>
                                <select id="agama" name="agama"
                                        class="form-control @error('agama') is-error @enderror">
                                    <option value="">-- Pilih Agama --</option>
                                    @foreach(['Islam','Kristen Protestan','Kristen Katolik','Hindu','Buddha','Konghucu'] as $agm)
                                        <option value="{{ $agm }}" {{ old('agama', $siswa->agama ?? '') == $agm ? 'selected' : '' }}>{{ $agm }}</option>
                                    @endforeach
                                </select>
                                @error('agama')<span class="err-msg show">{{ $message }}</span>@enderror
                                <span class="err-msg" id="err_agama">Agama wajib dipilih</span>
                            </div>
                        </div>

                        {{-- NIK --}}
                        <div class="form-row form-col-2">
                            <div class="form-group">
                                <label for="nik_siswa">NIK Siswa <span class="label-hint">(16 digit, sesuai KK)</span></label>
                                <input type="text" id="nik_siswa" name="nik_siswa"
                                       class="form-control"
                                       value="{{ old('nik_siswa', $siswa->nik_siswa ?? '') }}"
                                       placeholder="3XXXXXXXXXXXXXXX"
                                       maxlength="16" inputmode="numeric">
                            </div>
                            <div class="form-group"></div>
                        </div>

                        {{-- Alamat --}}
                        <div class="form-row">
                            <div class="form-group">
                                <label for="alamat">Alamat Lengkap <span class="req">*</span></label>
                                <textarea id="alamat" name="alamat" rows="2"
                                          class="form-control @error('alamat') is-error @enderror"
                                          placeholder="Nama jalan, nomor rumah, RT/RW">{{ old('alamat', $siswa->alamat ?? '') }}</textarea>
                                {{--
                                    FIX BUG 3: Tombol Maps
                                    - type="button" sudah ada, tapi pastikan tidak ada z-index issue
                                    - Pindah handler ke onclick attribute untuk menghindari listener race condition
                                --}}
                                <button type="button" class="btn-gmaps" id="btnMaps" onclick="ambilDariMaps(this)">
                                    <i class="fa-solid fa-location-dot"></i> Ambil dari Maps
                                </button>
                                @error('alamat')<span class="err-msg show">{{ $message }}</span>@enderror
                                <span class="err-msg" id="err_alamat">Alamat lengkap wajib diisi</span>
                            </div>
                        </div>

                        {{-- Kelurahan, Kecamatan, Kode Pos --}}
                        <div class="form-row form-col-3">
                            {{-- KELURAHAN --}}
                            <div class="form-group">
                                <label for="kelurahan_sel">Kelurahan / Desa</label>
                                <select id="kelurahan_sel" class="form-control" onchange="handleKelurahan(this)">
                                    <option value="">-- Pilih Kelurahan --</option>
                                    @php
                                        $kelurahanList = [
                                            'Babakan','Babat','Bojongkamal','Caringin','Ciangir',
                                            'Cirarab','Kemuning','Legok','Palasari','Rancagong','Serdang Wetan'
                                        ];
                                        $savedKel = old('kelurahan', $siswa->kelurahan ?? '');
                                    @endphp
                                    @foreach($kelurahanList as $kel)
                                        <option value="{{ $kel }}" {{ $savedKel === $kel ? 'selected' : '' }}>{{ $kel }}</option>
                                    @endforeach
                                    <option value="__lainnya__" {{ ($savedKel && !in_array($savedKel, $kelurahanList)) ? 'selected' : '' }}>-- Lainnya (isi manual) --</option>
                                </select>
                                <input type="hidden" id="kelurahan" name="kelurahan"
                                       value="{{ old('kelurahan', $siswa->kelurahan ?? '') }}">
                                {{--
                                    FIX BUG 4: Input manual kelurahan
                                    - Hapus style="display:none" dari sini, visibilitas dikontrol murni via JS
                                    - Tambah id yang konsisten dan pastikan tidak ada CSS yang override pointer-events
                                --}}
                                <input type="text" id="kelurahan_custom" class="form-control kelurahan-custom-input"
                                       placeholder="Ketik nama kelurahan/desa"
                                       autocomplete="off"
                                       value="{{ ($savedKel && !in_array($savedKel, $kelurahanList)) ? $savedKel : '' }}">
                            </div>

                            {{-- KECAMATAN --}}
                            <div class="form-group">
                                <label for="kecamatan_sel">Kecamatan</label>
                                <select id="kecamatan_sel" class="form-control" onchange="handleKecamatan(this)">
                                    <option value="">-- Pilih Kecamatan --</option>
                                    @php
                                        $kecamatanList = ['Legok'];
                                        $savedKec = old('kecamatan', $siswa->kecamatan ?? '');
                                    @endphp
                                    @foreach($kecamatanList as $kec)
                                        <option value="{{ $kec }}" {{ $savedKec === $kec ? 'selected' : '' }}>{{ $kec }}</option>
                                    @endforeach
                                    <option value="__lainnya__" {{ ($savedKec && !in_array($savedKec, $kecamatanList)) ? 'selected' : '' }}>-- Lainnya (isi manual) --</option>
                                </select>
                                <input type="hidden" id="kecamatan" name="kecamatan"
                                       value="{{ old('kecamatan', $siswa->kecamatan ?? '') }}">
                                {{-- FIX BUG 4: sama seperti kelurahan --}}
                                <input type="text" id="kecamatan_custom" class="form-control kecamatan-custom-input"
                                       placeholder="Ketik nama kecamatan"
                                       autocomplete="off"
                                       value="{{ ($savedKec && !in_array($savedKec, $kecamatanList)) ? $savedKec : '' }}">
                            </div>

                            {{-- KODE POS --}}
                            <div class="form-group">
                                <label for="kode_pos">Kode Pos</label>
                                <input type="text" id="kode_pos" name="kode_pos"
                                       class="form-control"
                                       value="{{ old('kode_pos', $siswa->kode_pos ?? '') }}"
                                       placeholder="XXXXX"
                                       maxlength="5" inputmode="numeric">
                            </div>
                        </div>

                        <div class="form-row form-col-2">
                            <div class="form-group">
                                <label for="anak_ke">Anak Ke-</label>
                                <input type="number" id="anak_ke" name="anak_ke"
                                       class="form-control"
                                       value="{{ old('anak_ke', $siswa->anak_ke ?? '') }}"
                                       min="1" max="20" placeholder="1">
                            </div>
                            <div class="form-group">
                                <label for="jml_saudara">Jumlah Saudara Kandung</label>
                                <input type="number" id="jml_saudara" name="jml_saudara"
                                       class="form-control"
                                       value="{{ old('jml_saudara', $siswa->jml_saudara ?? '') }}"
                                       min="0" max="20" placeholder="0">
                            </div>
                        </div>

                        <div class="form-divider"></div>

                        <h2 class="section-title">
                            <i class="fa-solid fa-graduation-cap"></i>
                            Riwayat Pendidikan Sebelumnya
                        </h2>

                        <div class="form-row form-col-2">
                            <div class="form-group">
                                <label>Lulusan TK / PAUD <span class="req">*</span></label>
                                <div class="radio-group" id="rg_lulusan_tk">
                                    <label class="radio-btn {{ old('lulusan_tk', $siswa->lulusan_tk ?? '') == 'ya' ? 'selected' : '' }}" data-value="ya">
                                        <input type="radio" name="lulusan_tk" value="ya"
                                               {{ old('lulusan_tk', $siswa->lulusan_tk ?? '') == 'ya' ? 'checked' : '' }}>
                                        <span class="radio-dot"></span>
                                        <i class="fa-solid fa-check"></i> Ya
                                    </label>
                                    <label class="radio-btn {{ old('lulusan_tk', $siswa->lulusan_tk ?? '') == 'tidak' ? 'selected' : '' }}" data-value="tidak">
                                        <input type="radio" name="lulusan_tk" value="tidak"
                                               {{ old('lulusan_tk', $siswa->lulusan_tk ?? '') == 'tidak' ? 'checked' : '' }}>
                                        <span class="radio-dot"></span>
                                        <i class="fa-solid fa-xmark"></i> Tidak
                                    </label>
                                </div>
                                <span class="err-msg" id="err_lulusan_tk">Pilih salah satu</span>
                            </div>
                            <div class="form-group" id="group_nama_tk">
                                <label for="nama_tk">Nama TK / PAUD</label>
                                <input type="text" id="nama_tk" name="nama_tk"
                                       class="form-control"
                                       value="{{ old('nama_tk', $siswa->nama_tk ?? '') }}"
                                       placeholder="Nama sekolah TK/PAUD asal">
                            </div>
                        </div>

                        <div class="form-actions">
                            <div></div>
                            <button type="button" class="btn btn-primary" onclick="nextStep(1)">
                                Lanjut: Data Orang Tua <i class="fa-solid fa-arrow-right"></i>
                            </button>
                        </div>

                    </div>
                </div>

                {{-- ===== PANEL 2: DATA ORANG TUA ===== --}}
                <div class="step-panel" id="panel-2">
                    <div class="section-card">

                        <h2 class="section-title">
                            <i class="fa-solid fa-person"></i>
                            Data Ayah
                        </h2>

                        <div class="form-row form-col-2">
                            <div class="form-group">
                                <label for="nama_ayah">Nama Ayah <span class="req">*</span></label>
                                <input type="text" id="nama_ayah" name="nama_ayah"
                                       class="form-control @error('nama_ayah') is-error @enderror"
                                       value="{{ old('nama_ayah', $orangtua->nama_ayah ?? '') }}"
                                       placeholder="Nama lengkap ayah kandung">
                                @error('nama_ayah')<span class="err-msg show">{{ $message }}</span>@enderror
                                <span class="err-msg" id="err_nama_ayah">Nama ayah wajib diisi</span>
                            </div>
                            <div class="form-group">
                                <label for="nik_ayah">NIK Ayah <span class="label-hint">(sesuai KTP)</span></label>
                                <input type="text" id="nik_ayah" name="nik_ayah"
                                       class="form-control"
                                       value="{{ old('nik_ayah', $orangtua->nik_ayah ?? '') }}"
                                       placeholder="16 digit NIK" maxlength="16" inputmode="numeric">
                            </div>
                        </div>

                        <div class="form-row form-col-2">
                            <div class="form-group">
                                <label for="pekerjaan_ayah">Pekerjaan Ayah <span class="req">*</span></label>
                                <select id="pekerjaan_ayah" name="pekerjaan_ayah"
                                        class="form-control @error('pekerjaan_ayah') is-error @enderror">
                                    <option value="">-- Pilih Pekerjaan --</option>
                                    @foreach(['PNS / ASN','TNI / Polri','Karyawan Swasta','Wiraswasta / Pedagang','Petani / Nelayan','Buruh','Tidak Bekerja','Lainnya'] as $pkj)
                                        <option value="{{ $pkj }}" {{ old('pekerjaan_ayah', $orangtua->pekerjaan_ayah ?? '') == $pkj ? 'selected' : '' }}>{{ $pkj }}</option>
                                    @endforeach
                                </select>
                                @error('pekerjaan_ayah')<span class="err-msg show">{{ $message }}</span>@enderror
                                <span class="err-msg" id="err_pekerjaan_ayah">Pekerjaan ayah wajib dipilih</span>
                            </div>
                            <div class="form-group">
                                <label for="pendidikan_ayah">Pendidikan Terakhir Ayah</label>
                                <select id="pendidikan_ayah" name="pendidikan_ayah" class="form-control">
                                    <option value="">-- Pilih --</option>
                                    @foreach(['SD / Sederajat','SMP / Sederajat','SMA / Sederajat','D1 / D2 / D3','S1 / D4','S2','S3','Tidak Sekolah'] as $pdd)
                                        <option value="{{ $pdd }}" {{ old('pendidikan_ayah', $orangtua->pendidikan_ayah ?? '') == $pdd ? 'selected' : '' }}>{{ $pdd }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-divider"></div>

                        <h2 class="section-title">
                            <i class="fa-solid fa-person-dress"></i>
                            Data Ibu
                        </h2>

                        <div class="form-row form-col-2">
                            <div class="form-group">
                                <label for="nama_ibu">Nama Ibu <span class="req">*</span></label>
                                <input type="text" id="nama_ibu" name="nama_ibu"
                                       class="form-control @error('nama_ibu') is-error @enderror"
                                       value="{{ old('nama_ibu', $orangtua->nama_ibu ?? '') }}"
                                       placeholder="Nama lengkap ibu kandung">
                                @error('nama_ibu')<span class="err-msg show">{{ $message }}</span>@enderror
                                <span class="err-msg" id="err_nama_ibu">Nama ibu wajib diisi</span>
                            </div>
                            <div class="form-group">
                                <label for="nik_ibu">NIK Ibu <span class="label-hint">(sesuai KTP)</span></label>
                                <input type="text" id="nik_ibu" name="nik_ibu"
                                       class="form-control"
                                       value="{{ old('nik_ibu', $orangtua->nik_ibu ?? '') }}"
                                       placeholder="16 digit NIK" maxlength="16" inputmode="numeric">
                            </div>
                        </div>

                        <div class="form-row form-col-2">
                            <div class="form-group">
                                <label for="pekerjaan_ibu">Pekerjaan Ibu <span class="req">*</span></label>
                                <select id="pekerjaan_ibu" name="pekerjaan_ibu"
                                        class="form-control @error('pekerjaan_ibu') is-error @enderror">
                                    <option value="">-- Pilih Pekerjaan --</option>
                                    @foreach(['PNS / ASN','TNI / Polri','Karyawan Swasta','Wiraswasta / Pedagang','Ibu Rumah Tangga','Buruh','Tidak Bekerja','Lainnya'] as $pkj)
                                        <option value="{{ $pkj }}" {{ old('pekerjaan_ibu', $orangtua->pekerjaan_ibu ?? '') == $pkj ? 'selected' : '' }}>{{ $pkj }}</option>
                                    @endforeach
                                </select>
                                @error('pekerjaan_ibu')<span class="err-msg show">{{ $message }}</span>@enderror
                                <span class="err-msg" id="err_pekerjaan_ibu">Pekerjaan ibu wajib dipilih</span>
                            </div>
                            <div class="form-group">
                                <label for="pendidikan_ibu">Pendidikan Terakhir Ibu</label>
                                <select id="pendidikan_ibu" name="pendidikan_ibu" class="form-control">
                                    <option value="">-- Pilih --</option>
                                    @foreach(['SD / Sederajat','SMP / Sederajat','SMA / Sederajat','D1 / D2 / D3','S1 / D4','S2','S3','Tidak Sekolah'] as $pdd)
                                        <option value="{{ $pdd }}" {{ old('pendidikan_ibu', $orangtua->pendidikan_ibu ?? '') == $pdd ? 'selected' : '' }}>{{ $pdd }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-divider"></div>

                        <h2 class="section-title">
                            <i class="fa-solid fa-phone"></i>
                            Kontak &amp; Alamat
                        </h2>

                        <div class="form-row form-col-2">
                            <div class="form-group">
                                <label for="no_hp">No. HP / WhatsApp <span class="req">*</span></label>
                                <div class="input-prefix-wrapper">
                                    <span class="input-prefix">+62</span>
                                    <input type="tel" id="no_hp" name="no_hp"
                                           class="form-control has-prefix @error('no_hp') is-error @enderror"
                                           value="{{ old('no_hp', $orangtua->no_hp ?? '') }}"
                                           placeholder="08xxxxxxxxxx" inputmode="numeric">
                                </div>
                                @error('no_hp')<span class="err-msg show">{{ $message }}</span>@enderror
                                <span class="err-msg" id="err_no_hp">Nomor HP tidak valid (format: 08xxxxxxxxxx)</span>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email"
                                       class="form-control"
                                       value="{{ old('email', $orangtua->email ?? '') }}"
                                       placeholder="contoh@email.com">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="alamat_ortu">Alamat Orang Tua <span class="label-hint">(kosongkan jika sama dengan alamat siswa)</span></label>
                                <textarea id="alamat_ortu" name="alamat_ortu" rows="2"
                                          class="form-control"
                                          placeholder="Isi jika berbeda dengan alamat calon siswa">{{ old('alamat_ortu', $orangtua->alamat_ortu ?? '') }}</textarea>
                            </div>
                        </div>

                        <div class="form-divider"></div>

                        <div class="collapsible-header" onclick="toggleSection('wali-section', this)">
                            <h2 class="section-title" style="margin:0;">
                                <i class="fa-solid fa-person-shelter"></i>
                                Data Wali <span class="label-hint">(opsional)</span>
                            </h2>
                            <i class="fa-solid fa-chevron-down collapsible-icon"></i>
                        </div>

                        <div class="collapsible-content" id="wali-section">
                            <div class="form-row form-col-2" style="margin-top:16px;">
                                <div class="form-group">
                                    <label for="nama_wali">Nama Wali</label>
                                    <input type="text" id="nama_wali" name="nama_wali"
                                           class="form-control"
                                           value="{{ old('nama_wali', $orangtua->nama_wali ?? '') }}"
                                           placeholder="Jika diasuh selain orang tua kandung">
                                </div>
                                <div class="form-group">
                                    <label for="hub_wali">Hubungan dengan Siswa</label>
                                    <select id="hub_wali" name="hub_wali" class="form-control">
                                        <option value="">-- Pilih --</option>
                                        @foreach(['Kakek / Nenek','Paman / Bibi','Kakak Kandung','Lainnya'] as $hw)
                                            <option value="{{ $hw }}" {{ old('hub_wali', $orangtua->hub_wali ?? '') == $hw ? 'selected' : '' }}>{{ $hw }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-row form-col-2">
                                <div class="form-group">
                                    <label for="nik_wali">NIK Wali</label>
                                    <input type="text" id="nik_wali" name="nik_wali"
                                           class="form-control"
                                           value="{{ old('nik_wali', $orangtua->nik_wali ?? '') }}"
                                           placeholder="16 digit NIK" maxlength="16" inputmode="numeric">
                                </div>
                                <div class="form-group">
                                    <label for="no_hp_wali">No. HP Wali</label>
                                    <input type="tel" id="no_hp_wali" name="no_hp_wali"
                                           class="form-control"
                                           value="{{ old('no_hp_wali', $orangtua->no_hp_wali ?? '') }}"
                                           placeholder="08xxxxxxxxxx" inputmode="numeric">
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="button" class="btn btn-outline" onclick="prevStep(2)">
                                <i class="fa-solid fa-arrow-left"></i> Kembali
                            </button>
                            <button type="button" class="btn btn-primary" onclick="nextStep(2)">
                                Lanjut: Preview <i class="fa-solid fa-arrow-right"></i>
                            </button>
                        </div>

                    </div>
                </div>

                {{-- ===== PANEL 3: PREVIEW & SUBMIT ===== --}}
                <div class="step-panel" id="panel-3">
                    <div class="section-card">

                        <h2 class="section-title">
                            <i class="fa-solid fa-eye"></i>
                            Preview Data Pendaftaran
                        </h2>

                        <div class="info-box info-blue">
                            <i class="fa-solid fa-circle-info"></i>
                            <div>
                                Periksa kembali semua data sebelum mengirim.
                                Setelah submit, Anda akan mendapatkan <strong>nomor pendaftaran</strong>
                                dan dapat melanjutkan ke tahap upload dokumen.
                            </div>
                        </div>

                        <div class="preview-section">
                            <div class="preview-section-title">
                                <i class="fa-solid fa-child-reaching"></i>
                                Data Calon Siswa
                                <button type="button" class="btn-edit-step" onclick="goToStep(1)">
                                    <i class="fa-solid fa-pen"></i> Edit
                                </button>
                            </div>
                            <div class="preview-grid" id="preview-siswa"></div>
                        </div>

                        <div class="form-divider"></div>

                        <div class="preview-section">
                            <div class="preview-section-title">
                                <i class="fa-solid fa-users"></i>
                                Data Orang Tua / Wali
                                <button type="button" class="btn-edit-step" onclick="goToStep(2)">
                                    <i class="fa-solid fa-pen"></i> Edit
                                </button>
                            </div>
                            <div class="preview-grid" id="preview-ortu"></div>
                        </div>

                        <div class="form-divider"></div>

                        <div class="form-group">
                            <label class="checkbox-label">
                                <input type="checkbox" id="setuju" name="setuju" value="1">
                                <span class="checkbox-box"></span>
                                <span>
                                    Saya menyatakan bahwa data yang saya isi adalah <strong>benar dan dapat dipertanggungjawabkan</strong>.
                                    Apabila dikemudian hari terbukti tidak benar, saya bersedia menerima konsekuensi yang berlaku.
                                </span>
                            </label>
                            <span class="err-msg" id="err_setuju">Anda harus menyetujui pernyataan di atas</span>
                        </div>

                        <div class="form-actions">
                            <button type="button" class="btn btn-outline" onclick="prevStep(3)">
                                <i class="fa-solid fa-arrow-left"></i> Kembali Edit
                            </button>
                            <button type="submit" class="btn btn-success" onclick="return checkSetuju()">
                                <i class="fa-solid fa-paper-plane"></i>
                                {{ isset($pendaftaran) && $pendaftaran ? 'Simpan Perubahan' : 'Submit Pendaftaran' }}
                            </button>
                        </div>

                    </div>
                </div>

            </form>

        </div>
    </main>
</div>

@endsection

@push('scripts')
<script>
// ================================================================
// KONSTANTA
// ================================================================
var refDate = new Date('{{ date('Y') }}-07-01');

// ================================================================
// DOMContentLoaded — INIT SEMUA
// ================================================================
document.addEventListener('DOMContentLoaded', function () {

    // ------------------------------------------------------------
    // FIX BUG 2: RADIO BUTTON
    // Root cause lama: JS pasang position:fixed + pointer-events:none
    // tapi itu malah bikin input TETAP ADA di DOM dan block klik.
    // Fix baru: JANGAN SENTUH style input sama sekali.
    // CSS sudah handle dengan display:none. JS hanya pasang listener
    // pada .radio-group via event delegation — clean, no conflict.
    // ------------------------------------------------------------
    document.querySelectorAll('.radio-group').forEach(function (group) {
        group.addEventListener('click', function (e) {
            // Cari .radio-btn yang paling dekat dari target klik
            var btn = e.target.closest('.radio-btn');
            if (!btn) return;

            // Cegah default browser behavior
            e.preventDefault();

            var radio = btn.querySelector('input[type="radio"]');
            if (!radio) return;

            // Reset semua dalam group ini
            group.querySelectorAll('.radio-btn').forEach(function (b) {
                b.classList.remove('selected');
                var r = b.querySelector('input[type="radio"]');
                if (r) r.checked = false;
            });

            // Set yang dipilih
            radio.checked = true;
            btn.classList.add('selected');

            // Side effects
            if (radio.name === 'lulusan_tk') {
                var group_tk = document.getElementById('group_nama_tk');
                group_tk.style.display = (radio.value === 'ya') ? '' : 'none';
                // Recalculate usia badge karena syarat usia bergantung status TK
                var tglVal = document.getElementById('tgl_lahir').value;
                if (tglVal) hitungUsia(tglVal);
                setError('lulusan_tk', false);
            }
            if (radio.name === 'jenis_kelamin') {
                setError('jenis_kelamin', false);
            }
        });
    });

    // ------------------------------------------------------------
    // FIX BUG 1: USIA OTOMATIS
    // Root cause: event 'change' tidak selalu fire di semua browser
    // saat user pilih tanggal (terutama mobile & Firefox).
    // Fix: listen KEDUANYA — 'input' dan 'change'.
    // Selain itu, field #usia (readonly) dihapus dari HTML,
    // digantikan badge #usia-inline yang tampil inline di kanan
    // tanggal lahir via .tgl-usia-row layout (flexbox).
    // ------------------------------------------------------------
    var tglInput = document.getElementById('tgl_lahir');

    function onTglChange() {
        var val = tglInput.value;
        if (val) {
            hitungUsia(val);
        } else {
            var box = document.getElementById('usia-inline');
            if (box) box.style.display = 'none';
        }
    }

    tglInput.addEventListener('change', onTglChange);
    tglInput.addEventListener('input',  onTglChange);  // FIX: tambah 'input' event

    // Init langsung saat load jika value sudah ada (dari old() / DB)
    if (tglInput.value) hitungUsia(tglInput.value);

    // ------------------------------------------------------------
    // FIX BUG 4: INPUT MANUAL KELURAHAN & KECAMATAN
    // Root cause: display:none di HTML membuat field tidak bisa
    // dapat focus/klik. Event listener dipasang sebelum element
    // visible (race condition). Fix: visibilitas DIKONTROL PENUH
    // oleh JS via fungsi showCustomInput() — tidak ada inline style
    // di HTML. Listener input langsung update hidden field.
    // ------------------------------------------------------------

    // Init state kelurahan
    var kelSel    = document.getElementById('kelurahan_sel');
    var kelCustom = document.getElementById('kelurahan_custom');
    var kelHidden = document.getElementById('kelurahan');

    // Sembunyikan dulu, tampilkan hanya jika 'lainnya' terpilih
    if (kelSel.value === '__lainnya__') {
        kelCustom.style.display = '';
        kelCustom.style.marginTop = '8px';
    } else {
        kelCustom.style.display = 'none';
    }

    // Listener realtime: update hidden input setiap user mengetik
    kelCustom.addEventListener('input', function () {
        kelHidden.value = this.value;
    });
    kelCustom.addEventListener('change', function () {
        kelHidden.value = this.value;
    });

    // Init state kecamatan
    var kecSel    = document.getElementById('kecamatan_sel');
    var kecCustom = document.getElementById('kecamatan_custom');
    var kecHidden = document.getElementById('kecamatan');

    if (kecSel.value === '__lainnya__') {
        kecCustom.style.display = '';
        kecCustom.style.marginTop = '8px';
    } else {
        kecCustom.style.display = 'none';
    }

    kecCustom.addEventListener('input', function () {
        kecHidden.value = this.value;
    });
    kecCustom.addEventListener('change', function () {
        kecHidden.value = this.value;
    });

    // Auto-fill kecamatan & kode pos jika kelurahan dari list sudah terpilih
    if (kelSel.value && kelSel.value !== '' && kelSel.value !== '__lainnya__') {
        if (!document.getElementById('kode_pos').value) {
            document.getElementById('kode_pos').value = '15820';
        }
        if (!kecHidden.value) {
            kecSel.value    = 'Legok';
            kecHidden.value = 'Legok';
        }
    }

    // NIK & kode pos: digits only
    ['nik_siswa', 'nik_ayah', 'nik_ibu', 'nik_wali', 'kode_pos'].forEach(function (id) {
        var el = document.getElementById(id);
        if (el) {
            el.addEventListener('input', function () {
                this.value = this.value.replace(/\D/g, '');
            });
        }
    });

    // Sidebar toggle
    var sidebarToggle = document.getElementById('sidebarToggle');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('sidebar-open');
        });
    }

    // Auto-dismiss alerts setelah 5 detik
    setTimeout(function () {
        document.querySelectorAll('.alert').forEach(function (el) {
            el.style.transition = 'opacity .4s';
            el.style.opacity    = '0';
            setTimeout(function () { if (el.parentNode) el.remove(); }, 400);
        });
    }, 5000);

    // Init TK visibility
    var tkChecked = document.querySelector('input[name="lulusan_tk"]:checked');
    var groupTk = document.getElementById('group_nama_tk');
    groupTk.style.display = (tkChecked && tkChecked.value === 'ya') ? '' : 'none';

    // Checkbox setuju — clear error
    var setujuCb = document.getElementById('setuju');
    if (setujuCb) {
        setujuCb.addEventListener('change', function () {
            setError('setuju', false);
        });
    }
});

// ================================================================
// FIX BUG 1: HITUNG USIA
// Mengisi badge #usia-inline yang tampil di sebelah kanan input
// tanggal lahir (dalam .tgl-usia-row via flexbox).
// Field #usia readonly sudah dihapus dari HTML sepenuhnya.
// ================================================================
function hitungUsia(tglStr) {
    var tgl    = new Date(tglStr);
    var years  = refDate.getFullYear() - tgl.getFullYear();
    var months = refDate.getMonth()    - tgl.getMonth();
    if (refDate.getDate() < tgl.getDate()) months--;
    if (months < 0) { years--; months += 12; }
    var total = years * 12 + months;

    var box  = document.getElementById('usia-inline');
    if (!box) return;

    var tkCk  = document.querySelector('input[name="lulusan_tk"]:checked');
    var hasTK = tkCk && tkCk.value === 'ya';

    box.style.display = 'inline-flex';
    box.className     = 'usia-inline-box';

    if (total >= 84) {
        box.classList.add('usia-ok');
        box.innerHTML = '<i class="fa-solid fa-circle-check"></i>&nbsp;' +
                        years + ' thn ' + months + ' bln — Memenuhi syarat';
    } else if (total >= 80 && hasTK) {
        box.classList.add('usia-warn');
        box.innerHTML = '<i class="fa-solid fa-triangle-exclamation"></i>&nbsp;' +
                        years + ' thn ' + months + ' bln — Perlu ijazah TK';
    } else if (total >= 80) {
        box.classList.add('usia-warn');
        box.innerHTML = '<i class="fa-solid fa-triangle-exclamation"></i>&nbsp;' +
                        years + ' thn ' + months + ' bln — Pilih "Ya" jika punya ijazah TK';
    } else {
        box.classList.add('usia-err');
        box.innerHTML = '<i class="fa-solid fa-circle-xmark"></i>&nbsp;' +
                        years + ' thn ' + months + ' bln — Belum memenuhi syarat';
    }
}

// ================================================================
// FIX BUG 4: KELURAHAN & KECAMATAN DROPDOWN
// ================================================================
function handleKelurahan(sel) {
    var custom = document.getElementById('kelurahan_custom');
    var hidden = document.getElementById('kelurahan');
    var isLain = sel.value === '__lainnya__';

    if (isLain) {
        custom.style.display    = '';
        custom.style.marginTop  = '8px';
        hidden.value            = '';
        custom.value            = '';
        // Fokus ke input supaya user langsung bisa ketik
        setTimeout(function () { custom.focus(); }, 50);
    } else {
        custom.style.display = 'none';
        hidden.value         = sel.value;
        custom.value         = '';

        // Auto-fill kecamatan & kode pos untuk kelurahan dalam list Legok
        if (sel.value !== '') {
            document.getElementById('kecamatan_sel').value            = 'Legok';
            document.getElementById('kecamatan').value                = 'Legok';
            document.getElementById('kecamatan_custom').style.display = 'none';
            document.getElementById('kode_pos').value                 = '15820';
        }
    }
}

function handleKecamatan(sel) {
    var custom = document.getElementById('kecamatan_custom');
    var hidden = document.getElementById('kecamatan');
    var isLain = sel.value === '__lainnya__';

    if (isLain) {
        custom.style.display   = '';
        custom.style.marginTop = '8px';
        hidden.value           = '';
        custom.value           = '';
        setTimeout(function () { custom.focus(); }, 50);
    } else {
        custom.style.display = 'none';
        hidden.value         = sel.value;
        custom.value         = '';
    }
}

// ================================================================
// FIX BUG 3: AMBIL DARI MAPS
// Root cause: addEventListener di DOMContentLoaded oke, tapi
// onclick="ambilDariMaps(this)" di HTML lebih reliable karena
// tidak bergantung pada urutan eksekusi listener.
// (Handler sudah dipindah ke atribut onclick di HTML di atas)
// ================================================================
function ambilDariMaps(btn) {
    if (!navigator.geolocation) {
        alert('Browser tidak mendukung geolokasi.');
        return;
    }

    var originalHTML = btn.innerHTML;
    btn.innerHTML    = '<i class="fa-solid fa-spinner fa-spin"></i> Mengambil lokasi...';
    btn.disabled     = true;

    navigator.geolocation.getCurrentPosition(
        function (pos) {
            fetch(
                'https://nominatim.openstreetmap.org/reverse?format=json' +
                '&lat=' + pos.coords.latitude +
                '&lon=' + pos.coords.longitude +
                '&addressdetails=1&accept-language=id'
            )
            .then(function (r) { return r.json(); })
            .then(function (data) {
                var addr     = data.address || {};
                var road     = addr.road || addr.pedestrian || addr.footway || '';
                var house    = addr.house_number ? ' No. ' + addr.house_number : '';
                var village  = addr.village || addr.suburb || addr.neighbourhood || '';
                var district = addr.city_district || addr.county || '';
                var postcode = (addr.postcode || '').replace(/\D/g, '').slice(0, 5);

                var alamatField = document.getElementById('alamat');
                if (road && !alamatField.value.trim()) {
                    alamatField.value = road + house;
                }
                if (village)  isiKelurahan(village);
                if (district) isiKecamatan(district);
                if (postcode) document.getElementById('kode_pos').value = postcode;

                btn.innerHTML     = '<i class="fa-solid fa-circle-check"></i> Lokasi didapat!';
                btn.style.cssText = 'background:#d4edda;color:#0e6655;border-color:#a3cfbb;';

                setTimeout(function () {
                    btn.innerHTML     = originalHTML;
                    btn.style.cssText = '';
                    btn.disabled      = false;
                }, 2500);
            })
            .catch(function () {
                btn.innerHTML = originalHTML;
                btn.disabled  = false;
                alert('Gagal mendapatkan alamat. Silakan isi manual.');
            });
        },
        function (err) {
            btn.innerHTML = originalHTML;
            btn.disabled  = false;
            alert('Akses lokasi ditolak. Aktifkan izin lokasi di browser Anda.');
        },
        { timeout: 10000 }
    );
}

function isiKelurahan(val) {
    var sel  = document.getElementById('kelurahan_sel');
    var norm = val.toLowerCase();
    for (var i = 0; i < sel.options.length; i++) {
        var opt = sel.options[i].value;
        if (!opt || opt === '__lainnya__') continue;
        if (norm === opt.toLowerCase() || norm.includes(opt.toLowerCase())) {
            sel.value = opt;
            handleKelurahan(sel);
            return;
        }
    }
    sel.value = '__lainnya__';
    handleKelurahan(sel);
    var custom = document.getElementById('kelurahan_custom');
    custom.value = val;
    document.getElementById('kelurahan').value = val;
}

function isiKecamatan(val) {
    var sel  = document.getElementById('kecamatan_sel');
    var norm = val.toLowerCase();
    for (var i = 0; i < sel.options.length; i++) {
        var opt = sel.options[i].value;
        if (!opt || opt === '__lainnya__') continue;
        if (norm === opt.toLowerCase() || norm.includes(opt.toLowerCase())) {
            sel.value = opt;
            handleKecamatan(sel);
            return;
        }
    }
    sel.value = '__lainnya__';
    handleKecamatan(sel);
    var custom = document.getElementById('kecamatan_custom');
    custom.value = val;
    document.getElementById('kecamatan').value = val;
}

// ================================================================
// STEP NAVIGATION
// ================================================================
function nextStep(from) {
    if (from === 1 && !validateStep1()) return;
    if (from === 2 && !validateStep2()) return;
    if (from === 2) buildPreview();
    document.getElementById('panel-' + from).classList.remove('active');
    document.getElementById('panel-' + (from + 1)).classList.add('active');
    updateStepBar(from + 1);
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function prevStep(from) {
    document.getElementById('panel-' + from).classList.remove('active');
    document.getElementById('panel-' + (from - 1)).classList.add('active');
    updateStepBar(from - 1);
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function goToStep(target) {
    document.getElementById('panel-3').classList.remove('active');
    document.getElementById('panel-' + target).classList.add('active');
    updateStepBar(target);
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function updateStepBar(current) {
    [1, 2, 3].forEach(function (i) {
        var si = document.getElementById('si-' + i);
        si.classList.remove('active', 'done');
        if (i < current)  si.classList.add('done');
        if (i === current) si.classList.add('active');
    });
    [1, 2].forEach(function (i) {
        document.getElementById('sl-' + i).classList.toggle('done', i < current);
    });
}

// ================================================================
// VALIDASI
// ================================================================
function setError(id, isError) {
    var errEl = document.getElementById('err_' + id);
    var inpEl = document.getElementById(id);
    if (errEl) errEl.classList.toggle('show', isError);
    if (inpEl) inpEl.classList.toggle('is-error', isError);
    return !isError;
}

function validateStep1() {
    var ok = true;

    if (!document.getElementById('nama_siswa').value.trim()) {
        setError('nama_siswa', true); ok = false;
    } else { setError('nama_siswa', false); }

    if (!document.getElementById('tempat_lahir').value.trim()) {
        setError('tempat_lahir', true); ok = false;
    } else { setError('tempat_lahir', false); }

    if (!document.getElementById('agama').value) {
        setError('agama', true); ok = false;
    } else { setError('agama', false); }

    if (!document.getElementById('alamat').value.trim()) {
        setError('alamat', true); ok = false;
    } else { setError('alamat', false); }

    var jkChecked = document.querySelector('input[name="jenis_kelamin"]:checked');
    if (!jkChecked) {
        setError('jenis_kelamin', true); ok = false;
    } else { setError('jenis_kelamin', false); }

    // Validasi tanggal lahir + syarat usia
    var tglVal = document.getElementById('tgl_lahir').value;
    var tglOk  = false;
    if (tglVal) {
        var tgl    = new Date(tglVal);
        var years  = refDate.getFullYear() - tgl.getFullYear();
        var months = refDate.getMonth()    - tgl.getMonth();
        if (refDate.getDate() < tgl.getDate()) months--;
        if (months < 0) { years--; months += 12; }
        var total = years * 12 + months;
        var tkCk  = document.querySelector('input[name="lulusan_tk"]:checked');
        var hasTK = tkCk && tkCk.value === 'ya';
        tglOk = total >= (hasTK ? 80 : 84);
    }
    if (!tglOk) {
        setError('tgl_lahir', true); ok = false;
    } else { setError('tgl_lahir', false); }

    if (!ok) {
        var first = document.getElementById('panel-1').querySelector('.is-error, .err-msg.show');
        if (first) first.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
    return ok;
}

function validateStep2() {
    var ok = true;

    if (!document.getElementById('nama_ayah').value.trim()) {
        setError('nama_ayah', true); ok = false;
    } else { setError('nama_ayah', false); }

    if (!document.getElementById('nama_ibu').value.trim()) {
        setError('nama_ibu', true); ok = false;
    } else { setError('nama_ibu', false); }

    if (!document.getElementById('pekerjaan_ayah').value) {
        setError('pekerjaan_ayah', true); ok = false;
    } else { setError('pekerjaan_ayah', false); }

    if (!document.getElementById('pekerjaan_ibu').value) {
        setError('pekerjaan_ibu', true); ok = false;
    } else { setError('pekerjaan_ibu', false); }

    var hp = document.getElementById('no_hp').value.trim();
    if (!hp || !/^08[0-9]{7,12}$/.test(hp)) {
        setError('no_hp', true); ok = false;
    } else { setError('no_hp', false); }

    if (!ok) {
        var first = document.getElementById('panel-2').querySelector('.is-error, .err-msg.show');
        if (first) first.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
    return ok;
}

function checkSetuju() {
    var ok = document.getElementById('setuju').checked;
    setError('setuju', !ok);
    return ok;
}

// ================================================================
// BUILD PREVIEW
// ================================================================
function getVal(id) {
    var el = document.getElementById(id);
    return (el && el.value.trim())
        ? el.value.trim()
        : '<span style="color:var(--text-muted);font-style:italic">—</span>';
}

function previewItem(label, val) {
    return '<div class="preview-item">' +
               '<div class="preview-label">' + label + '</div>' +
               '<div class="preview-val">'   + val   + '</div>' +
           '</div>';
}

function buildPreview() {
    var tglRaw = document.getElementById('tgl_lahir').value;
    var tglFmt = tglRaw
        ? new Date(tglRaw).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' })
        : '—';

    var jkCk   = document.querySelector('input[name="jenis_kelamin"]:checked');
    var jkTeks = jkCk ? (jkCk.value === 'L' ? 'Laki-laki' : 'Perempuan') : '—';

    var tkCk   = document.querySelector('input[name="lulusan_tk"]:checked');
    var tkNama = document.getElementById('nama_tk').value.trim();
    var tkTeks = tkCk
        ? (tkCk.value === 'ya' ? ('Ya' + (tkNama ? ' — ' + tkNama : '')) : 'Tidak')
        : '—';

    var kelVal = document.getElementById('kelurahan').value || '—';
    var kecVal = document.getElementById('kecamatan').value || '—';

    document.getElementById('preview-siswa').innerHTML =
        previewItem('Nama Lengkap',    getVal('nama_siswa'))   +
        previewItem('Tempat Lahir',    getVal('tempat_lahir')) +
        previewItem('Tanggal Lahir',   tglFmt)                 +
        previewItem('Jenis Kelamin',   jkTeks)                 +
        previewItem('Agama',           getVal('agama'))        +
        previewItem('Alamat',          getVal('alamat'))       +
        previewItem('Kelurahan',       kelVal)                 +
        previewItem('Kecamatan',       kecVal)                 +
        previewItem('Kode Pos',        getVal('kode_pos'))     +
        previewItem('Lulusan TK/PAUD', tkTeks);

    document.getElementById('preview-ortu').innerHTML =
        previewItem('Nama Ayah',      getVal('nama_ayah'))      +
        previewItem('Pekerjaan Ayah', getVal('pekerjaan_ayah')) +
        previewItem('Nama Ibu',       getVal('nama_ibu'))       +
        previewItem('Pekerjaan Ibu',  getVal('pekerjaan_ibu'))  +
        previewItem('No. HP / WA',    getVal('no_hp'))          +
        previewItem('Email',          getVal('email'));
}

// ================================================================
// COLLAPSIBLE
// ================================================================
function toggleSection(id, header) {
    var section = document.getElementById(id);
    var icon    = header.querySelector('.collapsible-icon');
    var isOpen  = section.style.display !== 'none' && section.style.display !== '';
    section.style.display = isOpen ? 'none' : '';
    icon.style.transform  = isOpen ? 'rotate(0deg)' : 'rotate(180deg)';
}
</script>
@endpush