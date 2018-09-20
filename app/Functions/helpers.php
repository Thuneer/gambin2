<?php


function userAvatar($id)
{

    $path = '';

    if ($id % 7 == 0)
        $path = '/img/avatars/avatar1.png';
    else if ($id % 6 == 0)
        $path = '/img/avatars/avatar2.png';
    else if ($id % 5 == 0)
        $path = '/img/avatars/avatar3.png';
    else if ($id % 4 == 0)
        $path = '/img/avatars/avatar4.png';
    else if ($id % 3 == 0)
        $path = '/img/avatars/avatar5.png';
    else if ($id % 2 == 0)
        $path = '/img/avatars/avatar6.png';
    else if ($id % 1 == 0)
        $path = '/img/avatars/avatar7.png';

    return $path;

}

function canEditUserRole($auth_user, $user, $permission)
{

    if (
        (($user->roles[0]->name == 'standard user' && $auth_user->roles[0]->hasPermissionTo('edit standard users') &&
                $auth_user->roles[0]->hasPermissionTo($permission)) ||

            ($user->roles[0]->name == 'editor' && $auth_user->roles[0]->hasPermissionTo('edit editors') &&
                $auth_user->roles[0]->hasPermissionTo($permission)) ||

            ($user->roles[0]->name == 'administrator' && $auth_user->roles[0]->hasPermissionTo('edit administrators') &&
                $auth_user->roles[0]->hasPermissionTo($permission)) ||

            ($user->roles[0]->name == 'super admin' && $auth_user->roles[0]->hasPermissionTo('edit super admins') &&
                $auth_user->roles[0]->hasPermissionTo($permission))) || ($auth_user->roles[0]->name == 'owner' && $auth_user->id == $user->id)) {
        return true;
    } else {
        return false;
    }

}

function canEditUser($user_role_name, $auth_role)
{

    return (
        ($user_role_name == 'standard user' && $auth_role->hasPermissionTo('edit standard users')) ||
        ($user_role_name == 'editor' && $auth_role->hasPermissionTo('edit editors')) ||
        ($user_role_name == 'administrator' && $auth_role->hasPermissionTo('edit administrators')) ||
        ($user_role_name == 'super admin' && $auth_role->hasPermissionTo('edit super admins')));

}

function canDeleteUsers($auth_user, $user)
{

    return
        ($user->roles[0]->name == 'standard user' && $auth_user->roles[0]->hasPermissionTo('delete standard users')) ||
        ($user->roles[0]->name == 'editor' && $auth_user->roles[0]->hasPermissionTo('delete editors')) ||
        ($user->roles[0]->name == 'administrator' && $auth_user->roles[0]->hasPermissionTo('delete administrators')) ||
        ($user->roles[0]->name == 'super admin' && $auth_user->roles[0]->hasPermissionTo('delete super admins')) ||
        !$user->roles[0]->name == 'owner';

}

function canEditArticles($auth_user, $post)
{

    return $auth_user->hasPermissionTo('edit articles') || $auth_user->id == $post->user->id;

}

// Check if a user can delete an article
function canDeleteArticles($auth_user, $post)
{

    return $auth_user->roles[0]->hasPermissionTo('delete articles') || $auth_user->id == $post->user->id;

}

function canEditMedia($auth_user)
{

    return $auth_user->hasPermissionTo('edit media');

}

function canDeleteMedia($auth_user)
{

    return $auth_user->hasPermissionTo('delete media');

}

function canEditPages($auth_user)
{

    return $auth_user->hasPermissionTo('edit pages');

}

function canDeletePages($auth_user)
{

    return $auth_user->hasPermissionTo('delete pages');

}


// *Very simple* recursive rendering function
function renderPageParentNodes($page, $editPage, $prefix = 0) {
    echo "<option ";

   if ($editPage != null) {
       if ($page->children()->count() > 0) {

           foreach($page->children as $child) {

               if ($child->id == $editPage->id && $child->isLeaf()) {

                   echo "selected ";

               }

           }
       }

   }

    echo "value='{$page->id}'>";

    for ($i = 0; $i < $prefix; $i++)
        echo "&nbsp;&nbsp;";

    echo "{$page->title}";
    echo "</option>";
    if ( $page->children()->count() > 0 ) {
        foreach($page->children as $child) renderPageParentNodes($child, $editPage, $prefix + 1);
    }


}

