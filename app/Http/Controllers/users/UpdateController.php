<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Subcategory;
use App\Http\Requests\UpdateUserRequest;
class UpdateController extends Controller
{
  public function getsubcategory(Request $request)
  {
    $subcategory = Subcategory::where('category_id', $request->id)->get(['id', 'subcategory_name']);
    // dd($subcategory);
    return response()->json(['status' => true, 'data' => $subcategory]);
  }
  public function edit(Request $request)
  {
  

    $data['user'] = User::find($request->id);
  
    $data['Category'] = Category::get(['category_name', 'id']);
    $data['subcategory'] = Subcategory::get(['subcategory_name', 'id']);
    return response()->json(['status' => true, 'data' => $data]);
  }
  public function update(UpdateUserRequest $request)
  {

    $data = User::find($request->id);
    $data->firstname = $request->input('firstname');
    $data->lastname = $request->input('lastname');
    $data->email = $request->input('email');
    $data->category_id = $request->input('category');
    $data->subcategory_id = $request->input('subcategory');
    if ($profile = $request->file('profile')) {
      if ($data->profile != "") {
        $destinationPath = 'images/';
        $file_old = $destinationPath . $data->profile;
        unlink($file_old);
      }
      $profileImage = date('YmdHis') . "." . $profile->getClientOriginalExtension();
      $profile->move($destinationPath, $profileImage);
      $data->profile = "$profileImage";
    }
    $data->update();
    return response()->json(['status' => true, 'message' => 'Update Success']);
  }
}
