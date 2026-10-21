const daftarInovasiKota = [
    { key: 'elearning-puspaga', pokja: 'pokja 1', title: 'E-learning Puspaga PKK' },
    { key: 'kemanggi', pokja: 'pokja 1', title: 'Kemanggi (Kelas Remaja dan Orang Tua Tangguh, Kreatif, dan Mandiri)' },
    { key: 'selantang', pokja: 'pokja 2', title: 'Selantang' },
    { key: 'soth', pokja: 'pokja 2', title: 'SOTH (Sekolah Orang Tua Hebat)' },
    { key: 'empty-sekretaris', pokja: 'sekretaris', title: 'Data Inovasi tidak ditemukan' },
    { key: 'makan-ketan', pokja: 'pokja 3', title: 'Makan Ketan (Pemanfaatan Pekarangan untuk Ketahanan Pangan)' },
    { key: 'pisang-danor', pokja: 'pokja 3', title: 'Pisang Danor (Pilah Sampah Anorganik dan Organik)' },
    { key: 'pmt', pokja: 'pokja 3', title: 'PMT (Pemberian Makanan Tambahan)' },
    { key: 'pendampingan-bumil', pokja: 'pokja 4', title: 'Inovasi Pendampingan Ibu Hamil dan Ibu Hamil Resti' },
    { key: 'kampung-asi', pokja: 'pokja 4', title: 'Kampung ASI' },
    { key: 'surabaya-emas', pokja: 'pokja 4', title: 'Surabaya Emas' }
];

const dataWilayahElearning = {
    'Asem Rowo': {
        skor: 91.40,
        kelurahan: [
            { nama: 'Asem Rowo', skor: '91.80' },
            { nama: 'Genting Kalianak', skor: '90.50' },
            { nama: 'Tambak Sarioso', skor: '91.90' }
        ]
    },
    'Benowo': {
        skor: 85.00,
        kelurahan: [
            { nama: 'Kandangan', skor: '85.20' },
            { nama: 'Romokalisari', skor: '84.80' },
            { nama: 'Sememi', skor: '86.10' },
            { nama: 'Tambak Osowilangun', skor: '83.90' }
        ]
    },
    'Bubutan': {
        skor: 91.74,
        kelurahan: [
            { nama: 'Alun-Alun Contong', skor: '91.70' },
            { nama: 'Bubutan', skor: '92.10' },
            { nama: 'Gundih', skor: '90.50' },
            { nama: 'Jepara', skor: '91.80' },
            { nama: 'Tembok Dukuh', skor: '92.60' }
        ]
    },
    'Bulak': {
        skor: 91.20,
        kelurahan: [
            { nama: 'Bulak', skor: '91.00' },
            { nama: 'Kedung Cowek', skor: '91.50' },
            { nama: 'Kenjeran', skor: '90.80' },
            { nama: 'Sukolilo Baru', skor: '91.50' }
        ]
    },
    'Dukuh Pakis': {
        skor: 90.10,
        kelurahan: [
            { nama: 'Dukuh Kupang', skor: '90.50' },
            { nama: 'Dukuh Pakis', skor: '89.80' },
            { nama: 'Gunung Sari', skor: '90.20' },
            { nama: 'Pradah Kalikendal', skor: '89.90' }
        ]
    },
    'Gayungan': {
        skor: 88.50,
        kelurahan: [
            { nama: 'Dukuh Menanggal', skor: '88.20' },
            { nama: 'Gayungan', skor: '89.00' },
            { nama: 'Ketintang', skor: '88.70' },
            { nama: 'Menanggal', skor: '88.10' }
        ]
    },
    'Genteng': {
        skor: 84.60,
        kelurahan: [
            { nama: 'Embong Kaliasin', skor: '92.40' },
            { nama: 'Ketabang', skor: '89.10' },
            { nama: 'Kapasari', skor: '94.20' },
            { nama: 'Peneleh', skor: '91.00' },
            { nama: 'Genteng', skor: '88.50' }
        ]
    },
    'Gubeng': {
        skor: 88.10,
        kelurahan: [
            { nama: 'Airlangga', skor: '88.50' },
            { nama: 'Barata Jaya', skor: '87.80' },
            { nama: 'Gubeng', skor: '88.40' },
            { nama: 'Kertajaya', skor: '88.00' },
            { nama: 'Mojo', skor: '87.90' },
            { nama: 'Pucang Sewu', skor: '88.00' }
        ]
    },
    'Gunung Anyar': {
        skor: 89.20,
        kelurahan: [
            { nama: 'Gunung Anyar', skor: '89.50' },
            { nama: 'Gunung Anyar Tambak', skor: '88.90' },
            { nama: 'Rungkut Menanggal', skor: '89.20' },
            { nama: 'Rungkut Tengah', skor: '89.20' }
        ]
    }
};

const listKecamatanSoth = [
    'ASEMROWO', 'BENOWO', 'BULAK', 'DUKUH PAKIS', 'GAYUNGAN', 'GENTENG',
    'GUBENG', 'GUNUNG ANYAR', 'KARANG PILANG', 'KENJERAN', 'KREMBANGAN',
    'LAKAR SANTRI', 'MULYOREJO', 'PABEAN CANTIAN', 'PAKAL', 'RUNGKUT',
    'SAMBI KEREP', 'SAWAHAN', 'SEMAMPIR', 'SIMOKERTO', 'SUKOLILO',
    'SUKOMANUNGGAL', 'TAMBAKSARI', 'TANDES', 'TEGALSARI', 'TENGGILIS MEJOYO',
    'WONOCOLO', 'WONOKROMO'
];

let chartElearningInstance = null;
let chartRemajaInstance = null;
let chartOrangTuaInstance = null;
let selectedKecamatanAktif = 'Genteng';

function populateInovasiOptions(selectedPokja = 'semua') {
    const $select = $('#select-filter-inovasi');
    const nativeSelect = document.getElementById('select-filter-inovasi');
    if (!nativeSelect) return;

    const pokjaKey = (selectedPokja || 'semua').toString().trim().toLowerCase();

    if (window.jQuery && $select.data('select2')) {
        $select.empty();
    } else {
        nativeSelect.innerHTML = '';
    }

    if (pokjaKey === 'sekretaris') {
        const opt = new Option('Data Inovasi tidak ditemukan', 'empty-sekretaris', true, true);
        $(opt).prop('disabled', true);
        $select.append(opt);
        if ($select.data('select2')) $select.trigger('change');
        return;
    }

    const defaultOpt = new Option('Pilih salah satu inovasi...', '', true, true);
    $(defaultOpt).prop('disabled', true);
    $select.append(defaultOpt);

    // 1. Filter item berdasarkan pokja
    let items = (typeof daftarInovasiKota !== 'undefined' ? daftarInovasiKota : []).filter(item => {
        const itemPokja = (item.pokja || '').toString().trim().toLowerCase();
        if (itemPokja === 'sekretaris') return false;
        return pokjaKey === 'semua' || itemPokja === pokjaKey;
    });

    // 2. URUTKAN SESUAI ABJAD A - Z BERDASARKAN TITLE
    items.sort((a, b) => {
        return a.title.localeCompare(b.title, 'id', { sensitivity: 'base' });
    });

    // 3. Masukkan opsi yang sudah urut abjad ke dalam dropdown
    items.forEach(item => {
        const newOption = new Option(item.title, item.key, false, false);
        $select.append(newOption);
    });

    if (window.jQuery && $select.data('select2')) {
        $select.val('').trigger('change.select2');
    }
}

function handlePokjaChange() {
    const selectedPokja = document.getElementById('select-filter-pokja').value;
    populateInovasiOptions(selectedPokja);
    resetDetailState();
}

function handleInovasiChange() {
    const inovasiSelect = document.getElementById('select-filter-inovasi');
    const selectedKey = (window.jQuery && $(inovasiSelect).length ? $(inovasiSelect).val() : inovasiSelect?.value) || '';
    const emptyState = document.getElementById('state-placeholder-empty');
    const detailState = document.getElementById('state-detail-content');
    const subtitleBanner = document.getElementById('banner-subtitle-inovasi');

    document.querySelectorAll('.inovasi-item-view').forEach(el => el.classList.add('d-none'));

    if (selectedKey && selectedKey !== 'empty-sekretaris') {
        if (emptyState) emptyState.classList.add('d-none');
        if (detailState) {
            detailState.classList.remove('d-none');
            detailState.style.display = 'block';
        }

        if (subtitleBanner && inovasiSelect.selectedIndex >= 0) {
            const selectedText = inovasiSelect.options[inovasiSelect.selectedIndex].text;
            subtitleBanner.textContent = `Data Inovasi ${selectedText}`;
        }

        const activeContent = document.getElementById('content-' + selectedKey);
        if (activeContent) {
            activeContent.classList.remove('d-none');
            activeContent.style.display = 'block';

            if (selectedKey === 'kemanggi') {
                setTimeout(() => {
                    gambarGrafikKemanggi();
                }, 100);
            }

            if (selectedKey === 'elearning-puspaga') {
                if (typeof updateElearningTimestamp === 'function') {
                    updateElearningTimestamp();
                }
                setTimeout(() => {
                    renderGrafikElearning();
                }, 120);
            }

            if (selectedKey === 'soth') {
        setTimeout(() => {
            if (typeof initChartSoth === 'function') {
                initChartSoth();
            }
            if (typeof fetchTableSoth === 'function') {
                fetchTableSoth(1);
            }
            if (typeof fetchChartSoth === 'function') {
                fetchChartSoth();
            }
        }, 150);
    }

            if (selectedKey === 'kampung-asi') {
                setTimeout(() => {
                    if (typeof initKampungAsi === 'function') {
                        initKampungAsi();
                    }
                }, 150);
            }

            if (selectedKey === 'surabaya-emas') {
                setTimeout(() => {
                    if (typeof initSurabayaEmas === 'function') {
                        initSurabayaEmas();
                    }
                }, 150);
            }

        } else {
            console.error('Elemen tidak ditemukan untuk ID: content-' + selectedKey);
        }
    } else {
        resetDetailState();
    }
}

function resetDetailState() {
    const emptyState = document.getElementById('state-placeholder-empty');
    const detailState = document.getElementById('state-detail-content');
    const subtitleBanner = document.getElementById('banner-subtitle-inovasi');

    if (subtitleBanner) {
        subtitleBanner.textContent = 'Data Inovasi Kota';
    }

    if (emptyState) emptyState.classList.remove('d-none');
    if (detailState) detailState.classList.add('d-none');
    document.querySelectorAll('.inovasi-item-view').forEach(el => el.classList.add('d-none'));
}

function gambarGrafikKemanggi() {
    if (typeof Chart === 'undefined') {
        console.error('Chart.js belum terpasang!');
        return;
    }

    const kecamatanLabels = [
        'Genteng', 'Tegalsari', 'Bubutan', 'Simokerto', 'Gubeng',
        'Wonokromo', 'Sawahan', 'Tambaksari', 'Kenjeran', 'Rungkut',
        'Sukolilo', 'Mulyorejo', 'Tandes', 'Benowo', 'Lakarsantri'
    ];

    const chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        interaction: { mode: 'index', intersect: false },
        plugins: { legend: { display: false } },
        scales: {
            y: {
                min: 0,
                max: 160,
                ticks: { stepSize: 20, color: '#64748b', font: { size: 11 } },
                grid: { color: '#f1f5f9' }
            },
            x: {
                ticks: { color: '#64748b', font: { size: 10 }, maxRotation: 45, minRotation: 45 },
                grid: { display: false }
            }
        }
    };

    const canvasRemaja = document.getElementById('chartKemanggiRemaja');
    if (canvasRemaja) {
        if (chartRemajaInstance) chartRemajaInstance.destroy();
        chartRemajaInstance = new Chart(canvasRemaja.getContext('2d'), {
            type: 'line',
            data: {
                labels: kecamatanLabels,
                datasets: [
                    {
                        label: 'Pretest',
                        data: [42, 50, 48, 62, 55, 70, 65, 58, 62, 75, 68, 59, 64, 72, 60],
                        borderColor: '#0284c7',
                        backgroundColor: '#0284c7',
                        borderWidth: 2.5,
                        tension: 0.35,
                        pointRadius: 3
                    },
                    {
                        label: 'Posttest',
                        data: [110, 125, 118, 142, 130, 148, 138, 126, 135, 152, 144, 130, 137, 150, 140],
                        borderColor: '#f43f5e',
                        backgroundColor: '#f43f5e',
                        borderWidth: 2.5,
                        tension: 0.35,
                        pointRadius: 3
                    }
                ]
            },
            options: chartOptions
        });
        chartRemajaInstance.resize();
    }

    const canvasOrangTua = document.getElementById('chartKemanggiOrangTua');
    if (canvasOrangTua) {
        if (chartOrangTuaInstance) chartOrangTuaInstance.destroy();
        chartOrangTuaInstance = new Chart(canvasOrangTua.getContext('2d'), {
            type: 'line',
            data: {
                labels: kecamatanLabels,
                datasets: [
                    {
                        label: 'Pretest',
                        data: [50, 58, 52, 68, 60, 78, 70, 64, 69, 82, 74, 65, 70, 80, 68],
                        borderColor: '#0284c7',
                        backgroundColor: '#0284c7',
                        borderWidth: 2.5,
                        tension: 0.35,
                        pointRadius: 3
                    },
                    {
                        label: 'Posttest',
                        data: [105, 118, 112, 135, 124, 140, 132, 120, 128, 145, 138, 122, 130, 142, 134],
                        borderColor: '#f43f5e',
                        backgroundColor: '#f43f5e',
                        borderWidth: 2.5,
                        tension: 0.35,
                        pointRadius: 3
                    }
                ]
            },
            options: chartOptions
        });
        chartOrangTuaInstance.resize();
    }
}

function filterWilayahElearning() {
    const kecSelect = document.getElementById('filter_elearning_kecamatan').value;
    const kelSelect = document.getElementById('filter_elearning_kelurahan');
    kelSelect.innerHTML = '<option value="all" selected>Semua Kelurahan</option>';

    if (kecSelect !== 'all' && dataWilayahElearning[kecSelect]) {
        dataWilayahElearning[kecSelect].kelurahan.forEach(kel => {
            const opt = document.createElement('option');
            opt.value = kel.nama;
            opt.textContent = kel.nama;
            kelSelect.appendChild(opt);
        });
        renderGrafikElearning([kecSelect], [dataWilayahElearning[kecSelect].skor]);
    } else {
        renderGrafikElearning();
    }
}

function filterKelurahanElearning() {
    const kelVal = document.getElementById('filter_elearning_kelurahan').value;
    const kecVal = document.getElementById('filter_elearning_kecamatan').value;

    if (kelVal !== 'all' && kecVal !== 'all') {
        const found = dataWilayahElearning[kecVal]?.kelurahan.find(k => k.nama === kelVal);
        if (found) {
            renderGrafikElearning([kelVal], [parseFloat(found.skor)]);
        }
    } else if (kecVal !== 'all') {
        renderGrafikElearning([kecVal], [dataWilayahElearning[kecVal].skor]);
    } else {
        renderGrafikElearning();
    }
}

function renderGrafikElearning(customLabels = null, customData = null) {
    const canvas = document.getElementById('chartElearningPaaredi');
    if (!canvas) return;

    const labelsKecamatan = customLabels || Object.keys(dataWilayahElearning);
    const dataSkor = customData || labelsKecamatan.map(k => dataWilayahElearning[k]?.skor || 90.00);

    if (chartElearningInstance) chartElearningInstance.destroy();

    const dataLabelsPlugin = {
        id: 'dataLabelsPlugin',
        afterDatasetsDraw(chart) {
            const { ctx } = chart;
            chart.data.datasets.forEach((dataset, i) => {
                const meta = chart.getDatasetMeta(i);
                meta.data.forEach((bar, index) => {
                    const val = dataset.data[index];
                    ctx.fillStyle = '#0f172a';
                    ctx.font = 'bold 11px Inter, sans-serif';
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'bottom';
                    ctx.fillText(Number(val).toFixed(2), bar.x, bar.y - 4);
                });
            });
        }
    };

    chartElearningInstance = new Chart(canvas.getContext('2d'), {
        type: 'bar',
        data: {
            labels: labelsKecamatan,
            datasets: [{
                label: 'Skor Rata-rata',
                data: dataSkor,
                backgroundColor: '#00a676',
                hoverBackgroundColor: '#008a62',
                borderRadius: 4,
                barPercentage: 0.55
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            onHover: (event, chartElement) => {
                event.native.target.style.cursor = chartElement[0] ? 'pointer' : 'default';
            },
            scales: {
                y: {
                    min: 0,
                    max: 100,
                    ticks: { stepSize: 10, color: '#64748b', font: { size: 11 } },
                    grid: { color: '#f1f5f9' }
                },
                x: {
                    ticks: { color: '#334155', font: { weight: '600', size: 11 } },
                    grid: { display: false }
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1f2937',
                    titleFont: { size: 13, weight: 'bold' },
                    bodyFont: { size: 12 },
                    padding: 12,
                    cornerRadius: 8,
                    callbacks: {
                        label: function (context) {
                            return ` Skor Rata-rata: ${context.parsed.y}`;
                        },
                        afterBody: function () {
                            return '\n👆 Klik untuk lihat daftar kelurahan';
                        }
                    }
                }
            },
            onClick: (event, elements) => {
                if (elements.length > 0) {
                    const index = elements[0].index;
                    const namaKecamatan = labelsKecamatan[index];
                    if (dataWilayahElearning[namaKecamatan]) {
                        bukaModalKelurahan(namaKecamatan);
                    } else {
                        bukaModalKelurahan(document.getElementById('filter_elearning_kecamatan').value || 'Genteng');
                    }
                }
            }
        },
        plugins: [dataLabelsPlugin]
    });
}

function bukaModalKelurahan(kecamatan) {
    selectedKecamatanAktif = kecamatan;
    const badgeEl = document.getElementById('modal_kecamatan_badge');
    if (badgeEl) badgeEl.textContent = kecamatan;

    const tbody = document.getElementById('tabel_daftar_kelurahan_body');
    if (!tbody) return;
    tbody.innerHTML = '';

    const listKel = dataWilayahElearning[kecamatan]?.kelurahan || [
        { nama: kecamatan + ' 1', skor: '90.00' },
        { nama: kecamatan + ' 2', skor: '88.50' }
    ];

    listKel.forEach((kel, idx) => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td class="text-center text-gray-400">${idx + 1}</td>
            <td class="fw-bold text-gray-800">${kel.nama}</td>
            <td class="text-center fw-bold text-dark">${kel.skor}</td>
            <td class="text-end pe-4">
                <button type="button" class="btn btn-sm fw-bold px-3 py-1 rounded-2"
                        style="background-color: #e0f2fe; color: #0284c7; border: none;"
                        onclick="bukaModalPesertaKelurahan('${kecamatan}', '${kel.nama}')">
                    Lihat Peserta
                </button>
            </td>
        `;
        tbody.appendChild(tr);
    });

    const modalEl = document.getElementById('modalElearningKelurahan');
    if (modalEl) {
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();
    }
}

function bukaModalPesertaKelurahan(kecamatan, kelurahan) {
    const modalKel = bootstrap.Modal.getInstance(document.getElementById('modalElearningKelurahan'));
    if (modalKel) modalKel.hide();

    const badgeKec = document.getElementById('badge_peserta_kecamatan');
    const badgeKel = document.getElementById('badge_peserta_kelurahan');
    if (badgeKec) badgeKec.textContent = kecamatan;
    if (badgeKel) {
        badgeKel.textContent = kelurahan;
        badgeKel.classList.remove('d-none');
    }

    isiTabelPeserta([]);

    setTimeout(() => {
        const modalPesertaEl = document.getElementById('modalElearningPeserta');
        if (modalPesertaEl) {
            const modalPeserta = bootstrap.Modal.getOrCreateInstance(modalPesertaEl);
            modalPeserta.show();
        }
    }, 300);
}

function bukaModalPesertaKecamatan() {
    const modalKel = bootstrap.Modal.getInstance(document.getElementById('modalElearningKelurahan'));
    if (modalKel) modalKel.hide();

    const badgeKec = document.getElementById('badge_peserta_kecamatan');
    const badgeKel = document.getElementById('badge_peserta_kelurahan');
    if (badgeKec) badgeKec.textContent = selectedKecamatanAktif;
    if (badgeKel) badgeKel.classList.add('d-none');

    isiTabelPeserta([]);

    setTimeout(() => {
        const modalPesertaEl = document.getElementById('modalElearningPeserta');
        if (modalPesertaEl) {
            const modalPeserta = bootstrap.Modal.getOrCreateInstance(modalPesertaEl);
            modalPeserta.show();
        }
    }, 300);
}

function isiTabelPeserta(dataList = []) {
    const tbody = document.getElementById('tabel_detail_peserta_body');
    const labelTotal = document.getElementById('label_total_peserta');
    if (!tbody || !labelTotal) return;

    tbody.innerHTML = '';
    if (dataList.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="5" class="text-center py-12 text-gray-400 fw-semibold fs-6">
                    Belum ada data
                </td>
            </tr>
        `;
        labelTotal.textContent = 'Total: 0 data';
    } else {
        dataList.forEach((row, idx) => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="text-center text-gray-400">${idx + 1}</td>
                <td class="fw-bold text-gray-800">${row.nama}</td>
                <td>${row.nik}</td>
                <td>${row.materi}</td>
                <td class="text-center fw-bold text-success">${row.skor}</td>
            `;
            tbody.appendChild(tr);
        });
        labelTotal.textContent = `Total: ${dataList.length} data`;
    }
}

function updateElearningTimestamp() {
    const el = document.getElementById('elearning-timestamp');
    if (!el) return;

    const now = new Date();
    const pad = (n) => String(n).padStart(2, '0');

    const tgl = pad(now.getDate());
    const bln = pad(now.getMonth() + 1);
    const thn = now.getFullYear();
    const jam = pad(now.getHours());
    const mnt = pad(now.getMinutes());
    const dtk = pad(now.getSeconds());

    el.textContent = `Pembaruan data: ${tgl}-${bln}-${thn} ${jam}:${mnt}:${dtk}`;
}

function initInovasi() {
    const pokjaSelect = document.getElementById('select-filter-pokja');
    const valPokja = pokjaSelect ? pokjaSelect.value : 'semua';
    populateInovasiOptions(valPokja);
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initInovasi);
} else {
    initInovasi();
}

let sothCurrentPage = 1;
let sothPageSize = 10;
let sothChartInstance = null;
let sothModal = null;
let sothModalHapus = null;
let sothNotifModal = null;
let targetHashHapusSoth = null;

function tampilkanPopUpSoth(judul, pesan) {
    const titleEl = document.getElementById('notifikasiSothTitle');
    const textEl = document.getElementById('notifikasiSothText');
    if (titleEl) titleEl.textContent = judul;
    if (textEl) textEl.textContent = pesan;

    const modalEl = document.getElementById('modalNotifikasiSoth');
    if (modalEl) {
        if (!sothNotifModal) {
            sothNotifModal = new bootstrap.Modal(modalEl);
        }
        sothNotifModal.show();
    }
}

function initSothModule() {
    const modalEl = document.getElementById('modalFormSoth');
    if (modalEl && !sothModal) {
        sothModal = new bootstrap.Modal(modalEl);
    }

    const modalHapusEl = document.getElementById('modalKonfirmasiHapusSoth');
    if (modalHapusEl && !sothModalHapus) {
        sothModalHapus = new bootstrap.Modal(modalHapusEl);
    }

    const modalNotifEl = document.getElementById('modalNotifikasiSoth');
    if (modalNotifEl && !sothNotifModal) {
        sothNotifModal = new bootstrap.Modal(modalNotifEl);
    }

    initChartSoth();
    fetchTableSoth(1);
    fetchChartSoth();
}

const listKecamatanSothMaster = [
    'ASEMROWO', 'BENOWO', 'BUBUTAN', 'BULAK', 'DUKUH PAKIS', 'GAYUNGAN', 'GENTENG',
    'GUBENG', 'GUNUNG ANYAR', 'JAMBANGAN', 'KARANG PILANG', 'KENJERAN', 'KREMBANGAN',
    'LAKAR SANTRI', 'MULYOREJO', 'PABEAN CANTIAN', 'PAKAL', 'RUNGKUT',
    'SAMBI KEREP', 'SAWAHAN', 'SEMAMPIR', 'SIMOKERTO', 'SUKOLILO',
    'SUKOMANUNGGAL', 'TAMBAKSARI', 'TANDES', 'TEGALSARI', 'TENGGILIS MEJOYO',
    'WIYUNG', 'WONOCOLO', 'WONOKROMO'
];

function initChartSoth() {
    const ctx = document.getElementById('chartSothNilai');
    if (!ctx) return;

    if (sothChartInstance) {
        sothChartInstance.destroy();
        sothChartInstance = null;
    }

    sothChartInstance = new Chart(ctx, {
        type: 'line',
        data: {
            labels: listKecamatanSothMaster,
            datasets: [
                {
                    label: 'Pretest',
                    data: new Array(listKecamatanSothMaster.length).fill(0),
                    borderColor: '#38bdf8',
                    backgroundColor: 'rgba(56, 189, 248, 0.12)',
                    borderWidth: 4,               
                    borderDash: [6, 6],           
                    tension: 0,
                    pointRadius: 5.5,             
                    pointHoverRadius: 8,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#38bdf8',
                    pointBorderWidth: 3,         
                    fill: false
                },
                {
                    label: 'Posttest',
                    data: new Array(listKecamatanSothMaster.length).fill(0),
                    borderColor: '#fb7185',
                    backgroundColor: 'rgba(251, 113, 133, 0.12)',
                    borderWidth: 4,               
                    borderDash: [6, 6],          
                    tension: 0,
                    pointRadius: 5.5,             
                    pointHoverRadius: 8,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#fb7185',
                    pointBorderWidth: 3,         
                    fill: false
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { display: false },
                datalabels: { display: false },
                tooltip: {
                    backgroundColor: '#1f2937',
                    padding: 10,
                    cornerRadius: 8,
                    callbacks: {
                        label: (ctx) => ` ${ctx.dataset.label}: ${ctx.parsed.y}%`
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    min: 0,
                    max: 100,
                    ticks: {
                        stepSize: 10,
                        callback: (v) => v + '%',
                        color: '#64748b',
                        font: { size: 10 }
                    },
                    grid: { color: '#f1f5f9' }
                },
                x: {
                    ticks: {
                        color: '#64748b',
                        font: { size: 9, weight: '600' },
                        maxRotation: 45,
                        minRotation: 45
                    },
                    grid: { color: '#f8fafc' }
                }
            }
        }
    });
}

function fetchChartSoth() {
    const kec = document.getElementById('filter_soth_kecamatan')?.value || 'all';
    const chartUrl = window.ROUTES_SOTH?.chart || '/inovasi/soth/chart';

    fetch(`${chartUrl}?kecamatan=${encodeURIComponent(kec)}`, {
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(res => res.json())
    .then(data => {
        if (!sothChartInstance || !sothChartInstance.ctx) return;

        if (kec !== 'all') {
            sothChartInstance.data.labels = [kec];
            sothChartInstance.data.datasets[0].data = data.pretest || [0];
            sothChartInstance.data.datasets[1].data = data.posttest || [0];
            sothChartInstance.update();
            return;
        }

        const apiLabels = (data.labels || []).map(l => l.toUpperCase().replace(/\s+/g, ''));
        const apiPre = data.pretest || [];
        const apiPost = data.posttest || [];

        const mappedPre = listKecamatanSothMaster.map(k => {
            const clean = k.replace(/\s+/g, '');
            const idx = apiLabels.indexOf(clean);
            return idx !== -1 ? apiPre[idx] : 0;
        });

        const mappedPost = listKecamatanSothMaster.map(k => {
            const clean = k.replace(/\s+/g, '');
            const idx = apiLabels.indexOf(clean);
            return idx !== -1 ? apiPost[idx] : 0;
        });

        sothChartInstance.data.labels = listKecamatanSothMaster;
        sothChartInstance.data.datasets[0].data = mappedPre;
        sothChartInstance.data.datasets[1].data = mappedPost;
        sothChartInstance.update();
    })
    .catch(err => console.error("Gagal load chart SOTH:", err));
}

function filterSothKecamatan() {
    fetchTableSoth(1);
    fetchChartSoth();
}

function changeSothPageSize() {
    const sel = document.getElementById('soth_page_size');
    sothPageSize = parseInt(sel.value, 10) || 10;
    fetchTableSoth(1);
}

function fetchTableSoth(page = 1) {
    sothCurrentPage = page;
    const tbody = document.getElementById('tabel_soth_body');
    if (tbody) {
        tbody.innerHTML = `<tr><td colspan="11" class="text-center py-8 text-gray-400">Memuat data...</td></tr>`;
    }

    const kec = document.getElementById('filter_soth_kecamatan')?.value || 'all';
    const dataUrl = window.ROUTES_SOTH?.data || '/inovasi/soth/data';
    const params = new URLSearchParams({
        page: page,
        limit: sothPageSize,
        kecamatan: kec
    });

    fetch(`${dataUrl}?${params.toString()}`, {
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(res => res.json())
    .then(data => renderTableSoth(data))
    .catch(err => {
        console.error("Gagal load tabel SOTH:", err);
        if (tbody) {
            tbody.innerHTML = `<tr><td colspan="11" class="text-center py-8 text-gray-400">Gagal memuat data</td></tr>`;
        }
    });
}

function renderTableSoth(res) {
    const tbody = document.getElementById('tabel_soth_body');
    if (!tbody) return;

    const items = res.data || [];
    if (items.length === 0) {
        tbody.innerHTML = `<tr><td colspan="11" class="text-center py-8 text-gray-400">Data tidak ditemukan</td></tr>`;
        updatePaginationInfo(0, 0, 0, 1, 1);
        return;
    }

    let html = '';
    const startNo = ((res.current_page - 1) * res.per_page) + 1;

    items.forEach((item, index) => {
        const no = startNo + index;
        const refId = item.hash || item.id;
        html += `
            <tr>
                <td class="text-center">${no}</td>
                <td>${item.nama ?? '-'}</td>
                <td>${item.alamat ?? '-'}</td>
                <td class="text-center">${item.rt ?? '-'}</td>
                <td class="text-center">${item.rw ?? '-'}</td>
                <td>${item.kelurahan ?? '-'}</td>
                <td>${item.kecamatan ?? '-'}</td>
                <td class="text-center">${parseFloat(item.rata_pre ?? item.rata_rata_pre ?? 0).toFixed(2)}</td>
                <td class="text-center">${parseFloat(item.rata_post ?? item.rata_rata_post ?? 0).toFixed(2)}</td>
                <td class="text-center">${item.total_peserta ?? 0}</td>
                <td class="text-center">
                    <div class="d-flex justify-content-center gap-1">
                        <button type="button" class="btn btn-icon btn-light-success btn-sm" onclick="editDataSoth('${refId}')">
                            <i class="ki-outline ki-pencil fs-4"></i>
                        </button>
                        <button type="button" class="btn btn-icon btn-light-danger btn-sm" onclick="konfirmasiHapusSoth('${refId}')">
                            <i class="ki-outline ki-trash fs-4"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    });

    tbody.innerHTML = html;
    const from = res.from || 0;
    const to = res.to || 0;
    const total = res.total || 0;
    updatePaginationInfo(from, to, total, res.current_page, res.last_page);
}

function updatePaginationInfo(from, to, total, current, last) {
    const info = document.getElementById('soth_info_records');
    if (info) {
        info.textContent = `Showing ${from} to ${to} of ${total} records`;
    }

    const pag = document.getElementById('soth_pagination');
    if (!pag) return;

    if (last <= 1) {
        pag.innerHTML = '';
        return;
    }

    let pagHtml = '';

    // Tombol Sebelumnya (<)
    pagHtml += `
        <li class="page-item previous ${current <= 1 ? 'disabled' : ''}">
            <a class="page-link" href="javascript:void(0)" onclick="${current > 1 ? `fetchTableSoth(${current - 1})` : ''}">&lt;</a>
        </li>
    `;

    // Tombol Angka Halaman (1, 2, 3, dst)
    for (let i = 1; i <= last; i++) {
        pagHtml += `
            <li class="page-item ${i === current ? 'active' : ''}">
                <a class="page-link" href="javascript:void(0)" onclick="fetchTableSoth(${i})">${i}</a>
            </li>
        `;
    }

    // Tombol Selanjutnya (>)
    pagHtml += `
        <li class="page-item next ${current >= last ? 'disabled' : ''}">
            <a class="page-link" href="javascript:void(0)" onclick="${current < last ? `fetchTableSoth(${current + 1})` : ''}">&gt;</a>
        </li>
    `;

    pag.innerHTML = pagHtml;
}

function bukaModalTambahSoth() {
    document.getElementById('form_modal_soth').reset();
    document.getElementById('soth_form_id').value = '';
    document.getElementById('modalFormSothTitle').textContent = 'Input Data SOTH';
    if (!sothModal) {
        sothModal = new bootstrap.Modal(document.getElementById('modalFormSoth'));
    }
    sothModal.show();
}

function editDataSoth(hash) {
    const showUrl = window.ROUTES_SOTH?.show || '/inovasi/soth/show';
    fetch(`${showUrl}/${encodeURIComponent(hash)}`, {
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(res => res.json())
    .then(res => {
        const d = res.data;
        document.getElementById('soth_form_id').value = d.hash || d.id;
        document.getElementById('soth_form_nama').value = d.nama;
        document.getElementById('soth_form_alamat').value = d.alamat;
        document.getElementById('soth_form_rt').value = d.rt;
        document.getElementById('soth_form_rw').value = d.rw || '';
        document.getElementById('soth_form_kelurahan').value = d.kelurahan;
        document.getElementById('soth_form_kecamatan').value = d.kecamatan;
        document.getElementById('soth_form_pre').value = d.rata_pre ?? d.rata_rata_pre;
        document.getElementById('soth_form_post').value = d.rata_post ?? d.rata_rata_post;
        document.getElementById('soth_form_total').value = d.total_peserta;

        document.getElementById('modalFormSothTitle').textContent = 'Edit Data SOTH';
        if (!sothModal) {
            sothModal = new bootstrap.Modal(document.getElementById('modalFormSoth'));
        }
        sothModal.show();
    })
    .catch(() => alert('Gagal memuat detail data.'));
}

function handleFormSothSubmit(e) {
    e.preventDefault();

    const hash = document.getElementById('soth_form_id').value;
    const isEdit = Boolean(hash);
    const token = window.ROUTES_SOTH?.csrfToken || document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    const payload = {
        nama: document.getElementById('soth_form_nama').value,
        alamat: document.getElementById('soth_form_alamat').value,
        rt: document.getElementById('soth_form_rt').value,
        rw: document.getElementById('soth_form_rw').value,
        kelurahan: document.getElementById('soth_form_kelurahan').value,
        kecamatan: document.getElementById('soth_form_kecamatan').value,
        rata_pre: document.getElementById('soth_form_pre').value,
        rata_post: document.getElementById('soth_form_post').value,
        total_peserta: document.getElementById('soth_form_total').value,
        _token: token
    };

    const updateUrl = window.ROUTES_SOTH?.update || '/inovasi/soth/update';
    const storeUrl = window.ROUTES_SOTH?.store || '/inovasi/soth/store';
    const targetUrl = isEdit ? `${updateUrl}/${encodeURIComponent(hash)}` : storeUrl;
    const btn = document.getElementById('btn_submit_soth');
    btn.disabled = true;

    fetch(targetUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify(payload)
    })
    .then(async res => {
        const data = await res.json();
        if (!res.ok) throw new Error(data.message || 'Terjadi kesalahan saat menyimpan');
        return data;
    })
    .then(res => {
        if (sothModal) sothModal.hide();
        fetchTableSoth(sothCurrentPage);
        fetchChartSoth();
        
        tampilkanPopUpSoth(
            'Sukses', 
            isEdit ? 'Data Inovasi SOTH berhasil diperbarui!' : 'Data Inovasi SOTH berhasil ditambahkan!'
        );
    })
    .catch(err => {
        alert(err.message || 'Gagal menyimpan data');
    })
    .finally(() => {
        btn.disabled = false;
    });
}

function konfirmasiHapusSoth(hash) {
    if (!hash) return;
    targetHashHapusSoth = hash;
    const modalEl = document.getElementById('modalKonfirmasiHapusSoth');
    if (!sothModalHapus && modalEl) {
        sothModalHapus = new bootstrap.Modal(modalEl);
    }
    if (sothModalHapus) sothModalHapus.show();
}

document.getElementById('btnProsesHapusSoth')?.addEventListener('click', function() {
    if (!targetHashHapusSoth) return;

    const btn = document.getElementById('btnProsesHapusSoth');
    const spinner = document.getElementById('btnHapusSothSpinner');
    const btnText = document.getElementById('btnHapusSothText');
    const token = window.ROUTES_SOTH?.csrfToken || document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    btn.disabled = true;
    spinner.classList.remove('d-none');
    btnText.textContent = 'Menghapus...';

    const destroyUrl = window.ROUTES_SOTH?.destroy || '/inovasi/soth/destroy';
    fetch(`${destroyUrl}/${encodeURIComponent(targetHashHapusSoth)}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            _token: token,
            _method: 'DELETE'
        })
    })
    .then(async (res) => {
        if (!res.ok) {
            const err = await res.json();
            throw new Error(err.message || 'Gagal menghapus data.');
        }
        return res.json();
    })
    .then(() => {
        if (sothModalHapus) sothModalHapus.hide();

        targetHashHapusSoth = null;
        fetchTableSoth(sothCurrentPage);
        fetchChartSoth();

        tampilkanPopUpSoth('Sukses', 'Data Inovasi SOTH berhasil dihapus!');
    })
    .catch(err => {
        alert(err.message || 'Terjadi kesalahan saat menghapus data.');
    })
    .finally(() => {
        btn.disabled = false;
        spinner.classList.add('d-none');
        btnText.textContent = 'Ya, Hapus';
    });
});

    
let chartKampungAsiInstance = null;
let kampungAsiCurrentPage = 1;
let kampungAsiPageSize = 10;
let kampungAsiTotalPages = 1;
let kampungAsiSearchQuery = '';
let kampungAsiSearchTimer = null;

function initKampungAsi() {
    setTimeout(() => {
        renderGrafikKampungAsi();
        fetchTableKampungAsi(1);
    }, 150);
}

function filterKampungAsiKecamatanTop() {
    const val = document.getElementById('filter_kampung_asi_kecamatan_top')?.value || 'all';
    
    if (val === 'all') {
        renderGrafikKampungAsi();
    } else {
        renderGrafikKampungAsi([val], [0]);
    }

    fetchTableKampungAsi(1);
}

function renderGrafikKampungAsi(customLabels = null, customData = null) {
    const canvas = document.getElementById('chartKampungAsiPersentase');
    if (!canvas || typeof Chart === 'undefined') return;

    const labels = customLabels || listKecamatanKampungAsi;
    const dataValues = customData || new Array(labels.length).fill(0);
    const isMobile = window.innerWidth < 768;

    if (chartKampungAsiInstance) {
        chartKampungAsiInstance.destroy();
    }

    const ctx = canvas.getContext('2d');
    chartKampungAsiInstance = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Presentase Kampung ASI',
                data: dataValues,
                borderColor: '#38bdf8',
                backgroundColor: 'rgba(56, 189, 248, 0.12)',
                borderWidth: 2,
                borderDash: [4, 4],
                fill: false,
                tension: 0,
                pointRadius: isMobile ? 2 : 3,
                pointHoverRadius: 6,
                pointBackgroundColor: '#38bdf8'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: (ctx) => ` Presentase: ${ctx.parsed.y}%`
                    }
                }
            },
            scales: {
                y: {
                    min: 0,
                    max: 100,
                    ticks: {
                        stepSize: 10,
                        callback: (v) => v + '%',
                        color: '#64748b',
                        font: { size: isMobile ? 9 : 10 }
                    },
                    grid: { color: '#f1f5f9' }
                },
                x: {
                    ticks: {
                        color: '#64748b',
                        font: { size: isMobile ? 7.5 : 8.5 },
                        maxRotation: isMobile ? 70 : 45,
                        minRotation: isMobile ? 70 : 45
                    },
                    grid: { color: '#f8fafc' }
                }
            }
        }
    });

    chartKampungAsiInstance.resize();
}

function fetchTableKampungAsi(page = 1) {
    kampungAsiCurrentPage = page;
    const tbody = document.getElementById('tabel_kampung_asi_body');
    const infoRecords = document.getElementById('kampung_asi_info_records');
    if (!tbody) return;

    tbody.innerHTML = `<tr><td colspan="9" class="text-center py-6 text-gray-500"><span class="spinner-border spinner-border-sm me-2"></span>Memuat data...</td></tr>`;

    const kec = document.getElementById('filter_kampung_asi_kecamatan_top')?.value || 'all';
    const baseUrl = window.API_ROUTES?.kampungAsi || '/inovasi-kota/api/kampung-asi/data';
    const params = new URLSearchParams({
        page: page,
        limit: kampungAsiPageSize,
        kecamatan: kec,
        search: kampungAsiSearchQuery
    });

    fetch(`${baseUrl}?${params.toString()}`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => {
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        return res.json();
    })
    .then(data => {
        renderTableKampungAsi(data);
    })
    .catch(() => {
        renderTableKampungAsi({
            total: 0,
            current_page: 1,
            per_page: kampungAsiPageSize,
            last_page: 1,
            data: []
        });
    });
}

function renderTableKampungAsi(res) {
    const tbody = document.getElementById('tabel_kampung_asi_body');
    const infoRecords = document.getElementById('kampung_asi_info_records');
    const paginationEl = document.getElementById('kampung_asi_pagination');
    if (!tbody) return;

    tbody.innerHTML = '';
    const total = res.total || 0;
    const currentPage = res.current_page || 1;
    const perPage = res.per_page || kampungAsiPageSize;
    kampungAsiTotalPages = res.last_page || 1;

    if (!res.data || res.data.length === 0 || total === 0) {
        tbody.innerHTML = `<tr><td colspan="9" class="text-center py-6 text-gray-400">Data tidak ditemukan</td></tr>`;
        if (infoRecords) infoRecords.textContent = 'Menampilkan 0 sampai 0 dari 0 data';
        if (paginationEl) paginationEl.innerHTML = '';
        return;
    }

    res.data.forEach((row, idx) => {
        const no = (currentPage - 1) * perPage + (idx + 1);
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td class="text-center text-gray-600">${no}</td>
            <td class="text-gray-800">${row.kecamatan || '-'}</td>
            <td class="text-gray-800">${row.kelurahan || '-'}</td>
            <td class="text-gray-800">${row.nama_kampung_asi || '-'}</td>
            <td class="text-center text-gray-800">${row.jumlah_kader ?? row.kader ?? 0}</td>
            <td class="text-center text-gray-800">${row.jumlah_toga ?? row.toga ?? 0}</td>
            <td class="text-center text-gray-800">${row.ibu_hamil ?? row.bumil ?? 0}</td>
            <td class="text-center text-gray-800">${row.ibu_menyusui ?? row.menyusui ?? 0}</td>
            <td class="text-center text-gray-800">${row.persentase ? row.persentase + (String(row.persentase).includes('%') ? '' : '%') : '0%'}</td>
        `;
        tbody.appendChild(tr);
    });

    const start = (currentPage - 1) * perPage + 1;
    const end = Math.min(currentPage * perPage, total);
    if (infoRecords) {
        infoRecords.textContent = `Menampilkan ${start} sampai ${end} dari ${total} data`;
    }

    renderPaginationKampungAsi(currentPage, kampungAsiTotalPages);
}

function renderPaginationKampungAsi(currentPage, totalPages) {
    const el = document.getElementById('kampung_asi_pagination');
    if (!el || totalPages <= 1) {
        if (el) el.innerHTML = '';
        return;
    }
    el.innerHTML = '';

    const prevLi = document.createElement('li');
    prevLi.className = `page-item previous ${currentPage === 1 ? 'disabled' : ''}`;
    prevLi.innerHTML = `<a class="page-link" href="javascript:void(0)">&lt;</a>`;
    if (currentPage > 1) {
        prevLi.addEventListener('click', () => fetchTableKampungAsi(currentPage - 1));
    }
    el.appendChild(prevLi);

    let startPage = Math.max(1, currentPage - 2);
    let endPage = Math.min(totalPages, currentPage + 2);

    for (let p = startPage; p <= endPage; p++) {
        const li = document.createElement('li');
        li.className = `page-item ${p === currentPage ? 'active' : ''}`;
        li.innerHTML = `<a class="page-link" href="javascript:void(0)">${p}</a>`;
        if (p !== currentPage) {
            li.addEventListener('click', () => fetchTableKampungAsi(p));
        }
        el.appendChild(li);
    }

    const nextLi = document.createElement('li');
    nextLi.className = `page-item next ${currentPage === totalPages ? 'disabled' : ''}`;
    nextLi.innerHTML = `<a class="page-link" href="javascript:void(0)">&gt;</a>`;
    if (currentPage < totalPages) {
        nextLi.addEventListener('click', () => fetchTableKampungAsi(currentPage + 1));
    }
    el.appendChild(nextLi);
}

function changeKampungAsiPageSize() {
    const sizeSelect = document.getElementById('kampung_asi_page_size');
    if (sizeSelect) {
        kampungAsiPageSize = parseInt(sizeSelect.value, 10);
    }
    fetchTableKampungAsi(1);
}

function searchKampungAsiTable() {
    clearTimeout(kampungAsiSearchTimer);
    kampungAsiSearchTimer = setTimeout(() => {
        const input = document.getElementById('kampung_asi_search');
        kampungAsiSearchQuery = input ? input.value.trim() : '';
        fetchTableKampungAsi(1);
    }, 400);
}

function submitFormKampungAsi(e) {
    e.preventDefault();
    const form = e.target;
    const btn = document.getElementById('btnSimpanKampungAsi');
    const label = btn.querySelector('.indicator-label');
    const progress = btn.querySelector('.indicator-progress');

    label.classList.add('d-none');
    progress.classList.remove('d-none');
    btn.disabled = true;

    const formData = new FormData(form);
    const postUrl = window.API_ROUTES?.kampungAsiStore || '/inovasi-kota/api/kampung-asi/store';

    fetch(postUrl, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(res => res.json())
    .then(() => {
        const modalEl = document.getElementById('modalTambahKampungAsi');
        const modalInstance = bootstrap.Modal.getInstance(modalEl);
        if (modalInstance) modalInstance.hide();
        form.reset();
        fetchTableKampungAsi(1);
    })
    .catch(err => {
        console.error("Gagal menyimpan data:", err);
    })
    .finally(() => {
        label.classList.remove('d-none');
        progress.classList.add('d-none');
        btn.disabled = false;
    });
}

window.addEventListener('resize', () => {
    if (chartKampungAsiInstance) {
        const isMobile = window.innerWidth < 768;
        chartKampungAsiInstance.options.scales.x.ticks.maxRotation = isMobile ? 70 : 45;
        chartKampungAsiInstance.options.scales.x.ticks.minRotation = isMobile ? 70 : 45;
        chartKampungAsiInstance.resize();
    }
});

const listKecamatanSurabayaEmas = [
    'ASEMROWO', 'BENOWO', 'BUBUTAN', 'BULAK', 'DUKUH PAKIS', 'GAYUNGAN', 'GENTENG',
    'GUBENG', 'GUNUNG ANYAR', 'JAMBANGAN', 'KARANG PILANG', 'KENJERAN', 'KREMBANGAN',
    'LAKAR SANTRI', 'MULYOREJO', 'PABEAN CANTIAN', 'PAKAL', 'RUNGKUT',
    'SAMBI KEREP', 'SAWAHAN', 'SEMAMPIR', 'SIMOKERTO', 'SUKOLILO',
    'SUKOMANUNGGAL', 'TAMBAKSARI', 'TANDES', 'TEGALSARI', 'TENGGILIS MEJOYO',
    'WIYUNG', 'WONOCOLO', 'WONOKROMO'
];

const kelurahanPerKecamatanDummy = {
    'ASEMROWO': ['Asem Rowo', 'Genting Kalianak', 'Tambak Sarioso'],
    'BENOWO': ['Sememi', 'Tambak Osowilangon', 'Romokalisari', 'Kandangan'],
    'BUBUTAN': ['Bubutan', 'Alun-Alun Contong', 'Gundih', 'Jepara', 'Tembok Dukuh'],
    'RUNGKUT': ['Kali Rungkut', 'Rungkut Kidul', 'Rungkut Tengah', 'Kedung Baruk', 'Wonorejo']
};

const masterBalitaSurabayaEmasDummy = [
    { nik: '3578012304210001', nama: 'MUHAMMAD AL FATIH', tgl_lahir: '12-04-2024', jk: 'Laki-laki', alamat: 'Jl. Asem Rowo No. 12', kelurahan: 'Asem Rowo', kecamatan: 'ASEMROWO', tpk: 'TPK 01', tahun: '2026' },
    { nik: '3578021405220002', nama: 'AISYAH AQILA PUTRI', tgl_lahir: '14-05-2024', jk: 'Perempuan', alamat: 'Jl. Sememi Jaya V No. 8', kelurahan: 'Sememi', kecamatan: 'BENOWO', tpk: 'TPK 03', tahun: '2026' },
    { nik: '3578031109200003', nama: 'KENZO ARKANANTA', tgl_lahir: '11-09-2023', jk: 'Laki-laki', alamat: 'Jl. Gundih Timur No. 4', kelurahan: 'Gundih', kecamatan: 'BUBUTAN', tpk: 'TPK 02', tahun: '2025' },
    { nik: '3578042512210004', nama: 'ZAHRA SHANUM', tgl_lahir: '25-12-2024', jk: 'Perempuan', alamat: 'Jl. Rungkut Tengah No. 15', kelurahan: 'Rungkut Tengah', kecamatan: 'RUNGKUT', tpk: 'TPK 05', tahun: '2026' },
    { nik: '3578051701220005', nama: 'RAYYAN ALFARIZI', tgl_lahir: '17-01-2024', jk: 'Laki-laki', alamat: 'Jl. Genteng Kali No. 22', kelurahan: 'Genteng', kecamatan: 'GENTENG', tpk: 'TPK 01', tahun: '2026' }
];

const riwayatTimbangPerBalita = {
    '3578012304210001': [
        { no: 1, tgl: '12-01-2026', tb: '74 cm', bb: '9.2 kg', lila: '14.5 cm', tbu: 'Normal', bbu: 'Normal', bbtb: 'Normal', gizi: 'Baik' },
        { no: 2, tgl: '14-02-2026', tb: '75.2 cm', bb: '9.5 kg', lila: '14.7 cm', tbu: 'Normal', bbu: 'Normal', bbtb: 'Normal', gizi: 'Baik' },
        { no: 3, tgl: '16-03-2026', tb: '76.0 cm', bb: '9.7 kg', lila: '14.8 cm', tbu: 'Normal', bbu: 'Normal', bbtb: 'Normal', gizi: 'Baik' },
        { no: 4, tgl: '15-04-2026', tb: '77.1 cm', bb: '10.1 kg', lila: '15.0 cm', tbu: 'Normal', bbu: 'Normal', bbtb: 'Normal', gizi: 'Baik' },
        { no: 5, tgl: '18-05-2026', tb: '78.0 cm', bb: '10.4 kg', lila: '15.2 cm', tbu: 'Normal', bbu: 'Normal', bbtb: 'Normal', gizi: 'Baik' }
    ]
};

let chartSurabayaEmasInstance = null;
let chartDetailBalitaInstance = null;
let surabayaEmasCurrentPage = 1;
let surabayaEmasPageSize = 10;
let surabayaEmasTotalPages = 1;
let surabayaEmasSearchQuery = '';
let surabayaEmasSearchTimer = null;

function initSurabayaEmas() {
    setTimeout(() => {
        renderGrafikSurabayaEmas(null, new Array(listKecamatanSurabayaEmas.length).fill(0));
        fetchTableSurabayaEmas(1);
    }, 150);
}

function handleSurabayaEmasKecamatanChange() {
    const kec = document.getElementById('filter_surabaya_emas_kecamatan')?.value || '';
    const selKel = document.getElementById('filter_surabaya_emas_kelurahan');
    if (!selKel) return;

    selKel.innerHTML = '<option value="all" selected>Semua</option>';
    if (kec && kelurahanPerKecamatanDummy[kec]) {
        kelurahanPerKecamatanDummy[kec].forEach(kel => {
            const opt = document.createElement('option');
            opt.value = kel;
            opt.textContent = kel;
            selKel.appendChild(opt);
        });
    }
}

function terapkanFilterSurabayaEmas() {
    const kec = document.getElementById('filter_surabaya_emas_kecamatan')?.value || 'all';

    if (kec === 'all' || !kec) {
        renderGrafikSurabayaEmas(null, new Array(listKecamatanSurabayaEmas.length).fill(0));
    } else {
        const dummyVal = [75, 82, 68, 90, 85, 78, 92, 88][Math.floor(Math.random() * 8)];
        renderGrafikSurabayaEmas([kec], [dummyVal]);
    }

    fetchTableSurabayaEmas(1);
}

function resetFilterSurabayaEmas() {
    const selKec = document.getElementById('filter_surabaya_emas_kecamatan');
    const selKel = document.getElementById('filter_surabaya_emas_kelurahan');
    const selThn = document.getElementById('filter_surabaya_emas_tahun');
    const searchInput = document.getElementById('surabaya_emas_search');

    if (selKec) selKec.value = 'all';
    if (selKel) selKel.innerHTML = '<option value="all" selected>Semua</option>';
    if (selThn) selThn.value = 'all';
    if (searchInput) searchInput.value = '';

    surabayaEmasSearchQuery = '';
    renderGrafikSurabayaEmas(null, new Array(listKecamatanSurabayaEmas.length).fill(0));
    fetchTableSurabayaEmas(1);
}

function renderGrafikSurabayaEmas(customLabels = null, customData = null) {
    const canvas = document.getElementById('chartSurabayaEmas');
    if (!canvas || typeof Chart === 'undefined') return;

    const labels = customLabels || listKecamatanSurabayaEmas;
    const dataValues = customData || new Array(labels.length).fill(0);
    const isMobile = window.innerWidth < 768;

    if (chartSurabayaEmasInstance) {
        chartSurabayaEmasInstance.destroy();
    }

    const ctx = canvas.getContext('2d');
    chartSurabayaEmasInstance = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Presentase Surabaya Emas',
                data: dataValues,
                borderColor: '#38bdf8',
                backgroundColor: 'rgba(56, 189, 248, 0.12)',
                borderWidth: 2,
                borderDash: [4, 4],
                fill: false,
                tension: 0.3,
                pointRadius: isMobile ? 2 : 3,
                pointHoverRadius: 6,
                pointBackgroundColor: '#38bdf8'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: (ctx) => ` Presentase: ${ctx.parsed.y}%`
                    }
                }
            },
            scales: {
                y: {
                    min: 0,
                    max: 100,
                    ticks: {
                        stepSize: 10,
                        callback: (v) => v + '%',
                        color: '#64748b',
                        font: { size: isMobile ? 9 : 10 }
                    },
                    grid: { color: '#f1f5f9' }
                },
                x: {
                    ticks: {
                        color: '#64748b',
                        font: { size: isMobile ? 7.5 : 8.5 },
                        maxRotation: isMobile ? 70 : 45,
                        minRotation: isMobile ? 70 : 45
                    },
                    grid: { color: '#f8fafc' }
                }
            }
        }
    });

    chartSurabayaEmasInstance.resize();
}

function fetchTableSurabayaEmas(page = 1) {
    surabayaEmasCurrentPage = page;
    const tbody = document.getElementById('tabel_surabaya_emas_body');
    if (!tbody) return;

    tbody.innerHTML = `<tr><td colspan="10" class="text-center py-6 text-gray-500"><span class="spinner-border spinner-border-sm me-2"></span>Memuat data...</td></tr>`;

    const kec = document.getElementById('filter_surabaya_emas_kecamatan')?.value || 'all';
    const kel = document.getElementById('filter_surabaya_emas_kelurahan')?.value || 'all';
    const tahun = document.getElementById('filter_surabaya_emas_tahun')?.value || 'all';

    const baseUrl = window.API_ROUTES?.surabayaEmas || '/inovasi-kota/api/surabaya-emas/data';
    const params = new URLSearchParams({
        page: page,
        limit: surabayaEmasPageSize,
        kecamatan: kec,
        kelurahan: kel,
        tahun: tahun,
        search: surabayaEmasSearchQuery
    });

    fetch(`${baseUrl}?${params.toString()}`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => {
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        return res.json();
    })
    .then(data => {
        renderTableSurabayaEmas(data);
    })
    .catch(() => {
        let filtered = masterBalitaSurabayaEmasDummy.filter(item => {
            const matchKec = (kec === 'all' || !kec) || (item.kecamatan.toUpperCase() === kec.toUpperCase());
            const matchKel = (kel === 'all' || !kel) || (item.kelurahan.toUpperCase() === kel.toUpperCase());
            const matchThn = (tahun === 'all' || !tahun) || (item.tahun === tahun);
            const query = surabayaEmasSearchQuery.toLowerCase();
            const matchSearch = !query || 
                item.nama.toLowerCase().includes(query) || 
                item.nik.includes(query) ||
                item.alamat.toLowerCase().includes(query);

            return matchKec && matchKel && matchThn && matchSearch;
        });

        renderTableSurabayaEmas({
            total: filtered.length,
            current_page: 1,
            per_page: surabayaEmasPageSize,
            last_page: Math.ceil(filtered.length / surabayaEmasPageSize) || 1,
            data: filtered.slice(0, surabayaEmasPageSize)
        });
    });
}

function renderTableSurabayaEmas(res) {
    const tbody = document.getElementById('tabel_surabaya_emas_body');
    const infoRecords = document.getElementById('surabaya_emas_info_records');
    const paginationEl = document.getElementById('surabaya_emas_pagination');
    if (!tbody) return;

    tbody.innerHTML = '';
    const total = res.total || 0;
    const currentPage = res.current_page || 1;
    const perPage = res.per_page || surabayaEmasPageSize;
    surabayaEmasTotalPages = res.last_page || 1;

    if (!res.data || res.data.length === 0 || total === 0) {
        tbody.innerHTML = `<tr><td colspan="10" class="text-center py-6 text-gray-400">Data tidak ditemukan</td></tr>`;
        if (infoRecords) infoRecords.textContent = 'Menampilkan 0 sampai 0 dari 0 data';
        if (paginationEl) paginationEl.innerHTML = '';
        return;
    }

    res.data.forEach((row, idx) => {
        const no = (currentPage - 1) * perPage + (idx + 1);
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td class="text-center text-gray-600">${no}</td>
            <td class="fw-bold text-gray-800">${row.nama}</td>
            <td class="text-gray-700">${row.tgl_lahir}</td>
            <td class="text-center text-gray-700">${row.jk}</td>
            <td class="text-gray-700">${row.alamat}</td>
            <td class="text-gray-700">${row.kelurahan}</td>
            <td class="text-gray-700">${row.kecamatan}</td>
            <td class="text-center text-gray-700">${row.tpk}</td>
            <td class="text-center text-gray-700">${row.tahun}</td>
            <td class="text-center">
                <button type="button" class="btn btn-sm btn-icon btn-light-primary" onclick="bukaModalDetailBalita('${row.nik}', '${row.nama}')" title="Detail Balita">
                    <i class="ki-duotone ki-eye fs-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                </button>
            </td>
        `;
        tbody.appendChild(tr);
    });

    const start = (currentPage - 1) * perPage + 1;
    const end = Math.min(currentPage * perPage, total);
    if (infoRecords) {
        infoRecords.textContent = `Menampilkan ${start} sampai ${end} dari ${total} data`;
    }

    renderPaginationSurabayaEmas(currentPage, surabayaEmasTotalPages);
}

function renderPaginationSurabayaEmas(currentPage, totalPages) {
    const el = document.getElementById('surabaya_emas_pagination');
    if (!el || totalPages <= 1) {
        if (el) el.innerHTML = '';
        return;
    }
    el.innerHTML = '';

    const prevLi = document.createElement('li');
    prevLi.className = `page-item previous ${currentPage === 1 ? 'disabled' : ''}`;
    prevLi.innerHTML = `<a class="page-link" href="javascript:void(0)">&lt;</a>`;
    if (currentPage > 1) {
        prevLi.addEventListener('click', () => fetchTableSurabayaEmas(currentPage - 1));
    }
    el.appendChild(prevLi);

    let startPage = Math.max(1, currentPage - 2);
    let endPage = Math.min(totalPages, currentPage + 2);

    for (let p = startPage; p <= endPage; p++) {
        const li = document.createElement('li');
        li.className = `page-item ${p === currentPage ? 'active' : ''}`;
        li.innerHTML = `<a class="page-link" href="javascript:void(0)">${p}</a>`;
        if (p !== currentPage) {
            li.addEventListener('click', () => fetchTableSurabayaEmas(p));
        }
        el.appendChild(li);
    }

    const nextLi = document.createElement('li');
    nextLi.className = `page-item next ${currentPage === totalPages ? 'disabled' : ''}`;
    nextLi.innerHTML = `<a class="page-link" href="javascript:void(0)">&gt;</a>`;
    if (currentPage < totalPages) {
        nextLi.addEventListener('click', () => fetchTableSurabayaEmas(currentPage + 1));
    }
    el.appendChild(nextLi);
}

function changeSurabayaEmasPageSize() {
    const sizeSelect = document.getElementById('surabaya_emas_page_size');
    if (sizeSelect) {
        surabayaEmasPageSize = parseInt(sizeSelect.value, 10);
    }
    fetchTableSurabayaEmas(1);
}

function searchSurabayaEmasTable() {
    clearTimeout(surabayaEmasSearchTimer);
    surabayaEmasSearchTimer = setTimeout(() => {
        const input = document.getElementById('surabaya_emas_search');
        surabayaEmasSearchQuery = input ? input.value.trim() : '';
        fetchTableSurabayaEmas(1);
    }, 400);
}

function bukaModalDetailBalita(nik, nama) {
    document.getElementById('detail_balita_nik').textContent = nik;
    document.getElementById('detail_balita_nama').textContent = nama;

    const tbody = document.getElementById('tabel_detail_balita_body');
    const dataRiwayat = riwayatTimbangPerBalita[nik] || riwayatTimbangPerBalita['3578012304210001'];
    
    if (tbody) {
        tbody.innerHTML = '';
        dataRiwayat.forEach(item => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="text-gray-500">${item.no}</td>
                <td>${item.tgl}</td>
                <td>${item.tb}</td>
                <td>${item.bb}</td>
                <td>${item.lila}</td>
                <td>${item.tbu}</td>
                <td>${item.bbu}</td>
                <td>${item.bbtb}</td>
                <td><span class="badge badge-light-success fw-bold">${item.gizi}</span></td>
            `;
            tbody.appendChild(tr);
        });
    }

    const modalEl = document.getElementById('modalDetailBalita');
    const modalInstance = new bootstrap.Modal(modalEl);
    modalInstance.show();

    modalEl.addEventListener('shown.bs.modal', function () {
        renderGrafikDetailBalita();
    }, { once: true });
}

function renderGrafikDetailBalita() {
    const canvas = document.getElementById('chartDetailRiwayatBalita');
    if (!canvas || typeof Chart === 'undefined') return;

    if (chartDetailBalitaInstance) {
        chartDetailBalitaInstance.destroy();
    }

    const ctx = canvas.getContext('2d');
    chartDetailBalitaInstance = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Berat Badan (kg)',
                data: [8.5, 8.8, 9.2, 9.5, 9.7, 10.1, 10.4, 10.6, 10.9, 11.2, 11.4, 11.7],
                borderColor: '#38bdf8',
                backgroundColor: 'rgba(56, 189, 248, 0.1)',
                borderWidth: 2,
                fill: false,
                tension: 0.25,
                pointRadius: 3,
                pointHoverRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    min: 6,
                    max: 14,
                    ticks: {
                        stepSize: 2,
                        callback: (v) => v + ' kg',
                        font: { size: 9 },
                        color: '#64748b'
                    },
                    grid: { color: '#f1f5f9' }
                },
                x: {
                    ticks: { font: { size: 9 }, color: '#64748b' },
                    grid: { display: false }
                }
            }
        }
    });

    chartDetailBalitaInstance.resize();
}

window.addEventListener('resize', () => {
    if (chartSurabayaEmasInstance) {
        const isMobile = window.innerWidth < 768;
        chartSurabayaEmasInstance.options.scales.x.ticks.maxRotation = isMobile ? 70 : 45;
        chartSurabayaEmasInstance.options.scales.x.ticks.minRotation = isMobile ? 70 : 45;
        chartSurabayaEmasInstance.resize();
    }
});

// Window Exports
window.populateInovasiOptions = populateInovasiOptions;
window.handlePokjaChange = handlePokjaChange;
window.handleInovasiChange = handleInovasiChange;
window.updateElearningTimestamp = updateElearningTimestamp;
window.initSothModule = initSothModule;
window.initChartSoth = initChartSoth;
window.fetchChartSoth = fetchChartSoth;
window.filterSothKecamatan = filterSothKecamatan;
window.fetchTableSoth = fetchTableSoth;
window.changeSothPageSize = changeSothPageSize;
window.bukaModalTambahSoth = bukaModalTambahSoth;
window.editDataSoth = editDataSoth;
window.handleFormSothSubmit = handleFormSothSubmit;
window.konfirmasiHapusSoth = konfirmasiHapusSoth;
window.initKampungAsi = initKampungAsi;
window.filterKampungAsiKecamatanTop = filterKampungAsiKecamatanTop;
window.renderGrafikKampungAsi = renderGrafikKampungAsi;
window.fetchTableKampungAsi = fetchTableKampungAsi;
window.changeKampungAsiPageSize = changeKampungAsiPageSize;
window.searchKampungAsiTable = searchKampungAsiTable;
window.submitFormKampungAsi = submitFormKampungAsi;
window.initSurabayaEmas = initSurabayaEmas;
window.handleSurabayaEmasKecamatanChange = handleSurabayaEmasKecamatanChange;
window.terapkanFilterSurabayaEmas = terapkanFilterSurabayaEmas;
window.resetFilterSurabayaEmas = resetFilterSurabayaEmas;
window.changeSurabayaEmasPageSize = changeSurabayaEmasPageSize;
window.searchSurabayaEmasTable = searchSurabayaEmasTable;
window.bukaModalDetailBalita = bukaModalDetailBalita;

$(document).ready(function() {
    handlePokjaChange();

    $('#select-filter-pokja').on('change select2:select', function() {
        handlePokjaChange();
    });

    $('#select-filter-inovasi').on('change select2:select', function() {
        handleInovasiChange();
    });
});