<ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-6 fs-6 flex-nowrap overflow-auto" role="tablist" id="tabs_{{ $prefix }}">
    @foreach($tabLaporan as $i => $t)
        <li class="nav-item" role="presentation">
            <a class="nav-link text-nowrap {{ $i === 0 ? 'active' : '' }}"
               data-bs-toggle="tab"
               href="#pane_{{ $prefix }}_{{ $t['field'] }}"
               data-field="{{ $t['field'] }}"
               role="tab">
                {{ $t['tab'] }}
                <i class="ki-outline ki-check-circle text-success fs-4 ms-1 d-none tab-check"></i>
            </a>
        </li>
    @endforeach
</ul>

<div class="tab-content">
    @foreach($tabLaporan as $i => $t)
        <div class="tab-pane fade {{ $i === 0 ? 'show active' : '' }}" id="pane_{{ $prefix }}_{{ $t['field'] }}" role="tabpanel">
            <h4 class="fw-bold text-gray-900 text-center mb-5">{{ $t['judul'] }}</h4>

            <div class="alert alert-primary bg-light-primary border border-primary d-flex p-5 mb-8">
                <i class="ki-outline ki-information-5 fs-2 text-warning me-4 mt-1"></i>
                <div class="d-flex flex-column">
                    <span class="fw-semibold text-primary mb-2">Panduan Pengisian {{ $t['tab'] }}:</span>
                    <ul class="mb-0 ps-5 text-primary">
                        @foreach($t['panduan'] as $p)
                            <li>{{ $p }}</li>
                        @endforeach
                    </ul>

                    @if(!empty($t['catatan']))
                        <span class="text-primary mt-3">{{ $t['catatan'] }}</span>
                    @endif

                    @if(!empty($t['butir']))
                        <ul class="mb-0 mt-2 ps-5 text-primary" style="list-style-type: '- ';">
                            @foreach($t['butir'] as $b)
                                <li>{{ $b }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            @if($prefix === 'edit')
                <div class="file-status mb-4" data-field="{{ $t['field'] }}"></div>
            @endif

            <label class="form-label fw-semibold text-gray-800">
                <span class="label-upload">{{ $t['tab'] }}</span>
                <span class="fst-italic text-danger fs-7">(File maksimal 2Mb)</span>
            </label>
            <input type="file"
                   name="{{ $t['field'] }}"
                   class="form-control form-control-solid input-file-laporan"
                   accept=".pdf" />
            <div class="form-text">Format PDF. Boleh dikosongkan dan diunggah belakangan.</div>
        </div>
    @endforeach
</div>