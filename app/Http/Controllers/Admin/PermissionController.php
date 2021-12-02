<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
// use App\Models\Permission;
use App\DataTables\PermissionDataTable;
use App\Http\Requests\PermissionRequest;
use Spatie\Permission\Models\Permission;


class PermissionController extends Controller
{
    public function view(PermissionDataTable $datatable)
    {
        return $datatable->render('admin.permission.index');
    }
    public function create(PermissionRequest $request)
    {
        $Permission = new Permission;
        $Permission->name = $request->input('Permission');
        $Permission->guard_name = "admin";
        $Permission->save();
        return response()->json(['status' => true, 'data' => $Permission, 'message' => "Permission Added"]);
    }
    public function edit(Request $request)
    {
        $data = Permission::find($request->id);
        return response()->json(['status' => true, 'data' => $data]);
    }
    public function update(Request $request)
    {
        $id = $request->hidden_id;
        $request->validate([
            'Permission_edit' => 'required|unique:permissions,name,' . $id
        ]);
        $update = Permission::find($request->hidden_id);

        if (!empty($update)) {
            $update->name = $request->input('Permission_edit');
            $update->update();
            return response()->json(['status' => true, 'data' => $update, 'message' => "'Permission Updated'"]);
        }
    }
    public function delete(Request $request)
    {
        $delete = Permission::find($request->id);
        $delete->delete();
        return response()->json(['status' => true, 'data' => $delete, 'message' => "Permission Deleted"]);
    }
}
