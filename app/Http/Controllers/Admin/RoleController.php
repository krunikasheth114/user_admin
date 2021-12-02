<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\RoleRequest;
use App\Http\Controllers\Controller;
use App\DataTables\RoleDataTable;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\Permission;

class RoleController extends Controller
{
    public function viewRole(RoleDataTable $datatable)
    {

        return $datatable->render('admin.roles.index');
    }

    public function create(RoleRequest $request)
    {

        $create_role = new Role;
        $create_role->name = $request->input('role');
        $create_role->guard_name = "admin";
        $create_role->save();
        return response()->json(['status' => true, 'data' => $create_role, 'message' => "Role Added"]);
    }
    public function deleteRole(Request $request)
    {
        $delete = Role::find($request->id);
        $delete->delete();
        return response()->json(['status' => true, 'data' => $delete, 'message' => "Role Deleted"]);
    }

    public function show($id)
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $role_permission =  Role::select('role_has_permissions.*')->join('role_has_permissions', function ($join) use ($id) {
            $join->on('roles.id', '=', 'role_has_permissions.role_id')->where("role_has_permissions.role_id", $id);
        })->pluck('role_has_permissions.permission_id')->toArray();

        return view('admin.roles.assign_role', compact('role', 'permission', 'role_permission'));
    }
    public function assign(Request $request, $id)
    {

        $permission = $request->permission;
        foreach ($permission as $perm) {
            $assign = DB::table('role_has_permissions')->insert([
                "permission_id" => $perm,
                "role_id" => $id
            ]);
        }
        return redirect()->back()->with('success', "Permission Assign To User");
    }
    public function updatePermission(Request $request)
    {

        $role = Role::find($request->role_id);
        $role->name = $request->input('role_name');
        $role->update();

        if (isset($request->permission)) {
            $update_permission = DB::table('role_has_permissions')->where("role_id", $request->role_id)->delete();
            if (is_array($request->permission)) {
                foreach ($request->permission as $per) {
                    DB::table('role_has_permissions')->insert([
                        "permission_id" => $per,
                        "role_id" => $request->role_id
                    ]);
                }
            }
        }
        return response()->json(['status' => true, 'data' => $role, 'message' => " Permission Updated"]);
    }
}
