/**
 * Inovasi Kota Script
 * Mengelola navigasi dropdown Pokja & Inovasi, render chart (Kemanggi & E-Learning),
 * serta pop-up modal interaktif E-Learning PAAREDI.
 */

// 1. Data Inovasi Kota Berdasarkan Pokja
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

// 2. Data Wilayah & Kelurahan E-Learning PAAREDI
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

// 3. Variable Instance Chart & State Aktif
let chartElearningInstance = null;
let chartRemajaInstance = null;
let chartOrangTuaInstance = null;
let selectedKecamatanAktif = 'Genteng';

// =========================================================================
// LOGIKA FILTER POKJA & PILIH INOVASI
// =========================================================================
function populateInovasiOptions(selectedPokja = 'semua') {
    const inovasiSelect = document.getElementById('select-filter-inovasi');
    if (!inovasiSelect) {
        console.warn("Elemen #select-filter-inovasi tidak ditemukan di DOM!");
        return;
    }

    // Normalisasi input Pokja
    const pokjaKey = (selectedPokja || 'semua').toString().trim().toLowerCase();

    // 1. Kosongkan opsi lama
    inovasiSelect.innerHTML = '';

    // 2. Kasus khusus Sekretaris
    if (pokjaKey === 'sekretaris') {
        const opt = document.createElement('option');
        opt.value = 'empty-sekretaris';
        opt.textContent = 'Data Inovasi tidak ditemukan';
        opt.selected = true;
        opt.disabled = true;
        inovasiSelect.appendChild(opt);
        
        // Update Select2 jika Metronic menggunakannya
        if (window.jQuery && $(inovasiSelect).data('select2')) {
            $(inovasiSelect).trigger('change.select2');
        }
        return;
    }

    // 3. Tambahkan default placeholder
    const defaultOpt = document.createElement('option');
    defaultOpt.value = '';
    defaultOpt.textContent = 'Pilih salah satu inovasi...';
    defaultOpt.selected = true;
    defaultOpt.disabled = true;
    inovasiSelect.appendChild(defaultOpt);

    // 4. Filter daftar inovasi dengan aman
    const filtered = daftarInovasiKota.filter(item => {
        const itemPokja = (item.pokja || '').toString().trim().toLowerCase();
        if (itemPokja === 'sekretaris') return false;
        return pokjaKey === 'semua' || itemPokja === pokjaKey;
    });

    // 5. Masukkan opsi inovasi yang cocok
    filtered.forEach(item => {
        const opt = document.createElement('option');
        opt.value = item.key;
        opt.textContent = item.title;
        inovasiSelect.appendChild(opt);
    });

    // 6. WAJIB UNTUK METRONIC: Sinkronkan kembali UI Select2
    if (window.jQuery && $(inovasiSelect).data('select2')) {
        $(inovasiSelect).trigger('change.select2');
    }
}

function handlePokjaChange() {
    const selectedPokja = document.getElementById('select-filter-pokja').value;
    populateInovasiOptions(selectedPokja);
    resetDetailState();
}

function handleInovasiChange() {
    const inovasiSelect = document.getElementById('select-filter-inovasi');
    const selectedKey = inovasiSelect ? inovasiSelect.value : '';
    const emptyState = document.getElementById('state-placeholder-empty');
    const detailState = document.getElementById('state-detail-content');
    const subtitleBanner = document.getElementById('banner-subtitle-inovasi'); // 1. Tangkap elemen span banner

    // Sembunyikan semua inovasi terlebih dahulu
    document.querySelectorAll('.inovasi-item-view').forEach(el => el.classList.add('d-none'));

    if (selectedKey && selectedKey !== 'empty-sekretaris') {
        if (emptyState) emptyState.classList.add('d-none');
        if (detailState) detailState.classList.remove('d-none');

        // 2. Ambil teks nama inovasi dari dropdown dan pasang ke banner
        if (subtitleBanner && inovasiSelect.selectedIndex >= 0) {
            const selectedText = inovasiSelect.options[inovasiSelect.selectedIndex].text;
            subtitleBanner.textContent = `Data Inovasi ${selectedText}`;
        }

        const activeContent = document.getElementById('content-' + selectedKey);
        if (activeContent) {
            activeContent.classList.remove('d-none');

            // Render grafik Kemanggi
            if (selectedKey === 'kemanggi') {
                setTimeout(() => {
                    gambarGrafikKemanggi();
                }, 100);
            }

            // Render grafik E-Learning
            if (selectedKey === 'elearning-puspaga') {
                if (typeof updateElearningTimestamp === 'function') {
                    updateElearningTimestamp();
                }
                setTimeout(() => {
                    renderGrafikElearning();
                }, 120);
            }
        }
    } else {
        resetDetailState();
    }
}

function resetDetailState() {
    const emptyState = document.getElementById('state-placeholder-empty');
    const detailState = document.getElementById('state-detail-content');
    const subtitleBanner = document.getElementById('banner-subtitle-inovasi');

    // Kembalikan ke teks default
    if (subtitleBanner) {
        subtitleBanner.textContent = 'Data Inovasi Kota';
    }

    if (emptyState) emptyState.classList.remove('d-none');
    if (detailState) detailState.classList.add('d-none');
    document.querySelectorAll('.inovasi-item-view').forEach(el => el.classList.add('d-none'));
}

// =========================================================================
// GRAFIK KEMANGGI (DUAL LINE CHART: PRETEST & POSTTEST)
// =========================================================================
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

    // 1. Chart Remaja
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

    // 2. Chart Orang Tua
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

// =========================================================================
// GRAFIK & FILTER E-LEARNING PUSPAGA (BAR CHART & MODAL)
// =========================================================================
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

    // Plugin Render Angka di Atas Bar
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

// =========================================================================
// MODAL POP-UP HANDLERS
// =========================================================================
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

// Daftarkan ke window
window.populateInovasiOptions = populateInovasiOptions;
window.handlePokjaChange = handlePokjaChange;
window.handleInovasiChange = handleInovasiChange;
window.updateElearningTimestamp = updateElearningTimestamp;

// Jalankan otomatis dengan proteksi DOM ready
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