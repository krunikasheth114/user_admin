@extends('user.user_layout.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-2">
                <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#card-model" name="submit"
                    id="submit" type="submit">Add New Card</button>
            </div>
        </div>
    </div>
    <div class="row mt-6">
        <div class="col-3"></div>
        <div class="col-6">
            @if (isset($paymentDetails))
                @foreach ($paymentDetails as $item)
                    <div class="card">
                        <div class="card-header">
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
                                        <input type="text" name="ammount" id="" value=" {{ $data['total_amount'] }} "
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
        </script>
    @endpush
    @include('user.products.payment.create')
@endsection
