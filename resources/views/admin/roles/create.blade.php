<div class="modal fade" id="Add-role-modal" role="dialog" aria-modal="true" data-backdrop="static"
    aria-labelledby="add_permission_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="workerLabel"> {{__('messages.addpermission')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data"
                    class="role_form">
                    @csrf
                    <div class="form-group">
                        <label> {{__('messages.role')}}</label>
                        <input type="text" class="form-control" name="role" id="role"
                            placeholder="Add Role" required>
                    </div>
                    @if ($errors->has('role'))
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $errors->first('role') }}</strong>
                        </span>
                    @endif
                    <div class="form-group">
                        <div>
                            <button type="submit" id="submit" name="submit" value="submit"
                                class="btn btn-primary">{{__('messages.add')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(".role_form").validate({
        rules: {
            role: {
                required: true,
            }
        },
      
        submitHandler: function(form) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },

                url: "{{ route('admin.role.store') }}",
                method: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'JSON',
                success: function(data) {
                    if (data.status == true) {
                        swal("Done!", data.message, "success");
                        $("#Add-role-modal").modal('hide');
                        window.LaravelDataTables["role-table"].draw();
                    }
                    $(".role_form")[0].reset();

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
    })
</script>
