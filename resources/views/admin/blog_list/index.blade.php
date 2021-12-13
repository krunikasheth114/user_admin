@extends('layouts.master')
@section('page_title', 'Blog List')

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
                                    {{-- <button class="btn btn-success btn-save float-right" title="Add " data-toggle="modal"
                                        data-target="#blog_category" data-id="'.$data->id.'">Add </button> --}}
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- ajax form response -->

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



@endsection
@push('page_scripts')
    {!! $dataTable->scripts() !!}
  
    <script>
        $(document).on('click', '.delete', function() {

            var conf = confirm("Are you sure to want delete??");
            if (conf == true) {
                var id = $(this).attr('id');

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    url: "{{ route('admin.blog.deleteblog') }}",
                    method: "POST",
                    data: {
                        id: id,
                    },
                    success: function(data) {
                        if (data.status == true)

                        {
                            swal("Done!", data.message, "success");
                            window.LaravelDataTables["blog-table"].draw();
                        }


                    },

                })
            }


        })
        $(document).on('click', '.update', function() {
            var id = $(this).attr('id');
            //    console.log(id);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url: "{{ route('admin.blog.editblog') }}",
                method: "post",
                data: {

                    id: id,
                },
                success: function(data) {



                    $('#id').val(data.data.blog.id);
                    $('#title').val(data.data.blog.title);
                    $('#description').val(data.data.blog.description);
                    $('#images').html('<img src="' + /images/ + data.data.blog.image +
                        '"height="50px" width="50px"/>');
                    $.each(data.data.category, function(key, value) {
                        selectdata = (value.id == data.data.blog.category_id) ? 'selected' : '';
                        $("#catgory_id").append('<option value="' + value.id + '" ' +
                            selectdata + '>' + value.category + '</option>');
                    });
                }

            })

        })
    </script>
    @include('admin.blog_list.create');
@endpush
