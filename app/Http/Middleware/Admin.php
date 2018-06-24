<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $user = Auth::user();

        if (!$user)
            return redirect('admin/login');

        if (!$user->hasPermissionTo('access admin panel')) {
            return redirect('/');
        }

        // Articles
        if($request->is('admin/articles')) {
            if (!$user->hasPermissionTo('view articles')) {

                $request->session()->flash('message', 'You do not have permission to view articles');
                $request->session()->flash('message-status', 'error');

                return redirect('/admin');
            }
        }

        if($request->is('admin/articles/new')) {
            if (!$user->hasPermissionTo('create articles')) {

                $request->session()->flash('message', 'You do not have permission to create articles');
                $request->session()->flash('message-status', 'error');

                return redirect('/admin');
            }
        }

        if($request->is('admin/articles/*/edit')) {
            if (!$user->hasPermissionTo('view articles')) {

                $request->session()->flash('message', 'You do not have permission to view articles');
                $request->session()->flash('message-status', 'error');

                return redirect('/admin');
            }
        }

        // Media
        if($request->is('admin/media/*/edit')) {
            if (Request::isMethod('post') &&!$user->hasPermissionTo('edit media')) {

                $request->session()->flash('message', 'You do not have permission to edit media files');
                $request->session()->flash('message-status', 'error');

                return redirect('/admin');
            }
        }

        if($request->is('admin/media/delete')) {
            if (Request::isMethod('post') &&!$user->hasPermissionTo('delete media')) {

                $request->session()->flash('message', 'You do not have permission to delete media files');
                $request->session()->flash('message-status', 'error');

                return redirect('/admin');
            }
        }

        // Users
        if($request->is('admin/users')) {
            if (!$user->hasPermissionTo('view users')) {

                $request->session()->flash('message', 'You do not have permission to view users');
                $request->session()->flash('message-status', 'error');

                return redirect('/admin');
            }
        }

        if($request->is('admin/users/new')) {
            if (!$user->hasPermissionTo('create standard users') && !$user->hasPermissionTo('create editors') && !$user->hasPermissionTo('create administrators') && !$user->hasPermissionTo('create super admins') ) {

                $request->session()->flash('message', 'You do not have permission to create any users');
                $request->session()->flash('message-status', 'error');

                return redirect('/admin');
            }
        }

        if($request->is('admin/users/*/edit')) {
            if (!$user->hasPermissionTo('view users')) {

                $request->session()->flash('message', 'You do not have permission to view users');
                $request->session()->flash('message-status', 'error');

                return redirect('/admin');
            }
        }

        // Permissions
        if($request->is('admin/permissions')) {

            if (Request::isMethod('post')) {
                if (!$user->hasRole('owner')) {
                    return response()->json('No permission.', 403);
                }
            } else {
                if (!$user->hasRole('owner')) {

                    $request->session()->flash('message', 'You do not have permission to view permissions');
                    $request->session()->flash('message-status', 'error');

                    return redirect('/admin');
                }

            }

        }

        return $next($request);
    }
}
