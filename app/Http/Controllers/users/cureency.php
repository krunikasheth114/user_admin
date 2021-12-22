\Session::forget('currency1');
        // dd(\Session::get('currency1'));
        $product = Product::orderBy('id')->get();
        $category = Product_category::get();
        $from = $request->from;
        $currency = \session(['currency1' => $request->to]);
        $data =   \Session::get('currency1');
        $to = $request->to;
        foreach ($product as $p) {
            $converted = $p;
            if ($from == 'INR') {
                $to = 'EUR';
                $newPrice = Currency::convert()
                    ->from($from)
                    ->to($to)
                    ->amount($p->price)
                    ->get();
            } else {
                $newPrice = $p->price;
            }
            $converted['new_price'] = $newPrice;
            $converted['category_name'] = $p->getCategory->name;
            $new[] = $converted;
            $converted['session_val'] = $data;

            // dd(\Session::get('currency1'));