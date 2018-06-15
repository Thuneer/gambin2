<?php

namespace App\Http\Controllers;

use App\Media;
use App\Mediable;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function index(Request $request)
    {

        $search = $request->query('search') == null ? '' : $request->query('search');
        $per_page = $request->query('per-page') ?: '15';
        $list = $request->query('list') == null || $request->query('list') == '1' ? '1' : '0';

        $sort_value = $request->query('sort-value') == null || $request->query('sort-value') == 'desc' ? 'desc' : 'asc';
        $sort_type = $request->query('sort-type') !== null ? $request->query('sort-type') : 'created_at';

        if ($sort_type !== 'first_name' && $sort_type !== 'email' && $sort_type !== 'role_id' && $sort_type !== 'created_at')
            $sort_type = 'first_name';

        if ($search) {

            $users = User::where('first_name', 'like', '%' . $search . '%')->orWhere('last_name', 'like', '%' . $search . '%')->orderBy($sort_type, $sort_value)->paginate($per_page);

        } else {

            $users = User::orderBy($sort_type, $sort_value)->paginate($per_page);

        }

        return view('admin/users/users', ['users' => $users, 'search' => $search, 'per_page' => $per_page, 'list' => $list, 'sort_type' => $sort_type, 'sort_value' => $sort_value]);

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
            'role' => 'required|integer|digits_between:1,4',
        ]);

        $role_id = $request->input('role');

        $user = new User();
        $user->first_name = $request->input('first-name');
        $user->last_name = $request->input('last-name');
        $user->email = $request->input('email');

        if (Auth::user()->role_id > $role_id)
            $user->role_id = $role_id;
        else
            $user->role_id = 1;

        $user->password = bcrypt($request->input('password'));
        $user->save();

        if (strlen($request->input('image')) > 0) {

            $media = Media::find($request->input('image'));

            if ($media) {

                $mediable = new Mediable();
                $mediable->media_id = $media->id;
                $mediable->mediable_id = $user->id;
                $mediable->mediable_type = 'App\User';
                $mediable->save();

            }

        }

        $request->session()->flash('message', $user->first_name . ' ' . $user->last_name . ' was successfully added.');
        $request->session()->flash('status', 'success');

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
            'role' => 'nullable|integer|digits_between:1,4',
            'image' => 'nullable|integer'
        ]);

        $user = User::find($id);

        if ($user) {

            if (Auth::user()->role_id <= $user->role_id && Auth::user()->id != $user->id) {

                $request->session()->flash('message', 'You do not have permission to edit this user.');
                $request->session()->flash('status', 'error');

                return redirect('admin/users');

            }

            $role_id = $request->input('role') == null ? $role_id = -1 : $role_id = $request->input('role');

            $user->first_name = $request->input('first-name');
            $user->last_name = $request->input('last-name');
            $user->email = $request->input('email');

            if (Auth::user()->role_id > $role_id && $role_id != -1)
                $user->role_id = $role_id;
            else if(Auth::user()->id != $user->id)
                $user->role_id = 1;

            $password = $request->input('password');

            if (strlen($password) >= 8)
                $user->password = bcrypt($password);

            $user->save();

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

        $request->session()->flash('message', '<b>' . $user->first_name . ' ' . $user->last_name . '</b> was successfully edited.');
        $request->session()->flash('status', 'success');

        return redirect('admin/users');

    }

    public function delete(Request $request)
    {

        $ids = $request->input('deleteIds');

        $id_array = explode(',', $ids);

        if (count($id_array) == 0) {
            $request->session()->flash('message', 'Something went wrong.');
            $request->session()->flash('status', 'error');

            return redirect('/admin/users');
        }

        for ($i = 0; $i < count($id_array); $i++) {

            $user = User::find($id_array[$i]);

            if (!$user) {
                $request->session()->flash('message', 'Something went wrong, please try again.');
                $request->session()->flash('status', 'error');

                return redirect('/admin/users');
            } else if ($user->id == Auth::user()->id) {
                $request->session()->flash('message', 'You can\'t delete yourself.');
                $request->session()->flash('status', 'error');

                return redirect('/admin/users');
            } else if ($user->role_id >= Auth::user()->role_id) {
                $request->session()->flash('message', 'You do not have permission to do this.');
                $request->session()->flash('status', 'error');

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
            $request->session()->flash('status', 'success');

            return redirect('/admin/users');

        } else {
            $request->session()->flash('message', '<b>' . $user->first_name . ' ' . $user->last_name . '</b> was successfully deleted.');
            $request->session()->flash('status', 'success');

            return redirect('/admin/users');
        }

    }

}