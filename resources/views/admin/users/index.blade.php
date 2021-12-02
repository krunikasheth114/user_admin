@extends('layouts.master')

@section('page_title', 'Registered User ')

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0">@yield('page_title')</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);"></a></li>
                                    <li class="breadcrumb-item active"></li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-header">
                            </div>
                            <div class="card-body">
                                <!-- ajax form response -->

                                <div class="ajax-msg"></div>
                                <div class="table-responsive">
                                    
                                    {!! $dataTable->table(['class' => 'table table-bordered dt-responsive nowrap']) !!}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
    </div>
    @include('admin.users.create_doc');

    <div class="modal" tabindex="-1" role="dialog" id="updateuser" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <h4 class="text-muted text-center font-18"><b>
                                Update User!</b></h4>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">


                    <div class="p-2">
                        <form method="POST" id="update_form">
                            @csrf
                            <div class="form-group">
                                <label for="profile">{{ __('Current Profile') }} :</label>
                                <span id="profile"></span>
                            </div>
                            <div class="form-group">
                                <label for="firstname">{{ __('Firstname') }} :</label>
                                <input id="firstname" type="firstname"
                                    class="form-control @error('firstname') is-invalid @enderror" name="firstname" required
                                    autocomplete="firstname" placeholder="Enter Firstname" autofocus>
                            </div>
                            <div class="form-group">
                                <label for="lastname">{{ __('Lastname') }} :</label>
                                <input id="lastname" type="lastname"
                                    class="form-control @error('lastname') is-invalid @enderror" name="lastname"
                                    value="{{ old('lastname') }}" required autocomplete="lastname"
                                    placeholder="Enter Lastname" autofocus>
                            </div>
                            <div class="form-group ">
                                <label for="email">{{ __('Email') }} :</label>

                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email"
                                    placeholder="Enter Email" autofocus>
                            </div>
                            <div class="form-group">
                                <label for="category">{{ __('Category') }} :</label>
                                <select class="form-control" name="category" id="category">



                                </select>
                            </div>
                            <div class="form-group">
                                <label for="subcategory">{{ __('Subcategory') }} :</label>
                                <select class="form-control" name="subcategory" id="subcategory">

                                </select>
                            </div>
                            <div class="form-group ">
                                <label for="profile">{{ __('Profile') }} :</label>
                                <input id="profile" type="file" class="form-control @error('profile') is-invalid @enderror"
                                    name="profile" autocomplete="current-profile">
                            </div>
                            <input type="hidden" id="id" name="id" value="">
                            <div class="form-group">
                                <button type="submit" name="submit" class="btn btn-primary">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    @endsection
    @push('page_scripts')
        {!! $dataTable->scripts() !!}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


        <script>
            $('#update_form').validate({
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

                },
                submitHandler: function(form) {

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },

                        url: "{{ route('admin.update') }}",
                        method: "POST",
                        data: new FormData(form),
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: 'JSON',
                        success: function(data) {
                            alert(data.message);
                            $("#updateuser").modal('hide')
                            window.LaravelDataTables["users-table"].draw();
                        },
                        error: function(error) {
                            console.log(error.responseJSON.errors);
                            var i;
                            var res = error.responseJSON.errors;
                            $.each(res, function(key, value) {
                                alert.error(value);
                            });

                        }

                    })
                },

            })

            $(document).on('click', '.update', function() {
                var id = $(this).attr('id');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    url: "{{ route('admin.edit') }}",
                    method: "post",
                    data: {
                        id: id,
                    },
                    dataType: 'JSON',
                    success: function(data) {

                        $('#id').val(data.data.user.id);
                        $('#firstname').val(data.data.user.firstname);
                        $('#lastname').val(data.data.user.lastname);
                        $('#email').val(data.data.user.email);
                        $("#category").html('');

                        $.each(data.data.Category, function(key, value) {
                            selectdata = (value.id == data.data.user.category_id) ? 'selected' : '';

                            $("#category").append('<option value="' + value.id + '" ' + selectdata +
                                '>' + value
                                .category_name + '</option>');
                        });
                        $("#subcategory ").html('');
                        $.each(data.data.subcategory, function(key, value) {
                            selectdata = (value.id == data.data.user.subcategory_id) ? 'selected' :
                                '';
                            $("#subcategory").append('<option value="' + value.id + '" ' +
                                selectdata + '>' + value
                                .subcategory_name + '</option>');
                        })
                        if (data.data.user.profile == '') {
                            $('#profile').html(
                                '<img src="images/default/default.jpg" height="50px" width="50px" />');
                        } else {
                            $('#profile').html('<img src="' + /images/ + data.data.user.profile +
                                '" height="50px" width="50px" />');
                        }


                    }

                })
            })


            $(document).on('click', '.changestatus', function() {

                var status = $(this).attr('status');
                var id = $(this).attr('id');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    url: "{{ route('admin.gets') }}",
                    method: "POST",
                    data: {
                        status: status,
                        id: id,
                    },
                    success: function(data) {
                        console.log(data.status);
                        if (data.status == true)

                        {
                            window.LaravelDataTables["users-table"].draw();
                        }
                    }

                })

            });

            $(document).on('click', '.delete', function() {

                var conf = confirm("Are you sure to want delete??");
                if (conf == true) {
                    var id = $('.delete').attr('id');

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        url: "{{ route('admin.delete') }}",
                        method: "POST",
                        data: {
                            id: id,
                        },
                        success: function(data) {
                            if (data.status == true)

                            {
                                alert(data.message);
                                window.LaravelDataTables["users-table"].draw();
                            }


                        }

                    })
                }
            });
            $('body').on('change', '#category', function() {
                var id = $(this).val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    url: "{{ route('admin.getsub') }}",
                    method: "post",
                    data: {
                        id: id,
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        $("#subcategory").html('');
                        if (data.status == true) {
                            $.each(data.data, function(key, value) {
                                $("#subcategory").append('<option value="' + value.id + '">' + value
                                    .subcategory_name + '</option>');
                            });
                        }
                    }
                })

            })
        </script>
    @endpush
