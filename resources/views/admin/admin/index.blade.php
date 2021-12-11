@extends('layouts.master')
@section('page_title', __('messages.adminuser'))
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
                                <div class="card-header-actions">
                                    <button class="btn btn-success btn-save float-right" title="Add " data-toggle="modal"
                                        data-target="#Admin_user" data-id="'.$data->id.'">{{ __('messages.add') }}</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="ajax-msg"></div>
                                <div class="table-responsive">
                                    {!! $dataTable->table(['class' => 'table table-bordered dt-responsive']) !!}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
    </div>
    </section>

    <div class="modal " id="update_admin_user" role="dialog" aria-modal="true" tabindex="-1" data-backdrop="static"
        aria-labelledby="">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="workerLabel">{{ __('messages.updateadminuser') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" class="admin_user_update" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <div class="col-sm-8">
                                <label for="email">{{ __('messages.email') }} :</label>
                                <input type="email" class="form-control" id="email_edit" name="email_edit" value=""
                                    autocomplete="email" required autofocus>
                                <input type="hidden" class="form-control" id="hidden" name="hidden" value=""
                                    autocomplete="hidden" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-8">
                                <label> {{ __('messages.role') }}</label>
                                <select class="form-control" name="role_edit" id="role_edit">
                                    <option value="">---select----</option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-8">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('messages.update') }}

                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    </div>
   
@endsection
@push('page_scripts')
    {!! $dataTable->scripts() !!}
    <script>
        $(document).on('click', '.edit', function() {
            var id = $(this).attr('id');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url: "{{ route('admin.admin_user.edit_admin') }}",
                method: "post",
                data: {
                    id: id,
                },
                success: function(data) {
                    console.log(data);
                    $('#email_edit').val(data.data.users.email);
                    $('#hidden').val(data.data.users.id);
                    $("#role_edit").html('');
                    $.each(data.data.role, function(key, value) {
                        selectdata = (value.id == data.data.roles[0].role_id) ? 'selected' : '';
                        $("#role_edit").append('<option value="' + value.id + '"' +
                            selectdata + '>' + value.name + '</option>');
                    });
                }
            })
        })
        $('.admin_user_update').validate({
            lang: 'fr',
            rules: {
                email_edit: {
                    required: true,
                },

            },
            messages: {
                email_edit: {
                    required: 'email is requuired',
                },


            },
            submitHandler: function(form) {
                var id = $('#hidden').val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    url: '{{ route('admin.admin_user.update_admin') }}',
                    method: "POST",
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'JSON',
                    success: function(data) {
                        swal("Done!", data.message, "success");
                        $('#update_admin_user').modal('hide');

                        window.LaravelDataTables["admin-table"].draw()
                        // $(".admin_user_update")[0].reset();
                    },
                    error: function(error) {
                        var i;
                        var res = error.responseJSON.errors;
                        $.each(res, function(key, value) {
                            toastr.error(value);
                        });
                    }


                })
            }
        })
        $(document).on('click', '.delete', function() {
            var conf = confirm("Are you sure to want delete??");
            if (conf == true) {
                var id = $(this).attr('id');

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    url: "{{ route('admin.admin_user.delete_admin') }}",
                    method: "POST",
                    data: {
                        id: id,
                    },
                    success: function(data) {
                        if (data.status == true) {
                            swal("Done!", data.message, "success");
                            window.LaravelDataTables["admin-table"].draw();
                        }
                    },

                })
            }
        })
    </script>
    @include('admin.admin.create');
@endpush
