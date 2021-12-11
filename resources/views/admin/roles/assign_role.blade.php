@extends('layouts.master')
@section('page_title', __('messages.assignrole'))
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
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
                                @include('common.flash')
                            </div>
                            <div class="card-body">
                                <!-- ajax form response -->
                                {{-- <div class="ajax-msg"></div> --}}
                                {{-- <div class="table-responsive"></div> --}}
                                <form action="{{ route('admin.role.assign', $role->id) }}" method="POST"
                                    enctype="multipart/form-data" class="add_update_permissions">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="role_name">{{ __('messages.rolename') }} :</label>
                                                <input id="role_name" type="role_name" class="form-control"
                                                    name="role_name" value="{{ $role->name }}" autocomplete="role_name"
                                                    autofocus>
                                                <input id="role_id" type="hidden" class="form-control" name="role_id"
                                                    value="{{ $role->id }}" autocomplete="role_id" autofocus>

                                                @if ($errors->has('role_name'))
                                                    <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $errors->first('role_name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="checkbox" name="" id="identifier">
                                        <label for="identifier">{{ __('messages.permissions') }} </label>

                                        <table class="table" id="permission">
                                            <table class="table" id="permission">
                                                <tr>
                                                    <td><b>{{ __('messages.module') }}</b></td>
                                                    <td><b>{{ __('messages.create') }}</b></td>
                                                    <td><b>{{ __('messages.update') }}</b></td>
                                                    <td><b>{{ __('messages.view') }}</b></td>
                                                    <td><b>{{ __('messages.delete') }}</b></td>
                                                </tr>
                                                @php $a=1; @endphp
                                                @foreach ($permission as $value)
                                                    @if ($a == 1)
                                                        <tr>
                                                            <td><b><input type="checkbox" name=""
                                                                        class="rowcheck">{{ ucfirst($value->module) }}</b>
                                                            </td>
                                                    @endif
                                                    <td>
                                                        <input type="checkbox" class="permision_check" name="permission[]"
                                                            value="{{ $value->id }}"
                                                            {{ in_array($value->id, $role_permission) ? 'checked' : '' }}>{{ $value->name }}
                                                    </td>
                                                    @if ($a == 4)
                                                        </tr>
                                                        @php $a=0; @endphp
                                                    @endif
                                                    @php $a++; @endphp
                                                @endforeach
                                            </table>
                                            <span class="help-block js_error_span"></span>
                                    </div>


                                    <div class="form-group">
                                        <button type="submit" id="submit" value="submit"
                                            class="btn btn-primary">{{ __('messages.assign') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('page_scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
    <script>
        $(".add_update_permissions").validate({
            rules: {
                role_name: {
                    required: true,
                }
            },
            messages: {
                role_name: {
                    required: "This field is required",
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    url: "{{ route('admin.role.update-permission') }}",
                    method: "POST",
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'JSON',
                    success: function(data) {
                        if (data.status == true) {
                            swal("Done!", data.message, "success");
                        }
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
        $('#identifier').on('click', function() {
            if ($(this).prop("checked")) {
                $('body').find("input[type=checkbox]").prop("checked", true);
            } else {
                $('body').find("input[type=checkbox]").prop("checked", false);
            }
        });
        $('.permision_check').on('click', function() {
            $('body').find('#globalCheckbox').prop("checked", false);
            if ($('.permision_check:checked').length == $('.permision_check').length) {
                $('body').find('#globalCheckbox').prop("checked", true);
            }
        });

        $('.rowcheck').on('click', function() {
            if ($(this).prop("checked")) {
                $(this).parent().parent().parent().find("input[type=checkbox]").prop("checked", true);
            }else{
                $(this).parent().parent().parent().find("input[type=checkbox]").prop("checked", false);
            }
        });
    </script>
@endpush
