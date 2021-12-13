<div class="modal fade" id="product_sub_category_add_modal" role="dialog" aria-modal="true" data-backdrop="static"
    aria-labelledby="product_category_add_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="workerLabel">Add Sub Category
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="" method="POST" enctype="multipart/form-data" id="add_subcategory_form">
                    @csrf
                    <div class="form-group">
                        <label>{{ __('messages.category_name') }}</label>
                        <select class="form-control" name="category" id="category">
                            <option value="">---select----</option>
                            @foreach ($category as $c)
                            <option value="{{$c->id}}">
                                {{$c->name}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>{{ __('messages.subcategory_name') }}:</label>
                        <input type="text" class="form-control" name="subcategory_name" id="subcategory_name"
                            placeholder="Type your SubCategory">
                    </div>

                    <div class="form-group">
                        <div>
                            <button type="submit" id="submit" value="submit" class="btn btn-primary">Add</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $('#add_subcategory_form').validate({
        rules: {
            category: {
                required: true,
            },
            subcategory_name: {
                required: true,
            },
        },
        submitHandler: function(form) {
          
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },

                url: "{{ route('admin.product.product-subcategory-store')}}",
                method: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'JSON',
                success: function(data) {
                    if (data.status == true) {

                        $("#product_sub_category_add_modal").modal('hide');
                        // window.LaravelDataTables["subcategory-table"].draw();
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
        }
    });
</script>
