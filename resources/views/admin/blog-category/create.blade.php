<div class="modal fade blog_category" id="blog_category" role="dialog" aria-modal="true" data-backdrop="static"  aria-labelledby="category_add_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="workerLabel">{{  __('messages.addblogcategory')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('common.flash')
                <form action="#" method="POST" enctype="multipart/form-data" id="bolg_category">
                    @csrf
                    <div class="form-group">
                        <label>{{  __('messages.category_name')}}
                        </button></label>
                        <input type="text" class="form-control" name="category" id="category"
                            placeholder="Type Blog Category">
                    </div>
                    @if ($errors->has('category'))
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $errors->first('category') }}</strong>
                        </span>
                    @endif

                    <div class="form-group">
                        <div>
                            <button type="submit" id="submit" name="submit" value="submit"
                                class="btn btn-primary">{{  __('messages.add')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
$("#bolg_category").validate({
    rules: {
        category:{
            required:true,
        }
    },messages:{
        category:{
            required:"This field is required",
        }
    },
    submitHandler: function(form) {
        $.ajax({
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },

                url: "{{ route('admin.blog.store')}}",
                method: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'JSON',
                success: function(data) {
                    if(data.status==true){
                        alert(data.message);
                        $(".blog_category").modal('hide');
                        window.LaravelDataTables["blog_category-table"].draw();
                    }
                    $("#bolg_category")[0].reset();
                
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