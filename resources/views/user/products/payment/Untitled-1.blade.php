
                <form role="form" action="{{ route('product.user-payment')}}" method="post" class="require-validation" data-cc-on-file="false"
                data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" id="payment-form">
                @csrf
                <div class="form-group">
                    <label for='nameoncard'>Name on Card</label>
                    <input class='form-control' name="nameoncard" size='4' type='text'>
                </div>
                <div class="form-group">
                    <label for='email'>email</label>
                    <input class='form-control' name="email" type='text'>
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
                            class='form-control card-expiry-month' name="expirationmonth" placeholder='MM' size='2'
                            type='text'>
                    </div>
                    <div class='col-xs-12 col-md-4 form-group expiration required'>
                        <label for='expirationyear'>Expiration Year</label> <input
                            class='form-control card-expiry-year' name="expirationyear" placeholder='YYYY' size='4'
                            type='text'>
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
                    <button class="btn btn-primary btn-lg" type="submit">Pay Now <i
                            class="fa fa-inr">{{ $data['total_amount'] }}</i></button>
                </div>

            </form>




            card.mount('#card-element');
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









            $('#payment-form').validate({
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