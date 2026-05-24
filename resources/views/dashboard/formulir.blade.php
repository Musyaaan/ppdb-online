@extends ("layouts.app")

@section ("title", "Formulir Pendaftaran - PPDB SD Negeri Legok III")

@section ("styles")
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/formulir.css') }}" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    />
@endsection

@section ("content")
    <div class="dashboard-wrapper">
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <img
                    src="{{ asset('image/Logo4.png') }}"
                    alt="Logo"
                    class="sidebar-logo"
                />
                <div class="sidebar-brand">
                    <span class="sidebar-brand-title">PPDB Online</span>
                    <span class="sidebar-brand-sub">SD Negeri Legok III</span>
                </div>
            </div>

            <nav class="sidebar-nav">
                <a
                    href="{{ route('dashboard.orangtua') }}"
                    class="sidebar-nav-item"
                >
                    <i class="fa-solid fa-house"></i>
                    <span>Dashboard</span>
                </a>
                <a
                    href="{{ route('formulir.index') }}"
                    class="sidebar-nav-item active"
                >
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
                <a href="{{ route('status.index') }}" class="sidebar-nav-item">
                    <i class="fa-solid fa-info-circle"></i>
                    <span>Status Pendaftaran</span>
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
                <a
                    href="{{ route('profil') }}"
                    class="topbar-user"
                    style="text-decoration: none"
                >
                    <div class="topbar-user-info">
                        <span class="topbar-user-name">{{
                            Auth::user()
                                ->nama
                        }}</span>
                        <span class="topbar-user-role"
                            >Orang Tua / Wali Murid</span
                        >
                    </div>
                    <div class="topbar-avatar">
                        {{
                            strtoupper(
                                substr(Auth::user()->nama, 0, 1),
                            )
                        }}
                    </div>
                </a>
            </header>

            <div class="dashboard-content">
                <div class="page-title-bar">
                    <div>
                        <h1 class="page-title">Formulir Pendaftaran</h1>
                        <p class="page-subtitle">Isi data berikut dengan lengkap dan benar sesuai dokumen resmi.</p>
                    </div>
                    @if (isset($pendaftaran) && $pendaftaran)
                        <span
                            class="status-badge status-{{ $pendaftaran->status }}"
                        >
                            <i class="fa-solid fa-circle-dot"></i>
                            {{
                                ucfirst(
                                    $pendaftaran->status,
                                )
                            }}
                        </span>
                    @endif
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <div>
                            <strong
                                >Terdapat kesalahan pada data yang
                                diisi:</strong
                            >
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                @if (session("success"))
                    <div class="alert alert-success">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>{{
                            session(
                                "success",
                            )
                        }}</span>
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
                                <span class="step-status"
                                    >Data calon peserta didik</span
                                >
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
                                <span class="step-status"
                                    >Wali murid &amp; kontak</span
                                >
                            </div>
                        </div>
                        <div class="step-line" id="sl-2"></div>
                        <div class="step-item" id="si-3">
                            <div class="step-circle">
                                <i class="fa-solid fa-check step-check"></i>
                                <span class="step-num-text">3</span>
                            </div>
                            <div class="step-info">
                                <span class="step-label"
                                    >Preview &amp; Kirim</span
                                >
                                <span class="step-status">Konfirmasi data</span>
                            </div>
                        </div>
                    </div>
                </div>

                <form
                    method="POST"
                    action="{{ route('formulir.submit') }}"
                    id="formPPDB"
                    novalidate
                >
                    @csrf

                    {{-- ===== PANEL 1: DATA SISWA ===== --}}
                    <div class="step-panel active" id="panel-1">
                        <div class="section-card">
                            <h2 class="section-title">Data Calon Siswa</h2>

                            <div class="info-box info-warning">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                                <div>
                                    Usia minimal pendaftaran:
                                    <strong>7 tahun</strong> tanpa ijazah TK,
                                    atau <strong>6 tahun 8 bulan</strong> dengan
                                    ijazah TK (dihitung per 1 Juli {{ date("Y") }}).
                                </div>
                            </div>

                            {{-- Nama Lengkap --}}
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="nama_siswa"
                                        >Nama Lengkap
                                        <span class="req">*</span></label
                                    >
                                    <input
                                        type="text"
                                        id="nama_siswa"
                                        name="nama_siswa"
                                        class="form-control @error('nama_siswa') is-error @enderror"
                                        value="{{ old('nama_siswa', $siswa->nama_siswa ?? '') }}"
                                        placeholder="Sesuai akta kelahiran, tanpa singkatan"
                                    />
                                    @error ("nama_siswa")
                                        <span
                                            class="err-msg show"
                                            >{{ $message }}</span
                                        >
                                    @enderror
                                    <span class="err-msg" id="err_nama_siswa"
                                        >Nama lengkap wajib diisi</span
                                    >
                                </div>
                            </div>

                            {{-- Tempat & Tanggal Lahir --}}
                            <div class="form-row form-col-2">
                                <div class="form-group">
                                    <label for="tempat_lahir"
                                        >Tempat Lahir
                                        <span class="req">*</span></label
                                    >
                                    <input
                                        type="text"
                                        id="tempat_lahir"
                                        name="tempat_lahir"
                                        class="form-control @error('tempat_lahir') is-error @enderror"
                                        value="{{ old('tempat_lahir', $siswa->tempat_lahir ?? '') }}"
                                        placeholder="Kota / Kabupaten"
                                    />
                                    @error ("tempat_lahir")
                                        <span
                                            class="err-msg show"
                                            >{{ $message }}</span
                                        >
                                    @enderror
                                    <span class="err-msg" id="err_tempat_lahir"
                                        >Tempat lahir wajib diisi</span
                                    >
                                </div>

                                <div class="form-group">
                                    <label for="tgl_lahir">
                                        Tanggal Lahir <span class="req">*</span>
                                        <span class="label-hint"
                                            >- usia terisi otomatis</span
                                        >
                                    </label>
                                    <div class="tgl-usia-row">
                                        <input
                                            type="date"
                                            id="tgl_lahir"
                                            name="tgl_lahir"
                                            class="form-control @error('tgl_lahir') is-error @enderror"
                                            value="{{ old('tgl_lahir', isset($siswa->tanggal_lahir) ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('Y-m-d') : '') }}"
                                            max="{{ date('Y-m-d') }}"
                                        />
                                        <div
                                            class="usia-field-wrapper"
                                            id="usia-wrapper"
                                            style="display: none"
                                        >
                                            <input
                                                type="text"
                                                id="usia-display"
                                                class="form-control-usia"
                                                readonly
                                                tabindex="-1"
                                                aria-label="Usia siswa"
                                            />
                                            <span class="usia-satuan">thn</span>
                                            <span
                                                class="usia-inline-box"
                                                id="usia-inline"
                                            ></span>
                                        </div>
                                    </div>
                                    @error ("tgl_lahir")
                                        <span
                                            class="err-msg show"
                                            >{{ $message }}</span
                                        >
                                    @enderror
                                    <span class="err-msg" id="err_tgl_lahir">
                                        Usia tidak memenuhi syarat (7-8 tahun
                                        per 1 Juli, atau min. 6 thn 8 bln dengan
                                        ijazah TK)
                                    </span>
                                </div>
                            </div>

                            {{-- Jenis Kelamin & Agama --}}
                            <div class="form-row form-col-2">
                                <div class="form-group">
                                    <label
                                        >Jenis Kelamin
                                        <span class="req">*</span></label
                                    >
                                    <div
                                        class="radio-group"
                                        id="rg_jenis_kelamin"
                                    >
                                        <div
                                            class="radio-btn {{ old('jenis_kelamin', $siswa->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}"
                                            onclick="
                                                piliRadio(
                                                    this,
                                                    'jenis_kelamin',
                                                    'L',
                                                )
                                            "
                                        >
                                            <input
                                                type="radio"
                                                name="jenis_kelamin"
                                                value="L"
                                                {{
                                                    old(
                                                        "jenis_kelamin",
                                                        $siswa->jenis_kelamin ?? "",
                                                    ) == "L"
                                                        ? "checked"
                                                        : ""
                                                }}
                                            />
                                            <span class="radio-dot"></span>
                                            <i class="fa-solid fa-mars"></i>
                                            Laki-laki
                                        </div>
                                        <div
                                            class="radio-btn {{ old('jenis_kelamin', $siswa->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}"
                                            onclick="
                                                piliRadio(
                                                    this,
                                                    'jenis_kelamin',
                                                    'P',
                                                )
                                            "
                                        >
                                            <input
                                                type="radio"
                                                name="jenis_kelamin"
                                                value="P"
                                                {{
                                                    old(
                                                        "jenis_kelamin",
                                                        $siswa->jenis_kelamin ?? "",
                                                    ) == "P"
                                                        ? "checked"
                                                        : ""
                                                }}
                                            />
                                            <span class="radio-dot"></span>
                                            <i class="fa-solid fa-venus"></i>
                                            Perempuan
                                        </div>
                                    </div>
                                    <span class="err-msg" id="err_jenis_kelamin"
                                        >Jenis kelamin wajib dipilih</span
                                    >
                                </div>

                                <div class="form-group">
                                    <label for="agama"
                                        >Agama <span class="req">*</span></label
                                    >
                                    <select
                                        id="agama"
                                        name="agama"
                                        class="form-control @error('agama') is-error @enderror"
                                    >
                                        <option value="">
                                            -- Pilih Agama --
                                        </option>
                                        @foreach ([
                                                "Islam",
                                                "Kristen Protestan",
                                                "Kristen Katolik",
                                                "Hindu",
                                                "Buddha",
                                                "Konghucu"
                                            ]
                                            as $agm)
                                            <option
                                                value="{{ $agm }}"
                                                {{
                                                    old("agama", $siswa->agama ?? "") == $agm
                                                        ? "selected"
                                                        : ""
                                                }}
                                                >{{ $agm }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error ("agama")
                                        <span
                                            class="err-msg show"
                                            >{{ $message }}</span
                                        >
                                    @enderror
                                    <span class="err-msg" id="err_agama"
                                        >Agama wajib dipilih</span
                                    >
                                </div>
                            </div>

                            {{-- NIK --}}
                            <div class="form-row form-col-2">
                                <div class="form-group">
                                    <label for="nik_siswa"
                                        >NIK Siswa
                                        <span class="label-hint"
                                            >(16 digit, sesuai KK)</span
                                        ></label
                                    >
                                    <input
                                        type="text"
                                        id="nik_siswa"
                                        name="nik_siswa"
                                        class="form-control"
                                        value="{{ old('nik_siswa', $siswa->nik_siswa ?? '') }}"
                                        placeholder="3XXXXXXXXXXXXXXX"
                                        maxlength="16"
                                        inputmode="numeric"
                                    />
                                </div>
                                <div class="form-group"></div>
                            </div>

                            {{-- Alamat --}}
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="alamat"
                                        >Alamat Lengkap
                                        <span class="req">*</span></label
                                    >
                                    <textarea
                                        id="alamat"
                                        name="alamat"
                                        rows="2"
                                        class="form-control @error('alamat') is-error @enderror"
                                        placeholder="Nama jalan, nomor rumah, RT/RW"
                                        >{{
                                            old(
                                                "alamat",
                                                $siswa->alamat ?? "",
                                            )
                                        }}</textarea
                                    >
                                    <button
                                        type="button"
                                        class="btn-gmaps"
                                        id="btnMaps"
                                        onclick="ambilDariMaps(this)"
                                    >
                                        <i class="fa-solid fa-location-dot"></i>
                                        Buka Google Maps
                                    </button>
                                    @error ("alamat")
                                        <span
                                            class="err-msg show"
                                            >{{ $message }}</span
                                        >
                                    @enderror
                                    <span class="err-msg" id="err_alamat"
                                        >Alamat lengkap wajib diisi</span
                                    >
                                </div>
                            </div>

                            {{-- Kelurahan, Kecamatan, Kode Pos --}}
                            <div class="form-row form-col-3">
                                <div class="form-group">
                                    <label for="kelurahan_sel"
                                        >Kelurahan / Desa</label
                                    >
                                    <select
                                        id="kelurahan_sel"
                                        class="form-control"
                                        onchange="handleKelurahan(this)"
                                    >
                                        <option value="">
                                            -- Pilih Kelurahan --
                                        </option>
                                        @php
                                            $kelurahanList = [
                                                "Babakan",
                                                "Babat",
                                                "Bojongkamal",
                                                "Caringin",
                                                "Ciangir",
                                                "Cirarab",
                                                "Kemuning",
                                                "Legok",
                                                "Palasari",
                                                "Rancagong",
                                                "Serdang Wetan",
                                            ];
                                            $savedKel = old("kelurahan", $siswa->kelurahan ?? "");
                                        @endphp
                                        @foreach ($kelurahanList as $kel)
                                            <option
                                                value="{{ $kel }}"
                                                {{
                                                    $savedKel === $kel
                                                        ? "selected"
                                                        : ""
                                                }}
                                                >{{ $kel }}
                                            </option>
                                        @endforeach
                                        <option
                                            value="__lainnya__"
                                            {{
                                                $savedKel &&
                                                !in_array($savedKel, $kelurahanList)
                                                    ? "selected"
                                                    : ""
                                            }}
                                            >-- Lainnya (isi manual) --
                                        </option>
                                    </select>
                                    <input
                                        type="hidden"
                                        id="kelurahan"
                                        name="kelurahan"
                                        value="{{ old('kelurahan', $siswa->kelurahan ?? '') }}"
                                    />
                                    <input
                                        type="text"
                                        id="kelurahan_custom"
                                        class="form-control kelurahan-custom-input"
                                        placeholder="Ketik nama kelurahan/desa"
                                        autocomplete="off"
                                        value="{{ ($savedKel && !in_array($savedKel, $kelurahanList)) ? $savedKel : '' }}"
                                    />
                                </div>

                                <div class="form-group">
                                    <label for="kecamatan_sel">Kecamatan</label>
                                    <select
                                        id="kecamatan_sel"
                                        class="form-control"
                                        onchange="handleKecamatan(this)"
                                    >
                                        <option value="">
                                            -- Pilih Kecamatan --
                                        </option>
                                        @php
                                            $kecamatanList = ["Legok"];
                                            $savedKec = old("kecamatan", $siswa->kecamatan ?? "");
                                        @endphp
                                        @foreach ($kecamatanList as $kec)
                                            <option
                                                value="{{ $kec }}"
                                                {{
                                                    $savedKec === $kec
                                                        ? "selected"
                                                        : ""
                                                }}
                                                >{{ $kec }}
                                            </option>
                                        @endforeach
                                        <option
                                            value="__lainnya__"
                                            {{
                                                $savedKec &&
                                                !in_array($savedKec, $kecamatanList)
                                                    ? "selected"
                                                    : ""
                                            }}
                                            >-- Lainnya (isi manual) --
                                        </option>
                                    </select>
                                    <input
                                        type="hidden"
                                        id="kecamatan"
                                        name="kecamatan"
                                        value="{{ old('kecamatan', $siswa->kecamatan ?? '') }}"
                                    />
                                    <input
                                        type="text"
                                        id="kecamatan_custom"
                                        class="form-control kecamatan-custom-input"
                                        placeholder="Ketik nama kecamatan"
                                        autocomplete="off"
                                        value="{{ ($savedKec && !in_array($savedKec, $kecamatanList)) ? $savedKec : '' }}"
                                    />
                                </div>

                                <div class="form-group">
                                    <label for="kode_pos">Kode Pos</label>
                                    <input
                                        type="text"
                                        id="kode_pos"
                                        name="kode_pos"
                                        class="form-control"
                                        value="{{ old('kode_pos', $siswa->kode_pos ?? '') }}"
                                        placeholder="XXXXX"
                                        maxlength="5"
                                        inputmode="numeric"
                                    />
                                </div>
                            </div>

                            {{-- Anak ke & Jumlah Saudara --}}
                            <div class="form-row form-col-2">
                                <div class="form-group">
                                    <label for="anak_ke">Anak Ke-</label>
                                    <input
                                        type="number"
                                        id="anak_ke"
                                        name="anak_ke"
                                        class="form-control"
                                        value="{{ old('anak_ke', $siswa->anak_ke ?? '') }}"
                                        min="1"
                                        max="20"
                                        placeholder="1"
                                    />
                                </div>
                                <div class="form-group">
                                    <label for="jml_saudara"
                                        >Jumlah Saudara Kandung</label
                                    >
                                    <input
                                        type="number"
                                        id="jml_saudara"
                                        name="jml_saudara"
                                        class="form-control"
                                        value="{{ old('jml_saudara', $siswa->jml_saudara ?? '') }}"
                                        min="0"
                                        max="20"
                                        placeholder="0"
                                    />
                                </div>
                            </div>

                            <div class="form-divider"></div>

                            <h2 class="section-title">
                                <i class="fa-solid fa-graduation-cap"></i>
                                Riwayat Pendidikan Sebelumnya
                            </h2>

                            <div class="form-row form-col-2">
                                <div class="form-group">
                                    <label
                                        >Lulusan TK / PAUD
                                        <span class="req">*</span></label
                                    >
                                    <div class="radio-group" id="rg_lulusan_tk">
                                        <div
                                            class="radio-btn {{ old('lulusan_tk', $siswa->lulusan_tk ?? '') == 'ya' ? 'selected' : '' }}"
                                            onclick="
                                                piliRadio(
                                                    this,
                                                    'lulusan_tk',
                                                    'ya',
                                                )
                                            "
                                        >
                                            <input
                                                type="radio"
                                                name="lulusan_tk"
                                                value="ya"
                                                {{
                                                    old(
                                                        "lulusan_tk",
                                                        $siswa->lulusan_tk ?? "",
                                                    ) == "ya"
                                                        ? "checked"
                                                        : ""
                                                }}
                                            />
                                            <span class="radio-dot"></span>
                                            Ya
                                        </div>
                                        <div
                                            class="radio-btn {{ old('lulusan_tk', $siswa->lulusan_tk ?? '') == 'tidak' ? 'selected' : '' }}"
                                            onclick="
                                                piliRadio(
                                                    this,
                                                    'lulusan_tk',
                                                    'tidak',
                                                )
                                            "
                                        >
                                            <input
                                                type="radio"
                                                name="lulusan_tk"
                                                value="tidak"
                                                {{
                                                    old(
                                                        "lulusan_tk",
                                                        $siswa->lulusan_tk ?? "",
                                                    ) == "tidak"
                                                        ? "checked"
                                                        : ""
                                                }}
                                            />
                                            <span class="radio-dot"></span>
                                            Tidak
                                        </div>
                                    </div>
                                    <span class="err-msg" id="err_lulusan_tk"
                                        >Pilih salah satu</span
                                    >
                                </div>
                                <div class="form-group" id="group_nama_tk">
                                    <label for="nama_tk">Nama TK / PAUD</label>
                                    <input
                                        type="text"
                                        id="nama_tk"
                                        name="nama_tk"
                                        class="form-control"
                                        value="{{ old('nama_tk', $siswa->nama_tk ?? '') }}"
                                        placeholder="Nama sekolah TK/PAUD asal"
                                    />
                                </div>
                            </div>

                            <div class="form-actions">
                                <div></div>
                                <button
                                    type="button"
                                    class="btn btn-primary"
                                    onclick="nextStep(1)"
                                >
                                    Lanjut: Data Orang Tua
                                    <i class="fa-solid fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    {{-- END PANEL 1 --}}

                    {{-- ===== PANEL 2: DATA ORANG TUA ===== --}}
                    <div class="step-panel" id="panel-2">
                        <div class="section-card">
                            <h2 class="section-title">
                                <i class="fa-solid fa-person"></i>
                                Data Ayah
                            </h2>

                            <div class="form-row form-col-2">
                                <div class="form-group">
                                    <label for="nama_ayah"
                                        >Nama Ayah
                                        <span class="req">*</span></label
                                    >
                                    <input
                                        type="text"
                                        id="nama_ayah"
                                        name="nama_ayah"
                                        class="form-control @error('nama_ayah') is-error @enderror"
                                        value="{{ old('nama_ayah', $orangtua->nama_ayah ?? '') }}"
                                        placeholder="Nama lengkap ayah kandung"
                                    />
                                    @error ("nama_ayah")
                                        <span
                                            class="err-msg show"
                                            >{{ $message }}</span
                                        >
                                    @enderror
                                    <span class="err-msg" id="err_nama_ayah"
                                        >Nama ayah wajib diisi</span
                                    >
                                </div>
                                <div class="form-group">
                                    <label for="nik_ayah"
                                        >NIK Ayah
                                        <span class="label-hint"
                                            >(sesuai KTP)</span
                                        ></label
                                    >
                                    <input
                                        type="text"
                                        id="nik_ayah"
                                        name="nik_ayah"
                                        class="form-control"
                                        value="{{ old('nik_ayah', $orangtua->nik_ayah ?? '') }}"
                                        placeholder="16 digit NIK"
                                        maxlength="16"
                                        inputmode="numeric"
                                    />
                                </div>
                            </div>

                            <div class="form-row form-col-2">
                                <div class="form-group">
                                    <label for="pekerjaan_ayah"
                                        >Pekerjaan Ayah
                                        <span class="req">*</span></label
                                    >
                                    <select
                                        id="pekerjaan_ayah"
                                        name="pekerjaan_ayah"
                                        class="form-control @error('pekerjaan_ayah') is-error @enderror"
                                    >
                                        <option value="">
                                            -- Pilih Pekerjaan --
                                        </option>
                                        @foreach ([
                                                "PNS / ASN",
                                                "TNI / Polri",
                                                "Karyawan Swasta",
                                                "Wiraswasta / Pedagang",
                                                "Petani / Nelayan",
                                                "Buruh",
                                                "Tidak Bekerja",
                                                "Lainnya"
                                            ]
                                            as $pkj)
                                            <option
                                                value="{{ $pkj }}"
                                                {{
                                                    old(
                                                        "pekerjaan_ayah",
                                                        $orangtua->pekerjaan_ayah ?? "",
                                                    ) == $pkj
                                                        ? "selected"
                                                        : ""
                                                }}
                                                >{{ $pkj }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error ("pekerjaan_ayah")
                                        <span
                                            class="err-msg show"
                                            >{{ $message }}</span
                                        >
                                    @enderror
                                    <span
                                        class="err-msg"
                                        id="err_pekerjaan_ayah"
                                        >Pekerjaan ayah wajib dipilih</span
                                    >
                                </div>
                                <div class="form-group">
                                    <label for="pendidikan_ayah"
                                        >Pendidikan Terakhir Ayah</label
                                    >
                                    <select
                                        id="pendidikan_ayah"
                                        name="pendidikan_ayah"
                                        class="form-control"
                                    >
                                        <option value="">-- Pilih --</option>
                                        @foreach ([
                                                "SD / Sederajat",
                                                "SMP / Sederajat",
                                                "SMA / Sederajat",
                                                "D1 / D2 / D3",
                                                "S1 / D4",
                                                "S2",
                                                "S3",
                                                "Tidak Sekolah"
                                            ]
                                            as $pdd)
                                            <option
                                                value="{{ $pdd }}"
                                                {{
                                                    old(
                                                        "pendidikan_ayah",
                                                        $orangtua->pendidikan_ayah ?? "",
                                                    ) == $pdd
                                                        ? "selected"
                                                        : ""
                                                }}
                                                >{{ $pdd }}
                                            </option>
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
                                    <label for="nama_ibu"
                                        >Nama Ibu
                                        <span class="req">*</span></label
                                    >
                                    <input
                                        type="text"
                                        id="nama_ibu"
                                        name="nama_ibu"
                                        class="form-control @error('nama_ibu') is-error @enderror"
                                        value="{{ old('nama_ibu', $orangtua->nama_ibu ?? '') }}"
                                        placeholder="Nama lengkap ibu kandung"
                                    />
                                    @error ("nama_ibu")
                                        <span
                                            class="err-msg show"
                                            >{{ $message }}</span
                                        >
                                    @enderror
                                    <span class="err-msg" id="err_nama_ibu"
                                        >Nama ibu wajib diisi</span
                                    >
                                </div>
                                <div class="form-group">
                                    <label for="nik_ibu"
                                        >NIK Ibu
                                        <span class="label-hint"
                                            >(sesuai KTP)</span
                                        ></label
                                    >
                                    <input
                                        type="text"
                                        id="nik_ibu"
                                        name="nik_ibu"
                                        class="form-control"
                                        value="{{ old('nik_ibu', $orangtua->nik_ibu ?? '') }}"
                                        placeholder="16 digit NIK"
                                        maxlength="16"
                                        inputmode="numeric"
                                    />
                                </div>
                            </div>

                            <div class="form-row form-col-2">
                                <div class="form-group">
                                    <label for="pekerjaan_ibu"
                                        >Pekerjaan Ibu
                                        <span class="req">*</span></label
                                    >
                                    <select
                                        id="pekerjaan_ibu"
                                        name="pekerjaan_ibu"
                                        class="form-control @error('pekerjaan_ibu') is-error @enderror"
                                    >
                                        <option value="">
                                            -- Pilih Pekerjaan --
                                        </option>
                                        @foreach ([
                                                "PNS / ASN",
                                                "TNI / Polri",
                                                "Karyawan Swasta",
                                                "Wiraswasta / Pedagang",
                                                "Ibu Rumah Tangga",
                                                "Buruh",
                                                "Tidak Bekerja",
                                                "Lainnya"
                                            ]
                                            as $pkj)
                                            <option
                                                value="{{ $pkj }}"
                                                {{
                                                    old(
                                                        "pekerjaan_ibu",
                                                        $orangtua->pekerjaan_ibu ?? "",
                                                    ) == $pkj
                                                        ? "selected"
                                                        : ""
                                                }}
                                                >{{ $pkj }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error ("pekerjaan_ibu")
                                        <span
                                            class="err-msg show"
                                            >{{ $message }}</span
                                        >
                                    @enderror
                                    <span class="err-msg" id="err_pekerjaan_ibu"
                                        >Pekerjaan ibu wajib dipilih</span
                                    >
                                </div>
                                <div class="form-group">
                                    <label for="pendidikan_ibu"
                                        >Pendidikan Terakhir Ibu</label
                                    >
                                    <select
                                        id="pendidikan_ibu"
                                        name="pendidikan_ibu"
                                        class="form-control"
                                    >
                                        <option value="">-- Pilih --</option>
                                        @foreach ([
                                                "SD / Sederajat",
                                                "SMP / Sederajat",
                                                "SMA / Sederajat",
                                                "D1 / D2 / D3",
                                                "S1 / D4",
                                                "S2",
                                                "S3",
                                                "Tidak Sekolah"
                                            ]
                                            as $pdd)
                                            <option
                                                value="{{ $pdd }}"
                                                {{
                                                    old(
                                                        "pendidikan_ibu",
                                                        $orangtua->pendidikan_ibu ?? "",
                                                    ) == $pdd
                                                        ? "selected"
                                                        : ""
                                                }}
                                                >{{ $pdd }}
                                            </option>
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
                                    <label for="no_hp"
                                        >No. HP / WhatsApp
                                        <span class="req">*</span></label
                                    >
                                    <div class="input-prefix-wrapper">
                                        <span class="input-prefix">+62</span>
                                        <input
                                            type="tel"
                                            id="no_hp"
                                            name="no_hp"
                                            class="form-control has-prefix @error('no_hp') is-error @enderror"
                                            value="{{ old('no_hp', $orangtua->no_hp ?? '') }}"
                                            placeholder="08xxxxxxxxxx"
                                            inputmode="numeric"
                                        />
                                    </div>
                                    @error ("no_hp")
                                        <span
                                            class="err-msg show"
                                            >{{ $message }}</span
                                        >
                                    @enderror
                                    <span class="err-msg" id="err_no_hp"
                                        >Nomor HP tidak valid (format:
                                        08xxxxxxxxxx)</span
                                    >
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        class="form-control"
                                        value="{{ old('email', $orangtua->email ?? '') }}"
                                        placeholder="contoh@email.com"
                                    />
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="alamat_ortu"
                                        >Alamat Orang Tua
                                        <span class="label-hint"
                                            >(kosongkan jika sama dengan alamat
                                            siswa)</span
                                        ></label
                                    >
                                    <textarea
                                        id="alamat_ortu"
                                        name="alamat_ortu"
                                        rows="2"
                                        class="form-control"
                                        placeholder="Isi jika berbeda dengan alamat calon siswa"
                                        >{{
                                            old(
                                                "alamat_ortu",
                                                $orangtua->alamat_ortu ?? "",
                                            )
                                        }}</textarea
                                    >
                                </div>
                            </div>

                            <div class="form-divider"></div>

                            <div
                                class="collapsible-header"
                                onclick="toggleSection('wali-section', this)"
                            >
                                <h2 class="section-title" style="margin: 0">
                                    <i class="fa-solid fa-person-shelter"></i>
                                    Data Wali
                                    <span class="label-hint">(opsional)</span>
                                </h2>
                                <i
                                    class="fa-solid fa-chevron-down collapsible-icon"
                                ></i>
                            </div>

                            <div class="collapsible-content" id="wali-section">
                                <div
                                    class="form-row form-col-2"
                                    style="margin-top: 16px"
                                >
                                    <div class="form-group">
                                        <label for="nama_wali">Nama Wali</label>
                                        <input
                                            type="text"
                                            id="nama_wali"
                                            name="nama_wali"
                                            class="form-control"
                                            value="{{ old('nama_wali', $orangtua->nama_wali ?? '') }}"
                                            placeholder="Jika diasuh selain orang tua kandung"
                                        />
                                    </div>
                                    <div class="form-group">
                                        <label for="hub_wali"
                                            >Hubungan dengan Siswa</label
                                        >
                                        <select
                                            id="hub_wali"
                                            name="hub_wali"
                                            class="form-control"
                                        >
                                            <option value="">
                                                -- Pilih --
                                            </option>
                                            @foreach (["Kakek / Nenek", "Paman / Bibi", "Kakak Kandung", "Lainnya"] as $hw)
                                                <option
                                                    value="{{ $hw }}"
                                                    {{
                                                        old(
                                                            "hub_wali",
                                                            $orangtua->hub_wali ?? "",
                                                        ) == $hw
                                                            ? "selected"
                                                            : ""
                                                    }}
                                                    >{{ $hw }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row form-col-2">
                                    <div class="form-group">
                                        <label for="nik_wali">NIK Wali</label>
                                        <input
                                            type="text"
                                            id="nik_wali"
                                            name="nik_wali"
                                            class="form-control"
                                            value="{{ old('nik_wali', $orangtua->nik_wali ?? '') }}"
                                            placeholder="16 digit NIK"
                                            maxlength="16"
                                            inputmode="numeric"
                                        />
                                    </div>
                                    <div class="form-group">
                                        <label for="no_hp_wali"
                                            >No. HP Wali</label
                                        >
                                        <input
                                            type="tel"
                                            id="no_hp_wali"
                                            name="no_hp_wali"
                                            class="form-control"
                                            value="{{ old('no_hp_wali', $orangtua->no_hp_wali ?? '') }}"
                                            placeholder="08xxxxxxxxxx"
                                            inputmode="numeric"
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button
                                    type="button"
                                    class="btn btn-outline"
                                    onclick="prevStep(2)"
                                >
                                    <i class="fa-solid fa-arrow-left"></i>
                                    Kembali
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-primary"
                                    onclick="nextStep(2)"
                                >
                                    Lanjut: Preview
                                    <i class="fa-solid fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    {{-- END PANEL 2 --}}

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
                                    Setelah submit, Anda akan mendapatkan
                                    <strong>nomor pendaftaran</strong>
                                    dan dapat melanjutkan ke tahap upload
                                    dokumen.
                                </div>
                            </div>

                            <div class="preview-section">
                                <div class="preview-section-title">
                                    Data Calon Siswa
                                    <button
                                        type="button"
                                        class="btn-edit-step"
                                        onclick="goToStep(1)"
                                    >
                                        <i class="fa-solid fa-pen"></i> Edit
                                    </button>
                                </div>
                                <div
                                    class="preview-grid"
                                    id="preview-siswa"
                                ></div>
                            </div>

                            <div class="form-divider"></div>

                            <div class="preview-section">
                                <div class="preview-section-title">
                                    <i class="fa-solid fa-users"></i>
                                    Data Orang Tua / Wali
                                    <button
                                        type="button"
                                        class="btn-edit-step"
                                        onclick="goToStep(2)"
                                    >
                                        <i class="fa-solid fa-pen"></i> Edit
                                    </button>
                                </div>
                                <div
                                    class="preview-grid"
                                    id="preview-ortu"
                                ></div>
                            </div>

                            <div class="form-divider"></div>

                            <div class="form-group">
                                <label class="checkbox-label">
                                    <input
                                        type="checkbox"
                                        id="setuju"
                                        name="setuju"
                                        value="1"
                                    />
                                    <span class="checkbox-box"></span>
                                    <span>
                                        Saya menyatakan bahwa data yang saya isi
                                        adalah
                                        <strong
                                            >benar dan dapat
                                            dipertanggungjawabkan</strong
                                        >. Apabila dikemudian hari terbukti
                                        tidak benar, saya bersedia menerima
                                        konsekuensi yang berlaku.
                                    </span>
                                </label>
                                <span class="err-msg" id="err_setuju"
                                    >Anda harus menyetujui pernyataan di
                                    atas</span
                                >
                            </div>

                            <div class="form-actions">
                                <button
                                    type="button"
                                    class="btn btn-outline"
                                    onclick="prevStep(3)"
                                >
                                    <i class="fa-solid fa-arrow-left"></i>
                                    Kembali Edit
                                </button>
                                <button
                                    type="submit"
                                    class="btn btn-success"
                                    onclick="return checkSetuju();"
                                >
                                    <i class="fa-solid fa-paper-plane"></i>
                                    {{
                                        isset($pendaftaran) && $pendaftaran
                                            ? "Simpan Perubahan"
                                            : "Submit Pendaftaran"
                                    }}
                                </button>
                            </div>
                        </div>
                    </div>
                    {{-- END PANEL 3 --}}
                </form>
            </div>
        </main>
    </div>

@endsection

@push ("scripts")
    <script>
        var tahunAjaran = {{ date("Y") }};
    </script>
    <script src="{{ asset('js/formulir.js') }}"></script>
@endpush
