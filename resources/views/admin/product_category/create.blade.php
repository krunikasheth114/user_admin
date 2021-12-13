<div class="modal fade" id="product_category_add_modal" role="dialog" aria-modal="true" data-backdrop="static"
    aria-labelledby="product_category_add_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="workerLabel">{{ __('messages.add_category') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="" method="POST" enctype="multipart/form-data" id="add_productcategory_form">
                    @csrf
                    <div class="form-group">
                        <label>{{ __('messages.categoryname') }}</label>
                        <input type="text" class="form-control" name="category_name" id="category_name"
                            placeholder="Type your Category">
                    </div>
                    @if ($errors->has('category_name'))
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $errors->first('category_name') }}</strong>
                        </span>
                    @endif

                    <div class="form-group">
                        <div>
                            <button type="submit" id="submit" name="submit" value="submit"
                                class="btn btn-primary">{{ __('messages.add') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $('#add_productcategory_form').validate({
        rules: {
            category_name: {
                required: true,
            }
        
        },
        submitHandler: function(form) {

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },

                url: "{{ route('admin.product.product-store')}}",
                method: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'JSON',
                success: function(data) {
                    if (data.status == true) {
                        $("#product_category_add_modal").modal('hide');
                        swal("Done!", data.message, "success");
                            window.LaravelDataTables["product_category-table"].draw();
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
</script>
