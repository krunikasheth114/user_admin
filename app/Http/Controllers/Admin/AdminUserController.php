<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use  App\DataTables\AdminDataTable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Requests\AdminRequest;
use App\Models\Admin;

class AdminUserController extends Controller
{
    public function index(AdminDataTable $datatable)
    {
        $role = \App\Models\Role::get();
        return $datatable->render('admin.admin.index', compact('role'));
    }

    
    public function edit(Request $request)
    {
        $data['users'] = Admin::find($request->id);
        $data['roles'] = DB::table('model_has_roles')->where('Model_id', $request->id)->get();
        $data['role'] = \App\Models\Role::get();
        return response()->json(['status' => true,  'data' =>  $data]);
    }
    public function update(Request $request)
    {

        // dd($request->all());
        $id = $request->hidden;
        $request->validate([
            'email_edit' => 'required|unique:admins,email,' . $id,
        ]);
        $update_admin_user = Admin::find($request->hidden);
        $update_admin_user->email = $request->input('email_edit');
        $role_id = $request->role_edit;
        $delete = DB::table('model_has_roles')->where('model_id', $request->hidden)->delete();
        $update_admin_user->assignRole($role_id);
        $update_admin_user->save();

        return response()->json(['status' => true, 'message' => '  Admin Updated Succesfully']);
    }
    public function delete(Request $request)
    {
        $delete_admin_user = Admin::find($request->id);
        $delete_admin_user->delete();
        $delete = DB::table('model_has_roles')->where("model_id", $request->id)->delete();
        return response()->json(['status' => true, 'message' => '  Admin Deleted Succesfully']);
    }
}
