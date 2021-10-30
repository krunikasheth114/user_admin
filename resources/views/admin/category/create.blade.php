<div class="modal fade" id="category_add_modal" role="dialog" aria-modal="true" aria-labelledby="category_add_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="workerLabel">Add Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="" method="POST" enctype="multipart/form-data" id="add_category_form">
                    @csrf
                    <div class="form-group">
                        <label>Category Name :</label>
                        <textarea class="form-control" name="category_name" id="category_name" placeholder="Type your Category"></textarea>
                    </div>
                    @if ($errors->has('category_name'))
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $errors->first('category_name') }}</strong>
                    </span>
                    @endif

                    <div class="form-group">
                        <div>
                            <button type="submit" id="submit" name="submit" value="submit" class="btn btn-primary">Add</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
    $('#add_category_form').validate({

        rules: {
            category_name: {
                required: true,
            }
        },

        messages: {
            category_name: {
                required: "Category field is required",
            }
        },
        submitHandler: function(form) {

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },

                url: "{{ route('admin.category.store')}}",
                method: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'JSON',
                success: function(data) {
                    if (data.status == true) {
                        $("#category_add_modal").modal('hide');
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

            });
        }
    });
</script>