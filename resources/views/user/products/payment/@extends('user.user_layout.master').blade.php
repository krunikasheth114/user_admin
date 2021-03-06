@extends('user.user_layout.master')
@section('content')
    <div class="container">
        <div class="row">
            {{-- <div class="col-2">
                <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#card-model" name="submit"
                    id="submit" type="submit">Add Card</button>
            </div> --}}
        </div>
        <form action="/charge" method="post" id="payment-form">
            <div class="form-row">
                <label for="card-element">
                    Credit or debit card
                </label>
                <div id="card-element">
                    <!-- A Stripe Element will be inserted here. -->
                </div>

                <!-- Used to display Element errors. -->
                <div id="card-errors" role="alert"></div>
            </div>

            <button>Submit Payment</button>
        </form>

    </div>

    @push('page_scripts')
        <script src="https://js.stripe.com/v3/"></script>
        <script>
            // console.log(env('STRIPE_SECRET'));
            var stripe = Stripe(
                'pk_test_51KWcfwDW7BFxuIWNo1aEzQ2EBKsiTlQ7WxcdZgjELCkKD41eYGuC6ZBFbUokhZkgJAQwuakkP4AaDUE2mgNjLpzz00l061Od6x'
            );
            var elements = stripe.elements();
          
            // Custom styling can be passed to options when creating an Element.
            var style = {
                base: {
                    // Add your base input styles here. For example:
                    fontSize: '16px',
                    color: '#32325d',
                },
            };
         
            // Create an instance of the card Element.
            var card = elements.create('card', {
                style: style
            });
      
            var form = document.getElementById('payment-form');
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                stripe.createToken(card).then(function(result) {
                    if (result.error) {
                        // Inform the customer that there was an error.
                        var errorElement = document.getElementById('card-errors');
                        errorElement.textContent = result.error.message;
                    } else {
                        // Send the token to your server.
                        stripeTokenHandler(result.token);
                    }
                });
            });
         
            function stripeTokenHandler(token) {
                // Insert the token ID into the form so it gets submitted to the server
                var form = document.getElementById('payment-form');
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', token.id);
                form.appendChild(hiddenInput);

                // Submit the form
                form.submit();
            }
            
        </script>
    @endpush

    </body>
@endsection
