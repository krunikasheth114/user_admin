elseif (isset($retriveCusId->cus_id) &&  $retriveCusId->last4 != $request->cardnumber) {
                $customer = $stripe->customers->update($retriveCusId->cus_id);
                $stripe->customers->createSource(
                    $customer->id,
                    [
                        'source' => $token->id,
                    ]
                );
                $stripe->customers->update(
                    $customer->id,
                    ['default_source' => $customer->default_source]
                );
                Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                $charge = \Stripe\Charge::create([
                    'amount' => $request->total_amount * 100, // $15.00 this time
                    'currency' => 'usd',
                    'customer' => $retriveCusId->cus_id, // Previously stored, then retrieved
                    "description" => "Test payment",
                ]);
                $cardDetail = PaymentMethod::create([
                    'token_id' =>  $token->id,
                    'user_id' => Auth::user()->id,
                    'cus_id' => $charge->source->customer,
                    'card_id' => $charge->payment_method,
                    'last4' => $request->cardnumber,
                    'exp_month' => $charge->payment_method_details->card->exp_month,
                    'exp_year' => $charge->payment_method_details->card->exp_year,
                    'brand' => $charge->payment_method_details->card->brand,
                    'cvc' => $request->cvc,
                    'default_method' => 1,
                ]);
                $defalt0 = PaymentMethod::where('user_id', Auth::user()->id)->where('card_id', '!=', $charge->payment_method)->update([
                    'default_method' => 0,
                ]);

                // create new one
            } 