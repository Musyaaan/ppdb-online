var refDate = new Date(tahunAjaran + "-07-01");

// ================================================================
// RADIO BUTTON
// ================================================================
function piliRadio(div, name, value) {
    var group = div.closest(".radio-group");
    group.querySelectorAll(".radio-btn").forEach(function (b) {
        b.classList.remove("selected");
        var r = b.querySelector('input[type="radio"]');
        if (r) r.checked = false;
    });
    div.classList.add("selected");
    var radio = div.querySelector('input[type="radio"]');
    if (radio) radio.checked = true;

    if (name === "lulusan_tk") {
        document.getElementById("group_nama_tk").style.display =
            value === "ya" ? "" : "none";
        var tglVal = document.getElementById("tgl_lahir").value;
        if (tglVal) hitungUsia(tglVal);
        setError("lulusan_tk", false);
    }
    if (name === "jenis_kelamin") {
        setError("jenis_kelamin", false);
    }
}

// ================================================================
// DOMContentLoaded
// ================================================================
document.addEventListener("DOMContentLoaded", function () {
    // ---- Tanggal lahir → usia otomatis ----
    var tglInput = document.getElementById("tgl_lahir");
    function onTglChange() {
        if (tglInput.value) hitungUsia(tglInput.value);
        else document.getElementById("usia-wrapper").style.display = "none";
    }
    tglInput.addEventListener("change", onTglChange);
    tglInput.addEventListener("input", onTglChange);
    if (tglInput.value) hitungUsia(tglInput.value);

    // ---- Kelurahan custom input ----
    var kelSel = document.getElementById("kelurahan_sel");
    var kelCustom = document.getElementById("kelurahan_custom");
    var kelHidden = document.getElementById("kelurahan");
    kelCustom.style.display = kelSel.value === "__lainnya__" ? "" : "none";
    if (kelSel.value === "__lainnya__") kelCustom.style.marginTop = "8px";
    kelCustom.addEventListener("input", function () {
        kelHidden.value = this.value;
    });
    kelCustom.addEventListener("change", function () {
        kelHidden.value = this.value;
    });

    // ---- Kecamatan custom input ----
    var kecSel = document.getElementById("kecamatan_sel");
    var kecCustom = document.getElementById("kecamatan_custom");
    var kecHidden = document.getElementById("kecamatan");
    kecCustom.style.display = kecSel.value === "__lainnya__" ? "" : "none";
    if (kecSel.value === "__lainnya__") kecCustom.style.marginTop = "8px";
    kecCustom.addEventListener("input", function () {
        kecHidden.value = this.value;
    });
    kecCustom.addEventListener("change", function () {
        kecHidden.value = this.value;
    });

    if (kelSel.value && kelSel.value !== "" && kelSel.value !== "__lainnya__") {
        if (!document.getElementById("kode_pos").value)
            document.getElementById("kode_pos").value = "15820";
        if (!kecHidden.value) {
            kecSel.value = "Legok";
            kecHidden.value = "Legok";
        }
    }

    // ---- Digits only ----
    ["nik_siswa", "nik_ayah", "nik_ibu", "nik_wali", "kode_pos"].forEach(
        function (id) {
            var el = document.getElementById(id);
            if (el)
                el.addEventListener("input", function () {
                    this.value = this.value.replace(/\D/g, "");
                });
        },
    );

    // ---- Sidebar toggle ----
    var toggle = document.getElementById("sidebarToggle");
    if (toggle)
        toggle.addEventListener("click", function () {
            document.getElementById("sidebar").classList.toggle("sidebar-open");
        });

    // ---- Auto-dismiss alerts ----
    setTimeout(function () {
        document.querySelectorAll(".alert").forEach(function (el) {
            el.style.transition = "opacity .4s";
            el.style.opacity = "0";
            setTimeout(function () {
                if (el.parentNode) el.remove();
            }, 400);
        });
    }, 5000);

    // ---- Init TK visibility ----
    var tkChecked = document.querySelector('input[name="lulusan_tk"]:checked');
    document.getElementById("group_nama_tk").style.display =
        tkChecked && tkChecked.value === "ya" ? "" : "none";

    // ---- Checkbox setuju ----
    var setujuCb = document.getElementById("setuju");
    if (setujuCb)
        setujuCb.addEventListener("change", function () {
            setError("setuju", false);
        });
});

// ================================================================
// HITUNG USIA OTOMATIS
// ================================================================
function hitungUsia(tglStr) {
    var tgl = new Date(tglStr);
    var years = refDate.getFullYear() - tgl.getFullYear();
    var months = refDate.getMonth() - tgl.getMonth();
    if (refDate.getDate() < tgl.getDate()) months--;
    if (months < 0) {
        years--;
        months += 12;
    }
    var totalBulan = years * 12 + months;

    var wrapper = document.getElementById("usia-wrapper");
    var display = document.getElementById("usia-display");
    var badge = document.getElementById("usia-inline");

    wrapper.style.display = "flex";
    display.value = years;

    var tkCk = document.querySelector('input[name="lulusan_tk"]:checked');
    var hasTK = tkCk && tkCk.value === "ya";
    badge.className = "usia-inline-box";

    if (totalBulan >= 96) {
        badge.classList.add("usia-err");
        badge.innerHTML =
            '<i class="fa-solid fa-circle-xmark"></i> ' +
            years +
            " thn " +
            months +
            " bln -  Terlalu tua, tidak memenuhi syarat";
    } else if (totalBulan >= 84) {
        badge.classList.add("usia-ok");
        badge.innerHTML =
            '<i class="fa-solid fa-circle-check"></i> ' +
            years +
            " thn " +
            months +
            " bln -  Memenuhi syarat";
    } else if (totalBulan >= 80 && hasTK) {
        badge.classList.add("usia-warn");
        badge.innerHTML =
            '<i class="fa-solid fa-triangle-exclamation"></i> ' +
            years +
            " thn " +
            months +
            " bln -  Pertimbangan (wajib lampir ijazah TK)";
    } else if (totalBulan >= 80) {
        badge.classList.add("usia-warn");
        badge.innerHTML =
            '<i class="fa-solid fa-triangle-exclamation"></i> ' +
            years +
            " thn " +
            months +
            ' bln -  Pilih "Ya" jika punya ijazah TK';
    } else {
        badge.classList.add("usia-err");
        badge.innerHTML =
            '<i class="fa-solid fa-circle-xmark"></i> ' +
            years +
            " thn " +
            months +
            " bln -  Terlalu muda, tidak memenuhi syarat";
    }
}

// ================================================================
// KELURAHAN & KECAMATAN
// ================================================================
function handleKelurahan(sel) {
    var custom = document.getElementById("kelurahan_custom");
    var hidden = document.getElementById("kelurahan");
    if (sel.value === "__lainnya__") {
        custom.style.display = "";
        custom.style.marginTop = "8px";
        hidden.value = "";
        custom.value = "";
        setTimeout(function () {
            custom.focus();
        }, 50);
    } else {
        custom.style.display = "none";
        hidden.value = sel.value;
        custom.value = "";
        if (sel.value !== "") {
            document.getElementById("kecamatan_sel").value = "Legok";
            document.getElementById("kecamatan").value = "Legok";
            document.getElementById("kecamatan_custom").style.display = "none";
            document.getElementById("kode_pos").value = "15820";
        }
    }
}

function handleKecamatan(sel) {
    var custom = document.getElementById("kecamatan_custom");
    var hidden = document.getElementById("kecamatan");
    if (sel.value === "__lainnya__") {
        custom.style.display = "";
        custom.style.marginTop = "8px";
        hidden.value = "";
        custom.value = "";
        setTimeout(function () {
            custom.focus();
        }, 50);
    } else {
        custom.style.display = "none";
        hidden.value = sel.value;
        custom.value = "";
    }
}

// ================================================================
// MAPS
// ================================================================
function ambilDariMaps(btn) {
    if (!navigator.geolocation) {
        window.open("https://maps.google.com", "_blank");
        return;
    }
    var originalHTML = btn.innerHTML;
    btn.innerHTML =
        '<i class="fa-solid fa-spinner fa-spin"></i> Membuka Maps...';
    btn.disabled = true;

    navigator.geolocation.getCurrentPosition(
        function (pos) {
            var url =
                "https://maps.google.com/?q=" +
                pos.coords.latitude +
                "," +
                pos.coords.longitude;
            window.open(url, "_blank");
            btn.innerHTML =
                '<i class="fa-solid fa-circle-check"></i> Maps dibuka — copy alamat lalu paste di sini';
            btn.style.cssText =
                "background:#d4edda;color:#0e6655;border-color:#a3cfbb;";
            setTimeout(function () {
                btn.innerHTML = originalHTML;
                btn.style.cssText = "";
                btn.disabled = false;
            }, 4000);
        },
        function () {
            window.open("https://maps.google.com", "_blank");
            btn.innerHTML = originalHTML;
            btn.disabled = false;
        },
        { timeout: 8000 },
    );
}

// ================================================================
// STEP NAVIGATION
// ================================================================
function nextStep(from) {
    if (from === 1 && !validateStep1()) return;
    if (from === 2 && !validateStep2()) return;
    if (from === 2) buildPreview();
    document.getElementById("panel-" + from).classList.remove("active");
    document.getElementById("panel-" + (from + 1)).classList.add("active");
    updateStepBar(from + 1);
    window.scrollTo({ top: 0, behavior: "smooth" });
}

function prevStep(from) {
    document.getElementById("panel-" + from).classList.remove("active");
    document.getElementById("panel-" + (from - 1)).classList.add("active");
    updateStepBar(from - 1);
    window.scrollTo({ top: 0, behavior: "smooth" });
}

function goToStep(target) {
    document.getElementById("panel-3").classList.remove("active");
    document.getElementById("panel-" + target).classList.add("active");
    updateStepBar(target);
    window.scrollTo({ top: 0, behavior: "smooth" });
}

function updateStepBar(current) {
    [1, 2, 3].forEach(function (i) {
        var si = document.getElementById("si-" + i);
        si.classList.remove("active", "done");
        if (i < current) si.classList.add("done");
        if (i === current) si.classList.add("active");
    });
    [1, 2].forEach(function (i) {
        document
            .getElementById("sl-" + i)
            .classList.toggle("done", i < current);
    });
}

// ================================================================
// VALIDASI
// ================================================================
function setError(id, isError) {
    var errEl = document.getElementById("err_" + id);
    var inpEl = document.getElementById(id);
    if (errEl) errEl.classList.toggle("show", isError);
    if (inpEl) inpEl.classList.toggle("is-error", isError);
    return !isError;
}

function validateStep1() {
    var ok = true;
    if (!document.getElementById("nama_siswa").value.trim()) {
        setError("nama_siswa", true);
        ok = false;
    } else {
        setError("nama_siswa", false);
    }
    if (!document.getElementById("tempat_lahir").value.trim()) {
        setError("tempat_lahir", true);
        ok = false;
    } else {
        setError("tempat_lahir", false);
    }
    if (!document.getElementById("agama").value) {
        setError("agama", true);
        ok = false;
    } else {
        setError("agama", false);
    }
    if (!document.getElementById("alamat").value.trim()) {
        setError("alamat", true);
        ok = false;
    } else {
        setError("alamat", false);
    }

    var jkChecked = document.querySelector(
        'input[name="jenis_kelamin"]:checked',
    );
    if (!jkChecked) {
        setError("jenis_kelamin", true);
        ok = false;
    } else {
        setError("jenis_kelamin", false);
    }

    var tglVal = document.getElementById("tgl_lahir").value;
    var tglOk = false;
    if (tglVal) {
        var tgl = new Date(tglVal);
        var years = refDate.getFullYear() - tgl.getFullYear();
        var months = refDate.getMonth() - tgl.getMonth();
        if (refDate.getDate() < tgl.getDate()) months--;
        if (months < 0) {
            years--;
            months += 12;
        }
        var total = years * 12 + months;
        var tkCk = document.querySelector('input[name="lulusan_tk"]:checked');
        var minOk = total >= (tkCk && tkCk.value === "ya" ? 80 : 84);
        var maxOk = total < 96;
        tglOk = minOk && maxOk;
    }
    if (!tglOk) {
        setError("tgl_lahir", true);
        ok = false;
    } else {
        setError("tgl_lahir", false);
    }

    if (!ok) {
        var first = document
            .getElementById("panel-1")
            .querySelector(".is-error, .err-msg.show");
        if (first)
            first.scrollIntoView({ behavior: "smooth", block: "center" });
    }
    return ok;
}

function validateStep2() {
    var ok = true;
    if (!document.getElementById("nama_ayah").value.trim()) {
        setError("nama_ayah", true);
        ok = false;
    } else {
        setError("nama_ayah", false);
    }
    if (!document.getElementById("nama_ibu").value.trim()) {
        setError("nama_ibu", true);
        ok = false;
    } else {
        setError("nama_ibu", false);
    }
    if (!document.getElementById("pekerjaan_ayah").value) {
        setError("pekerjaan_ayah", true);
        ok = false;
    } else {
        setError("pekerjaan_ayah", false);
    }
    if (!document.getElementById("pekerjaan_ibu").value) {
        setError("pekerjaan_ibu", true);
        ok = false;
    } else {
        setError("pekerjaan_ibu", false);
    }

    var hp = document.getElementById("no_hp").value.trim();
    if (!hp || !/^08[0-9]{7,12}$/.test(hp)) {
        setError("no_hp", true);
        ok = false;
    } else {
        setError("no_hp", false);
    }

    if (!ok) {
        var first = document
            .getElementById("panel-2")
            .querySelector(".is-error, .err-msg.show");
        if (first)
            first.scrollIntoView({ behavior: "smooth", block: "center" });
    }
    return ok;
}

function checkSetuju() {
    var ok = document.getElementById("setuju").checked;
    setError("setuju", !ok);
    return ok;
}

// ================================================================
// BUILD PREVIEW
// ================================================================
function getVal(id) {
    var el = document.getElementById(id);
    return el && el.value.trim()
        ? el.value.trim()
        : '<span style="color:var(--text-muted);font-style:italic">—</span>';
}

function previewItem(label, val) {
    return (
        '<div class="preview-item"><div class="preview-label">' +
        label +
        '</div><div class="preview-val">' +
        val +
        "</div></div>"
    );
}

function buildPreview() {
    var tglRaw = document.getElementById("tgl_lahir").value;
    var tglFmt = tglRaw
        ? new Date(tglRaw).toLocaleDateString("id-ID", {
              day: "2-digit",
              month: "long",
              year: "numeric",
          })
        : "—";

    var usiaVal = document.getElementById("usia-display").value;
    var usiaTeks = usiaVal ? usiaVal + " tahun" : "—";

    var jkCk = document.querySelector('input[name="jenis_kelamin"]:checked');
    var jkTeks = jkCk ? (jkCk.value === "L" ? "Laki-laki" : "Perempuan") : "—";

    var tkCk = document.querySelector('input[name="lulusan_tk"]:checked');
    var tkNama = document.getElementById("nama_tk").value.trim();
    var tkTeks = tkCk
        ? tkCk.value === "ya"
            ? "Ya" + (tkNama ? " — " + tkNama : "")
            : "Tidak"
        : "—";

    var kelVal = document.getElementById("kelurahan").value || "—";
    var kecVal = document.getElementById("kecamatan").value || "—";

    document.getElementById("preview-siswa").innerHTML =
        previewItem("Nama Lengkap", getVal("nama_siswa")) +
        previewItem("Tempat Lahir", getVal("tempat_lahir")) +
        previewItem("Tanggal Lahir", tglFmt) +
        previewItem("Usia", usiaTeks) +
        previewItem("Jenis Kelamin", jkTeks) +
        previewItem("Agama", getVal("agama")) +
        previewItem("Alamat", getVal("alamat")) +
        previewItem("Kelurahan", kelVal) +
        previewItem("Kecamatan", kecVal) +
        previewItem("Kode Pos", getVal("kode_pos")) +
        previewItem("Lulusan TK/PAUD", tkTeks);

    document.getElementById("preview-ortu").innerHTML =
        previewItem("Nama Ayah", getVal("nama_ayah")) +
        previewItem("Pekerjaan Ayah", getVal("pekerjaan_ayah")) +
        previewItem("Nama Ibu", getVal("nama_ibu")) +
        previewItem("Pekerjaan Ibu", getVal("pekerjaan_ibu")) +
        previewItem("No. HP / WA", getVal("no_hp")) +
        previewItem("Email", getVal("email"));
}

// ================================================================
// COLLAPSIBLE
// ================================================================
function toggleSection(id, header) {
    var section = document.getElementById(id);
    var icon = header.querySelector(".collapsible-icon");
    var isOpen =
        section.style.display !== "none" && section.style.display !== "";
    section.style.display = isOpen ? "none" : "";
    icon.style.transform = isOpen ? "rotate(0deg)" : "rotate(180deg)";
}
