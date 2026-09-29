@extends('bo.layout.app')

@section('content')
<div id="kt_app_content_container" class="app-container container-fluid">
    <div class="card card-flush py-4">
        <div class="card-header">
            <div class="card-title">
                <h2>{{ $menu->nama_menu }}</h2>
            </div>
        </div>
        <div class="card-body pt-0">
            <p class="text-muted">Ini adalah halaman dinamis untuk menu: <strong>{{ $menu->nama_menu }}</strong></p>
            <p>URL Slug saat ini : <code>{{ $menu->url_menu }}</code></p>
        </div>
    </div>
</div>
@endsection