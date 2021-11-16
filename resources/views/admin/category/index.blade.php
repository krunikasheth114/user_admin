@extends('layouts.master')

@section('page_title', 'Category ')

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
                                <button class="btn btn-success btn-save float-right" title="Add " data-toggle="modal" data-target="#category_add_modal" data-id="'.$data->id.'">Add </button>
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

<div class="modal" id="editcategory" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Category </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>

                    <div class="form-group">
                        <label>Category Name :</label>
                        <input type="text" class="form-control" value="" name="category_name" id="category_name" placeholder="Type your Category">
                    </div>
                   
                    <input type="hidden" id="hidden_id">

                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" id="btn" value="submit" class="btn btn-primary">Update</button>

            </div>
        </div>
    </div>
</div>

</section>
@include('admin.category.create')
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
                url: "{{ route('admin.category.deletecategory')}}",
                method: "POST",
                data: {
                    id: id,
                },
                success: function(data) {
                    if (data.status == true)

                    {
                        alert(data.message);
                        window.LaravelDataTables["category-table"].draw();
                    }


                },

            })
        }


    })
    $(document).on('click', '.changestatus', function() {

        var status = $(this).attr('status');
        var id = $(this).attr('id');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url: "{{ route('admin.category.getstatus')}}",
            method: "POST",
            data: {
                status: status,
                id: id,
            },
            success: function(data) {
                console.log(data.status);
                if (data.status == true)

                {
                    window.LaravelDataTables["category-table"].draw();
                }
            }

        })

    })

    $(document).on('click', '#btn', function() {
        var id = $('#hidden_id').val();
        var category_name = $('#category_name').val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url: "{{ route('admin.category.updatecategory')}}",
            method: "post",
            data: {
                id: id,
                category_name: category_name
            },
            success: function(data) {
                if (data.status == true)

                {
                    $("#editcategory").modal('hide');
                    window.LaravelDataTables["category-table"].draw();
                }

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

    })

    $(document).on('click', '.edit', function() {

        var id = $(this).attr('id');
        //    console.log(id);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url: "{{ route('admin.category.getcategory')}}",
            method: "post",
            data: {

                id: id,
            },
            success: function(data) {
                //   console.log(data.data);
                $('#category_name').val(data.data.category_name);
                $('#hidden_id').val(data.data.id);
            }

        })

    })
</script>

@endpush







