<div class="modal" tabindex="-1" role="dialog" id="updateprofile">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <h4 class="text-muted text-center font-18"><b>
                            Update Your Profile!</b></h4>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                <div class="p-2">
                    <form method="POST" id="update_form" action="#">
                        @csrf
                        <div class="form-group">
                            <label for="profile">{{ __('Current Profile') }} :</label>
                            <span id="profile"></span>
                        </div>
                        <div class="form-group">
                            <label for="firstname">{{ __('Firstname') }} :</label>
                            <input id="firstname" type="firstname" class="form-control @error('firstname') is-invalid @enderror" name="firstname" required autocomplete="firstname" autofocus>
                        </div>
                        @if ($errors->has('firstname'))
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $errors->first('firstname') }}</strong>
                        </span>
                        @endif
                        <div class="form-group">
                            <label for="lastname">{{ __('Lastname') }} :</label>
                            <input id="lastname" type="lastname" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}" required autocomplete="lastname" autofocus>
                        </div>
                        @if ($errors->has('lastname'))
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $errors->first('lastname') }}</strong>
                        </span>
                        @endif
                        <div class="form-group ">
                            <label for="email">{{ __('Email') }} :</label>

                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        </div>
                        @if ($errors->has('email'))
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                        <div class="form-group">
                            <label for="category">{{ __('Category') }} :</label>
                            <select class="form-control" name="category" id="category">
                            </select>
                        </div>
                        @if ($errors->has('category'))
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $errors->first('category') }}</strong>
                        </span>
                        @endif
                        <div class="form-group">
                            <label for="subcategory">{{ __('Subcategory') }} :</label>
                            <select class="form-control" name="subcategory" id="subcategory">

                            </select>
                        </div>
                        @if ($errors->has('subcategory'))
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $errors->first('subcategory') }}</strong>
                        </span>
                        @endif
                        <div class="form-group ">
                            <label for="profile">{{ __('Profile') }} :</label>
                            <input id="profile" type="file" class="form-control @error('profile') is-invalid @enderror" name="profile"  autocomplete="current-profile">
                        </div>
                        <input type="hidden" id="id" name="id" value="">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Update') }}
                            </button>
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
        $('#update_form').validate({
          
            submitHandler: function(form) {

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },

                    url: "{{ route('update')}}",
                    method: "POST",
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'JSON',
                    success: function(data) {
                        alert(data.message);
                        window.location.href = '/dashboard';
                    },
                    error:function(error){
                        console.log(error.responseJSON.errors);
                        var i;
                        var res= error.responseJSON.errors;
                        $.each(res, function(key,value){
                            tostr.error(value);
                        });
                    }
                })
            },

        });
        $(".update").on('click', function() {
            var id = $(this).attr('id');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url: "{{route('edit')}}",
                method: "post",
                data: {

                    id: id,
                },
                dataType: 'JSON',
                success: function(data) {

                    $('#id').val(data.data.user.id);
                    $('#firstname').val(data.data.user.firstname);
                    $('#lastname').val(data.data.user.lastname);
                    $('#email').val(data.data.user.email);
                    $.each(data.data.Category, function(key, value) {
                        $("#category").html('<option value="' + value.id + '">' + value.category_name + '</option>');
                    });
                    $.each(data.data.subcategory, function(key, value) {
                        $("#subcategory").html('<option value="' + value.id + '">' + value.subcategory_name + '</option>');
                    })
                    $('#profile').html('<img src="' + /images/ + data.data.user.profile + '"height="50px" width="50px"/>');

                }

            })
        })
    </script>