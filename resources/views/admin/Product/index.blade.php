@extends('layouts.master')
@section('page_title', 'Products')
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
                                        data-target="#add_product_model"
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

    {{-- Update Form --}}
    <div class="modal" id="update_product" tabindex="-1" role="dialog" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('messages.updatecategory') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="" method="POST" enctype="multipart/form-data" id="edit_product_form">
                        @csrf
                        <span id="image"></span>
                        <div class="form-group">
                            <label>{{ __('messages.category_name') }}</label>
                            <select class="form-control" name="category" id="category">
                                <option value="">---select----</option>
                                @foreach ($category as $c)
                                    <option value="{{ $c->id }}">
                                        {{ $c->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has('category_name'))
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $errors->first('category_name') }}</strong>
                            </span>
                        @endif
                        <div class="form-group">
                            <label>Subcategroy</label>
                            <select class="form-control" name="subcategory" id="subcategory">
                                <option value="">---select----</option>
                                @foreach ($subcategory as $s)
                                    <option value="{{ $s->id }}">
                                        {{ $s->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has('subcategory_name'))
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $errors->first('subcategory_name') }}</strong>
                            </span>
                        @endif
                        <div class="form-group">
                            <label>Product Name:</label>
                            <input type="text" class="form-control" name="product_name" id="product_name"
                                placeholder="Type your Product name">
                        </div>
                        @if ($errors->has('product_name'))
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $errors->first('product_name') }}</strong>
                            </span>
                        @endif
                        <div class="form-group">
                            <label for="image">Image:</label>
                            <input id="image" type="file" class="form-control @error('image') is-invalid @enderror"
                                name="image" autocomplete="current-image">
                        </div>
                        @if ($errors->has('image'))
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $errors->first('image') }}</strong>
                            </span>
                        @endif

                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" name="price" id="price" value="">
                            @if ($errors->has('price'))
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $errors->first('price') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <div>
                                <input type="hidden" name="hidden_id" id="hidden_id">
                                <button type="submit" id="submit" name="submit" value="submit"
                                    class="btn btn-primary">{{ __('messages.update') }}</button>
                            </div>
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
                url: "{{ route('admin.product.changestatus-product') }}",
                method: "POST",
                data: {
                    status: status,
                    id: id,
                },
                success: function(data) {
                    console.log(data.status);
                    if (data.status == true)

                    {
                        window.LaravelDataTables["products-table"].draw();
                    }
                }
            })
        })
        // GET Data
        $(document).on('click', '.edit', function() {
            var id = $(this).attr('id');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url: "{{ route('admin.product.edit') }}",
                method: "POST",
                data: {

                    id: id,
                },
                success: function(data) {
                    console.log(data.data.product.id);
                    $('#hidden_id').val(data.data.product.id);
                    $('#product_name').val(data.data.product.name);
                    $('#price').val(data.data.product.price);

                    $("#category").html('');
                    $.each(data.data.Category, function(key, value) {
                        selectdata = (value.id == data.data.product.category_id) ? 'selected' :
                            '';
                        $("#category").append('<option value="' + value.id + '" ' + selectdata +
                            '>' + value.name + '</option>');
                    });
                    $("#subcategory ").html('');
                    $.each(data.data.subcategory, function(key, value) {
                        selectdata = (value.id == data.data.product.subcategory_id) ?
                            'selected' : '';
                        $("#subcategory").append('<option value="' + value.id + '" ' +
                            selectdata + '>' + value
                            .name + '</option>');
                    })
                    if (data.data.product.image == '') {
                        $('#image').html(
                            '<img src="images/default/default.jpg" height="50px" width="50px" />');
                    } else {
                        $('#image').html('<img src="' + /images/ + data.data.product.image +
                            '" height="50px" width="50px" />');
                    }
                }
            })
        })
        // Update Product
        $('#edit_product_form').validate({
            rules: {
                category: {
                    required: true,
                },
                subcategory: {
                    required: true,
                },
                product_name: {
                    required: true,
                },

                price: {
                    required: true,
                },

            },
            submitHandler: function(form) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    url: "{{ route('admin.product.update') }}",
                    method: "POST",
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'JSON',
                    success: function(data) {
                        if (data.status == true) {
                            $("#update_product").modal('hide');
                            swal("Done!", data.message, "success");
                            window.LaravelDataTables["products-table"].draw();
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
        // Delete Product
        $(document).on('click', '.delete', function() {
            var conf = confirm("Are you sure to want delete??");
            if (conf == true) {
                var id = $(this).attr('id');

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    url: "{{ route('admin.product.delete') }}",
                    method: "POST",
                    data: {
                        id: id,
                    },
                    success: function(data) {
                        if (data.status == true) {
                            swal("Done!", data.message, "success");
                            window.LaravelDataTables["products-table"].draw();
                        }
                    },
                })
            }


        })
    </script>
    @include('admin.product.create')
@endpush
