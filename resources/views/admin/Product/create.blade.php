<div class="modal fade" id="add_product_model" role="dialog" aria-modal="true" data-backdrop="static"
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
                <form class="add_product_form" method="POST" enctype="multipart/form-data" id="add_product_form">
                    @csrf
                    <div class="form-group">
                        <label>{{ __('messages.category_name') }}</label>
                        <select class="form-control" name="category" id="category">
                            <option value="">---select----</option>
                            @foreach ($category as $c)
                                <option value="{{ $c->id }}">
                                    {{ $c->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @if ($errors->has('category_name'))
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $errors->first('category_name') }}</strong>
                        </span>
                    @endif
                    <div class="form-group">
                        <label>Subcategroy</label>
                        <select class="form-control" name="subcategory" id="subcategory">
                            <option value="">---select----</option>
                            @foreach ($subcategory as $s)
                                <option value="{{ $s->id }}">
                                    {{ $s->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @if ($errors->has('subcategory_name'))
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $errors->first('subcategory_name') }}</strong>
                        </span>
                    @endif
                    <div class="form-group">
                        <label>Product Name:</label>
                        <input type="text" class="form-control" name="product_name" id="product_name"
                            placeholder="Type your Product name">
                    </div>
                    @if ($errors->has('product_name'))
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $errors->first('product_name') }}</strong>
                        </span>
                    @endif
                    <div class="form-group">
                        <label for="image">Image:</label>
                        <input id="image" type="file" class="form-control @error('image') is-invalid @enderror"
                            name="image" autocomplete="current-image">
                    </div>
                    @if ($errors->has('image'))
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $errors->first('image') }}</strong>
                        </span>
                    @endif

                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" class="form-control" name="price" id="price" value="">
                        @if ($errors->has('price'))
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $errors->first('price') }}</strong>
                            </span>
                        @endif
                    </div>

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
    $('#add_product_form').validate({
        rules: {
            category: {
                required: true,
            },
            subcategory: {
                required: true,
            },
            product_name: {
                required: true,
            },
            image: {
                required: true,
            },
            price: {
                required: true,
            },

        },
        submitHandler: function(form) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url: "{{ route('admin.product.store') }}",
                method: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'JSON',
                success: function(data) {
                    if (data.status == true) {
                        swal("Done!", data.message, "success");
                        $("#add_product_model").modal('hide');
                        window.LaravelDataTables["products-table"].draw();
                    }
                    $(".add_product_form")[0].reset();
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
