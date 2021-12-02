<div class="modal fade" id="Add-permission-modal" role="dialog" aria-modal="true" data-backdrop="static"
    aria-labelledby="add_permission_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="workerLabel">Add Permission</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data"
                    class="Permission_form">
                    @csrf
                    <div class="form-group">
                        <label> Permission :</label>
                        <input type="text" class="form-control" name="Permission" id="Permission"
                            placeholder="Add Permission" required>
                    </div>
                    @if ($errors->has('Permission'))
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $errors->first('Permission') }}</strong>
                        </span>
                    @endif
                    <div class="form-group">
                        <div>
                            <button type="submit" id="submit" name="submit" value="submit"
                                class="btn btn-primary">Add</button>
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
<script>
    $(".Permission_form").validate({
        rules: {
            Permission: {
                required: true,
            }
        },
        messages: {
            Permission: {
                required: "This field is required",
            }
        },
        submitHandler: function(form) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },

                url: "{{ route('admin.permission.create') }}",
                method: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'JSON',
                success: function(data) {
                    if (data.status == true) {
                        swal("Done!", data.message, "success");
                        $("#Add-permission-modal").modal('hide');
                        window.LaravelDataTables["permission-table"].draw();
                    }
                    $(".Permission_form")[0].reset();

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
