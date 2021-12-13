@extends('layouts.master')

@section('page_title', 'Update User')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">@yield('page_title')</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);"></a></li>
                                <li class="breadcrumb-item active"></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-30">
                        <div class="card-header">

                        </div>
                        <div class="card-body">
                            <!-- ajax form response -->

                            <div class="ajax-msg"></div>
                            <div class="table-responsive">
                                <form method="post" id="update" action="{{route('admin.updateaddres')}}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="profile">{{ __('Current Profile') }} :</label>
                                        <img src="../../images/{{$userdata['profile']}} " height="50px" width="50px" />
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-4">
                                            <label for="firstname">{{ __('Firstname') }} :</label>
                                            <input id="firstname" type="firstname" class="form-control" name="firstname" value="{{$userdata['firstname']}}" autocomplete="firstname" autofocus>
                                        </div>


                                        <div class="col-sm-4">
                                            <label for="lastname">{{ __('Lastname') }} :</label>
                                            <input id="lastname" type="lastname" class="form-control " name="lastname" value="{{$userdata['lastname']}}" required autocomplete="lastname" autofocus>
                                        </div>

                                        <div class="col-sm-4">
                                            <label for="email">{{ __('Email') }} :</label>
                                            <input id="email" type="email" class="form-control " name="email" value="{{$userdata['email']}}" required autocomplete="email" autofocus>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-4">
                                            <label for="category">{{ __('Category') }} :</label>
                                            <select class="form-control" name="category" id="category">

                                                @foreach ($category as $cat)
                                                <option value="{{$cat->id}}" {{$cat->id == $cat->category_name ?'selected':''}}>{{"$cat->category_name"}}

                                                </option>
                                                @endforeach

                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="subcategory">{{ __('Subcategory') }} :</label>
                                            <select class="form-control subcategory" name="subcategory" id="subcategory">
                                                <option> ---Select Subcategory--- </option>


                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="profile">{{ __('Profile') }} :</label>
                                            <input id="profile" type="file" class="form-control @error('profile') is-invalid @enderror" name="profile" autocomplete="current-profile">
                                        </div>
                                    </div>


                                    <div class="form-group row ">
                                        <div class="col-sm-6">
                                            <label for="Address">{{ __('Address') }} :</label>
                                            <textarea id="address" type="text" class="form-control" name="address[0][address]" value="{{ old('address') }}" autocomplete="address" autofocus></textarea>
                                        </div>
                                        <div class="col-sm-4">
                                            <button type="button" class="btn btn-success" id="add-more" title="Add">Add </button>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-4">

                                            <label for="country">{{ __('Country') }} :</label>
                                            <select class="form-control country" name="address[0][country]" id="country">
                                                <option value=""> ---Select Country--- </option>
                                                @foreach ($data as $country)
                                                <option value="{{$country->id}}">
                                                    {{$country->name}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-4">

                                            <label for="state">{{ __('State') }} :</label>
                                            <select class="form-control state" name="address[0][state]" id="state">
                                                <option value=""> ---Select State--- </option>
                                            </select>
                                        </div>
                                        <div class="col-sm-4">

                                            <label for="city">{{ __('City') }} :</label>
                                            <select class="form-control city" name="address[0][city]" id="city">
                                                <option value=""> ---Select City--- </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div id="add-address">

                                    </div>
                                    <input type="hidden" id="id" name="id" value="{{$userdata['id']}}">
                                    <div class="form-group">
                                        <button type="submit" name="submit" class="btn btn-primary">
                                            {{ __('Update') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div> <!-- container-fluid -->
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>


    <script>
        $("#update").validate({
            rules: {
                firstname: {
                    required: true,
                },
                lastname: {
                    required: true,
                },
                email: {
                    required: true,
                },
                category: {
                    required: true,
                },
                subcategory: {
                    required: true,
                },
                'address[]': {
                    required: true,
                },
                'country[]': {
                    required: true,
                },
                'state[]': {
                    required: true,
                },
                'city[]': {
                    required: true,
                },


            },
        
        });
        $('#add-more').on('click', function() {

            // alert(123);
            my_addmore_count = $('body').find('.my_addmore').length;
            // alert(my_addmore_count);
            i = my_addmore_count + 1;
            // add rows to the form
            var html = `<div class="add_` + i + `"><div class="form-group row  my_addmore">
                                        <div class="col-sm-6 ">
                                            <label for="Address">{{ __('Address') }} :</label>
                                            <textarea id="address" type="text" class="form-control" name="address[` + i + `][address]" value="" autocomplete="address" autofocus></textarea>
                                        </div>
                                      
                                    </div>
                                        <div class="form-group row my_addmore">
                                         <div class="col-sm-4">

                                            <label for="country">{{ __('Country') }} :</label>
                                            <select class="form-control country" name="address[` + i + `][country]" id="country">
                                                <option> ---Select Country--- </option>
                                                @foreach ($data as $country)
                                                <option value="{{$country->id}}">
                                                    {{$country->name}}
                                                </option>
                                                @endforeach
                                            </select>
                                            </div>
                                        <div class="col-sm-4">

                                            <label for="country">{{ __('State') }} :</label>
                                            <select class="form-control state" name="address[` + i + `][state]" id="state">
                                                <option> ---Select State--- </option>
                                            </select>
                                        </div>
                                        <div class="col-sm-4">

                                            <label for="country">{{ __('City') }} :</label>
                                            <select class="form-control city" name="address[` + i + `][city]" id="city">
                                                <option> ---Select City--- </option>
                                            </select>
                                        </div>
                                        
                                    </div>
                                    <div class="col-sm-4">
                                            <button type = "button" style="margin:5px;" class="btn btn-danger delete">Delete </button>
                                        </div>
                                </div></div>`;
            $("#add-address").append(html);

            $('.delete').on('click', function() {
                $(this).parent().parent().remove();
            });


        })


        $('body').on('change', '.country', function() {
            $this = $(this);
            country = $this.val();
            console.log(country);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url: "{{route('admin.getstate')}}",
                type: 'POST',
                data: {
                    country: country
                },
                dataType: "JSON",
                success: function(data) {
                    $this.parent().parent().find(".state").html('');
                    $.each(data.data, function(key, value) {
                        $this.parent().parent().find(".state").append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                }
            });
        });

        $('body').on('change', '.state', function() {
            $this = $(this);
            state = $this.val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url: "{{route('admin.getcity')}}",
                type: 'POST',
                data: {
                    state: state
                },
                dataType: "JSON",
                success: function(data) {
                    $this.parent().parent().find(".city").html('');
                    $.each(data.data, function(key, value) {
                        $this.parent().parent().find(".city").append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                }

            });
        });

        $('#category').on('change', function() {
            category = $('#category').val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url: "{{route('admin.getsubcategory')}}",
                type: 'POST',
                data: {
                    category: category
                },
                dataType: "JSON",
                success: function(data) {
                    console.log(data.data);
                    $.each(data.data, function(key, value) {
                        $(".subcategory").append('<option value="' + value.id + '">' + value.subcategory_name + '</option>');
                    });
                }

            });
        });
    </script>
    @endsection