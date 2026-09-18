<!-- KONTEN INOVASI KEMANGGI (Tampil Bersih di Samping Sidebar Metronic) -->
<div class="d-flex flex-column gap-5">

    <!-- 1. Card Deskripsi Program Kemangi -->
    <div class="card card-flush shadow-sm rounded-4 border-0">
        <div class="card-body p-5 p-lg-8">
            <h2 class="fw-bolder text-gray-900 mb-1 fs-2">
                Inovasi Kemangi 
            </h2>
            <h4 class="text-success fw-bold text-uppercase tracking-wider fs-6 mb-3">
                Kelas Remaja dan Orang Tua Tangguh, Kreatif, dan Mandiri
            </h4>
            <div class="bg-success rounded-pill mb-4" style="height: 3px; width: 60px;"></div>
            <p class="text-gray-600 fs-6 lh-base mb-0">
                Kelas Remaja-orang tua tangguh, kreatif dan mandiri Kota Surabaya (KEMANGI) adalah kelas yang diadakan sebagai upaya untuk meningkatkan pengetahuan dan keterampilan para remaja dalam memberikan edukasi terhadap teman sebaya. Meningkatkan pengetahuan, sikap dan perilaku yang positif dalam pengembangan diri remaja secara mental, fisik, intelektual, spiritual dan sosial serta meningkatkan keterampilan orang tua dalam pengasuhan remaja agar keluarga mampu menghadapi tantangan modern dengan lebih baik.
            </p>
            <span class="text-gray-600 fs-6 lh-base mb-0 d-block mt-3">
                KEMANGGI merupakan inovasi yang dikembangkan oleh Dinas Pemberdayaan Perempuan dan Perlindungan Anak Kota Surabaya. Inovasi ini bertujuan untuk meningkatkan kualitas hidup remaja dan orang tua melalui pendidikan, pelatihan, dan dukungan sosial.
            </span>
        </div>
    </div>

    <!-- 2. Card Filter: Kecamatan & Periode (Sesuai Gambar Tangkapan Layar Anda) -->
    <div class="card card-flush shadow-sm rounded-4 border-0">
        <div class="card-body p-5 p-lg-6">
            <div class="row g-4">
                <div class="col-12 col-md-6">
                    <label for="filter_kecamatan" class="form-label fs-7 fw-bold text-gray-700 text-uppercase tracking-wide mb-2">
                        Kecamatan
                    </label>
                    <select id="filter_kecamatan" class="form-select form-select-solid fw-semibold">
                        <option value="SEMUA KECAMATAN" selected>SEMUA KECAMATAN</option>
                        <option value="Genteng">Genteng</option>
                        <option value="Tegalsari">Tegalsari</option>
                        <option value="Wonokromo">Wonokromo</option>
                        <option value="Gubeng">Gubeng</option>
                    </select>
                </div>
                <div class="col-12 col-md-6">
                    <label for="filter_periode" class="form-label fs-7 fw-bold text-gray-700 text-uppercase tracking-wide mb-2">
                        Periode
                    </label>
                    <select id="filter_periode" class="form-select form-select-solid fw-semibold">
                        <option value="2025" selected>2025</option>
                        <option value="2024">2024</option>
                        <option value="2023">2023</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. Card Grafik Nilai Rata-rata Remaja -->
    <div class="card card-flush shadow-sm rounded-4 border-0 overflow-hidden">
        <div class="card-header bg-light-subtle py-4 px-5 px-lg-7 border-0 d-flex flex-wrap align-items-center justify-content-between gap-2">
            <h3 class="card-title fw-bolder text-gray-800 fs-5 text-uppercase m-0">
                NILAI RATA - RATA REMAJA
            </h3>
            <span class="badge badge-light-primary fw-bold fs-7 px-3 py-2">
                Periode: 2025
            </span>
        </div>
        <div class="card-body p-4 p-lg-7">
            <!-- Legend Garis Custom (Biru & Merah) -->
            <div class="d-flex align-items-center justify-content-center gap-5 mb-4 fs-7 fw-semibold text-gray-600">
                <div class="d-flex align-items-center gap-2">
                    <span class="d-inline-block rounded-pill" style="width: 26px; height: 6px; background-color: #0284c7;"></span>
                    <span>Pretest</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="d-inline-block rounded-pill" style="width: 26px; height: 6px; background-color: #f43f5e;"></span>
                    <span>Posttest</span>
                </div>
            </div>
            <!-- Canvas Grafik Remaja -->
            <div style="position: relative; width: 100%; height: 320px;">
            <canvas id="chartKemanggiRemaja"></canvas>
        </div>
        </div>
    </div>

    <!-- 4. Card Grafik Nilai Rata-rata Orang Tua -->
    <div class="card card-flush shadow-sm rounded-4 border-0 overflow-hidden">
        <div class="card-header bg-light-subtle py-4 px-5 px-lg-7 border-0 d-flex flex-wrap align-items-center justify-content-between gap-2">
            <h3 class="card-title fw-bolder text-gray-800 fs-5 text-uppercase m-0">
                NILAI RATA - RATA ORANG TUA
            </h3>
            <span class="badge badge-light-primary fw-bold fs-7 px-3 py-2">
                Periode: 2025
            </span>
        </div>
        <div class="card-body p-4 p-lg-7">
            <!-- Legend Garis Custom (Biru & Merah) -->
            <div class="d-flex align-items-center justify-content-center gap-5 mb-4 fs-7 fw-semibold text-gray-600">
                <div class="d-flex align-items-center gap-2">
                    <span class="d-inline-block rounded-pill" style="width: 26px; height: 6px; background-color: #0284c7;"></span>
                    <span>Pretest</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="d-inline-block rounded-pill" style="width: 26px; height: 6px; background-color: #f43f5e;"></span>
                    <span>Posttest</span>
                </div>
            </div>
            <!-- Canvas Grafik Orang Tua -->
           <div style="position: relative; width: 100%; height: 320px;">
                <canvas id="chartKemanggiOrangTua"></canvas>
            </div>
        </div>
    </div>

    <!-- 5. Card Tabel Rekapitulasi Data (Status Dihapus) -->
    <div class="card card-flush shadow-sm rounded-4 border-0 overflow-hidden">
        <div class="card-header py-5 px-5 px-lg-7 border-0">
            <h3 class="card-title fw-bolder text-gray-900 fs-5 m-0">
                Tabel Rekapitulasi Nilai & Peserta
            </h3>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle table-row-dashed fs-7 gy-4 mb-0">
                    <thead class="bg-light text-gray-600 fw-bold fs-8 text-uppercase border-bottom border-gray-200">
                        <tr>
                            <th class="ps-5 py-3 text-center" style="width: 50px;">No</th>
                            <th class="py-3">Kecamatan</th>
                            <th class="py-3">Kelurahan</th>
                            <th class="py-3 text-center">Rata-rata Nilai Pre</th>
                            <th class="py-3 text-center">Rata-rata Nilai Post</th>
                            <th class="pe-5 py-3 text-center">Jumlah Peserta</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-700">
                        <tr>
                            <td class="ps-5 text-center text-gray-400">1</td>
                            <td class="text-dark fw-bold">Kecamatan Wonokromo</td>
                            <td>Darmo</td>
                            <td class="text-center fw-bold" style="color: #0284c7;">54.20</td>
                            <td class="text-center fw-bold" style="color: #f43f5e;">124.50</td>
                            <td class="pe-5 text-center">45</td>
                        </tr>
                        <tr>
                            <td class="ps-5 text-center text-gray-400">2</td>
                            <td class="text-dark fw-bold">Kecamatan Wonokromo</td>
                            <td>Sawunggaling</td>
                            <td class="text-center fw-bold" style="color: #0284c7;">61.10</td>
                            <td class="text-center fw-bold" style="color: #f43f5e;">135.00</td>
                            <td class="pe-5 text-center">50</td>
                        </tr>
                        <tr>
                            <td class="ps-5 text-center text-gray-400">3</td>
                            <td class="text-dark fw-bold">Kecamatan Tegalsari</td>
                            <td>Keputran</td>
                            <td class="text-center fw-bold" style="color: #0284c7;">48.75</td>
                            <td class="text-center fw-bold" style="color: #f43f5e;">118.20</td>
                            <td class="pe-5 text-center">38</td>
                        </tr>
                        <tr>
                            <td class="ps-5 text-center text-gray-400">4</td>
                            <td class="text-dark fw-bold">Kecamatan Tegalsari</td>
                            <td>Dr. Soetomo</td>
                            <td class="text-center fw-bold" style="color: #0284c7;">70.00</td>
                            <td class="text-center fw-bold" style="color: #f43f5e;">142.30</td>
                            <td class="pe-5 text-center">42</td>
                        </tr>
                        <tr>
                            <td class="ps-5 text-center text-gray-400">5</td>
                            <td class="text-dark fw-bold">Kecamatan Gubeng</td>
                            <td>Airlangga</td>
                            <td class="text-center fw-bold" style="color: #0284c7;">58.60</td>
                            <td class="text-center fw-bold" style="color: #f43f5e;">129.80</td>
                            <td class="pe-5 text-center">60</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Footer Pagination Metronic Responsif -->
            <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between p-5 border-top border-gray-100 gap-3">
                <div class="d-flex align-items-center gap-2 fs-7 text-gray-600">
                    <span>Showing</span>
                    <select class="form-select form-select-sm form-select-solid w-auto">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                    <span>of 45 entries</span>
                </div>
                <ul class="pagination pagination-sm m-0">
                    <li class="page-item previous disabled"><a href="#" class="page-link px-3">&lsaquo;</a></li>
                    <li class="page-item active"><a href="#" class="page-link px-3">1</a></li>
                    <li class="page-item"><a href="#" class="page-link px-3">2</a></li>
                    <li class="page-item"><a href="#" class="page-link px-3">3</a></li>
                    <li class="page-item next"><a href="#" class="page-link px-3">&rsaquo;</a></li>
                </ul>
            </div>
        </div>
    </div>

</div>