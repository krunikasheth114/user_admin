@extends('layouts.master')
@section('page_title', __('messages.blogcategory'))

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
                                    @if (auth()->user()->hasAnyPermission('blog_category_create'))
                                        {\
                                        <button class="btn btn-success btn-save float-right" title="Add "
                                            data-toggle="modal" data-target="#blog_category"
                                            data-id="'.$data->id.'">{{ __('messages.add') }}
                                        </button>
                                    @endif
                                </div>
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
    </section>
    <div class="modal fade blog_category" id="edit_blog_category" role="dialog" aria-modal="true" data-backdrop="static"
        aria-labelledby="category_add_modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="workerLabel"> {{ __('messages.updateblogcategory') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @include('common.flash')
                    <form action="#" method="POST" enctype="multipart/form-data" id="edit_blog_category_form"
                        class="edit_blog_category_form">
                        @csrf
                        <div class="form-group">
                            <label>{{ __('messages.blogcategory') }}</label>
                            <input type="text" class="form-control category" value=" " name="category" id="category"
                                placeholder="Type Blog Category">
                        </div>
                        @if ($errors->has('category'))
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $errors->first('category') }}</strong>
                            </span>
                        @endif

                        <div class="form-group">
                            <input type="hidden" id="id" name="id" class="id">
                            <div>
                                <button type="submit" id="submit" name="submit" value="submit"
                                    class="btn btn-primary">Update</button>
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
        $(".edit_blog_category_form").validate({
            rules: {
                category: {
                    required: true,
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    url: "{{ route('admin.blog.update') }}",
                    method: "POST",
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'JSON',
                    success: function(data) {
                        if (data.status == true) {
                            // alert(data.messages);
                            swal("Done!", data.messages, "success");

                        }
                        $(".blog_category").modal('hide');
                        $("#edit_blog_category_form")[0].reset();
                        window.LaravelDataTables["blog_category-table"].draw();

                    },
                    error: function(error) {
                        // console.log(error.responseJSON.errors);
                        var i;
                        var res = error.responseJSON.errors;
                        $.each(res, function(key, value) {
                            toastr.error(value);
                        });
                    }
                });
            }
        })
        $(document).on('click', '.changestatus', function() {
            var conf = confirm("Are you sure to want chanvge status??");
            if (conf == true) {
                var status = $(this).attr('status');
                var id = $(this).attr('id');

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    url: "{{ route('admin.blog.getstatus') }}",
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
                            window.LaravelDataTables["blog_category-table"].draw();
                        }
                    }

                })
            }

        })
        // Edit Blog Category
        $(document).on('click', '.edit', function() {

            var id = $(this).attr('id');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url: "{{ route('admin.blog.edit') }}",
                method: "post",
                data: {

                    id: id,
                },
                success: function(data) {
                    $('.category').val(data.data.category);
                    $('.id').val(data.data.id);



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
                    url: "{{ route('admin.blog.delete') }}",
                    method: "POST",
                    data: {
                        id: id,
                    },
                    success: function(data) {
                        if (data.status == true)

                        {
                            swal("Done!", data.message, "success");
                            window.LaravelDataTables["blog_category-table"].draw();
                        }


                    },

                })
            }


        })
    </script>
    @include('admin.blog-category.create');
@endpush
