@extends('user.user_layout.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-3"></div>
            <div class="col-4"></div>
            <div class="col-2" style="float: right">
                <button class="btn btn-success btn-lg " data-toggle="modal" data-target="#card-model" name="submit"
                    id="submit" type="submit">Add New Card</button>
            </div>
        </div>
    </div>
    <br>
    <div class="row mt-6">
        <div class="col-3"></div>
        <div class="col-6">
            @if (isset($paymentDetails))
                @foreach ($paymentDetails as $item)
                    <div class="card">
                        <div class="card-header">
                            @include('common.flash')
                            <button class="btn btn-primary update" data-toggle="modal" data-target="#card-model"
                                name="update" id="update" data-id="{{ $item['id'] }}" type="submit"><i
                                    class="fa fa-edit"></i></button>
                            {{-- Remove card --}}
                            {{-- <button class="btn btn-danger" style="float: right"><i class="fa fa-remove"
                                    cus_id="{{ $item->cus_id }}" card_id="{{ $item->card_id }}" id="remove"
                                    name="submit"></i></button> --}}
                        </div>
                        <div class="card-body">
                            <form action="{{ route('product.existingpayment') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <label for="cardnum">Card Number</label>
                                        <input type="text" name="card" id="" value="{{ $item->last4 }}"
                                            class="form-control" readonly><br>
                                        <label for="cardnum">Total amount</label>
                                        <input type="text" name="ammount" value=" {{ $data['total_amount'] }} "
                                            class="form-control" readonly><br>
                                    </div>
                                </div>
                                <input type="hidden" name="cart_id" value="{{ $data['cart_id'] }}">
                                <input type="hidden" name="quantity" value="{{ $data['quantity'] }}">
                                <input type="hidden" name="customer_id" value="{{ $item->cus_id }}">
                                <input type="hidden" name="card_id" value="{{ $item->card_id }}">
                                <input type="hidden" name="cvc" value="{{ $item->cvc }}">
                                <input type="hidden" name="exp_month" value="{{ $item->exp_month }}">
                                <input type="hidden" name="exp_year" value="{{ $item->exp_year }}">
                                <button class="btn btn-dark btn-block" name="submit">Pay <i class="fa fa-inr">
                                        {{ $data['total_amount'] }}</i></button>
                            </form>
                        </div>
                    </div>
                    <br>
                @endforeach
            @endif
        </div>
    </div>
    <script src="{{ asset('frontend/vendor/jquery/jquery.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>

    <script>
        $('.payment-form').validate({
            rules: {
                nameoncard: {
                    required: true,
                },
                email: {
                    required: true,
                },
                cardnumber: {
                    required: true,
                },
                cvc: {
                    required: true,
                },
                expirationmonth: {
                    required: true,
                },
                expirationyear: {
                    required: true,
                },

            },
            messages: {
                nameoncard: {
                    required: "This field is required",
                },
                email: {
                    required: "This field is required",
                },
                cardnumber: {
                    required: "This field is required",
                },
                cvc: {
                    required: "This field is required",
                },
                expirationmonth: {
                    required: "This field is required",
                },
                expirationyear: {
                    required: "This field is required",
                },


            },
        });
        $('body').on('click', '#remove', function() {
            var cus_id = $(this).attr('cus_id');
            var card_id = $(this).attr('card_id');
            $.ajax({
                url: "{{ route('product.deletepaymentmethod') }}",
                method: "post",
                data: {
                    _token: "{{ csrf_token() }}",
                    cus_id: cus_id,
                    card_id: card_id,
                },
                dataType: 'JSON',
                success: function(data) {
                    if (data.status == true) {
                        toastr.success(data.msg);
                    }
                }
            })
        })
        $('body').on('click', '.update', function() {
            var id = $(this).attr('data-id');
            $.ajax({
                url: "{{ route('product.editpaymentmethod') }}",
                method: "GET",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                dataType: 'JSON',
                success: function(data) {
                    console.log(data.data);
                    $('#hidden_id').val(data.data.editData.id);
                    $('#hidden_cusid').val(data.data.editData.cus_id);
                    $('#hidden_cardid').val(data.data.editData.card_id);
                    $("#nameoncard").val(data.data.customerData.name);
                    $(".email").val(data.data.customerData.email);
                    $("#cardnumber").val(data.data.editData.last4);
                    $("#cvc").val(data.data.editData.cvc);
                    $("#expirationmonth").val(data.data.editData.exp_month);
                    $("#expirationyear").val(data.data.editData.exp_year);

                }
            })

        })
    </script>

    @push('page-scripts')
        <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
        <script type="text/javascript">
            $(function() {
                var $form = $(".require-validation");
                $('form.require-validation').bind('submit', function(e) {
                    var $form = $(".require-validation"),
                        inputSelector = ['input[type=email]', 'input[type=password]',
                            'input[type=text]', 'input[type=file]',
                            'textarea'
                        ].join(', '),
                        $inputs = $form.find('.required').find(inputSelector),
                        $errorMessage = $form.find('div.error'),
                        valid = true;
                    $errorMessage.addClass('hide');
                    $('.has-error').removeClass('has-error');
                    $inputs.each(function(i, el) {
                        var $input = $(el);
                        if ($input.val() === '') {
                            $input.parent().addClass('has-error');
                            $errorMessage.removeClass('hide');
                            e.preventDefault();
                        }
                    });
                });

                function stripeResponseHandler(status, response) {
                    if (response.error) {
                        $('.error')
                            .removeClass('hide')
                            .find('.alert')
                            .text(response.error.message);
                    } else {
                        // token contains id, last4, and card type
                        var token = response['id'];
                        // insert the token into the form so it gets submitted to the server
                        $form.find('input[type=text]').empty();
                        $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                        $form.get(0).submit();
                    }
                }
            });
            $('body').on('click', ".submit", function() {

            })
        </script>
    @endpush
    @include('user.products.payment.create')
@endsection
