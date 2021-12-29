@extends('layouts.master')
@section('page_title', 'Product Category')
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
                                        data-target="#product_category_add_modal"
                                        data-id="'.$data->id.'">{{ __('messages.add') }}</button>
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
    <div class="modal" id="edit_product_category" tabindex="-1" role="dialog" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('messages.updatecategory') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="category_update" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>{{ __('messages.category') }}</label>
                            <input type="text" class="form-control" value="" name="category_name" id="category_name"
                                placeholder="Type your Category">
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" id="hidden_id" name="hidden_id" value="">
                            <button type="submit" id="submit" value="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
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
                url: "{{ route('admin.product.product-edit') }}",
                method: "post",
                data: {

                    id: id,
                },
                success: function(data) {
                    $('#category_name').val(data.data.name);
                    $('#hidden_id').val(data.data.id);
                }
            })
        })
        $('#category_update').validate({
            rules: {
                category_name: {
                    required: true,
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    url: "{{ route('admin.product.product-update') }}",
                    method: "POST",
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'JSON',
                    success: function(data) {
                        if (data.status == true) {
                            $("#edit_product_category").modal('hide');
                            swal("Done!", data.message, "success");
                            window.LaravelDataTables["product_category-table"].draw();
                        }
                    },
                    error: function(error) {
                        var i;
                        var res = error.responseJSON.errors;
                        $.each(res, function(key, value) {
                            toastr.error(value);
                        });
                    }

                });
            }
        });
        // Change status
        $(document).on('click', '.changestatus', function() {
            var conf = confirm("Are you sure to want chanvge status??");
            if (conf == true) {
                var status = $(this).attr('status');
                var id = $(this).attr('id');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    url: "{{ route('admin.product.changestatus') }}",
                    method: "POST",
                    data: {
                        status: status,
                        id: id,
                    },
                    success: function(data) {
                        console.log(data.status);
                        if (data.status == true)

                        {
                            swal("Done!", data.message, "success");
                            window.LaravelDataTables["product_category-table"].draw();
                        }
                    }

                })
            }

        })
        // Delete Category
        $(document).on('click', '.delete', function() {
            var conf = confirm("Are you sure to want delete??");
            if (conf == true) {
                var id = $(this).attr('id');

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    url: "{{ route('admin.product.product-delete') }}",
                    method: "POST",
                    data: {
                        id: id,
                    },
                    success: function(data) {
                        if (data.status == true) {
                            swal("Done!", data.message, "success");
                            window.LaravelDataTables["product_category-table"].draw();
                        }
                    },
                })
            }


        })
    </script>
    @include('admin.product_category.create')
@endpush
