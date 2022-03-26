<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Drixo - Responsive Booststrap 4 Admin & Dashboard</title>
    <meta content="Admin Dashboard" name="description" />
    <meta content="ThemeDesign" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />


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
                                    <h3 class="text-center mt-0 m-b-15">
                                        <a href="" class="logo logo-admin"><img
                                                src="{{ asset('assets/images/logo-dark.png') }}" height="30"
                                                alt="logo"></a>
                                    </h3>

                                    <h4 class="text-muted text-center font-18"><b>
                                            Register here!</b></h4>

                                    <div class="p-2">
                                        <form action="" method="post" id="register_form">
                                            @csrf
                                            <div class="form-group">
                                                <label for="firstname">{{ __('Firstname') }} :</label>
                                                <input id="firstname" type="text" class="form-control"
                                                    name="firstname" value="{{ old('firstname') }}"
                                                    autocomplete="firstname" placeholder="Enter Firstname" autofocus>
                                            </div>

                                            @if ($errors->has('firstname'))
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $errors->first('firstname') }}</strong>
                                                </span>
                                            @endif

                                            <div class="form-group ">
                                                <label for="lastname">{{ __('Lastname') }} :</label>
                                                <input id="lastname" type="text"
                                                    class="form-control @error('lastname') is-invalid @enderror"
                                                    name="lastname" value="{{ old('lastname') }}"
                                                    autocomplete="lastname" placeholder="Enter Lastname" autofocus>
                                            </div>
                                            @if ($errors->has('lastname'))
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $errors->first('lastname') }}</strong>
                                                </span>
                                            @endif


                                            <div class="form-group ">
                                                <label for="email">{{ __('Email') }} :</label>

                                                <input id="email" type="email" class="form-control" name="email"
                                                    value="{{ old('email') }}" autocomplete="email"
                                                    placeholder="Enter Email" autofocus>
                                            </div>
                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif

                                            <div class="form-group">
                                                <label for="category">{{ __('Category') }} :</label>
                                                <select class="form-control" name="category" id="category">
                                                    <option value="">---Select Category ----</option>
                                                    @foreach ($data as $category)
                                                        <option value="{{ $category->id }}">
                                                            {{ $category->category_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @if ($errors->has('category'))
                                                <span class="invalid-feedback d-block" id="category" role="alert">
                                                    <strong>{{ $errors->first('category') }}</strong>
                                                </span>
                                            @endif


                                            <div class="form-group">
                                                <label for="subcategory">{{ __('Subcategory') }} :</label>
                                                <select class="form-control" name="subcategory" id="subcategory">
                                                    <option value="">---Select Sub Category ----</option>
                                                </select>
                                            </div>
                                            @if ($errors->has('subcategory'))
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $errors->first('subcategory') }}</strong>
                                                </span>
                                            @endif

                                            <div class="form-group ">
                                                <label for="email">{{ __('Password') }} :</label>
                                                <input id="password" type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    name="password" placeholder="Enter Password"
                                                    autocomplete="current-password">
                                            </div>
                                            @if ($errors->has('password'))
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                            <div class="form-group ">
                                                <label for="profile">{{ __('Profile') }} :</label>
                                                <input id="profile" type="file"
                                                    class="form-control @error('profile') is-invalid @enderror"
                                                    name="profile" autocomplete="current-profile">
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" name="submit" class="btn btn-primary">
                                                    {{ __('Register') }}
                                                </button>
                                            </div>
                                            <div class="form-group row">
                                                Already have Acount?
                                                <a href="{{ route('user.login') }}"> Login here</a>
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


    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>

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


    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script> --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script>
        // var getCat ="{{ route('getcat') }}"
        // var register ="{{ route('store') }}"
        $('#category').on('change', function() {

            var catId = $(this).val();
            // console.log(catId);
            $.ajax({
                url: "{{ route('getcat') }}",
                method: "GET",
                data: {
                    catId: catId
                },
                dataType: 'JSON',
                success: function(data) {
                    // console.log(data);
                    $.each(data.data, function(key, value) {
                        $("#subcategory").append('<option value="' + value.id + '">' + value
                            .subcategory_name + '</option>');
                    });
                }
            })

        })

        $('#register_form').validate({
            rules: {
                firstname: {
                    required: true,
                },
                lastname: {
                    required: true,
                },
                email: {
                    required: true,
                },
                category: {
                    required: true,
                },
                subcategory: {
                    required: true,
                },
                password: {
                    required: true,
                },
                profile: {
                    required: true,
                },
            },
            messages: {
                firstname: {
                    required: "Firstname is required ",
                },
                lastname: {
                    required: "Lastname is required",
                },
                email: {
                    required: "Email is required",
                },
                category: {
                    required: "Category is required",
                },
                subcategory: {
                    required: "SubCategory is required",
                },
                password: {
                    required: "Password is required",
                },
                profile: {
                    required: "Profile is required",
                },
            },
            submitHandler: function(form) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },

                    url: "{{ route('store') }}",
                    method: "post",
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'JSON',
                    success: function(data) {
                        window.location.href = 'verify_register_user' + '/' + data.id;
                    },
                    error: function(error) {
                        var i;
                        var res = error.responseJSON.errors;
                        $.each(res, function(key, value) {
                            toastr.error(value)
                        });
                    }
                })
            },

        });
    </script>

</body>

</html>
