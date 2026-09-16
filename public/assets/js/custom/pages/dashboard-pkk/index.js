/* global bootstrap, Swal, $ */

// ==========================================
// 1. Pokja 1
// ==========================================
document.addEventListener("DOMContentLoaded", function () {
// DataTables Detail Pengurus Pokja I
    const tableEl = $("#kt_table_pengurus");
    if (tableEl.length) {
        const table = tableEl.DataTable({
            destroy: true,
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            // Mengatur layout: l (length) di kiri atas, f (filter/search) di kanan atas
            dom: 
                "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'l><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row mt-3'<'col-sm-12 col-md-5 d-flex align-items-center justify-content-start'i><'col-sm-12 col-md-7 d-flex align-items-center justify-content-end'p>>",
            language: {
                search: "Search:",
                // Menambahkan kembali teks "Show" di samping parameter _MENU_ (dropdown)
                lengthMenu: "Show _MENU_", 
                info: "Showing _START_ to _END_ of _TOTAL_ records",
                paginate: { previous: "‹", next: "›" },
            },
            // Menambahkan initComplete untuk memaksa tata letak horizontal
            initComplete: function() {
                // Memaksa label menjadi baris horizontal
                $('.dataTables_length label, .dataTables_filter label').css({
                    'display': 'flex',
                    'align-items': 'center',
                    'flex-direction': 'row',
                    'gap': '8px',
                    'margin-bottom': '0',
                    'white-space': 'nowrap'
                });
                
                // Mencegah select dan input mengambil lebar penuh
                $('.dataTables_length select, .dataTables_filter input').css({
                    'width': 'auto',
                    'display': 'inline-block'
                });
            }
        });

        const modalEl = document.getElementById("kt_modal_detail_pengurus");
        if (modalEl) {
            modalEl.addEventListener("shown.bs.modal", function () {
                table.columns.adjust();
            });
        }
    }

    // SweetAlert Aksi Terkunci
    document.addEventListener("click", function (e) {
        const btn = e.target.closest(".btn-aksi-terkunci");
        if (!btn) return;

        if (typeof Swal === "undefined") {
            console.error("[akses dibatasi] SweetAlert2 (Swal) tidak ditemukan.");
            return;
        }

        Swal.fire({
            icon: "info",
            title: "Akses Dibatasi",
            text: "Perubahan data hanya bisa dilakukan di akun kecamatan atau kelurahan",
            confirmButtonText: "Mengerti",
            confirmButtonColor: "bg-info",
            customClass: {
                confirmButton: "btn fw-bold btn-info",
            },
            buttonsStyling: false,
        });
    });
    

    // DataTables Modal Edit Volume
    if ($("#kt_table_edit_data").length) {
        $("#kt_table_edit_data").DataTable({
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            language: {
                lengthMenu: "Tampilkan _MENU_ data",
                zeroRecords: "Belum ada data",
                info: "Tidak ada data",
                infoEmpty: "Tidak ada data",
                infoFiltered: "",
                search: "",
                searchPlaceholder: "Search...",
                paginate: { previous: "‹", next: "›" },
            },
        });
    }

    const modalEditDataEl = document.getElementById("kt_modal_edit_data");
    if (modalEditDataEl) {
        modalEditDataEl.addEventListener("show.bs.modal", function (event) {
            const trigger = event.relatedTarget;
            const namaItem = trigger?.getAttribute("data-nama-item") || "";
            const subTitleEl = document.getElementById("modalEditDataSubtitle");
            if (subTitleEl) subTitleEl.textContent = namaItem;
        });
    }

    // DataTables Modal Edit Jumlah Peserta
    if ($("#kt_table_edit_data_peserta").length) {
        $("#kt_table_edit_data_peserta").DataTable({
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            language: {
                lengthMenu: "Tampilkan _MENU_ data",
                zeroRecords: "Belum ada data",
                info: "Tidak ada data",
                infoEmpty: "Tidak ada data",
                infoFiltered: "",
                search: "",
                searchPlaceholder: "Search...",
                paginate: { previous: "‹", next: "›" },
            },
        });
    }

    const modalEditPesertaEl = document.getElementById(
        "kt_modal_edit_data_peserta",
    );
    if (modalEditPesertaEl) {
        modalEditPesertaEl.addEventListener("show.bs.modal", function (event) {
            const trigger = event.relatedTarget;
            const namaItem = trigger?.getAttribute("data-nama-item") || "";
            const subTitleEl = document.getElementById(
                "modalEditDataPesertaSubtitle",
            );
            if (subTitleEl) subTitleEl.textContent = namaItem;
        });
    }
});

// ==========================================
// 2. Pokja 2
// ==========================================

/* Modal Detail Warga Masih Buta Pj 2 */
document.addEventListener('DOMContentLoaded', function () {
    if (!$.fn.DataTable.isDataTable('#kt_table_detail_buta')) {
        $('#kt_table_detail_buta').DataTable({
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            language: {
                lengthMenu: "_MENU_",
                zeroRecords: "Tidak ada data untuk ditampilkan",
                info: "Showing _START_ to _END_ of _TOTAL_ records",
                infoEmpty: "Showing no records",
                infoFiltered: "",
                search: "Search:",
                paginate: { previous: "‹", next: "›" }
            }
        });
    }

    const modalDetailButaEl = document.getElementById('kt_modal_detail_buta');
    if (modalDetailButaEl) {
        modalDetailButaEl.addEventListener('show.bs.modal', function (event) {
            const trigger = event.relatedTarget;
            const field = trigger.getAttribute('data-field') || '';
            const kecamatan = trigger.getAttribute('data-kecamatan') || '';
            document.getElementById('modalDetailButaTitle').textContent =
                `DETAIL ${field} - ${kecamatan}`.toUpperCase();
        });
    }
});

/* Modal Detail Jumlah Kelompok Belajar Pj 2 */
document.addEventListener('DOMContentLoaded', function () {
    if (!$.fn.DataTable.isDataTable('#kt_table_Jml_KLP_Belajar')) {
        $('#kt_table_Jml_KLP_Belajar').DataTable({
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            language: {
                lengthMenu: "_MENU_",
                zeroRecords: "Tidak ada data untuk ditampilkan",
                info: "Showing _START_ to _END_ of _TOTAL_ records",
                infoEmpty: "Showing no records",
                infoFiltered: "",
                search: "Search:",
                paginate: { previous: "‹", next: "›" }
            }
        });
    }

    const modalJmlKLPBelajarEl = document.getElementById('kt_modal_Jml_KLP_Belajar');
    if (modalJmlKLPBelajarEl) {
        modalJmlKLPBelajarEl.addEventListener('show.bs.modal', function (event) {
            const trigger = event.relatedTarget;
            const field = trigger.getAttribute('data-field') || '';
            const kecamatan = trigger.getAttribute('data-kecamatan') || '';
            document.getElementById('modalJmlKLPBelajarTitle').textContent =
                `DETAIL ${field} - ${kecamatan}`.toUpperCase();
        });
    }
});

// ==========================================
// 2. Pokja 4
// ==========================================
(function () {
    const FIRST_NAMES = [
        "Siti",
        "Nur",
        "Widiah",
        "Masula",
        "Ni'amah",
        "Chasanah",
        "Juli",
        "Fatimah",
        "Yustini",
        "Nafi'atus",
        "Agus",
        "Dwi",
        "Tri",
        "Ratna",
        "Eko",
        "Budi",
        "Sri",
        "Endang",
        "Wahyu",
        "Rahmawati",
        "Hidayah",
        "Kartika",
        "Puji",
        "Lestari",
        "Indah",
        "Wulan",
    ];
    const LAST_NAMES = [
        "Erni Yuliyanti",
        "Andarini",
        "Winarti",
        "Sholichah",
        "Wulandari",
        "Susanti",
        "Handayani",
        "Wijaya",
        "Kusuma",
        "Santoso",
        "Purnomo",
        "Utami",
        "Setiawan",
        "Rahayu",
        "Cahyani",
        "Saputri",
        "",
        "",
        "",
        "",
    ];
    const STREETS = [
        "Tambak Dalam Utama",
        "Kalianak Barat",
        "Greges Timur I",
        "Greges Barat Gg.Dalam",
        "Genting Tambak Dalam I",
        "Greges Barat Gg.Mulya",
        "Greges Timur III",
        "Jl. Raya Tambak Langon",
        "Greges Brt Gg. Makam",
        "Asemrowo Utara",
        "Benowo Indah",
        "Bubutan Praja",
    ];
    const GENDERS = ["LAKI-LAKI", "PEREMPUAN"];

    function mulberry32(seed) {
        return function () {
            seed |= 0;
            seed = (seed + 0x6d2b79f5) | 0;
            let t = Math.imul(seed ^ (seed >>> 15), 1 | seed);
            t = (t + Math.imul(t ^ (t >>> 7), 61 | t)) ^ t;
            return ((t ^ (t >>> 14)) >>> 0) / 4294967296;
        };
    }

    function hashString(str) {
        let h = 0;
        for (let i = 0; i < str.length; i++) {
            h = (Math.imul(31, h) + str.charCodeAt(i)) | 0;
        }
        return h;
    }

    function pick(rng, arr) {
        return arr[Math.floor(rng() * arr.length)];
    }
    function pad(num, len) {
        return String(num).padStart(len, "0");
    }

    function generateMockAgregatRecords(field, kecamatan, count) {
        const rng = mulberry32(hashString(`${field}|${kecamatan}`));
        const records = [];
        const kkBase = 3578280000000000 + Math.floor(rng() * 900000);

        for (let i = 0; i < count; i++) {
            const first = pick(rng, FIRST_NAMES);
            const last = pick(rng, LAST_NAMES);
            records.push({
                no: i + 1,
                noKk: String(kkBase + i * 7),
                nik: `35782${pad(Math.floor(rng() * 100000000), 9)}${pad(i, 3)}`,
                nama: `${first}${last ? " " + last : ""}`.toUpperCase(),
                jenisKelamin: pick(rng, GENDERS),
                rt: String(Math.floor(rng() * 10) + 1),
                rw: String(Math.floor(rng() * 8) + 1),
                alamat: `${pick(rng, STREETS)} No. ${Math.floor(rng() * 150) + 1}`,
            });
        }
        return records;
    }

    function parseValueToCount(rawValue) {
        const numeric = parseInt(String(rawValue).replace(/\./g, ""), 10);
        if (Number.isNaN(numeric) || numeric <= 0) return 0;
        return Math.min(numeric, 200);
    }

    let allRecords = [];
    let filteredRecords = [];
    let currentPage = 1;
    let pageSize = 10;

    function applyFilterAndRender() {
        const term = (
            document.getElementById("agregatDetailSearch")?.value || ""
        )
            .trim()
            .toLowerCase();
        filteredRecords = term
            ? allRecords.filter((r) =>
                  [r.noKk, r.nik, r.nama, r.jenisKelamin, r.rt, r.rw, r.alamat]
                      .join(" ")
                      .toLowerCase()
                      .includes(term),
              )
            : allRecords;

        currentPage = 1;
        renderTablePage();
    }

    function renderTablePage() {
        const tbody = document.getElementById("agregatDetailTbody");
        const info = document.getElementById("agregatDetailInfo");
        const pagination = document.getElementById("agregatDetailPagination");
        if (!tbody || !info || !pagination) return;

        const total = filteredRecords.length;
        const totalPages = Math.max(1, Math.ceil(total / pageSize));
        currentPage = Math.min(currentPage, totalPages);

        const start = (currentPage - 1) * pageSize;
        const pageRows = filteredRecords.slice(start, start + pageSize);

        if (pageRows.length === 0) {
            tbody.innerHTML = `<tr><td colspan="8" class="text-muted py-6">Tidak ada data ditemukan.</td></tr>`;
        } else {
            tbody.innerHTML = pageRows
                .map(
                    (r, idx) => `
                <tr>
                    <td>${start + idx + 1}</td>
                    <td>${r.noKk}</td>
                    <td>${r.nik}</td>
                    <td class="text-start">${r.nama}</td>
                    <td>${r.jenisKelamin}</td>
                    <td>${r.rt}</td>
                    <td>${r.rw}</td>
                    <td class="text-start">${r.alamat}</td>
                </tr>`,
                )
                .join("");
        }

        info.textContent =
            total === 0
                ? "Menampilkan 0 data"
                : `Menampilkan ${start + 1} - ${Math.min(start + pageSize, total)} dari ${total} data`;

        const buttons = [];
        buttons.push(
            `<button type="button" class="btn btn-sm btn-light" data-page="${currentPage - 1}" ${
                currentPage === 1 ? "disabled" : ""
            }>Prev</button>`,
        );
        for (let p = 1; p <= totalPages; p++) {
            buttons.push(
                `<button type="button" class="btn btn-sm ${
                    p === currentPage ? "btn-primary" : "btn-light"
                }" data-page="${p}">${p}</button>`,
            );
        }
        buttons.push(
            `<button type="button" class="btn btn-sm btn-light" data-page="${currentPage + 1}" ${
                currentPage === totalPages ? "disabled" : ""
            }>Next</button>`,
        );
        pagination.innerHTML = buttons.join("");
    }

    function openAgregatDetailModal(field, kecamatan, rawValue) {
        const titleEl = document.getElementById("modalAgregatTitle");
        const modalEl = document.getElementById("kt_modal_agregat");

        if (!modalEl || typeof bootstrap === "undefined" || !bootstrap.Modal)
            return;

        if (titleEl) {
            titleEl.textContent =
                `DETAIL ${field} - ${kecamatan}`.toUpperCase();
        }

        const count = parseValueToCount(rawValue);
        allRecords = generateMockAgregatRecords(field, kecamatan, count);

        const pageSizeEl = document.getElementById("agregatDetailPageSize");
        pageSize = pageSizeEl ? parseInt(pageSizeEl.value, 10) || 10 : 10;

        const searchEl = document.getElementById("agregatDetailSearch");
        if (searchEl) searchEl.value = "";

        const inputValEl = document.getElementById("modalAgregatValue");
        if (inputValEl) inputValEl.value = rawValue;

        applyFilterAndRender();
        bootstrap.Modal.getOrCreateInstance(modalEl).show();
    }

    const MOCK_GKSTB = {
        "GKSTB Kesehatan": [
            {
                no: 1,
                proyek: "SOSIALISASI BATRA BERSAMA POKJA 4 & NAKES PUSKESMAS (BATRA)",
                kategori: "Peduli kesehatan keluarga",
                kelurahan: "BENOWO",
                kecamatan: "KANDANGAN",
            },
            {
                no: 2,
                proyek: "MAKAN BERSAMA BALITA STUNTING KERJASAMA POKJA 3 & 4",
                kategori: "Peduli kesehatan keluarga",
                kelurahan: "BENOWO",
                kecamatan: "KANDANGAN",
            },
            {
                no: 3,
                proyek: "PEMBERIAN SUSU DAN VITAMIN BAGI BALITA STUNTING DAN PRASTUNTING",
                kategori: "Peduli stunting",
                kelurahan: "BENOWO",
                kecamatan: "KANDANGAN",
            },
            {
                no: 4,
                proyek: "PARENTING KEREN STUNTING LEREN",
                kategori: "Peduli stunting",
                kelurahan: "BENOWO",
                kecamatan: "KANDANGAN",
            },
            {
                no: 5,
                proyek: "PEMBERIAN MAKANAN BERGIZI",
                kategori: "Peduli stunting",
                kelurahan: "BENOWO",
                kecamatan: "TAMBAK OSO WILANGUN",
            },
        ],
        "GKSTB Lingkungan Hidup": [
            {
                no: 1,
                proyek: "SOSIALISASI PENANGGULANGAN BENCANA KEBAKARAN",
                kategori: "Mitigasi bencana",
                kelurahan: "BENOWO",
                kecamatan: "KANDANGAN",
            },
            {
                no: 2,
                proyek: "KAMPUNG MACO (MANGGA & COCODAMA)",
                kategori: "Peduli lingkungan",
                kelurahan: "BENOWO",
                kecamatan: "KANDANGAN",
            },
            {
                no: 3,
                proyek: "KERJA BAKTI & GOTONG ROYONG",
                kategori: "Peduli lingkungan",
                kelurahan: "BENOWO",
                kecamatan: "KANDANGAN",
            },
            {
                no: 4,
                proyek: "PSN",
                kategori: "Peduli lingkungan",
                kelurahan: "BENOWO",
                kecamatan: "TAMBAK OSO WILANGUN",
            },
        ],
        "GKSTB Perencanaan Sehat": [
            {
                no: 1,
                proyek: "KOPERASI SIMPAN PINJAM KELOMPOK RT & RW",
                kategori: "Keuangan sehat",
                kelurahan: "BENOWO",
                kecamatan: "KANDANGAN",
            },
            {
                no: 2,
                proyek: "SOSIALISASI DAN EDUKASI TUMBUH KEMBANG ANAK",
                kategori: "Keluarga sehat berkualitas",
                kelurahan: "BENOWO",
                kecamatan: "KANDANGAN",
            },
            {
                no: 3,
                proyek: "SOSIALISASI",
                kategori: "Keluarga sehat berkualitas",
                kelurahan: "BENOWO",
                kecamatan: "TAMBAK OSO WILANGUN",
            },
        ],
    };

    function openGkstbModal(field, kecamatan) {
        const modalEl = document.getElementById("kt_modal_gkstb");
        const tbody = document.getElementById("gkstbTbody");
        const info = document.getElementById("gkstbInfo");
        if (!modalEl || !tbody) return;

        const dataList = MOCK_GKSTB[field] || [];

        if (dataList.length === 0) {
            tbody.innerHTML = `<tr><td colspan="6" class="text-center text-muted py-5">Tidak ada data proyek ditemukan.</td></tr>`;
        } else {
            tbody.innerHTML = dataList
                .map(
                    (item) => `
                <tr  class="fw-bold fs-7 text-gray-700">
                    <td class="ps-3 w-50px">${item.no}</td>
                    <td class="min-w-200px">${item.proyek}</td>
                    <td class="min-w-150px">${item.kategori}</td>
                    <td class="min-w-120px">${item.kelurahan}</td>
                    <td class="min-w-120px">${item.kecamatan}</td>
                    <td class="text-center pe-3">
                        <button type="button" class="btn btn-icon btn-sm btn-light btn-aksi-terkunci">
                            <i class="ki-outline ki-lock fs-4"></i>
                        </button>
                    </td>
                </tr>
            `,
                )
                .join("");
        }

        if (info) {
            info.textContent = `Showing 1 to ${dataList.length} of ${dataList.length} records`;
        }

        bootstrap.Modal.getOrCreateInstance(modalEl).show();
    }

    // --- Global Event Delegation ---
    document.addEventListener("DOMContentLoaded", function () {
        document.addEventListener("click", function (e) {
            const trigger = e.target.closest(".agregat-trigger");
            if (trigger) {
                const field = trigger.getAttribute("data-field") || "";
                const kecamatan = trigger.getAttribute("data-kecamatan") || "";
                const value =
                    trigger.getAttribute("data-value") ||
                    trigger.textContent.trim();

                if (field.startsWith("GKSTB")) {
                    openGkstbModal(field, kecamatan);
                } else {
                    openAgregatDetailModal(field, kecamatan, value);
                }
                return;
            }

            const pageBtn = e.target.closest(
                "#agregatDetailPagination button[data-page]",
            );
            if (pageBtn && !pageBtn.disabled) {
                currentPage =
                    parseInt(pageBtn.getAttribute("data-page"), 10) || 1;
                renderTablePage();
            }
        });

        document.addEventListener("input", function (e) {
            if (e.target.id === "agregatDetailSearch") {
                applyFilterAndRender();
            }
        });

        document.addEventListener("change", function (e) {
            if (e.target.id === "agregatDetailPageSize") {
                pageSize = parseInt(e.target.value, 10) || 10;
                currentPage = 1;
                renderTablePage();
            }
        });
    });
})();
