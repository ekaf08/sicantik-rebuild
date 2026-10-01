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
let chartSothInstance = null;
let sothCurrentPage = 1;
let sothPageSize = 10;
let sothTotalPages = 1;
let selectedKecamatanAktif = 'Genteng';

function populateInovasiOptions(selectedPokja = 'semua') {
    const inovasiSelect = document.getElementById('select-filter-inovasi');
    if (!inovasiSelect) {
        console.warn("Elemen #select-filter-inovasi tidak ditemukan di DOM!");
        return;
    }

    const pokjaKey = (selectedPokja || 'semua').toString().trim().toLowerCase();
    inovasiSelect.innerHTML = '';

    if (pokjaKey === 'sekretaris') {
        const opt = document.createElement('option');
        opt.value = 'empty-sekretaris';
        opt.textContent = 'Data Inovasi tidak ditemukan';
        opt.selected = true;
        opt.disabled = true;
        inovasiSelect.appendChild(opt);
        
        if (window.jQuery && $(inovasiSelect).data('select2')) {$(inovasiSelect).trigger('change.select2');
        }
        return;
    }

    const defaultOpt = document.createElement('option');
    defaultOpt.value = '';
    defaultOpt.textContent = 'Pilih salah satu inovasi...';
    defaultOpt.selected = true;
    defaultOpt.disabled = true;
    inovasiSelect.appendChild(defaultOpt);

    const filtered = daftarInovasiKota.filter(item => {
        const itemPokja = (item.pokja || '').toString().trim().toLowerCase();
        if (itemPokja === 'sekretaris') return false;
        return pokjaKey === 'semua' || itemPokja === pokjaKey;
    });

    filtered.forEach(item => {
        const opt = document.createElement('option');
        opt.value = item.key;
        opt.textContent = item.title;
        inovasiSelect.appendChild(opt);
    });

    if (window.jQuery && $(inovasiSelect).data('select2')) {$(inovasiSelect).trigger('change.select2');
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
    const subtitleBanner = document.getElementById('banner-subtitle-inovasi');

    document.querySelectorAll('.inovasi-item-view').forEach(el => el.classList.add('d-none'));

    if (selectedKey && selectedKey !== 'empty-sekretaris') {
        if (emptyState) emptyState.classList.add('d-none');
        if (detailState) detailState.classList.remove('d-none');

        if (subtitleBanner && inovasiSelect.selectedIndex >= 0) {
            const selectedText = inovasiSelect.options[inovasiSelect.selectedIndex].text;
            subtitleBanner.textContent = `Data Inovasi ${selectedText}`;
        }

        const activeContent = document.getElementById('content-' + selectedKey);
        if (activeContent) {
            activeContent.classList.remove('d-none');

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
                    initSoth();
                }, 150);
            }

            if (selectedKey === 'kampung-asi') {
                setTimeout(() => {
                    if (typeof initKampungAsi === 'function') {
                        initKampungAsi();
                    }
                }, 150);
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

function initSoth() { 
    renderGrafikSoth();
    fetchTableSoth(1);
}

function filterSothKecamatan() {
    const filterEl = document.getElementById('filter_soth_kecamatan');
    const kec = filterEl ? filterEl.value : 'all';

    if (kec === 'all') {
        renderGrafikSoth();
    } else {
        renderGrafikSoth([kec], [45.20], [115.80]);
    }
    sothCurrentPage = 1;
    fetchTableSoth(1);
}

function renderGrafikSoth(customLabels = null, customPre = null, customPost = null) {
    const canvas = document.getElementById('chartSothNilai');
    if (!canvas || typeof Chart === 'undefined') return;

    const labels = customLabels || listKecamatanSoth;
    const dataPre = customPre || new Array(labels.length).fill(0);
    const dataPost = customPost || new Array(labels.length).fill(0);

    if (chartSothInstance) {
        chartSothInstance.destroy();
    }

    const sothLabelsPlugin = {
        id: 'sothLabelsPlugin',
        afterDatasetsDraw(chart) {
            const { ctx } = chart;
            chart.data.datasets.forEach((dataset, i) => {
                const meta = chart.getDatasetMeta(i);
                if (!meta || !meta.data) return;

                meta.data.forEach((point, index) => {
                    if (!point || isNaN(point.x) || isNaN(point.y)) return;
                    const val = dataset.data[index];
                    
                    if (val && Number(val) > 0) {
                        ctx.save();
                        ctx.fillStyle = i === 0 ? '#0284c7' : '#e11d48';
                        ctx.font = 'bold 9px sans-serif';
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'bottom';
                        ctx.fillText(Number(val).toFixed(2), point.x, point.y - 4);
                        ctx.restore();
                    }
                });
            });
        }
    };

    chartSothInstance = new Chart(canvas.getContext('2d'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Pretest',
                    data: dataPre,
                    borderColor: '#38bdf8',
                    backgroundColor: '#38bdf8',
                    borderWidth: 2,
                    tension: 0,
                    pointRadius: 2,
                    pointHoverRadius: 4
                },
                {
                    label: 'Posttest',
                    data: dataPost,
                    borderColor: '#fb7185',
                    backgroundColor: '#fb7185',
                    borderWidth: 2,
                    tension: 0,
                    pointRadius: 2,
                    pointHoverRadius: 4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: (ctx) => ` ${ctx.dataset.label}: ${ctx.parsed.y}`
                    }
                }
            },
            scales: {
                y: {
                    min: 0,
                    max: 160,
                    ticks: { stepSize: 20, color: '#64748b', font: { size: 10 } },
                    grid: { color: '#f1f5f9' }
                },
                x: {
                    ticks: { color: '#64748b', font: { size: 8.5 }, maxRotation: 45, minRotation: 45 },
                    grid: { display: false }
                }
            }
        },
        plugins: [sothLabelsPlugin]
    });

    chartSothInstance.resize();
}
function fetchTableSoth(page = 1) {
    sothCurrentPage = page;
    const filterEl = document.getElementById('filter_soth_kecamatan');
    const kec = filterEl ? filterEl.value : 'all';
    const tbody = document.getElementById('tabel_soth_body');
    if (!tbody) return;

    tbody.innerHTML = `<tr><td colspan="10" class="text-center py-8 text-gray-400">Memuat data...</td></tr>`;

    fetch(`/inovasi-kota/api/soth/data?page=${page}&limit=${sothPageSize}&kecamatan=${encodeURIComponent(kec)}`)
        .then(response => response.json())
        .then(res => {
            renderTableSoth(res);
        })
        .catch(err => {
            console.error(err);
            tbody.innerHTML = `<tr><td colspan="10" class="text-center py-8 text-danger">Gagal memuat data</td></tr>`;
        });
}

function renderTableSoth(res) {
    const tbody = document.getElementById('tabel_soth_body');
    const infoRecords = document.getElementById('soth_info_records');
    const paginationEl = document.getElementById('soth_pagination');
    if (!tbody) return;

    tbody.innerHTML = '';

    const total = res.total || 0;
    const currentPage = res.current_page || 1;
    const perPage = res.per_page || sothPageSize;
    sothTotalPages = res.last_page || 1;

    if (!res.data || res.data.length === 0 || total === 0) {
        tbody.innerHTML = `<tr><td colspan="10" class="text-center py-8 text-gray-400">Data tidak ditemukan</td></tr>`;
        if (infoRecords) infoRecords.textContent = 'Showing 0 to 0 of 0 records';
        if (paginationEl) paginationEl.innerHTML = '';
        return;
    }

    res.data.forEach((row, idx) => {
        const no = (currentPage - 1) * perPage + (idx + 1);
        const rowJson = encodeURIComponent(JSON.stringify(row));
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td class="text-center text-gray-400">${no}</td>
            <td class="fw-bold text-gray-800">${row.nama}</td>
            <td class="text-gray-600">${row.alamat}</td>
            <td class="text-center">${row.rt}</td>
            <td>${row.kelurahan}</td>
            <td>${row.kecamatan}</td>
            <td class="text-center fw-semibold">${row.rata_rata_pre}</td>
            <td class="text-center fw-semibold">${row.rata_rata_post}</td>
            <td class="text-center fw-bold text-dark">${row.total_peserta}</td>
            <td class="text-center">
                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm" onclick="bukaModalEditSoth('${rowJson}')">
                        <i class="ki-duotone ki-pencil fs-6"><span class="path1"></span><span class="path2"></span></i>
                    </button>
                    <button type="button" class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm" onclick="hapusDataSoth(${row.id})">
                        <i class="ki-duotone ki-trash fs-6"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                    </button>
                </div>
            </td>
        `;
        tbody.appendChild(tr);
    });

    const start = (currentPage - 1) * perPage + 1;
    const end = Math.min(currentPage * perPage, total);
    if (infoRecords) {
        infoRecords.textContent = `Showing ${start} to ${end} of ${total} records`;
    }

    renderPaginationSoth(currentPage, sothTotalPages);
}

function renderPaginationSoth(currentPage, totalPages) {
    const el = document.getElementById('soth_pagination');
    if (!el) return;
    el.innerHTML = '';

    if (totalPages <= 1) return;

    const prevLi = document.createElement('li');
    prevLi.className = `page-item previous ${currentPage === 1 ? 'disabled' : ''}`;
    const prevLink = document.createElement('a');
    prevLink.className = 'page-link';
    prevLink.href = 'javascript:void(0)';
    prevLink.innerHTML = '<i class="previous"></i>';
    if (currentPage > 1) {
        prevLink.addEventListener('click', () => fetchTableSoth(currentPage - 1));
    }
    prevLi.appendChild(prevLink);
    el.appendChild(prevLi);

    let startPage = Math.max(1, currentPage - 2);
    let endPage = Math.min(totalPages, currentPage + 2);

    if (startPage > 1) {
        el.appendChild(createPageItem(1, currentPage));
        if (startPage > 2) {
            el.appendChild(createDotsItem(Math.max(1, currentPage - 5)));
        }
    }

    for (let p = startPage; p <= endPage; p++) {
        el.appendChild(createPageItem(p, currentPage));
    }

    if (endPage < totalPages) {
        if (endPage < totalPages - 1) {
            el.appendChild(createDotsItem(Math.min(totalPages, currentPage + 5)));
        }
        el.appendChild(createPageItem(totalPages, currentPage));
    }

    const nextLi = document.createElement('li');
    nextLi.className = `page-item next ${currentPage === totalPages ? 'disabled' : ''}`;
    const nextLink = document.createElement('a');
    nextLink.className = 'page-link';
    nextLink.href = 'javascript:void(0)';
    nextLink.innerHTML = '<i class="next"></i>';
    if (currentPage < totalPages) {
        nextLink.addEventListener('click', () => fetchTableSoth(currentPage + 1));
    }
    nextLi.appendChild(nextLink);
    el.appendChild(nextLi);
}

function createPageItem(page, currentPage) {
    const li = document.createElement('li');
    li.className = `page-item ${page === currentPage ? 'active' : ''}`;
    const link = document.createElement('a');
    link.className = 'page-link';
    link.href = 'javascript:void(0)';
    link.textContent = page;
    if (page !== currentPage) {
        link.addEventListener('click', () => fetchTableSoth(page));
    }
    li.appendChild(link);
    return li;
}

function createDotsItem(targetPage) {
    const li = document.createElement('li');
    li.className = 'page-item';
    const link = document.createElement('a');
    link.className = 'page-link';
    link.href = 'javascript:void(0)';
    link.textContent = '...';
    link.addEventListener('click', () => fetchTableSoth(targetPage));
    li.appendChild(link);
    return li;
}

function changeSothPageSize() {
    const sizeSelect = document.getElementById('soth_page_size');
    if (sizeSelect) {
        sothPageSize = parseInt(sizeSelect.value, 10);
    }
    fetchTableSoth(1);
}

function bukaModalTambahSoth() {
    const modalEl = document.getElementById('modalFormSoth');
    if (!modalEl) return;

    const form = document.getElementById('form_modal_soth');
    if (form) form.reset();

    const idInput = document.getElementById('soth_form_id');
    if (idInput) idInput.value = '';

    const modalTitle = document.getElementById('modalFormSothTitle');
    if (modalTitle) modalTitle.textContent = 'Input Data SOTH';

    const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
    modal.show();
}

function bukaModalEditSoth(rowJson) {
    const data = JSON.parse(decodeURIComponent(rowJson));
    const modalEl = document.getElementById('modalFormSoth');
    if (!modalEl) return;

    document.getElementById('soth_form_id').value = data.id;
    document.getElementById('soth_form_nama').value = data.nama;
    document.getElementById('soth_form_alamat').value = data.alamat;
    document.getElementById('soth_form_kecamatan').value = data.kecamatan;
    document.getElementById('soth_form_kelurahan').value = data.kelurahan;
    document.getElementById('soth_form_rt').value = data.rt;
    document.getElementById('soth_form_pre').value = data.rata_rata_pre;
    document.getElementById('soth_form_post').value = data.rata_rata_post;
    document.getElementById('soth_form_total').value = data.total_peserta;

    const modalTitle = document.getElementById('modalFormSothTitle');
    if (modalTitle) modalTitle.textContent = 'Edit Data SOTH';

    const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
    modal.show();
}

function handleFormSothSubmit(e) {
    e.preventDefault();

    const id = document.getElementById('soth_form_id').value;
    const isEdit = id !== '';
    const url = isEdit ? `/inovasi-kota/api/soth/${id}` : '/inovasi-kota/api/soth';
    const method = isEdit ? 'PUT' : 'POST';

    const payload = {
        nama: document.getElementById('soth_form_nama').value,
        alamat: document.getElementById('soth_form_alamat').value,
        kecamatan: document.getElementById('soth_form_kecamatan').value,
        kelurahan: document.getElementById('soth_form_kelurahan').value,
        rt: document.getElementById('soth_form_rt').value,
        rata_rata_pre: document.getElementById('soth_form_pre').value,
        rata_rata_post: document.getElementById('soth_form_post').value,
        total_peserta: document.getElementById('soth_form_total').value
    };

    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': token || ''
        },
        body: JSON.stringify(payload)
    })
    .then(r => r.json())
    .then(res => {
        const modalEl = document.getElementById('modalFormSoth');
        const modalInstance = bootstrap.Modal.getInstance(modalEl);
        if (modalInstance) modalInstance.hide();

        fetchTableSoth(sothCurrentPage);
    })
    .catch(err => {
        console.error(err);
        alert('Gagal menyimpan data.');
    });
}

function hapusDataSoth(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus data ini?')) return;
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    fetch(`/inovasi-kota/api/soth/${id}`, {
        method: 'DELETE',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': token || ''
        }
    })
    .then(r => r.json())
    .then(res => {
        fetchTableSoth(sothCurrentPage);
    })
    .catch(err => console.error(err));
}

let chartKampungAsiInstance = null;
let kampungAsiCurrentPage = 1;
let kampungAsiPageSize = 10;
let kampungAsiTotalPages = 1;
let kampungAsiSearchQuery = '';

const listKecamatanKampungAsi = [
    'ASEMROWO', 'BENOWO', 'BUBUTAN', 'BULAK', 'DUKUH PAKIS', 'GAYUNGAN', 'GENTENG',
    'GUBENG', 'GUNUNG ANYAR', 'JAMBANGAN', 'KARANG PILANG', 'KENJERAN', 'KREMBANGAN',
    'LAKAR SANTRI', 'MULYOREJO', 'PABEAN CANTIAN', 'PAKAL', 'RUNGKUT',
    'SAMBI KEREP', 'SAWAHAN', 'SEMAMPIR', 'SIMOKERTO', 'SUKOLILO',
    'SUKOMANUNGGAL', 'TAMBAKSARI', 'TANDES', 'TEGALSARI', 'TENGGILIS MEJOYO',
    'WIYUNG', 'WONOCOLO', 'WONOKROMO'
];

function initKampungAsi() {
    renderGrafikKampungAsi();
    fetchTableKampungAsi(1);
}

function filterKampungAsiKecamatanTop() {
    const val = document.getElementById('filter_kampung_asi_kecamatan_top')?.value || 'all';
    const selectChart = document.getElementById('filter_kampung_asi_kecamatan_chart');
    if (selectChart) {
        selectChart.value = val;
    }
    eksekusiFilterKampungAsi(val);
}

function filterKampungAsiChart() {
    const val = document.getElementById('filter_kampung_asi_kecamatan_chart')?.value || 'all';
    const selectTop = document.getElementById('filter_kampung_asi_kecamatan_top');
    if (selectTop) {
        selectTop.value = val;
    }
    eksekusiFilterKampungAsi(val);
}

function eksekusiFilterKampungAsi(kecamatan) {
    if (kecamatan === 'all') {
        renderGrafikKampungAsi();
    } else {
        renderGrafikKampungAsi([kecamatan], [0]);
    }
    kampungAsiCurrentPage = 1;
    fetchTableKampungAsi(1);
}

function renderGrafikKampungAsi(customLabels = null, customData = null) {
    const canvas = document.getElementById('chartKampungAsiPersentase');
    if (!canvas || typeof Chart === 'undefined') return;

    const labels = customLabels || listKecamatanKampungAsi;
    const dataValues = customData || new Array(labels.length).fill(0);

    if (chartKampungAsiInstance) {
        chartKampungAsiInstance.destroy();
    }

    chartKampungAsiInstance = new Chart(canvas.getContext('2d'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Presentase Kampung ASI',
                    data: dataValues,
                    borderColor: '#38bdf8',
                    backgroundColor: 'rgba(56, 189, 248, 0.1)',
                    borderWidth: 2,
                    borderDash: [5, 5],
                    fill: false,
                    tension: 0,
                    pointRadius: 2,
                    pointHoverRadius: 4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: false,
            interaction: { mode: 'index', intersect: false },
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
                    max: 120,
                    ticks: {
                        stepSize: 10,
                        callback: (value) => value + '%',
                        color: '#64748b',
                        font: { size: 10 }
                    },
                    grid: { color: '#f1f5f9' }
                },
                x: {
                    ticks: {
                        color: '#64748b',
                        font: { size: 8.5 },
                        maxRotation: 45,
                        minRotation: 45
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
    const filterEl = document.getElementById('filter_kampung_asi_kecamatan_top');
    const kec = filterEl ? filterEl.value : 'all';
    const tbody = document.getElementById('tabel_kampung_asi_body');
    if (!tbody) return;

    tbody.innerHTML = `<tr><td colspan="9" class="text-center py-8 text-gray-400">Memuat data...</td></tr>`;

    const url = `/inovasi-kota/api/kampung-asi/data?page=${page}&limit=${kampungAsiPageSize}&kecamatan=${encodeURIComponent(kec)}&search=${encodeURIComponent(kampungAsiSearchQuery)}`;

    fetch(url, {
        headers: { 'Accept': 'application/json' }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP Error: ${response.status}`);
        }
        return response.json();
    })
    .then(res => {
        renderTableKampungAsi(res);
    })
    .catch(() => {
        renderTableKampungAsi({ total: 0, current_page: 1, per_page: kampungAsiPageSize, last_page: 1, data: [] });
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
        tbody.innerHTML = `<tr><td colspan="9" class="text-center py-8 text-gray-400">Belum ada data</td></tr>`;
        if (infoRecords) infoRecords.textContent = 'Menampilkan 0 sampai 0 dari 0 data';
        if (paginationEl) paginationEl.innerHTML = '';
        return;
    }

    res.data.forEach((row, idx) => {
        const no = (currentPage - 1) * perPage + (idx + 1);
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td class="text-center text-gray-400">${no}</td>
            <td class="fw-bold text-gray-800">${row.kecamatan || '-'}</td>
            <td>${row.kelurahan || '-'}</td>
            <td class="text-gray-700">${row.nama_kampung_asi || '-'}</td>
            <td class="text-center">${row.jumlah_kader ?? 0}</td>
            <td class="text-center">${row.jumlah_toga ?? 0}</td>
            <td class="text-center">${row.ibu_hamil ?? 0}</td>
            <td class="text-center">${row.ibu_menyusui ?? 0}</td>
            <td class="text-center fw-bold text-primary">${row.persentase ?? '0%'}</td>
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
    if (!el) return;
    el.innerHTML = '';

    if (totalPages <= 1) return;

    const prevLi = document.createElement('li');
    prevLi.className = `page-item previous ${currentPage === 1 ? 'disabled' : ''}`;
    const prevLink = document.createElement('a');
    prevLink.className = 'page-link';
    prevLink.href = 'javascript:void(0)';
    prevLink.innerHTML = '&lt;';
    if (currentPage > 1) {
        prevLink.addEventListener('click', () => fetchTableKampungAsi(currentPage - 1));
    }
    prevLi.appendChild(prevLink);
    el.appendChild(prevLi);

    let startPage = Math.max(1, currentPage - 2);
    let endPage = Math.min(totalPages, currentPage + 2);

    if (startPage > 1) {
        el.appendChild(createKampungAsiPageItem(1, currentPage));
        if (startPage > 2) el.appendChild(createKampungAsiDotsItem(Math.max(1, currentPage - 5)));
    }

    for (let p = startPage; p <= endPage; p++) {
        el.appendChild(createKampungAsiPageItem(p, currentPage));
    }

    if (endPage < totalPages) {
        if (endPage < totalPages - 1) el.appendChild(createKampungAsiDotsItem(Math.min(totalPages, currentPage + 5)));
        el.appendChild(createKampungAsiPageItem(totalPages, currentPage));
    }

    const nextLi = document.createElement('li');
    nextLi.className = `page-item next ${currentPage === totalPages ? 'disabled' : ''}`;
    const nextLink = document.createElement('a');
    nextLink.className = 'page-link';
    nextLink.href = 'javascript:void(0)';
    nextLink.innerHTML = '&gt;';
    if (currentPage < totalPages) {
        nextLink.addEventListener('click', () => fetchTableKampungAsi(currentPage + 1));
    }
    nextLi.appendChild(nextLink);
    el.appendChild(nextLi);
}

function createKampungAsiPageItem(page, currentPage) {
    const li = document.createElement('li');
    li.className = `page-item ${page === currentPage ? 'active' : ''}`;
    const link = document.createElement('a');
    link.className = 'page-link';
    link.href = 'javascript:void(0)';
    link.textContent = page;
    if (page !== currentPage) {
        link.addEventListener('click', () => fetchTableKampungAsi(page));
    }
    li.appendChild(link);
    return li;
}

function createKampungAsiDotsItem(targetPage) {
    const li = document.createElement('li');
    li.className = 'page-item';
    const link = document.createElement('a');
    link.className = 'page-link';
    link.href = 'javascript:void(0)';
    link.textContent = '...';
    link.addEventListener('click', () => fetchTableKampungAsi(targetPage));
    li.appendChild(link);
    return li;
}

function changeKampungAsiPageSize() {
    const sizeSelect = document.getElementById('kampung_asi_page_size');
    if (sizeSelect) {
        kampungAsiPageSize = parseInt(sizeSelect.value, 10);
    }
    fetchTableKampungAsi(1);
}

let kampungAsiSearchTimer = null;
function searchKampungAsiTable() {
    clearTimeout(kampungAsiSearchTimer);
    kampungAsiSearchTimer = setTimeout(() => {
        const searchInput = document.getElementById('kampung_asi_search');
        kampungAsiSearchQuery = searchInput ? searchInput.value.trim() : '';
        fetchTableKampungAsi(1);
    }, 400);
}

window.populateInovasiOptions = populateInovasiOptions;
window.handlePokjaChange = handlePokjaChange;
window.handleInovasiChange = handleInovasiChange;
window.updateElearningTimestamp = updateElearningTimestamp;
window.initSoth = initSoth;
window.filterSothKecamatan = filterSothKecamatan;
window.renderGrafikSoth = renderGrafikSoth;
window.fetchTableSoth = fetchTableSoth;
window.changeSothPageSize = changeSothPageSize;
window.bukaModalTambahSoth = bukaModalTambahSoth;
window.bukaModalEditSoth = bukaModalEditSoth;
window.handleFormSothSubmit = handleFormSothSubmit;
window.hapusDataSoth = hapusDataSoth;
window.initKampungAsi = initKampungAsi;
window.filterKampungAsiKecamatanTop = filterKampungAsiKecamatanTop;
window.filterKampungAsiChart = filterKampungAsiChart;
window.renderGrafikKampungAsi = renderGrafikKampungAsi;
window.fetchTableKampungAsi = fetchTableKampungAsi;
window.changeKampungAsiPageSize = changeKampungAsiPageSize;
window.searchKampungAsiTable = searchKampungAsiTable