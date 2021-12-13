@extends('layouts.master');
@section('page_title',  __('messages.userdocument'))

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
    <div class="modal" id="updatedoc" tabindex="-1" role="dialog" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Document </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="updatedocform" enctype="multipart/form-data">
                        @csrf
                        @method('POST')

                        <div class="form-group">
                            <div class="form-group">
                                <label>Document Name :</label>
                                <input type="text" class="form-control" name="doc_name" id="doc_name"
                                    placeholder="Type your document_name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Document number :</label>
                            <input type="text" class="form-control" name="doc_num" id="doc_num"
                                placeholder="Type your document_num">
                        </div>
                        <div class="form-group" id="old_document">

                        </div>

                        <div class="form-group">
                            <label>Document:</label>
                            <input type="file" class="form-control" id="documents" name="documents">
                        </div>
                </div>
                <input type="hidden" id="id" name="id" value="">
                <div class="modal-footer">
                    <button type="submit" id="submit" value="submit" class="btn btn-primary">Update</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    </section>

@endsection
@push('page_scripts')
    {!! $dataTable->scripts() !!}
 
    <script>
        // Get data
        $(document).on('click', '.update', function(e) {
            e.preventDefault();
            $('#updatedoc').modal('show');
            var href = $(this).attr('href');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },

                url: href,

                method: "get",
                success: function(data) {

                    $('#id').val(data.data.id);

                    $('#doc_name').val(data.data.doc_name);
                    $('#doc_num').val(data.data.doc_num);
                    // $('#old_document').append('<a class="btn btn-primary" target="_blank" href="'+data.data.document_url+'" > view Doc</a>');

                    $("#old_document").html(
                        '<a class="" target="_blank" href="' + data.data.document_url +
                        '" >View Document</a>');
                }

            });
        });
        // Update Documents
        $('#updatedocform').validate({
            rules: {
                doc_name: {
                    required: true,
                },
                doc_num: {
                    required: true,
                }
            },
         
            
            submitHandler: function(form) {
                var id = $('#id').val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    url: '{{ url('Admin/document/') }}' + '/' + id + '/update',
                    method: "POST",
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'JSON',
                    success: function(data) {
                        alert(data.messages);
                        $('#updatedoc').modal('hide');

                        window.LaravelDataTables["document-table"].draw()
                        $("#updatedocform")[0].reset();
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
        });
        $('#documents').change('on', function() {
            $("#old_document").html('');
        });
        // Delete Documents
        $(document).on('click', '.delete', function(e) {
            e.preventDefault();

            var conf = confirm("Are you sure to want delete??");
            if (conf == true) {
                var href = $(this).attr('href');

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    url: href,
                    method: "delete",

                    success: function(data) {
                        window.LaravelDataTables["document-table"].draw()

                    },

                })
            }


        })
    </script>
@endpush
