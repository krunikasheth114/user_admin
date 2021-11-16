@extends('layouts.master')

@section('page_title', 'Sub Category ')

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
                                <button class="btn btn-success btn-save float-right" title="Add " data-toggle="modal" data-target="#subcategory_add_modal" data-id="'.$data->id.'">Add </button>
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

<div class="modal" id="editsubcategory" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Sub-Category </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>

                    <div class="form-group">
                        <label>Category Name :</label>
                        <select class="form-control" name="category_name" id="category_name">

                            @foreach ($data as $category)
                            <option value="{{$category->id}}" {{$category->id == $category->category_name ?'selected':''}}>{{"$category->category_name"}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Sub Category Name :</label>
                        <input type="text" class="form-control" name="subcategory_name" id="subcategory_name" placeholder="Type your SubCategory">
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
@include('admin.subcategory.create')
@endsection
@push('page_scripts')
{!! $dataTable->scripts() !!}

<script>
    $(document).on('click', '.changestatus', function() {

        var status = $(this).attr('status');
        var id = $(this).attr('id');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url: "{{ route('admin.subcategory.getstatus')}}",
            method: "POST",
            data: {
                status: status,
                id: id,
            },
            success: function(data) {
                console.log(data.status);
                if (data.status == true)

                {
                    window.LaravelDataTables["subcategory-table"].draw();
                }
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
            url: "{{ route('admin.subcategory.edit')}}",
            method: "post",
            data: {

                id: id,
            },
            success: function(data) {
                console.log(data.data);
                $('#subcategory_name').val(data.data.subcategory_name);

                $('#hidden_id').val(data.data.id);
            }

        })
    })

    $(document).on('click', '#btn', function() {

        var id = $('#hidden_id').val();
        var category_name = $('#category_name').val();
        var subcategory_name = $('#subcategory_name').val();


        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url: "{{ route('admin.subcategory.updatesubcategory')}}",
            method: "post",
            data: {
                id: id,
                category_name: category_name,
                subcategory_name: subcategory_name
            },
            success: function(data) {
                $("#editsubcategory").modal('hide');
                alert(data.message);
                window.LaravelDataTables["subcategory-table"].draw();
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
    $(document).on('click', '.delete', function() {

        var conf = confirm("Are you sure to want delete??");
        if (conf == true) {
            var id = $(this).attr('id');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url: "{{ route('admin.subcategory.deletecategory')}}",
                method: "POST",
                data: {
                    id: id,
                },
                success: function(data) {
                    if (data.status == true)

                    {
                        alert(data.message);
                        window.LaravelDataTables["subcategory-table"].draw();
                    }


                }

            })
        }


    })
</script>
@endpush