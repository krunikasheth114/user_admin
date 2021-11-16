<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\UsersDataTable;
use App\Models\Category;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Http\Requests\UpdateRequest;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\Document;
use App\Http\Requests\DocumentRequest;
use App\Models\Subcategory;

class UserController extends Controller
{
  public function dataTable(UsersDataTable $datatable)
  {


    return $datatable->render('admin.users.index');
  }
  public function gets(Request $request)
  {

    $data = User::where('id', $request->id)->update(['status' => $request->status]);
    return response()->json(['status' => true, 'data' => $data]);
  }


  public function edit(Request $request)
  {

    $data['user'] = User::find($request->id);
    $data['Category'] = Category::get(['category_name', 'id']);
    $data['subcategory'] = Subcategory::get(['subcategory_name', 'id']);
    return response()->json(['status' => true, 'data' => $data]);
  }

  public function update(Request $request)
  {
    $id = $request->id;
    $request->validate([
      'firstname' => 'required',
      'lastname' => 'required',
      'email' => 'required|unique:users,email,' . $id,
      'profile' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);
    $data = User::find($request->id);

    $data->firstname = $request->input('firstname');
    $data->lastname = $request->input('lastname');
    $data->email = $request->input('email');
    $data->category_id = $request->input('category');
    $data->subcategory_id = $request->input('subcategory');
    if (isset($request->profile)) {
      $profile = $request->profile;
      $destinationPath = public_path('images/');
      if (!empty($data->profile)) {
        $file_old = $destinationPath . $data->profile;
        unlink($file_old);
      }
      $profileImage = date('YmdHis') . "." . $profile->extension();
      $profile->move($destinationPath, $profileImage);
      $data->profile = $profileImage;
    }
    $data->update();
    return response()->json(['status' => true, 'message' => 'Update Success']);
  }
  public function delete(Request $request)
  {
    $data = User::find($request->id);

    $data->delete();
    return response()->json(['status' => true, 'message' => "Delete Successfully"]);
  }

  public function show($id)
  {
    $userdata = User::find($id);
    $data = Country::get(['name', 'id']);
    $category = Category::get(['category_name', 'id']);
    return view('admin.users.edit_add', compact(['data', 'category', 'userdata']));
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

  public function getsub(Request $request)
  {
    $subcategory = Subcategory::where('category_id', $request->id)->get(['id', 'subcategory_name']);
    // dd($subcategory);
    return response()->json(['status' => true, 'data' => $subcategory]);
  }
}
