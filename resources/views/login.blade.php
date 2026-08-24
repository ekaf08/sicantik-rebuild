<!DOCTYPE html>

<html lang="en">

    <head>
        <base href="../../../">
        <title>Si Cantik Kota Surabaya</title>
        <meta charset="utf-8" />
        <meta name="description" content="Si Cantik" />
        <meta name="keywords" content="Pemerintah Kota Surabaya" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta property="og:locale" content="en_US" />
        <meta property="og:type" content="article" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="{{ asset('img/png/logo-sicantik.png') }}" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
        <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/vendor/dist/aos.css') }}" rel="stylesheet">
        <script src="{{ asset('assets/vendor/dist/aos.js') }}"></script>
    </head>

    <style>
        .bodycolor {
            background-image: url('{{ asset('img/png/bg_side_batik.png') }}');
            background-repeat: no-repeat;
            background-size: cover;
        }

        /* .bodycolor {
        position: relative;
        overflow: hidden;
    }

    .bodycolor::before {
        content: "";
        position: absolute;
        inset: 0;
        background-image: url('{{ asset('img/svg/bg_login_2.svg') }}');
        background-repeat: no-repeat;
        background-size: cover;
        transform: scaleX(-1);
        transform-origin: center;
        z-index: -1; /* supaya tidak nutupin konten */
        }

        */ .container {
            margin-right: auto;
            margin-left: auto;
            padding-right: 15px;
            padding-left: 15px;
            width: 100%;
            display: flex;
        }

        .log1 {
            position: absolute;
            z-index: 1;
            /* animation-name: log1;
  animation-duration: 5s;
  animation-iteration-count: infinite; */
        }

        .log2 {
            position: absolute;
            z-index: 2;
            animation-name: log2;
            animation-duration: 5s;
            animation-iteration-count: infinite;
        }

        .log3 {
            position: absolute;
            z-index: 3;
            animation-name: log3;
            animation-duration: 4s;
            animation-iteration-count: infinite;
        }

        .log4 {
            position: absolute;
            z-index: 4;
            /* animation-name: log3;
  animation-duration: 5s;
  animation-iteration-count: infinite; */
        }

        .log5 {
            position: absolute;
            z-index: 5;
            animation-name: log5;
            animation-duration: 6s;
            animation-iteration-count: infinite;
        }

        .log6 {
            position: absolute;
            z-index: 6;
            animation-name: log6;
            animation-duration: 6s;
            animation-iteration-count: infinite;
        }

        .btn.btn-primary,
        .swal2-confirm {
            color: #fff;
            background-color: #FF414D;
        }

        .btn.btn-primary:hover:not(.btn-active),
        .swal2-confirm:hover {
            color: #fff;
            background-color: #7A1012 !important;
        }

        @keyframes log1 {
            0% {
                transform: scale(0.98);
            }

            25% {
                transform: translateZ(0) scale(1);
            }

            50% {
                transform: scale(0.98);
            }

            75% {
                transform: translateZ(0) scale(1);
            }

            100% {
                transform: scale(0.98);
            }
        }

        @keyframes log2 {
            0% {
                transform: scale(1);
            }

            25% {
                transform: translateZ(0) scale(0.97);
            }

            50% {
                transform: scale(1);
            }

            75% {
                transform: translateZ(0) scale(0.97);
            }

            100% {
                transform: scale(1);
            }
        }

        @keyframes log3 {
            0% {
                transform: scale(0.95);
            }

            25% {
                transform: translateZ(0) scale(1);
            }

            50% {
                transform: scale(0.95);
                opacity: 100%;
            }

            75% {
                transform: translateZ(0) scale(1);
            }

            100% {
                transform: scale(0.95);
                opacity: 100%;
            }
        }

        @keyframes log4 {
            0% {
                transform: scale(1);
                opacity: 0%;
            }

            25% {
                transform: translateZ(0) scale(0.95);
                opacity: 100%;
            }

            50% {
                transform: scale(1);
                opacity: 0%;
            }

            75% {
                transform: translateZ(0) scale(0.95);
                opacity: 100%;
            }

            100% {
                transform: scale(1);
                opacity: 0%;
                animation-delay: 1000s
            }
        }

        @keyframes log5 {
            0% {
                transform: scale(0.95);
            }

            25% {
                transform: translateZ(0) scale(1);
            }

            50% {
                transform: scale(0.95);
            }

            75% {
                transform: translateZ(0) scale(1);
            }

            100% {
                transform: scale(0.95);
            }
        }

        @keyframes log6 {
            0% {
                transform: scale(1);
            }

            25% {
                transform: translateZ(0) scale(0.95);
            }

            50% {
                transform: scale(1);
            }

            75% {
                transform: translateZ(0) scale(0.95);
            }

            100% {
                transform: scale(1);
            }
        }

        @media only screen and (max-width: 767px) {
            .ilus {
                padding: 15px 0;
                width: 95%;
                justify-content: center;
                align-items: center;
                position: relative;
            }

            #gambar {
                display: none !important;
            }

            .mobile {
                min-height: 100%
            }
        }

        #pop-up-hjks .modal-content {
            background-color: transparent;
            border: none;
        }

        #pop-up-hjks .modal-header {
            border-bottom: none;
        }

        #pop-up-hjks .modal-body img {
            width: 100%;
        }

        #pop-up-hjks .modal-footer {
            border-top: none;
            justify-content: center;
        }
    </style>

    <body id="kt_body" class="bodycolor" style="justify-content: center;">
        <div class="container">
            <div class="d-flex flex-column flex-root ilus">
                <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed"
                    style="max-width: 100%">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex flex-center flex-column p-5 pb-lg-15">
                                {{-- <div class="d-md-none mb-5">
                                <div class="d-flex align-items-center justify-content-center">
                                    <img src="{{ asset('img/png/sby-pkk.png') }}" alt="" class="h-100px">
                                </div>
                            </div> --}}
                                <div class="w-lg-400px bg-body rounded shadow-sm p-8 mx-auto">
                                    <div class="mb-7" style="justify-content: center; text-align: center;">
                                        <img alt="Logo" src="{{ asset('img/png/logo-sicantik-pkk.png') }}"
                                            class="w-100" />
                                    </div>
                                    <div class="mb-10" style="justify-content: center; text-align: center;">
                                        <h5>Sistem Informasi<br>Pencatatan Kegiatan dan Inovasi PKK</h5>
                                    </div>
                                    <form class="form w-100" id="form">
                                        @csrf
                                        <div class="fv-row mb-10">
                                            <div class="input-group mb-5">
                                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                <input type="text" class="form-control" placeholder="Username"
                                                    name="username" />
                                            </div>

                                            <div class="input-group mb-5">
                                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                                                <input type="password" class="form-control" id="passwordInput"
                                                    placeholder="Password" name="password" />
                                                <span class="input-group-text" style="cursor:pointer;"
                                                    id="togglePassword">
                                                    <i class="fas fa-eye" id="togglePasswordIcon"></i>
                                                </span>
                                            </div>

                                            {{-- Captcha --}}
                                            <div class="mb-5 text-center">
                                                <div class="d-flex justify-content-center align-items-center gap-2">
                                                    <img src="{{ captcha_src('flat') }}" id="captchaImage"
                                                        style="cursor:pointer;" onclick="refreshCaptcha()"
                                                        title="Klik untuk refresh">
                                                    <button type="button" class="btn btn-sm btn-icon btn-light"
                                                        id="btnRefreshCaptcha" onclick="refreshCaptcha()"
                                                        title="Refresh captcha">
                                                        <i class="fas fa-sync-alt"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="input-group mb-5">
                                                <span class="input-group-text"><i class="fas fa-shield-alt"></i></span>
                                                <input type="text" class="form-control"
                                                    placeholder="Masukkan kode captcha" name="captcha" />
                                            </div>
                                            <div class="text-danger fs-8" id="captchaError"></div>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" id="kt_sign_in_submit"
                                                class="btn btn-success w-40 mb-5">
                                                <span class="indicator-label btn-login fw-bold"><i
                                                        class="fas fa-sign-in-alt me-2"></i>Login</span>
                                                <span class="indicator-progress wait-login" style="display:none;">
                                                    Please wait... <span
                                                        class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                </span>
                                            </button>
                                        </div>
                                    </form>
                                    <div class="separator my-5"></div>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <img src="{{ asset('img/png/logo-sby.png') }}" alt=""
                                            class="m-3 h-50px">
                                        <h5 class="mb-0">Kota Surabaya</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex flex-center flex-column flex-column-fluid" id="gambar"
                            style="padding: 50px;">
                            <div class="log1 d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20"
                                id="gambar" data-aos="zoom-in-up" data-aos-duration="3000">
                                <img src="{{ asset('img/png/rini_1.png') }}" alt="Image" class="img-fluid "
                                    id="gambar" style="width: 600px">
                            </div>
                            <div class="log2 d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20"
                                id="gambar" data-aos="zoom-in-up" data-aos-duration="1000">
                                <img src="{{ asset('img/png/rini_2.png') }}" alt="Image" class="img-fluid "
                                    id="gambar" style="width: 600px">
                            </div>
                            <div class="log3 d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20"
                                id="gambar" data-aos="zoom-in-up" data-aos-duration="1000">
                                <img src="{{ asset('img/png/rini_3.png') }}" alt="Image" class="img-fluid "
                                    id="gambar" style="width: 600px">
                            </div>
                            <div class="log4 d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20"
                                id="gambar" data-aos="zoom-in-up" data-aos-duration="1000">
                                <img src="{{ asset('img/png/rini_4_ai.png') }}" alt="Image" class="img-fluid "
                                    id="gambar" style="width: 600px">
                            </div>
                            {{-- <img src="{{ asset('img/png/logopkk.png') }}" alt="Image" class="img-fluid " id="gambar" style="width: 400px"> --}}
                            {{-- <img src="{{ asset('img/png/keluarga-pkk.png') }}" alt="Image" class="img-fluid " id="gambar" style="width: 400px"> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="position-absolute top-0 end-0 d-none d-md-block">
        <img src="{{ asset('img/png/sby-pkk.png') }}" alt="" class="m-3 h-lg-100px h-md-75px">
    </div> --}}

        <!-- Modal HJKS POP UP -->
        {{-- <div class="modal fade" id="pop-up-hjks" tabindex="-1" aria-labelledby="pop-up-hjksLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="{{ asset('img/png/hjks-pop-up.png') }}" alt="" srcset="">
            </div>
            <div class="modal-footer">
                <a href="https://www.surabaya.go.id/" target="_blank" type="button" class="btn btn-primary">Selengkapnya...</a>
            </div>
        </div>
    </div>
    </div> --}}
        {{-- <script async src="https://www.google.com/recaptcha/api.js"></script> --}}
        <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
        <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
        {{-- <script type="text/javascript">
        $('#pop-up-hjks').modal('show');
    </script> --}}

        <script>
            // Toggle show/hide password
            $(document).ready(function() {
                $('#togglePassword').on('click', function() {
                    const $input = $('#passwordInput');
                    const $icon = $('#togglePasswordIcon');

                    if ($input.attr('type') === 'password') {
                        $input.attr('type', 'text');
                        $icon.removeClass('fa-eye').addClass('fa-eye-slash');
                    } else {
                        $input.attr('type', 'password');
                        $icon.removeClass('fa-eye-slash').addClass('fa-eye');
                    }
                });
            });

            // Refresh captcha dengan animasi loading pada tombol
            function refreshCaptcha() {
                const $btn = $('#btnRefreshCaptcha');
                const $icon = $btn.find('i');

                $icon.addClass('fa-spin');

                $.ajax({
                    url: "{{ route('captcha.refresh') }}",
                    type: "GET",
                    cache: false, // <-- penting, cegah browser cache response AJAX
                    success: function(data) {
                        // tambahkan timestamp di query string agar <img> tidak load dari cache
                        $('#captchaImage').attr('src', data.captcha + '&t=' + new Date().getTime());
                    },
                    complete: function() {
                        $icon.removeClass('fa-spin');
                    }
                });
            }

            $(document).ready(function() {
                $('#form').on('submit', function(e) {
                    e.preventDefault();

                    const $btn = $('#kt_sign_in_submit');
                    const $label = $btn.find('.indicator-label');
                    const $wait = $btn.find('.indicator-progress');

                    // Tampilkan loading
                    $btn.prop('disabled', true);
                    $label.hide();
                    $wait.show();
                    $('#captchaError').text('');

                    $.ajax({
                        url: "{{ route('login.post') }}",
                        method: "POST",
                        data: $(this).serialize(),
                        success: function(res) {
                            if (res.status) {
                                window.location.href = res.redirect;
                            }
                        },
                        error: function(xhr) {
                            const res = xhr.responseJSON;
                            if (res && res.message) {
                                $('#captchaError').text(res.message);
                            }
                            // Refresh captcha setiap kali gagal login
                            refreshCaptcha();
                            $('input[name=captcha]').val('');
                        },
                        complete: function() {
                            $btn.prop('disabled', false);
                            $label.show();
                            $wait.hide();
                        }
                    });
                });
            });
        </script>

    </body>

</html>
