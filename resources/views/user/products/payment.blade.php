@extends('user.user_layout.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-2"></div>
            <div class="col-8">
                <div class="card">
                    <div class="card-header">
                        <h3>Payment Details</h3>
                    </div>
                    <div class="card-body">
                        @if (Session::has('success'))
                            <div class="alert alert-success text-center">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                <p>{{ Session::get('success') }}</p>
                            </div>
                        @endif
                        <form role="form" action="{{ route('product.user-payment') }}" method="post"
                            class="require-validation" data-cc-on-file="false"
                            data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" id="payment-form">
                            @csrf
                            <div class="form-group">
                                <label for='nameoncard'>Name on Card</label>
                                <input class='form-control' name="nameoncard" size='4' type='text'>
                            </div>
                            <div class='form-group'>
                                <label for='cardnumber'>Card Number</label>
                                <input autocomplete='off' name="cardnumber" class='form-control card-number' size='20'
                                    type='text'>
                            </div>

                            <div class='form-row row'>
                                <div class='col-xs-12 col-md-4 form-group cvc required'>
                                    <label for='cvc'>CVC</label>
                                    <input autocomplete='off' name="cvc" class='form-control card-cvc' placeholder='ex. 311'
                                        size='4' type='text'>
                                </div>
                                <div class='col-xs-12 col-md-4 form-group expiration required'>
                                    <label for='expirationmonth'>Expiration Month</label> <input
                                        class='form-control card-expiry-month' name="expirationmonth" placeholder='MM'
                                        size='2' type='text'>
                                </div>
                                <div class='col-xs-12 col-md-4 form-group expiration required'>
                                    <label for='expirationyear'>Expiration Year</label> <input
                                        class='form-control card-expiry-year' name="expirationyear" placeholder='YYYY'
                                        size='4' type='text'>
                                </div>
                            </div>
                            {{-- <div class='form-row row'>
                                    <div class='col-md-12 error form-group hide'>
                                        <div class='alert-danger alert'>Please correct the errors and try
                                            again.</div>
                                        </div>
                                    </div> --}}
                            <div class="row">
                                <div class="col-xs-12">
                                    <input type="hidden" name="cart_id" value="{{ $data['cart_id'] }}">
                                    <input type="hidden" name="quantity" value="{{ $data['quantity'] }}">
                                    <input type="hidden" name="total_amount" value="{{ $data['total_amount'] }}">

                                </div>
                                <button class="btn btn-primary btn-lg btn-block" type="submit">Pay Now <i
                                        class="fa fa-inr">{{ $data['total_amount'] }}</i></button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>



        </div>

        </body>


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

                    if (!$form.data('cc-on-file')) {
                        e.preventDefault();
                        Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                        Stripe.createToken({
                            number: $('.card-number').val(),
                            cvc: $('.card-cvc').val(),
                            exp_month: $('.card-expiry-month').val(),
                            exp_year: $('.card-expiry-year').val()
                        }, stripeResponseHandler);
                    }

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
            $('#payment-form').validate({
                rules: {
                    nameoncard: {
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
        </script>
    @endsection
