<div class="modal " id="Admin_user" role="dialog" aria-modal="true" tabindex="-1" data-backdrop="static"
    aria-labelledby="">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="workerLabel">{{__('messages.addadminuser') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" class="Admin_user" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <div class="col-sm-8">
                            <label for="email">{{__('messages.email') }}:</label>
                            <input id="email" type="email" class="form-control" id="email" name="email" value=""
                                autocomplete="email" required autofocus>

                            @if ($errors->has('email'))
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-8">
                            <label>{{__('messages.role') }}</label>
                            <select class="form-control" name="role" id="role">
                                <option value="">---select----</option>
                                @foreach ($role as $r)
                                    <option value="{{ $r->id }}">
                                        {{ $r->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-8">
                            <label for="password">{{__('messages.password') }}</label>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password"
                                placeholder="Enter Password" required>
                            @if ($errors->has('password'))
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-primary">
                                {{__('messages.add') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $('.Admin_user').validate({
        // lang: 'fr',
        rules: {
            email: {
                required: true,
            },
            password: {
                required: true,
            }
        },
        submitHandler: function(form) {
            var id = $('#id').val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url: '{{ route('admin.admin_user.store_admin') }}',
                method: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'JSON',
                success: function(data) {
                    swal("Done!", data.message, "success");
                    $('#Admin_user').modal('hide');

                    window.LaravelDataTables["admin-table"].draw()
                    $(".Admin_user")[0].reset();
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
