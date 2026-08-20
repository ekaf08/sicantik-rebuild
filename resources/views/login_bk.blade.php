 <!-- <script type="text/javascript">
            $(window).on('load', function() {
                $('#pop-up-hjks').modal('show');
            });
        </script>

        <script>
            $(document).ready(function() {
                const saveData = $("#kt_sign_in_submit");

                if (saveData.length) {
                    $('#form').on('submit', function(event) {
                        event.preventDefault();

                        $('.btn-login').hide();
                        $('.wait-login').show();
                        const button = $(this).find('button');
                        button.prop('disabled', true);

                        const formData = $(this).serialize(); // Serialize form data
                        const dataToken = $('meta[name="csrf-token"]').attr('content');

                        $.ajax({
                            url: "{{ route('.login') }}",
                            type: "POST",
                            data: formData + '&_token=' + dataToken,
                            dataType: "json",
                            success: function(post) {
                                if (post.code == 222) {
                                    location.assign(post.data.url);
                                } else {
                                    // Menampilkan pesan kesalahan untuk pesan umum
                                    Swal.fire({
                                        text: post.message,
                                        icon: "error",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok",
                                        customClass: {
                                            confirmButton: "btn"
                                        },
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            refreshCaptcha();
                                        }
                                    });
                                }
                            },
                            error: function(xhr) {
                                // Menangani kesalahan server
                                if (xhr.responseJSON && xhr.responseJSON.errors) {
                                    let errorMessages = "";
                                    $.each(xhr.responseJSON.errors, function(key, value) {
                                        errorMessages += value.join(", ") +
                                        "<br>"; // Menggabungkan semua pesan kesalahan
                                    });

                                    Swal.fire({
                                        html: errorMessages, // Menggunakan HTML untuk menampilkan pesan kesalahan
                                        icon: "error",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok",
                                        customClass: {
                                            confirmButton: "btn"
                                        },
                                    });
                                } else {
                                    // Jika tidak ada detail kesalahan, tampilkan pesan umum
                                    const errorMessage = xhr.responseJSON?.message ||
                                        "Internal Server Error";
                                    Swal.fire({
                                        text: errorMessage,
                                        icon: "error",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok",
                                        customClass: {
                                            confirmButton: "btn"
                                        },
                                    });
                                }
                            },
                            complete: function() {
                                $('.btn-login').show();
                                $('.wait-login').hide();
                                button.prop('disabled', false);
                            }
                        });
                    });
                }
            });
        </script>

        <script>
            AOS.init();
        </script>
        <script>
            function refreshCaptcha() {
                $.ajax({
                    type: 'GET',
                    url: "{{ route('refreshCaptcha') }}",
                    success: function(response) {
                        $('.captcha-container').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
            $(document).ready(function() {
                $("#form").keydown(function(e) {
                    if (e.originalEvent.key === "Enter") {
                        e.preventDefault();
                        $("#kt_sign_in_submit").click();
                    }
                });

                $("#refresh-captcha").on("click", function(e) {
                    e.preventDefault();
                    refreshCaptcha();
                });
            });
        </script> -->
