const daftarInovasiKota = [
    { key: 'elearning-puspaga', pokja: 'pokja 1', title: 'E-learning Puspaga PKK' },
    { key: 'kemanggi', pokja: 'pokja 1', title: 'Kemangi (Kelas Remaja dan Orang Tua Tangguh, Kreatif, dan Mandiri)' },
    { key: 'selantang', pokja: 'pokja 2', title: 'Selantang' },
    { key: 'soth', pokja: 'pokja 2', title: 'SOTH (Sekolah Orang Tua Hebat)' },
    { key: 'sicantik', pokja: 'sekretaris', title: 'Sicantik (Sistem Informasi Pencatatan Kegiatan dan Inovasi PKK Kota Surabaya)' },
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

    const defaultOpt = new Option('Pilih salah satu inovasi...', '', true, true);
    $(defaultOpt).prop('disabled', true);
    $select.append(defaultOpt);

    let items = (typeof daftarInovasiKota !== 'undefined' ? daftarInovasiKota : []).filter(item => {
        const itemPokja = (item.pokja || '').toString().trim().toLowerCase();
        return pokjaKey === 'semua' || itemPokja === pokjaKey;
    });

    const hasSicantik = items.some(i => i.key === 'sicantik');
    if (!hasSicantik && pokjaKey === 'semua') {
        items.push({
            title: 'Si Cantik',
            key: 'sicantik',
            pokja: 'sekretaris'
        });
    }

    items.sort((a, b) => {
        return a.title.localeCompare(b.title, 'id', { sensitivity: 'base' });
    });

    items.forEach(item => {
        const newOption = new Option(item.title, item.key, false, false);
        $select.append(newOption);
    });

    if (window.jQuery && $select.data('select2')) {
        $select.val('').trigger('change.select2');
    } else {
        nativeSelect.value = '';
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

            if (selectedKey === 'sicantik') {
                setTimeout(() => {
                    if (typeof fetchTableSiCantik === 'function') {
                        fetchTableSiCantik();
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

window.ROUTES_SOTH = window.ROUTES_SOTH || {
    data: '/inovasi/soth/data',
    chart: '/inovasi/soth/chart'
};

const masterKecamatanSoth = [
    'ASEMROWO', 'BENOWO', 'BUBUTAN', 'BULAK', 'DUKUH PAKIS', 'GAYUNGAN', 'GENTENG',
    'GUBENG', 'GUNUNG ANYAR', 'JAMBANGAN', 'KARANG PILANG', 'KENJERAN', 'KREMBANGAN',
    'LAKARSANTRI', 'MULYOREJO', 'PABEAN CANTIAN', 'PAKAL', 'RUNGKUT',
    'SAMBIKEREP', 'SAWAHAN', 'SEMAMPIR', 'SIMOKERTO', 'SUKOLILO',
    'SUKOMANUNGGAL', 'TAMBAKSARI', 'TANDES', 'TEGALSARI', 'TENGGILIS MEJOYO',
    'WIYUNG', 'WONOCOLO', 'WONOKROMO'
];

let chartSothInstance = null;

let sothCurrentPage = 1;
let sothPageSize = 10;
let sothTotalPages = 1;
let sothSearchQuery = '';
let sothSearchTimer = null;

function initSoth() {
    initDropdownKelurahanSoth();
    initChartSoth();
    fetchTableSoth(1);
    fetchChartSoth();

    const searchInput = document.getElementById('soth_search_input');
    if (searchInput) {
        searchInput.addEventListener('input', () => {
            searchSothTable();
        });
    }
}

function initDropdownKelurahanSoth() {
    const kec = (document.getElementById('filter_soth_kecamatan')?.value || 'all').toUpperCase().trim();
    const kelSelect = document.getElementById('filter_soth_kelurahan');
    if (!kelSelect) return;

    const options = kelSelect.querySelectorAll('option');

    options.forEach(opt => {
        if (opt.value === 'all') {
            opt.hidden = false;
            opt.disabled = false;
            return;
        }

        const optKec = (opt.getAttribute('data-kecamatan') || '').toUpperCase().trim();

        if (kec === 'all' || optKec === kec) {
            opt.hidden = false;
            opt.disabled = false;
        } else {
            opt.hidden = true;
            opt.disabled = true;
        }
    });

    kelSelect.value = 'all';
}

function handleSothKecamatanChange() {
    initDropdownKelurahanSoth();
    terapkanFilterSoth();
}

function terapkanFilterSoth() {
    sothCurrentPage = 1;
    fetchTableSoth(1);
    fetchChartSoth();
}

function resetFilterSoth() {
    const kec = document.getElementById('filter_soth_kecamatan');
    const kel = document.getElementById('filter_soth_kelurahan');
    const thn = document.getElementById('filter_soth_tahun');
    const search = document.getElementById('soth_search_input');

    if (kec) kec.value = 'all';
    if (kel) kel.value = 'all';
    if (thn) thn.value = 'all';
    if (search) search.value = '';

    initDropdownKelurahanSoth();

    sothSearchQuery = '';
    sothCurrentPage = 1;

    fetchTableSoth(1);
    fetchChartSoth();
}

function initChartSoth() {
    const canvas = document.getElementById('chartSothNilai');
    if (!canvas || typeof Chart === 'undefined') return;

    if (chartSothInstance) {
        chartSothInstance.destroy();
        chartSothInstance = null;
    }

    const ctx = canvas.getContext('2d');

    chartSothInstance = new Chart(ctx, {
        type: 'line',
        data: {
            labels: masterKecamatanSoth,
            datasets: [
                {
                    label: 'Pretest',
                    data: new Array(masterKecamatanSoth.length).fill(0),
                    borderColor: '#38bdf8',
                    backgroundColor: 'rgba(56, 189, 248, 0.15)',
                    borderWidth: 3,
                    borderDash: [5, 5],
                    tension: 0.15,
                    pointRadius: 5,
                    pointHoverRadius: 8,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#38bdf8',
                    pointBorderWidth: 2.5,
                    pointHoverBackgroundColor: '#38bdf8',
                    pointHoverBorderColor: '#ffffff',
                    pointHoverBorderWidth: 2,
                    fill: false
                },
                {
                    label: 'Posttest',
                    data: new Array(masterKecamatanSoth.length).fill(0),
                    borderColor: '#fb7185',
                    backgroundColor: 'rgba(251, 113, 133, 0.15)',
                    borderWidth: 3,
                    borderDash: [5, 5],
                    tension: 0.15,
                    pointRadius: 5,
                    pointHoverRadius: 8,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#fb7185',
                    pointBorderWidth: 2.5,
                    pointHoverBackgroundColor: '#fb7185',
                    pointHoverBorderColor: '#ffffff',
                    pointHoverBorderWidth: 2,
                    fill: false
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false
            },
            plugins: {
                legend: { display: false },
                datalabels: false,
                tooltip: {
                    enabled: true,
                    mode: 'index',
                    intersect: false,
                    backgroundColor: '#1e293b',
                    titleColor: '#ffffff',
                    bodyColor: '#e2e8f0',
                    borderColor: '#334155',
                    borderWidth: 1,
                    padding: 12,
                    cornerRadius: 8,
                    boxPadding: 6,
                    usePointStyle: true,
                    titleFont: { size: 13, weight: 'bold' },
                    bodyFont: { size: 12, weight: '600' },
                    callbacks: {
                        title: function(items) {
                            return items.length > 0 ? items[0].label : '';
                        },
                        label: function(ctx) {
                            const val = parseFloat(ctx.parsed.y || 0).toFixed(2);
                            return ` ${ctx.dataset.label}: ${val}%`;
                        }
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
                        font: { size: 10, weight: '500' }
                    },
                    grid: { color: '#f1f5f9' }
                },
                x: {
                    ticks: {
                        color: '#64748b',
                        font: { size: 9, weight: '600' },
                        maxRotation: 45,
                        minRotation: 45,
                        autoSkip: false
                    },
                    grid: { color: '#f8fafc' }
                }
            }
        }
    });
}

function fetchChartSoth() {
    const kec = document.getElementById('filter_soth_kecamatan')?.value || 'all';
    const kel = document.getElementById('filter_soth_kelurahan')?.value || 'all';
    const thn = document.getElementById('filter_soth_tahun')?.value || 'all';

    const chartUrl = window.ROUTES_SOTH?.chart || '/inovasi/soth/chart';
    const params = new URLSearchParams({ kecamatan: kec, kelurahan: kel, tahun: thn });

    fetch(`${chartUrl}?${params.toString()}`, {
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(res => {
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        return res.json();
    })
    .then(data => {
        if (!chartSothInstance || !chartSothInstance.ctx) return;

        const rawLabels = data.labels || [];
        const rawPre = data.pretest || [];
        const rawPost = data.posttest || [];

        if (kec === 'all' && kel === 'all') {
            const cleanName = (str) => (str || '').toString().toUpperCase().replace(/[^A-Z0-9]/g, '');

            const mappedPre = masterKecamatanSoth.map(masterKec => {
                const masterClean = cleanName(masterKec);
                const foundIndex = rawLabels.findIndex(l => cleanName(l) === masterClean);
                return foundIndex !== -1 ? (parseFloat(rawPre[foundIndex]) || 0) : 0;
            });

            const mappedPost = masterKecamatanSoth.map(masterKec => {
                const masterClean = cleanName(masterKec);
                const foundIndex = rawLabels.findIndex(l => cleanName(l) === masterClean);
                return foundIndex !== -1 ? (parseFloat(rawPost[foundIndex]) || 0) : 0;
            });

            chartSothInstance.data.labels = masterKecamatanSoth;
            chartSothInstance.data.datasets[0].data = mappedPre;
            chartSothInstance.data.datasets[1].data = mappedPost;
        } else {
            chartSothInstance.data.labels = rawLabels.length > 0 ? rawLabels : ['Data Kosong'];
            chartSothInstance.data.datasets[0].data = rawPre.length > 0 ? rawPre.map(v => parseFloat(v) || 0) : [0];
            chartSothInstance.data.datasets[1].data = rawPost.length > 0 ? rawPost.map(v => parseFloat(v) || 0) : [0];
        }

        chartSothInstance.update();
    })
    .catch(err => console.error('Chart error:', err));
}

function fetchTableSoth(page = 1) {
    sothCurrentPage = parseInt(page, 10) || 1;
    const tbody = document.getElementById('tabel_soth_body');
    if (!tbody) return;

    tbody.innerHTML = `<tr><td colspan="10" class="text-center py-6 text-gray-500"><span class="spinner-border spinner-border-sm me-2"></span>Memuat data...</td></tr>`;

    const kec = document.getElementById('filter_soth_kecamatan')?.value || 'all';
    const kel = document.getElementById('filter_soth_kelurahan')?.value || 'all';
    const thn = document.getElementById('filter_soth_tahun')?.value || 'all';
    const baseUrl = window.ROUTES_SOTH?.data || '/inovasi/soth/data';

    const params = new URLSearchParams({
        page: sothCurrentPage,
        limit: sothPageSize,
        kecamatan: kec,
        kelurahan: kel,
        tahun: thn,
        search: sothSearchQuery
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
        renderTableSoth(data);
    })
    .catch(err => {
        console.error('Table error:', err);
        tbody.innerHTML = `<tr><td colspan="10" class="text-center py-6 text-gray-400">Gagal memuat data</td></tr>`;
        renderPaginationSoth(1, 1);
    });
}

function renderTableSoth(res) {
    const tbody = document.getElementById('tabel_soth_body');
    const infoRecords = document.getElementById('soth_info_records');
    if (!tbody) return;

    tbody.innerHTML = '';

    let items = [];
    if (res && Array.isArray(res.data)) {
        items = res.data;
    } else if (res && res.data && Array.isArray(res.data.data)) {
        items = res.data.data;
    } else if (Array.isArray(res)) {
        items = res;
    }

    const total = parseInt(res?.total ?? (res?.data?.total ?? items.length), 10) || 0;
    const currentPage = parseInt(res?.current_page ?? (res?.data?.current_page ?? sothCurrentPage), 10) || 1;
    const perPage = parseInt(res?.per_page ?? (res?.data?.per_page ?? sothPageSize), 10) || 10;

    const calculatedPages = Math.max(1, Math.ceil(total / perPage));
    sothTotalPages = parseInt(res?.last_page ?? (res?.data?.last_page ?? calculatedPages), 10) || 1;

    if (items.length === 0) {
        tbody.innerHTML = `<tr><td colspan="10" class="text-center py-6 text-gray-400">Data tidak ditemukan</td></tr>`;
        if (infoRecords) infoRecords.textContent = 'Showing 0 to 0 of 0 records';
        renderPaginationSoth(1, 1);
        return;
    }

    items.forEach((row, idx) => {
        const no = (currentPage - 1) * perPage + (idx + 1);
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td class="text-center">${no}</td>
            <td>${row.nama || '-'}</td>
            <td>${row.alamat || '-'}</td>
            <td class="text-center">${row.rt || '-'}</td>
            <td class="text-center">${row.rw || '-'}</td>
            <td>${row.kelurahan || '-'}</td>
            <td>${row.kecamatan || '-'}</td>
            <td class="text-center">${parseFloat(row.rata_pre ?? row.rata_rata_pre ?? 0).toFixed(2)}</td>
            <td class="text-center">${parseFloat(row.rata_post ?? row.rata_rata_post ?? 0).toFixed(2)}</td>
            <td class="text-center">${row.total_peserta ?? 0}</td>
        `;
        tbody.appendChild(tr);
    });

    const start = res.from ?? ((currentPage - 1) * perPage + 1);
    const end = res.to ?? Math.min(currentPage * perPage, total);
    if (infoRecords) {
        infoRecords.textContent = `Showing ${start} to ${end} of ${total} records`;
    }

    renderPaginationSoth(currentPage, sothTotalPages);
}

function renderPaginationSoth(currentPage, totalPages) {
    const el = document.getElementById('soth_pagination');
    if (!el) return;

    el.innerHTML = '';

    currentPage = parseInt(currentPage, 10) || 1;
    totalPages = parseInt(totalPages, 10) || 1;

    const buatItemPagination = (label, targetPage, isDisabled, isActive) => {
        const li = document.createElement('li');
        li.className = `page-item ${isDisabled ? 'disabled' : ''} ${isActive ? 'active' : ''}`;

        const a = document.createElement('a');
        a.className = 'page-link';
        a.href = 'javascript:void(0);';
        a.style.cursor = isDisabled ? 'default' : 'pointer';
        a.innerHTML = label;

        if (!isDisabled && !isActive) {
            a.addEventListener('click', (e) => {
                e.preventDefault();
                fetchTableSoth(targetPage);
            });
        }

        li.appendChild(a);
        return li;
    };

    el.appendChild(buatItemPagination('&lt;', currentPage - 1, currentPage <= 1, false));

    let startPage = Math.max(1, currentPage - 2);
    let endPage = Math.min(totalPages, currentPage + 2);

    if (currentPage <= 3) endPage = Math.min(totalPages, 5);
    if (currentPage >= totalPages - 2) startPage = Math.max(1, totalPages - 4);

    if (startPage > 1) {
        el.appendChild(buatItemPagination('1', 1, false, false));
        if (startPage > 2) {
            const elipsis = document.createElement('li');
            elipsis.className = 'page-item disabled';
            elipsis.innerHTML = '<span class="page-link text-muted">...</span>';
            el.appendChild(elipsis);
        }
    }

    for (let p = startPage; p <= endPage; p++) {
        el.appendChild(buatItemPagination(p, p, false, p === currentPage));
    }

    if (endPage < totalPages) {
        if (endPage < totalPages - 1) {
            const elipsis = document.createElement('li');
            elipsis.className = 'page-item disabled';
            elipsis.innerHTML = '<span class="page-link text-muted">...</span>';
            el.appendChild(elipsis);
        }
        el.appendChild(buatItemPagination(totalPages, totalPages, false, false));
    }

    el.appendChild(buatItemPagination('&gt;', currentPage + 1, currentPage >= totalPages, false));
}

function searchSothTable() {
    clearTimeout(sothSearchTimer);
    sothSearchTimer = setTimeout(() => {
        const input = document.getElementById('soth_search_input');
        sothSearchQuery = input ? input.value.trim() : '';
        fetchTableSoth(1);
    }, 300);
}

function changeSothPageSize() {
    const sizeSelect = document.getElementById('soth_page_size');
    if (sizeSelect) {
        sothPageSize = parseInt(sizeSelect.value, 10);
    }
    fetchTableSoth(1);
}

document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('tabel_soth_body')) {
        initSoth();
    }
});

// KAMPUNG ASI 
const listKecamatanKampungAsiMaster = [
    'ASEMROWO', 'BENOWO', 'BUBUTAN', 'BULAK', 'DUKUH PAKIS', 'GAYUNGAN', 'GENTENG',
    'GUBENG', 'GUNUNG ANYAR', 'JAMBANGAN', 'KARANG PILANG', 'KENJERAN', 'KREMBANGAN',
    'LAKAR SANTRI', 'MULYOREJO', 'PABEAN CANTIAN', 'PAKAL', 'RUNGKUT',
    'SAMBI KEREP', 'SAWAHAN', 'SEMAMPIR', 'SIMOKERTO', 'SUKOLILO',
    'SUKOMANUNGGAL', 'TAMBAKSARI', 'TANDES', 'TEGALSARI', 'TENGGILIS MEJOYO',
    'WIYUNG', 'WONOCOLO', 'WONOKROMO'
];

let chartKampungAsiInstance = null;
let kampungAsiCurrentPage = 1;
let kampungAsiPageSize = 10;
let kampungAsiTotalPages = 1;
let kampungAsiSearchQuery = '';
let kampungAsiSearchTimer = null;

function initKampungAsi() {
    renderGrafikKampungAsi();
    fetchChartKampungAsi();
    fetchTableKampungAsi(1);
}

function filterKampungAsiKecamatanTop() {
    kampungAsiCurrentPage = 1;
    fetchChartKampungAsi();
    fetchTableKampungAsi(1);
}

function renderGrafikKampungAsi() {
    const canvas = document.getElementById('chartKampungAsiPersentase');
    if (!canvas || typeof Chart === 'undefined') return;

    if (chartKampungAsiInstance) {
        chartKampungAsiInstance.destroy();
        chartKampungAsiInstance = null;
    }

    const ctx = canvas.getContext('2d');
    chartKampungAsiInstance = new Chart(ctx, {
        type: 'line',
        data: {
            labels: listKecamatanKampungAsiMaster,
            datasets: [{
                label: 'Presentase Kampung ASI',
                data: new Array(listKecamatanKampungAsiMaster.length).fill(0),
                borderColor: '#38bdf8',
                backgroundColor: 'rgba(56, 189, 248, 0.12)',
                borderWidth: 3.5,
                borderDash: [6, 6],
                tension: 0,
                pointRadius: 5,
                pointHoverRadius: 7,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#38bdf8',
                pointBorderWidth: 2.5,
                fill: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { display: false },
                datalabels: false,
                tooltip: {
                    backgroundColor: '#1f2937',
                    padding: 10,
                    cornerRadius: 8,
                    callbacks: {
                        label: (ctx) => ` Presentase: ${ctx.parsed.y}%`
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
                        font: { size: 9, weight: '500' },
                        maxRotation: 45,
                        minRotation: 45
                    },
                    grid: { color: '#f8fafc' }
                }
            }
        }
    });
}

function fetchChartKampungAsi() {
    const kec = document.getElementById('filter_kampung_asi_kecamatan_top')?.value || 'all';
    const chartUrl = window.API_ROUTES?.kampungAsiChart || '/inovasi/kota/kampung-asi/chart';

    fetch(`${chartUrl}?kecamatan=${encodeURIComponent(kec)}`, {
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(res => {
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        return res.json();
    })
    .then(data => {
        if (!chartKampungAsiInstance || !chartKampungAsiInstance.ctx) return;

        const cleanName = (str) => (str || '').toString().toUpperCase().replace(/[^A-Z0-9]/g, '');

        if (kec !== 'all') {
            chartKampungAsiInstance.data.labels = [kec];
            chartKampungAsiInstance.data.datasets[0].data = [(parseFloat(data.data?.[0]) || 0)];
            chartKampungAsiInstance.update();
            return;
        }

        const rawLabels = data.labels || [];
        const rawValues = data.data || [];

        const mappedValues = listKecamatanKampungAsiMaster.map(masterKec => {
            const masterClean = cleanName(masterKec);
            const foundIndex = rawLabels.findIndex(l => cleanName(l) === masterClean);
            return foundIndex !== -1 ? (parseFloat(rawValues[foundIndex]) || 0) : 0;
        });

        chartKampungAsiInstance.data.labels = listKecamatanKampungAsiMaster;
        chartKampungAsiInstance.data.datasets[0].data = mappedValues;
        chartKampungAsiInstance.update();
    })
    .catch(err => console.error("Gagal load chart Kampung ASI:", err));
}

function fetchTableKampungAsi(page = 1) {
    kampungAsiCurrentPage = parseInt(page, 10) || 1;
    const tbody = document.getElementById('tabel_kampung_asi_body');
    if (!tbody) return;

    tbody.innerHTML = `<tr><td colspan="9" class="text-center py-6 text-gray-500"><span class="spinner-border spinner-border-sm me-2"></span>Memuat data...</td></tr>`;

    const kec = document.getElementById('filter_kampung_asi_kecamatan_top')?.value || 'all';
    const baseUrl = window.API_ROUTES?.kampungAsi || '/inovasi/kota/kampung-asi/data';
    const params = new URLSearchParams({
        page: kampungAsiCurrentPage,
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
    .then(async res => {
        const data = await res.json();
        if (!res.ok) {
            // Tangkap pesan error JSON dari backend (jika ada)
            throw new Error(data.message || `HTTP ${res.status}`);
        }
        return data;
    })
    .then(data => {
        renderTableKampungAsi(data);
    })
    .catch(err => {
        console.error("Gagal memuat tabel Kampung ASI:", err);
        if (tbody) {
            tbody.innerHTML = `<tr><td colspan="9" class="text-center py-6 text-danger">Gagal memuat data: ${err.message}</td></tr>`;
        }
        renderPaginationKampungAsi(1, 1);
    });
}

function renderTableKampungAsi(res) {
    const tbody = document.getElementById('tabel_kampung_asi_body');
    const infoRecords = document.getElementById('kampung_asi_info_records');
    const paginationEl = document.getElementById('kampung_asi_pagination');
    if (!tbody) return;

    tbody.innerHTML = '';

    let items = [];
    if (res && Array.isArray(res.data)) {
        items = res.data;
    } else if (res && res.data && Array.isArray(res.data.data)) {
        items = res.data.data;
    } else if (Array.isArray(res)) {
        items = res;
    }

    const total = parseInt(res?.total ?? (res?.data?.total ?? items.length), 10) || 0;
    const currentPage = parseInt(res?.current_page ?? (res?.data?.current_page ?? kampungAsiCurrentPage), 10) || 1;
    const perPage = parseInt(res?.per_page ?? (res?.data?.per_page ?? kampungAsiPageSize), 10) || 10;

    const calculatedPages = Math.max(1, Math.ceil(total / perPage));
    kampungAsiTotalPages = parseInt(res?.last_page ?? (res?.data?.last_page ?? calculatedPages), 10) || 1;

    if (items.length === 0) {
        tbody.innerHTML = `<tr><td colspan="9" class="text-center py-6 text-gray-400">Data tidak ditemukan</td></tr>`;
        if (infoRecords) infoRecords.textContent = 'Menampilkan 0 sampai 0 dari 0 data';
        if (paginationEl) paginationEl.innerHTML = '';
        return;
    }

    items.forEach((row, idx) => {
        const no = (currentPage - 1) * perPage + (idx + 1);
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td class="text-center text-gray-600">${no}</td>
            <td class="text-gray-800">${row.kecamatan || '-'}</td>
            <td class="text-gray-800">${row.kelurahan || '-'}</td>
            <td class="text-gray-800 fw-semibold">${row.nama_kampung_asi || '-'}</td>
            <td class="text-center text-gray-800">${row.jumlah_kader ?? 0}</td>
            <td class="text-center text-gray-800">${row.jumlah_toga ?? 0}</td>
            <td class="text-center text-gray-800">${row.ibu_hamil ?? 0}</td>
            <td class="text-center text-gray-800">${row.ibu_menyusui ?? 0}</td>
            <td class="text-center text-gray-800 fw-bold">${row.persentase ? parseFloat(row.persentase).toFixed(2) + '%' : '0%'}</td>
        `;
        tbody.appendChild(tr);
    });

    const start = res?.from ?? ((currentPage - 1) * perPage + 1);
    const end = res?.to ?? Math.min(currentPage * perPage, total);
    if (infoRecords) {
        infoRecords.textContent = `Menampilkan ${start} sampai ${end} dari ${total} data`;
    }

    renderPaginationKampungAsi(currentPage, kampungAsiTotalPages);
}

function renderPaginationKampungAsi(currentPage, totalPages) {
    const el = document.getElementById('kampung_asi_pagination');
    if (!el) return;

    el.innerHTML = '';

    currentPage = parseInt(currentPage, 10) || 1;
    totalPages = parseInt(totalPages, 10) || 1;

    const buatTombol = (label, targetPage, isDisabled, isActive) => {
        const li = document.createElement('li');
        li.className = `page-item ${isDisabled ? 'disabled' : ''} ${isActive ? 'active' : ''}`;

        const a = document.createElement('a');
        a.className = 'page-link';
        a.href = 'javascript:void(0);';
        a.style.cursor = isDisabled ? 'default' : 'pointer';
        a.innerHTML = label;

        if (!isDisabled && !isActive) {
            a.addEventListener('click', (e) => {
                e.preventDefault();
                fetchTableKampungAsi(targetPage);
            });
        }

        li.appendChild(a);
        return li;
    };

    el.appendChild(buatTombol('&lt;', currentPage - 1, currentPage <= 1, false));

    let startPage = Math.max(1, currentPage - 2);
    let endPage = Math.min(totalPages, currentPage + 2);

    if (currentPage <= 3) endPage = Math.min(totalPages, 5);
    if (currentPage >= totalPages - 2) startPage = Math.max(1, totalPages - 4);

    if (startPage > 1) {
        el.appendChild(buatTombol('1', 1, false, false));
        if (startPage > 2) {
            const elipsis = document.createElement('li');
            elipsis.className = 'page-item disabled';
            elipsis.innerHTML = '<span class="page-link text-muted">...</span>';
            el.appendChild(elipsis);
        }
    }

    for (let p = startPage; p <= endPage; p++) {
        el.appendChild(buatTombol(p, p, false, p === currentPage));
    }

    if (endPage < totalPages) {
        if (endPage < totalPages - 1) {
            const elipsis = document.createElement('li');
            elipsis.className = 'page-item disabled';
            elipsis.innerHTML = '<span class="page-link text-muted">...</span>';
            el.appendChild(elipsis);
        }
        el.appendChild(buatTombol(totalPages, totalPages, false, false));
    }

    el.appendChild(buatTombol('&gt;', currentPage + 1, currentPage >= totalPages, false));
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
    }, 300);
}

//Surabaya Emas
const masterKecamatanSurabayaEmas = [
    'ASEMROWO', 'BENOWO', 'BUBUTAN', 'BULAK', 'DUKUH PAKIS', 'GAYUNGAN', 'GENTENG',
    'GUBENG', 'GUNUNG ANYAR', 'JAMBANGAN', 'KARANG PILANG', 'KENJERAN', 'KREMBANGAN',
    'LAKAR SANTRI', 'MULYOREJO', 'PABEAN CANTIAN', 'PAKAL', 'RUNGKUT',
    'SAMBI KEREP', 'SAWAHAN', 'SEMAMPIR', 'SIMOKERTO', 'SUKOLILO',
    'SUKOMANUNGGAL', 'TAMBAKSARI', 'TANDES', 'TEGALSARI', 'TENGGILIS MEJOYO',
    'WIYUNG', 'WONOCOLO', 'WONOKROMO'
];

let chartSurabayaEmasInstance = null;
let chartDetailRiwayatInstance = null;

let surabayaEmasCurrentPage = 1;
let surabayaEmasPageSize = 10;
let surabayaEmasTotalPages = 1;
let surabayaEmasSearchQuery = '';
let surabayaEmasSearchTimer = null;

function initSurabayaEmas() {
    initChartSurabayaEmas();
    fetchTableSurabayaEmas(1);
    fetchChartSurabayaEmas();
}

function handleSurabayaEmasKecamatanChange() {
    const kelSelect = document.getElementById('filter_surabaya_emas_kelurahan');
    if (kelSelect) {
        kelSelect.value = 'all';
    }
    terapkanFilterSurabayaEmas();
}

function terapkanFilterSurabayaEmas() {
    surabayaEmasCurrentPage = 1;
    fetchTableSurabayaEmas(1);
    fetchChartSurabayaEmas();
}

function resetFilterSurabayaEmas() {
    const kec = document.getElementById('filter_surabaya_emas_kecamatan');
    const kel = document.getElementById('filter_surabaya_emas_kelurahan');
    const thn = document.getElementById('filter_surabaya_emas_tahun');
    const search = document.getElementById('surabaya_emas_search');

    if (kec) kec.value = 'all';
    if (kel) kel.value = 'all';
    if (thn) thn.value = 'all';
    if (search) search.value = '';

    surabayaEmasSearchQuery = '';
    surabayaEmasCurrentPage = 1;

    fetchTableSurabayaEmas(1);
    fetchChartSurabayaEmas();
}

function initChartSurabayaEmas() {
    const canvas = document.getElementById('chartSurabayaEmas');
    if (!canvas || typeof Chart === 'undefined') return;

    if (chartSurabayaEmasInstance) {
        chartSurabayaEmasInstance.destroy();
        chartSurabayaEmasInstance = null;
    }

    const ctx = canvas.getContext('2d');
    const pluginsToUse = (typeof ChartDataLabels !== 'undefined') ? [ChartDataLabels] : [];

    chartSurabayaEmasInstance = new Chart(ctx, {
        type: 'line',
        plugins: pluginsToUse,
        data: {
            labels: masterKecamatanSurabayaEmas,
            datasets: [{
                label: 'Balita',
                data: new Array(masterKecamatanSurabayaEmas.length).fill(0),
                borderColor: '#4373eb',
                backgroundColor: 'rgba(67, 115, 235, 0.25)',
                borderWidth: 2.5,
                tension: 0.45,
                pointRadius: 4.5,
                pointHoverRadius: 6.5,
                pointBackgroundColor: '#4373eb',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 1.5,
                fill: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            layout: {
                padding: { top: 25, bottom: 10, left: 10, right: 10 }
            },
            plugins: {
                title: {
                    display: false
                },
                legend: {
                    display: true,
                    position: 'top',
                    align: 'center',
                    labels: {
                        boxWidth: 26,
                        boxHeight: 12,
                        color: '#666666',
                        font: { size: 12 }
                    }
                },
                tooltip: {
                    enabled: true,
                    backgroundColor: '#1f2937',
                    padding: 8,
                    cornerRadius: 6
                },
                datalabels: {
                    display: function(context) {
                        return context.dataset.data[context.dataIndex] !== undefined;
                    },
                    align: 'top',
                    offset: 6,
                    backgroundColor: '#ffffff',
                    borderColor: '#4373eb',
                    borderWidth: 1,
                    borderRadius: 3,
                    color: '#4373eb',
                    font: {
                        size: 9,
                        weight: 'bold'
                    },
                    padding: {
                        top: 2,
                        bottom: 2,
                        left: 4,
                        right: 4
                    },
                    formatter: function(value) {
                        return value;
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    suggestedMax: 70,
                    ticks: {
                        stepSize: 10,
                        color: '#777777',
                        font: { size: 11 }
                    },
                    grid: {
                        color: '#eceff1',
                        drawBorder: false
                    }
                },
                x: {
                    ticks: {
                        color: '#777777',
                        font: { size: 9, weight: '500' },
                        maxRotation: 45,
                        minRotation: 45,
                        autoSkip: false
                    },
                    grid: {
                        color: '#f8f9fa',
                        drawBorder: false
                    }
                }
            }
        }
    });
}

function fetchChartSurabayaEmas() {
    const kec = document.getElementById('filter_surabaya_emas_kecamatan')?.value || 'all';
    const kel = document.getElementById('filter_surabaya_emas_kelurahan')?.value || 'all';
    const thn = document.getElementById('filter_surabaya_emas_tahun')?.value || 'all';

    const chartUrl = window.API_ROUTES?.surabayaEmasChart || '/inovasi/kota/surabaya-emas/chart';
    const params = new URLSearchParams({ kecamatan: kec, kelurahan: kel, tahun: thn });

    fetch(`${chartUrl}?${params.toString()}`, {
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(res => {
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        return res.json();
    })
    .then(data => {
        if (!chartSurabayaEmasInstance) return;

        chartSurabayaEmasInstance.data.labels = masterKecamatanSurabayaEmas;
        chartSurabayaEmasInstance.data.datasets[0].data = data.data || [];

        const maxVal = Math.max(...(data.data || [0]), 10);
        chartSurabayaEmasInstance.options.scales.y.suggestedMax = Math.ceil((maxVal + 10) / 10) * 10;

        chartSurabayaEmasInstance.update();
    })
    .catch(err => console.error('Chart error:', err));
}

function fetchTableSurabayaEmas(page = 1) {
    surabayaEmasCurrentPage = parseInt(page, 10) || 1;
    const tbody = document.getElementById('tabel_surabaya_emas_body');
    if (!tbody) return;

    tbody.innerHTML = `<tr><td colspan="10" class="text-center py-6 text-gray-500"><span class="spinner-border spinner-border-sm me-2"></span>Memuat data...</td></tr>`;

    const kec = document.getElementById('filter_surabaya_emas_kecamatan')?.value || 'all';
    const kel = document.getElementById('filter_surabaya_emas_kelurahan')?.value || 'all';
    const thn = document.getElementById('filter_surabaya_emas_tahun')?.value || 'all';
    const baseUrl = window.API_ROUTES?.surabayaEmas || '/inovasi/kota/surabaya-emas/data';

    const params = new URLSearchParams({
        page: surabayaEmasCurrentPage,
        limit: surabayaEmasPageSize,
        kecamatan: kec,
        kelurahan: kel,
        tahun: thn,
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
    .catch(err => {
        console.error('Table error:', err);
        tbody.innerHTML = `<tr><td colspan="10" class="text-center py-6 text-gray-400">Gagal memuat data</td></tr>`;
        renderPaginationSurabayaEmas(1, 1);
    });
}

function renderTableSurabayaEmas(res) {
    const tbody = document.getElementById('tabel_surabaya_emas_body');
    const infoRecords = document.getElementById('surabaya_emas_info_records');
    if (!tbody) return;

    tbody.innerHTML = '';

    let items = [];
    if (res && Array.isArray(res.data)) {
        items = res.data;
    } else if (res && res.data && Array.isArray(res.data.data)) {
        items = res.data.data;
    } else if (Array.isArray(res)) {
        items = res;
    }

    const total = parseInt(res?.total ?? (res?.data?.total ?? items.length), 10) || 0;
    const currentPage = parseInt(res?.current_page ?? (res?.data?.current_page ?? surabayaEmasCurrentPage), 10) || 1;
    const perPage = parseInt(res?.per_page ?? (res?.data?.per_page ?? surabayaEmasPageSize), 10) || 10;

    const calculatedPages = Math.max(1, Math.ceil(total / perPage));
    surabayaEmasTotalPages = parseInt(res?.last_page ?? (res?.data?.last_page ?? calculatedPages), 10) || 1;

    if (items.length === 0) {
        tbody.innerHTML = `<tr><td colspan="10" class="text-center py-6 text-gray-400">Data tidak ditemukan</td></tr>`;
        if (infoRecords) infoRecords.textContent = 'Menampilkan 0 sampai 0 dari 0 data';
        renderPaginationSurabayaEmas(1, 1);
        return;
    }

    items.forEach((row, idx) => {
        const no = (currentPage - 1) * perPage + (idx + 1);
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td class="text-center text-gray-600">${no}</td>
            <td class="text-gray-800 fw-semibold">${row.nama_balita || '-'}</td>
            <td class="text-gray-700">${row.tanggal_lahir || '-'}</td>
            <td class="text-center text-gray-700">${row.jenis_kelamin || '-'}</td>
            <td class="text-gray-700">${row.alamat_domisili || '-'}</td>
            <td class="text-gray-700">${row.kelurahan_domisili || '-'}</td>
            <td class="text-gray-700">${row.kecamatan_domisili || '-'}</td>
            <td class="text-center text-gray-700">${row.tpk || '-'}</td>
            <td class="text-center text-gray-700">${row.tahun || '-'}</td>
            <td class="text-center">
                <button type="button" class="btn btn-icon btn-sm btn-light-primary" title="Lihat Detail" onclick="lihatDetailBalita('${row.id_encrypted || row.id || ''}')">
                    <i class="ki-duotone ki-eye fs-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                </button>
            </td>
        `;
        tbody.appendChild(tr);
    });

    const start = res.from ?? ((currentPage - 1) * perPage + 1);
    const end = res.to ?? Math.min(currentPage * perPage, total);
    if (infoRecords) {
        infoRecords.textContent = `Menampilkan ${start} sampai ${end} dari ${total} data`;
    }

    renderPaginationSurabayaEmas(currentPage, surabayaEmasTotalPages);
}

function renderPaginationSurabayaEmas(currentPage, totalPages) {
    const el = document.getElementById('surabaya_emas_pagination');
    if (!el) return;

    el.innerHTML = '';

    currentPage = parseInt(currentPage, 10) || 1;
    totalPages = parseInt(totalPages, 10) || 1;

    const buatItemPagination = (label, targetPage, isDisabled, isActive) => {
        const li = document.createElement('li');
        li.className = `page-item ${isDisabled ? 'disabled' : ''} ${isActive ? 'active' : ''}`;

        const a = document.createElement('a');
        a.className = 'page-link';
        a.href = 'javascript:void(0);';
        a.style.cursor = isDisabled ? 'default' : 'pointer';
        a.innerHTML = label;

        if (!isDisabled && !isActive) {
            a.addEventListener('click', (e) => {
                e.preventDefault();
                fetchTableSurabayaEmas(targetPage);
            });
        }

        li.appendChild(a);
        return li;
    };

    el.appendChild(buatItemPagination('&lt;', currentPage - 1, currentPage <= 1, false));

    let startPage = Math.max(1, currentPage - 2);
    let endPage = Math.min(totalPages, currentPage + 2);

    if (currentPage <= 3) endPage = Math.min(totalPages, 5);
    if (currentPage >= totalPages - 2) startPage = Math.max(1, totalPages - 4);

    if (startPage > 1) {
        el.appendChild(buatItemPagination('1', 1, false, false));
        if (startPage > 2) {
            const elipsis = document.createElement('li');
            elipsis.className = 'page-item disabled';
            elipsis.innerHTML = '<span class="page-link text-muted">...</span>';
            el.appendChild(elipsis);
        }
    }

    for (let p = startPage; p <= endPage; p++) {
        el.appendChild(buatItemPagination(p, p, false, p === currentPage));
    }

    if (endPage < totalPages) {
        if (endPage < totalPages - 1) {
            const elipsis = document.createElement('li');
            elipsis.className = 'page-item disabled';
            elipsis.innerHTML = '<span class="page-link text-muted">...</span>';
            el.appendChild(elipsis);
        }
        el.appendChild(buatItemPagination(totalPages, totalPages, false, false));
    }

    el.appendChild(buatItemPagination('&gt;', currentPage + 1, currentPage >= totalPages, false));
}

function searchSurabayaEmasTable() {
    clearTimeout(surabayaEmasSearchTimer);
    surabayaEmasSearchTimer = setTimeout(() => {
        const input = document.getElementById('surabaya_emas_search');
        surabayaEmasSearchQuery = input ? input.value.trim() : '';
        fetchTableSurabayaEmas(1);
    }, 300);
}

function changeSurabayaEmasPageSize() {
    const sizeSelect = document.getElementById('surabaya_emas_page_size');
    if (sizeSelect) {
        surabayaEmasPageSize = parseInt(sizeSelect.value, 10);
    }
    fetchTableSurabayaEmas(1);
}

function lihatDetailBalita(id) {
    if (!id) return;

    const modalEl = document.getElementById('modalDetailBalita');
    const nikEl = document.getElementById('detail_balita_nik');
    const namaEl = document.getElementById('detail_balita_nama');
    const tbody = document.getElementById('tabel_detail_balita_body');
    const infoEl = document.getElementById('detail_balita_info');

    if (tbody) tbody.innerHTML = `<tr><td colspan="9" class="text-center py-4">Memuat data detail...</td></tr>`;

    const detailUrl = window.API_ROUTES?.surabayaEmasDetail || '/inovasi/kota/surabaya-emas/detail';

    fetch(`${detailUrl}/${encodeURIComponent(id)}`, {
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(res => {
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        return res.json();
    })
    .then(res => {
        const balita = res.balita || {};
        const riwayat = res.riwayat || [];

        if (nikEl) nikEl.textContent = balita.nik || '-';
        if (namaEl) namaEl.textContent = balita.nama || '-';

        if (tbody) {
            tbody.innerHTML = '';
            if (riwayat.length === 0) {
                tbody.innerHTML = `<tr><td colspan="9" class="text-center py-4 text-gray-400">Belum ada riwayat timbang</td></tr>`;
            } else {
                riwayat.forEach((r, idx) => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${idx + 1}</td>
                        <td>${r.tanggal_timbang || '-'}</td>
                        <td>${r.tinggi_badan ? r.tinggi_badan + ' cm' : '-'}</td>
                        <td>${r.berat_badan ? r.berat_badan + ' kg' : '-'}</td>
                        <td>${r.lila ? r.lila + ' cm' : '-'}</td>
                        <td>${r.tbu || '-'}</td>
                        <td>${r.bbu || '-'}</td>
                        <td>${r.bbtb || '-'}</td>
                        <td><span class="badge badge-light-primary fs-8">${r.status_gizi || '-'}</span></td>
                    `;
                    tbody.appendChild(tr);
                });
            }
        }

        if (infoEl) {
            infoEl.textContent = `Showing 1 to ${riwayat.length} of ${riwayat.length} records`;
        }

        renderChartDetailRiwayat(res.chart || { labels: [], bb: [], tb: [] });

        if (modalEl && typeof bootstrap !== 'undefined') {
            const modalInstance = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
            modalInstance.show();
        }
    })
    .catch(err => {
        console.error('Detail error:', err);
        if (tbody) tbody.innerHTML = `<tr><td colspan="9" class="text-center py-4 text-danger">Gagal memuat detail balita</td></tr>`;
    });
}

function renderChartDetailRiwayat(chartData) {
    const canvas = document.getElementById('chartDetailRiwayatBalita');
    if (!canvas || typeof Chart === 'undefined') return;

    if (chartDetailRiwayatInstance) {
        chartDetailRiwayatInstance.destroy();
        chartDetailRiwayatInstance = null;
    }

    const ctx = canvas.getContext('2d');
    chartDetailRiwayatInstance = new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartData.labels || [],
            datasets: [
                {
                    label: 'Tinggi Badan (cm)',
                    data: chartData.tb || [],
                    borderColor: '#009ef7',
                    backgroundColor: 'transparent',
                    borderWidth: 2,
                    tension: 0.3
                },
                {
                    label: 'Berat Badan (kg)',
                    data: chartData.bb || [],
                    borderColor: '#50cd89',
                    backgroundColor: 'transparent',
                    borderWidth: 2,
                    tension: 0.3
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top', labels: { boxWidth: 12 } },
                datalabels: { display: false }
            },
            scales: {
                y: { beginAtZero: false, ticks: { font: { size: 9 } } },
                x: { ticks: { font: { size: 9 } } }
            }
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('tabel_surabaya_emas_body')) {
        initSurabayaEmas();
    }
});


let sicantikData = [];
let sicantikCurrentPage = 1;
const sicantikLimit = 10;
let sicantikDebounceTimer = null;

function fetchTableSiCantik() {
    const tbody = document.getElementById('table-sicantik-body');
    if (tbody) {
        tbody.innerHTML = `
            <tr>
                <td colspan="5" class="text-center py-5">
                    <div class="spinner-border spinner-border-sm text-success mb-2" role="status"></div>
                    <div class="text-muted small fw-semibold">Memuat data dari database...</div>
                </td>
            </tr>
        `;
    }

    const endpoint = '/inovasi/sicantik/get-data';

    fetch(endpoint, {
        headers: {
            "X-Requested-With": "XMLHttpRequest",
            "Accept": "application/json"
        }
    })
    .then(res => {
        if (!res.ok) {
            throw new Error(`HTTP error! status: ${res.status}`);
        }
        return res.json();
    })
    .then(res => {
        if (res.status === 'success' && Array.isArray(res.data)) {
            sicantikData = res.data;
        } else if (Array.isArray(res)) {
            sicantikData = res;
        } else {
            sicantikData = [];
        }
        renderTableSiCantik(true);
    })
    .catch(err => {
        console.error("Gagal mengambil data Si Cantik:", err);
        sicantikData = [];
        renderTableSiCantik(true);
    });
}

function renderTableSiCantik(resetPage = false) {
    const tbody = document.getElementById('table-sicantik-body');
    const infoLabel = document.getElementById('table-sicantik-info');
    if (!tbody) return;

    if (resetPage) sicantikCurrentPage = 1;

    const searchInput = document.getElementById('search-sicantik-input');
    const q = (searchInput ? searchInput.value : '').toLowerCase().trim();

    const filtered = (sicantikData || []).filter(item => {
        const judul = (item.judul || '').toLowerCase();
        const deskripsi = (item.deskripsi || '').toLowerCase();
        const keterangan = (item.keterangan || '').toLowerCase();
        return q === '' || judul.includes(q) || deskripsi.includes(q) || keterangan.includes(q);
    });

    const total = filtered.length;
    const totalPages = Math.max(1, Math.ceil(total / sicantikLimit));
    if (sicantikCurrentPage > totalPages) sicantikCurrentPage = totalPages;

    const start = (sicantikCurrentPage - 1) * sicantikLimit;
    const rows = filtered.slice(start, start + sicantikLimit);

    if (rows.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="5" class="text-center py-5 text-muted small fw-semibold">
                    <i class="fa-solid fa-circle-info fs-3 d-block mb-2"></i>
                    Belum ada data Si Cantik yang ditemukan.
                </td>
            </tr>
        `;
        if (infoLabel) infoLabel.innerText = 'Showing 0 to 0 of 0 entries';
        renderPaginationSiCantik(0);
        return;
    }

    tbody.innerHTML = rows.map((item, idx) => {
        const hasImage = item.gambar && item.gambar !== '-' && item.gambar !== 'null';
        const imgThumb = hasImage 
            ? `<a href="javascript:void(0)" onclick="openPreviewSiCantik('${item.gambar}', '${(item.judul || '').replace(/'/g, "\\'")}')">
                <img src="${item.gambar}" class="img-table-thumb shadow-xs" style="width: 44px; height: 38px; object-fit: cover; border-radius: 6px;" alt="Foto">
               </a>`
            : `<span class="text-muted small">-</span>`;

        return `
            <tr>
                <td class="text-center fw-bold text-dark">${start + idx + 1}</td>
                <td class="fw-bold text-dark">${item.judul || '-'}</td>
                <td class="text-dark small" style="white-space: normal; max-width: 320px;">${item.deskripsi || '-'}</td>
                <td class="text-center">${imgThumb}</td>
                <td class="text-dark fw-medium small">${item.keterangan || '-'}</td>
            </tr>
        `;
    }).join('');

    const from = total ? start + 1 : 0;
    const to = Math.min(start + sicantikLimit, total);
    if (infoLabel) infoLabel.innerText = `Showing ${from} to ${to} of ${total} entries`;
    renderPaginationSiCantik(totalPages);
}

function renderPaginationSiCantik(totalPages) {
    const ul = document.getElementById('table-sicantik-pagination');
    if (!ul) return;

    if (totalPages <= 1) {
        ul.innerHTML = '';
        return;
    }

    let html = `
        <li class="page-item ${sicantikCurrentPage === 1 ? 'disabled' : ''}">
            <a class="page-link" href="javascript:void(0)" data-page="${sicantikCurrentPage - 1}">&lt;</a>
        </li>
    `;

    for (let p = 1; p <= totalPages; p++) {
        html += `
            <li class="page-item ${p === sicantikCurrentPage ? 'active' : ''}">
                <a class="page-link" href="javascript:void(0)" data-page="${p}">${p}</a>
            </li>
        `;
    }

    html += `
        <li class="page-item ${sicantikCurrentPage >= totalPages ? 'disabled' : ''}">
            <a class="page-link" href="javascript:void(0)" data-page="${sicantikCurrentPage + 1}">&gt;</a>
        </li>
    `;

    ul.innerHTML = html;
}

function openPreviewSiCantik(url, title) {
    const imgEl = document.getElementById('modal-preview-sicantik-img');
    const titleEl = document.getElementById('modal-preview-sicantik-title');
    if (imgEl) imgEl.src = url;
    if (titleEl) titleEl.innerText = title || 'Preview Gambar';

    const modalEl = document.getElementById('modal-preview-sicantik');
    if (modalEl) {
        if (window.bootstrap && window.bootstrap.Modal) {
            bootstrap.Modal.getOrCreateInstance(modalEl).show();
        } else if (window.jQuery) {
            $(modalEl).modal('show');
        }
    }
}

document.addEventListener('click', function(e) {
    const link = e.target.closest('#table-sicantik-pagination a[data-page]');
    if (link) {
        e.preventDefault();
        const p = parseInt(link.getAttribute('data-page'), 10);
        if (p && p !== sicantikCurrentPage) {
            sicantikCurrentPage = p;
            renderTableSiCantik();
        }
    }
});

document.addEventListener('input', function(e) {
    if (e.target && e.target.id === 'search-sicantik-input') {
        clearTimeout(sicantikDebounceTimer);
        sicantikDebounceTimer = setTimeout(() => {
            renderTableSiCantik(true);
        }, 150);
    }
});

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', fetchTableSiCantik);
} else {
    fetchTableSiCantik();
}

// Window Kampung ASI
window.initKampungAsi = initKampungAsi;
window.filterKampungAsiKecamatanTop = filterKampungAsiKecamatanTop;
window.renderGrafikKampungAsi = renderGrafikKampungAsi;
window.fetchChartKampungAsi = fetchChartKampungAsi;
window.fetchTableKampungAsi = fetchTableKampungAsi;
window.renderPaginationKampungAsi = renderPaginationKampungAsi;
window.changeKampungAsiPageSize = changeKampungAsiPageSize;
window.searchKampungAsiTable = searchKampungAsiTable;

//Window Surabaya Emas
window.initSurabayaEmas = initSurabayaEmas;
window.handleSurabayaEmasKecamatanChange = handleSurabayaEmasKecamatanChange;
window.terapkanFilterSurabayaEmas = terapkanFilterSurabayaEmas;
window.resetFilterSurabayaEmas = resetFilterSurabayaEmas;
window.changeSurabayaEmasPageSize = changeSurabayaEmasPageSize;
window.searchSurabayaEmasTable = searchSurabayaEmasTable;
window.fetchTableSurabayaEmas = fetchTableSurabayaEmas;
window.lihatDetailBalita = lihatDetailBalita;

// Window Exports
window.populateInovasiOptions = populateInovasiOptions;
window.handlePokjaChange = handlePokjaChange;
window.handleInovasiChange = handleInovasiChange;

//Window Soth
window.initSoth = initSoth;
window.initDropdownKelurahanSoth = initDropdownKelurahanSoth;
window.handleSothKecamatanChange = handleSothKecamatanChange;
window.terapkanFilterSoth = terapkanFilterSoth;
window.resetFilterSoth = resetFilterSoth;
window.initChartSoth = initChartSoth;
window.fetchChartSoth = fetchChartSoth;
window.fetchTableSoth = fetchTableSoth;
window.searchSothTable = searchSothTable;
window.changeSothPageSize = changeSothPageSize;

$(document).ready(function() {
    handlePokjaChange();

    $('#select-filter-pokja').on('change select2:select', function() {
        handlePokjaChange();
    });

    $('#select-filter-inovasi').on('change select2:select', function() {
        handleInovasiChange();
    });
});