@extends('layouts.master')
@section('page_title', 'Product Sub-Category')
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
                                        data-target="#product_sub_category_add_modal"
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
    <div class="modal" id="edit_product_subcategory" tabindex="-1" role="dialog" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('messages.updatesubcategory') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" enctype="multipart/form-data" id="edit_product_subcategory_form">
                        @csrf
                        <div class="form-group">
                            <label>{{ __('messages.category_name') }}</label>
                            <select class="form-control" name="category_name" id="category_name">
                                @foreach ($category as $c)
                                    <option value="{{ $c->id }}" {{ $c->id == $c->name ? 'selected' : '' }}>
                                        {{ "$c->name" }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @can('subcategory_create')
                            <div class="form-group">
                                <label>{{ __('messages.subcategory_name') }}:</label>
                                <input type="text" class="form-control" id="subcategory_name" value="" name="subcategory_name"
                                    placeholder="Type your SubCategory">
                            </div>
                        @endcan
                        <input type="hidden" id="hidden_id" name="id">

                        <div class="modal-footer">
                            <button type="submit" id="btn" name="submit"
                                class="btn btn-primary">{{ __('messages.update') }}:</button>
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
        // Change status
        $(document).on('click', '.changestatus', function() {
            var status = $(this).attr('status');
            var id = $(this).attr('id');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url: "{{ route('admin.product.product-subcategory-changestatus') }}",
                method: "POST",
                data: {
                    status: status,
                    id: id,
                },
                success: function(data) {
                    console.log(data.status);
                    if (data.status == true) {
                        window.LaravelDataTables["product_subcategory-table"].draw();
                    }
                }

            })

        })
        $(document).on('click', '.edit', function() {
            var id = $(this).attr('id');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url: "{{ route('admin.product.product-subcategory-edit') }}",
                method: "post",
                data: {
                    id: id,
                },
                success: function(data) {
                    console.log(data.data);
                    $('#subcategory_name').val(data.data.name);
                    $('#hidden_id').val(data.data.id);
                }
            })
        })
        $('#edit_product_subcategory_form').validate({
            rules: {
                category_name: {
                    required: true,
                },
                subcategory_name: {
                    required: true,
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    url: "{{ route('admin.product.product-subcategory-update') }}",
                    method: "POST",
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'JSON',
                    success: function(data) {
                        if (data.status == true) {
                            $("#edit_product_subcategory").modal('hide');
                            swal("Done!", data.message, "success");
                            window.LaravelDataTables["product_subcategory-table"].draw();
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
        $(document).on('click', '.delete', function() {
            var conf = confirm("Are you sure to want delete??");
            if (conf == true) {
                var id = $(this).attr('id');

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    url: "{{ route('admin.product.product-subcategory-delete') }}",
                    method: "POST",
                    data: {
                        id: id,
                    },
                    success: function(data) {
                        if (data.status == true) {
                            swal("Done!", data.message, "success");
                            window.LaravelDataTables["product_subcategory-table"].draw();
                        }
                    },
                })
            }


        })
    </script>
    @include('admin.product_subcategory.create')
@endpush
