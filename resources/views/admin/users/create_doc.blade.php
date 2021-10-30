<div class="modal" tabindex="-1" role="dialog" id="adddoc">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Document</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{ Form::open(['class' => 'doc', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                {{ Form::token() }}
                <div class="form-group row">
                    <div class="col-4">
                        {{ Form::label('documnet', 'Document Name:') }}
                    </div>
                    <div class="col-6">
                        {!! Form::text('Document', old('document'), ['name' => 'doc_name', 'class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-4">
                        {{ Form::label('documnet number', 'Document Number:') }}
                    </div>
                    <div class="col-6">
                        {!! Form::text('Document number', old('documnet number'), ['name' => 'doc_num', 'document', 'class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-4">
                        {{ Form::label('documnet image', 'Document image:') }}
                    </div>
                    <div class="col-6">
                        {!! Form::file('doc_image', ['name' => 'image[0]', 'multiple' => true, 'class' => 'form-control','id'=>'image','required']) !!}
                    </div>
                    <div class="col-2">
                        {!! Form::button('<i class="fa fa-plus"></i>', ['class' => 'btn btn-danger add_more']) !!}
                    </div>
                </div>
                <div class="form-group row " id="append">

                </div>
                <div class="form-group row">
                    <div class="col-4">

                    </div>
                    <div class="col-6">
                        {{ Form::hidden('user_id', 'secret', ['id' => 'user_id']) }}
                        {!! Form::submit('Save', ['class' => 'btn btn-primary', 'name' => 'submit', 'type' => 'submit']) !!}
                    </div>
                </div>
                {{ Form::close() }}
            </div>

        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
    var i = 1;
    $("body").on("click", ".add_more", function() {
        my_addmore_count = $('body').find('.my_add_more').length;
        i = my_addmore_count + 1;
        var maxfield = 2;

        if (i >= maxfield) {
            alert("you can not add more than two document");
            return false;
        }

        var html = `<div class="form-group row my_add_more">
                    <div class="col-4">
                        {{ Form::label('documnet image', 'Document image:') }}
                    </div>
                    <div class="col-6">
                        {!! Form::file('doc_image', ['name' => 'image[` + i + `]', 'multiple' => true, 'class' => 'form-control','id'=>'image','required']) !!}
                    </div>
                        <div class="col-2">
                            {!! Form::button('<i class="fa fa-close"></i>', ['class' => 'btn btn-danger delete_add_more']) !!}     
                        </div>
                </div>`;
        $("#append").append(html);
    });
    $("body").on("click", ".delete_add_more", function() {
        $(this).parent().parent().remove();
    });

    $("body").on("click", ".adddoc", function() {
        var Id = $(this).attr('id');
        $("#user_id").val(Id);
    })
    $(".doc").validate({
        rules: {
            doc_name: {
                required: true,
            },
            doc_num: {
                required: true,
                number: true,
            },
            'image[]':{
                required: true,
            }

        },
        messages: {
            doc_name: {
                required: "This field is required",
            },
            doc_num: {
                required: "This field is required",
                number: "Only Digits Are Allowed",
            },
            'image[]':{
                required: "This field is required",
            }



        },

        submitHandler: function(form) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url: "{{ route('admin.createDoc') }}",
                method: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'JSON',
                success: function(data) {
                    if (data.status == true) {
                        alert(data.message);
                        $("#adddoc").modal('hide')
                        window.LaravelDataTables["users-table"].draw();
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

        },
       

    })
</script>
