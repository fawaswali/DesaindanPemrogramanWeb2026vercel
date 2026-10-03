// ===== Hamburger menu (JS-driven) =====
function initNavToggle() {
    const toggleBtn = document.getElementById("nav-toggle-btn");
    const nav = document.querySelector("header nav");
    if (!toggleBtn || !nav) return;

    toggleBtn.addEventListener("click", function () {
        nav.classList.toggle("nav-open");
    });
}

// ===== Konfirmasi hapus data =====
function initHapusConfirm() {
    document.addEventListener("submit", function (e) {
        const form = e.target;
        if (!form.classList.contains("form-hapus")) return;

        const row = form.closest("tr");
        const identitas = row ? (row.querySelector("td strong")?.textContent || row.querySelector("td")?.textContent) : "data ini";
        const yakin = confirm("Yakin ingin menghapus \"" + identitas.trim() + "\"?");
        if (!yakin) {
            e.preventDefault();
        }
    });
}

// ===== Filter/pencarian tabel real-time client-side =====
function initTableFilter() {
    const input = document.getElementById("search-input");
    const table = document.querySelector(".table-responsive table");
    if (!input || !table) return;

    input.addEventListener("keyup", function () {
        const keyword = input.value.toLowerCase();
        const rows = table.querySelectorAll("tbody tr");
        rows.forEach(function (row) {
            const teks = row.textContent.toLowerCase();
            row.style.display = teks.includes(keyword) ? "" : "none";
        });
    });
}

// ===== Helper pesan error client-side =====
function tampilkanError(input, pesan) {
    hapusError(input);
    const span = document.createElement("span");
    span.className = "error";
    span.textContent = pesan;
    input.insertAdjacentElement("afterend", span);
}

function hapusError(input) {
    const next = input.nextElementSibling;
    if (next && next.classList.contains("error")) {
        next.remove();
    }
}

// ===== Validasi Form Kamar & Penghuni Kost Papa =====
function initValidasiForm() {
    const form = document.getElementById("form-tambah");
    if (!form) return;

    form.addEventListener("submit", function (e) {
        let valid = true;

        // Validasi NIK (jika di form penghuni)
        const nik = form.querySelector("[name='nik']");
        if (nik) {
            if (nik.value.trim() === "") {
                tampilkanError(nik, "NIK wajib diisi.");
                valid = false;
            } else if (!/^\d+$/.test(nik.value.trim())) {
                tampilkanError(nik, "NIK harus berupa angka.");
                valid = false;
            } else {
                hapusError(nik);
            }
        }

        // Validasi Nama Penghuni
        const nama = form.querySelector("[name='nama']");
        if (nama) {
            if (nama.value.trim() === "") {
                tampilkanError(nama, "Nama lengkap wajib diisi.");
                valid = false;
            } else {
                hapusError(nama);
            }
        }

        // Validasi Nomor Kamar (jika di form kamar)
        const noKamar = form.querySelector("[name='nomor_kamar']");
        if (noKamar) {
            if (noKamar.value.trim() === "") {
                tampilkanError(noKamar, "Nomor kamar wajib diisi.");
                valid = false;
            } else {
                hapusError(noKamar);
            }
        }

        // Validasi Harga Bulanan Kamar
        const harga = form.querySelector("[name='harga_bulanan']");
        if (harga) {
            const nilai = parseInt(harga.value, 10);
            if (isNaN(nilai) || nilai <= 0) {
                tampilkanError(harga, "Harga bulanan harus berupa angka positif.");
                valid = false;
            } else {
                hapusError(harga);
            }
        }

        if (!valid) {
            e.preventDefault();
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    initNavToggle();
    initHapusConfirm();
    initTableFilter();
    initValidasiForm();
});