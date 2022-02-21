<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Drixo - Responsive Booststrap 4 Admin & Dashboard</title>
    <meta content="Admin Dashboard" name="description" />
    <meta content="ThemeDesign" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="shortcut icon" href="images/favicon.ico">

    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css">

</head>


<body class="fixed-left">

    <!-- Loader -->
    <div id="preloader">
        <div id="status">
            <div class="spinner"></div>
        </div>
    </div>
    <!-- Begin page -->
    <div class="accountbg">
        <div class="content-center">
            <div class="content-desc-center">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5 col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    @include('common.flash')
                                    <h3 class="text-center mt-0 m-b-15">
                                        <a href="" class="logo logo-admin"><img
                                                src="{{ asset('assets/images/logo-dark.png') }}" height="30"
                                                alt="logo"></a>
                                    </h3>

                                    <h4 class="text-muted text-center font-18"><b>Please verify Your Account</b></h4>

                                    <div class="p-2">
                                        <form method="#" id="otp" action="#">
                                            @csrf

                                            <div class="form-group row">
                                                <label for="otp"
                                                    class="col-md-4 col-form-label text-md-right">{{ __('Enter Otp') }}</label>

                                                <div class="col-md-6">
                                                    <input id="otp" type="number" name="otp" class="form-control "
                                                        autocomplete="otp" autofocus>
                                                </div>
                                            </div>

                                            <div class="form-group row">

                                                <div class="col-md-6">
                                                    <input type="hidden" value="{{ $user->id }}" name="id"
                                                        class="form-control ">
                                                </div>
                                            </div>


                                            <div class="form-group row mb-0">
                                                <div class="col-md-8 offset-md-4">
                                                    <button type="submit" class="btn btn-primary submit">
                                                        {{ __('Verify') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery  -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/modernizr.min.js') }}"></script>
    <script src="{{ asset('assets/js/detect.js') }}"></script>
    <script src="{{ asset('assets/js/fastclick.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.blockUI.js') }}"></script>
    <script src="{{ asset('assets/js/waves.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.nicescroll.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.scrollTo.min.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('assets/js/app.js') }}"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script>
        var otpVerify ="{{ route('otp_verify') }}"
        // $('#otp').validate({

        //     rules: {
        //         otp: {
        //             required: true,
        //         }
        //     },
        //     messages: {
        //         otp: {
        //             required: "Please enter otp first",
        //         }
        //     },
        //     submitHandler: function(form) {
        //         $.ajax({
        //             headers: {
        //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        //             },

        //             url: "{{ route('otp_verify') }}",
        //             method: "POST",
        //             data: new FormData(form),
        //             contentType: false,
        //             cache: false,
        //             processData: false,
        //             dataType: 'JSON',
        //             success: function(data) {

        //                 if (data.status == true) {
        //                     alert(data.message);
        //                     window.location.href = '/home';
        //                 } else {
        //                     alert(data.message);

        //                 }

        //             }
        //         });
        //     }
        // });
    </script>
</body>

</html>
