<div class="modal " id="updateblog" role="dialog" aria-modal="true" tabindex="-1" data-backdrop="static"
    aria-labelledby="">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="workerLabel">Update Blog</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="update_blog" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <div class="col-sm-8">
                            <label for="images">{{ __('Current Image') }} :</label>
                            <span id="images"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-8">
                            <label for="catgory">{{ __('Blog Category') }} :</label>
                            <select class="form-control catgory" name="category_id" id="catgory_id">
                                <option value=""> ---Select Category--- </option>

                            </select>
                            @if ($errors->has('catgory'))
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $errors->first('catgory') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-8">
                            <label for="title">{{ __('Blog Title') }} :</label>
                            <input id="title" type="title" class="form-control" id="title" name="title" value=""
                                autocomplete="title" autofocus>
                            @if ($errors->has('title'))
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-8">
                            <label for="description">{{ __('Description') }} :</label>
                            <textarea id="description" type="description" class="form-control" id="description"
                                name="description" value="" autocomplete="description" autofocus></textarea>
                            @if ($errors->has('description'))
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-8">
                            <label for="file">{{ __('Add Image') }} :</label>
                            <input id="file" type="file" class="form-control" id="image" name="image" value=""
                                autocomplete="file" autofocus>
                            @if ($errors->has('image'))
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $errors->first('image') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <input type="hidden" id="id" class="id " name="id" value="">
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Update') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $('#update_blog').validate({
        rules: {
            category_id: {
                required: true,
            },
            title: {
                required: true,
            },
            description: {
                required: true,
            },


        },
    
        submitHandler: function(form) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },

                url: "{{ route('admin.blog.updateblog') }}",
                method: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'JSON',
                success: function(data) {
                    if (data.status == true)

                    {
                        $("#updateblog").hide();
                        alert(data.message);

                    }
                    window.LaravelDataTables["blog-table"].draw();
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


    });
</script>
