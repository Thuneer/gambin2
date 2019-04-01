<?php

namespace App\Http\Controllers;

use App\Media;
use App\Mediable;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function index(Request $request)
    {

        $search = $request->query('search') == null ? '' : $request->query('search');
        $per_page = $request->query('per-page') ?: '15';
        $list = $request->query('list') == null || $request->query('list') == '1' ? '1' : '0';

        $sort_direction = $request->query('sort-value') == null || $request->query('sort-value') == 'desc' ? 'desc' : 'asc';
        $sort_column = $request->query('sort-type') !== null ? $request->query('sort-type') : 'created_at';

        if ($sort_column !== 'first_name' && $sort_column !== 'email' && $sort_column !== 'role_id' && $sort_column !== 'created_at')
            $sort_type = 'first_name';

        if ($search) {
            if ($sort_column == 'role_id')
                $users = User::join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')->where('first_name', 'like', '%' . $search . '%')->orWhere('last_name', 'like', '%' . $search . '%')->orderBy('role_id', $sort_direction)->paginate($per_page);
            else
                $users = User::where('first_name', 'like', '%' . $search . '%')->orWhere('last_name', 'like', '%' . $search . '%')->orderBy($sort_column, $sort_direction)->paginate($per_page);
        } else if ($sort_column == 'role_id') {
            $users = User::join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')->orderBy('role_id', $sort_direction)->paginate($per_page);
        } else {
            $users = User::orderBy($sort_column, $sort_direction)->paginate($per_page);
        }

        $list_options = array(
            array(
                'title' => 'Name',
                'sort_value' => 'first_name',
                'sortable' => '1',
                'sort_type' => 'primary',
                'route' => '/admin/users',
                'list_type' => 'user-name'
            ),
            array(
                'title' => 'Email',
                'sort_value' => 'email',
                'sortable' => '1',
                'sort_type' => 'standard',
                'route' => '/admin/users',
                'list_type' => 'user-email'
            ),
            array(
                'title' => 'Role',
                'sort_value' => 'role_id',
                'sortable' => '1',
                'sort_type' => 'standard',
                'route' => '/admin/users',
                'list_type' => 'user-role'
            )
        );

        return view('admin/users/users', ['users' => $users, 'search' => $search, 'per_page' => $per_page, 'list' => $list, 'sort_column' => $sort_column, 'sort_direction' => $sort_direction, 'list_options' => $list_options]);

    }

    public function newView()
    {

        $roles = Role::all();

        return view('admin/users/new', ['roles' => $roles]);

    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'first-name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|integer|between:1,5',
        ]);

        $role_id = $request->input('role');
        $role = Role::find($role_id);

        if (!$role) {
            $request->session()->flash('message', 'Something went wrong, please try again.');
            $request->session()->flash('message-status', 'error');

            return redirect('admin');
        }

        $image_id = $request->input('image');

        $auth_role = Auth::user()->roles[0];

        if (($role->name === 'standard user' && !$auth_role->hasPermissionTo('create standard users')) ||
            ($role->name === 'editor' && !$auth_role->hasPermissionTo('create editors')) ||
            ($role->name === 'administrator' && !$auth_role->hasPermissionTo('create administrators')) ||
            ($role->name === 'super admin' && !$auth_role->hasPermissionTo('create super admins'))) {

            $request->session()->flash('message', 'You do not have permission to create <b>' . ucfirst($role->name) . 's</b>.');
            $request->session()->flash('message-status', 'error');

            return redirect('admin');

        }

        $user = new User();
        $user->first_name = $request->input('first-name');
        $user->last_name = $request->input('last-name');
        $user->email = $request->input('email');

        $user->password = bcrypt($request->input('password'));
        $user->save();

        $user->assignRole($role);

        if (strlen($request->input('image')) > 0) {

            if (Media::find($image_id)) {

                $user->images()->attach($image_id);

            }

        }

        $request->session()->flash('message', $user->first_name . ' ' . $user->last_name . ' was successfully added.');
        $request->session()->flash('message-status', 'success');

        return redirect('admin/users');

    }

    public function getImages()
    {

        $images = Media::all();

        return response()->json($images);

    }

    public function editView($id)
    {

        $user = User::find($id);

        $roles = Role::all();

        return view('admin/users/edit', ['user' => $user, 'roles' => $roles]);

    }

    public function edit(Request $request, $id)
    {

        $validatedData = $request->validate([
            'first-name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:8|confirmed',
            'role' => 'required|integer|between:1,5',
            'image' => 'nullable|integer'
        ]);

        $user = User::find($id);

        if ($user) {
            $user->first_name = $request->input('first-name');
            $user->last_name = $request->input('last-name');
            $user->email = $request->input('email');

            $role = Role::find($request->input('role'));

            if (!canEditUserRole(Auth::user(), $user, 'edit ' . $role->name . 's')) {
                $request->session()->flash('message', 'You do not have permission to edit <b>' . ucfirst($role->name) . 's</b>.');
                $request->session()->flash('message-status', 'error');

                return redirect('admin/users');
            }

            // Update new password if set
            if (!empty($request->input('password'))) {
                $user->password = bcrypt($request->input('password'));
            }

            $user->save();

            $user->syncRoles([$role]);

            $media_id = $request->input('image');

            if (strlen($media_id) > 0) {

                if (count($user->images) > 0) {

                    if ($user->images[0]->id != $media_id) {

                        if (Media::find($media_id)) {
                            $user->images()->detach();
                            $user->images()->attach($media_id);
                        }

                    }

                } else {
                    $user->images()->attach($media_id);
                }

            } else {
                if (count($user->images) > 0) {

                    $user->images()->detach();

                }
            }
        }

        $request->session()->flash('message', '<b>' . $user->first_name . ' ' . $user->last_name . '</b> was successfully updated.');
        $request->session()->flash('message-status', 'success');

        return redirect()->back();

    }

    public function delete(Request $request)
    {

        $ids = $request->input('deleteIds');

        $id_array = explode(',', $ids);

        if (count($id_array) == 0) {
            $request->session()->flash('message', 'Something went wrong.');
            $request->session()->flash('message-status', 'error');

            return redirect('/admin/users');
        }

        for ($i = 0; $i < count($id_array); $i++) {

            $user = User::find($id_array[$i]);

            if (!$user) {
                $request->session()->flash('message', 'Something went wrong, please try again.');
                $request->session()->flash('message-status', 'error');

                return redirect('/admin/users');
            } else if ($user->id == Auth::user()->id) {
                $request->session()->flash('message', 'You cannot delete yourself.');
                $request->session()->flash('message-status', 'error');

                return redirect('/admin/users');
            } else if (!canDeleteUsers(Auth::user(), $user)) {
                $request->session()->flash('message', 'You do not have permission to delete users with this role.');
                $request->session()->flash('message-status', 'error');

                return redirect('/admin/users');
            }

        }

        for ($i = 0; $i < count($id_array); $i++) {

            $user = User::find($id_array[$i]);
            $user->images()->detach();
            $user->delete();

        }

        if (count($id_array) > 1) {

            $request->session()->flash('message', count($id_array) . ' users were successfully deleted.');
            $request->session()->flash('message-status', 'success');

            return redirect('/admin/users');

        } else {
            $request->session()->flash('message', '<b>' . $user->first_name . ' ' . $user->last_name . '</b> was successfully deleted.');
            $request->session()->flash('message-status', 'success');

            return redirect('/admin/users');
        }

    }

}