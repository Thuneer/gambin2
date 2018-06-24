<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    public function index(Request $request) {

        $permissions = \Spatie\Permission\Models\Permission::all();
        $role = $request->input('role') == null ? 'super' : $request->input('role');

        if($role == 'super')
            $role = \Spatie\Permission\Models\Role::find(4);
        else if($role == 'admin')
            $role = \Spatie\Permission\Models\Role::find(3);
        else if($role == 'editor')
            $role = \Spatie\Permission\Models\Role::find(2);
        else
            $role = \Spatie\Permission\Models\Role::find(1);

        return view('admin.permissions', ['permissions' => $permissions, 'role' => $role]);

    }

    public function edit(Request $request) {

        $validator = Validator::make($request->all(), [
            'permission' => 'required|string',
            'checked' => 'required|string',
            'role_id' => 'required|integer|between:1,5',
        ]);

        $permission = $request->input('permission');
        $checked = $request->input('checked');
        $role_id = $request->input('role_id');

        $role = \Spatie\Permission\Models\Role::find($role_id);

        if ($role) {

            if ($validator->fails())
            {

                $request->session()->flash('message', 'Something went wrong, please try again');
                $request->session()->flash('message-status', 'error');

                return response()->json('refresh', 400);
            }

            if($checked == 'true') {
                if (!$role->hasPermissionTo($permission))
                    $role->givePermissionTo($permission);

            } else {
                if ($role->hasPermissionTo($permission))
                    $role->revokePermissionTo($permission);

            }

        } else {
            $request->session()->flash('message', 'Something went wrong, please try again');
            $request->session()->flash('message-status', 'error');

            return response()->json('refresh', 400);
        }

        return response()->json('success', 200);

    }
}
