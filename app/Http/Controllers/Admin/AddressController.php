<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AddressRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\User;
use App\Models\Subcategory;
use App\Models\UserAddress;
use App\Models\Category;
use App\Models\State;
use App\Models\City;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.users.address');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $userdata = User::find($id);
        $data = Country::get(['name', 'id']);
        $category = Category::get(['category_name', 'id']);
        $subcategory = Subcategory::get(['subcategory_name', 'id']);
        // dd($category);
        return view('admin.users.address', compact(['data', 'category', 'userdata', 'subcategory']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $userdata = User::find($id);
        $data = Country::get(['name', 'id']);
        $category = Category::get(['category_name', 'id']);
        $subcategory = Subcategory::get(['subcategory_name', 'id']);
        // dd($category);
        return view('admin.users.address', compact('data', 'category', 'userdata', 'subcategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AddressRequest $request, $id)
    {
        $data = $request->validated();
        $data = User::find($id);
        $data->firstname = $request->input('firstname');
        $data->lastname = $request->input('lastname');
        $data->email = $request->input('email');
        $data->category_id = $request->input('category');
        $data->subcategory_id = $request->input('subcategory');
        if ($profile = $request->file('profile')) {
            $destinationPath = 'images/';
            $profileImage = date('YmdHis') . "." . $profile->getClientOriginalExtension();
            $profile->move($destinationPath, $profileImage);

            $data->profile = "$profileImage";
        }
        $data->update();

        if (!empty($request->address)) {
            foreach ($request->address as $collec) {

                UserAddress::create([
                    'user_id' => $id,
                    'address' => $collec['address'],
                    'country' => $collec['country'],
                    'state' => $collec['state'],
                    'city' => $collec['city'],
                ]);
            }
        }
        $category = Category::get(['category_name', 'id']);

        $subcategory = Subcategory::get(['subcategory_name', 'id']);
        $userdata  = $data;
        $data = Country::get(['name', 'id']);
        return view('admin.users.address', compact('userdata', 'category', 'data', 'subcategory'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
    public function getstate(Request $request)
    {
        $state = State::where('country_id', $request->country)
            ->get(['name', 'id']);
        return response()->json(['status' => true, 'data' => $state]);
    }

    public function getcity(Request $request)
    {
        $city = City::where('state_id', $request->state)
            ->get(['name', 'id']);
        return response()->json(['status' => true, 'data' => $city]);
    }
    public function getsubcategory(Request $request)
    {
        $subcategory = Subcategory::where('category_id', $request->category)
            ->get(['subcategory_name', 'id']);
        return response()->json(['status' => true, 'data' => $subcategory]);
    }
}
