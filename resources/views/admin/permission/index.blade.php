@extends('layouts.master');
@section('page_title', 'Add Permission')
@section('content')
    <div class="main-content">
        <div class="page-content">
            @include('common.flash')
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
                                    <button class="btn btn-success btn-save float-right" title="Add" data-toggle="modal"
                                        data-target="#Add-permission-modal">Add</button>
                                </div>
                            </div>
                            <div class="card-body">
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
    {{-- update Model --}}
    <div class="modal fade" id="update_permission" role="dialog" aria-modal="true" data-backdrop="static"
        aria-labelledby="add_permission_modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="workerLabel">Update Permission</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="" method="post" enctype="multipart/form-data"
                        class="Permission_update_form">
                        @csrf
                        <div class="form-group">
                            <label> Permission :</label>
                            <input type="text" class="form-control" name="Permission_edit" id="Permission_edit"
                                placeholder="Permission_edit">
                        </div>
                        @if ($errors->has('Permission'))
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $errors->first('Permission') }}</strong>
                            </span>
                        @endif
                        <div class="form-group">
                            <div>
                                <input type="hidden" name="hidden_id" id="hidden_id" class="hidden">
                                <button type="submit" id="submit" name="submit" value="submit"
                                    class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('admin.permission.create')
@endsection
@push('page_scripts')
    {!! $dataTable->scripts() !!}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
    <script>
        $("body").on('click', '.update', function() {
            var id = $(this).attr('id');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url: "{{ route('admin.permission.edit') }}",
                method: "post",
                data: {

                    id: id,
                },
                success: function(data) {
                    console.log(data);
                    $('#Permission_edit').val(data.data.name);
                    $('#hidden_id').val(data.data.id);
                }

            })
        })
        $(document).on('click', '.delete', function() {
            var conf = confirm("Are you sure to want delete??");
            if (conf == true) {
                var id = $(this).attr('id');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    url: "{{ route('admin.permission.delete') }}",
                    method: "POST",
                    data: {
                        id: id,
                    },
                    success: function(data) {
                        if (data.status == true)
                        {
                            swal("Done!", data.message, "success");
                            window.LaravelDataTables["permission-table"].draw();
                        }
                    },
                })
            }
        })
        $(".Permission_update_form").validate({
        rules: {
            Permission_edit: {
                required: true,
            }
        },
      
    
        submitHandler: function(form) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },

                url: "{{ route('admin.permission.update') }}",
                method: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'JSON',
                success: function(data) {
                    if (data.status == true) {
                        swal("Done!", data.message, "success");
                        $("#update_permission").modal('hide');
                        window.LaravelDataTables["permission-table"].draw();
                    }
                    $(".Permission_update_form")[0].reset();

                },
                error: function(error) {
                    // console.log(error.responseJSON.errors);
                    var i;
                    var res = error.responseJSON.errors;
                    $.each(res, function(key, value) {
                        toastr.error(value);
                    });

                }
            })
        }
    })
    </script>
@endpush
