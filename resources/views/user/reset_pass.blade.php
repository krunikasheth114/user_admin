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
                                        <form method="POST" id="reset" action="#">
                                            @csrf

                                            <div class="form-group row" id="mydiv1">
                                                <label for="pass"
                                                    class="col-md-4 col-form-label text-md-right">{{ __('New Password') }}</label>
                                                <div class="col-md-6">
                                                    <input id="pass" type="password" name="pass" class="form-control "
                                                        autocomplete="pass" autofocus>
                                                </div>
                                            </div>
                                            <div class="form-group row" id="mydiv2">
                                                <label for="cpass"
                                                    class="col-md-4 col-form-label text-md-right">{{ __(' Confirm Password ') }}</label>
                                                <div class="col-md-6">
                                                    <input id="cpass" type="password" name="cpass"
                                                        class="form-control  " autocomplete="cpass" autofocus>
                                                </div>
                                            </div>
                                            <input type="hidden" value="{{ $id }}" name="id" id="id">

                                            <div class="form-group row mb-0" id="mybtn">
                                                <div class="col-md-8 offset-md-4">
                                                    <button type="submit" name="submit" id="reset"
                                                        class="btn btn-primary reset">
                                                        {{ __('Reset') }}
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
        var confirm_pass="{{ route('user.confirm_pass') }}"
        // $('#reset').validate({

        //     rules: {
              
        //         pass: {
        //             required: true,
        //         },
        //         cpass: {
        //             required: true,
        //             equalTo: '#pass'
        //         },

        //     },
        //     messages: {
               
        //         pass: {
        //             required: "please Enter Passwoord ",
        //         },
        //         cpass: {
        //             required: "Please Enter Confirm Password",
        //             equalTo: 'Confirm Password must be same as Password',
        //         },

        //     },
        //     submitHandler: function(form) {

        //         $.ajax({
        //             headers: {
        //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        //             },
        //             url: "{{ route('user.confirm_pass') }}",
        //             method: "POST",
        //             data: new FormData(form),
        //             contentType: false,
        //             cache: false,
        //             processData: false,
        //             dataType: 'JSON',
        //             success: function(data) {
        //                 if(data.status==true){
        //                     alert(data.message)
        //                 }
        //                 window.location.href = '/user/login' ;

        //             }


        //         });

        //     }


        // });
    </script>

</body>

</html>
