<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        app()['cache']->forget('spatie.permission.cache');

        $standard = Role::create(['name' => 'standard user']);
        $editor = Role::create(['name' => 'editor']);
        $admin = Role::create(['name' => 'administrator']);
        $super_admin = Role::create(['name' => 'super admin']);
        $owner = Role::create(['name' => 'owner']);

        $admin_access = Permission::create(['name' => 'access admin panel']);
        $edit_menu = Permission::create(['name' => 'edit menu']);
        $edit_settings = Permission::create(['name' => 'edit settings']);

        $article_view = Permission::create(['name' => 'view articles']);
        $article_create = Permission::create(['name' => 'create articles']);
        $article_edit = Permission::create(['name' => 'edit articles']);
        $article_delete = Permission::create(['name' => 'delete articles']);

        $page_view = Permission::create(['name' => 'view pages']);
        $page_create = Permission::create(['name' => 'create pages']);
        $page_edit = Permission::create(['name' => 'edit pages']);
        $page_delete = Permission::create(['name' => 'delete pages']);

        $media_view = Permission::create(['name' => 'view media']);
        $media_create = Permission::create(['name' => 'create media']);
        $media_edit = Permission::create(['name' => 'edit media']);
        $media_delete = Permission::create(['name' => 'delete media']);

        $user_view = Permission::create(['name' => 'view users']);

        $create_standard = Permission::create(['name' => 'create standard users']);
        $create_editor = Permission::create(['name' => 'create editors']);
        $create_admin = Permission::create(['name' => 'create administrators']);
        $create_super_admin = Permission::create(['name' => 'create super admins']);

        $edit_standard = Permission::create(['name' => 'edit standard users']);
        $edit_editor = Permission::create(['name' => 'edit editors']);
        $edit_admin = Permission::create(['name' => 'edit administrators']);
        $edit_super_admin = Permission::create(['name' => 'edit super admins']);

        $delete_standard = Permission::create(['name' => 'delete standard users']);
        $delete_editor = Permission::create(['name' => 'delete editors']);
        $delete_admin = Permission::create(['name' => 'delete administrators']);
        $delete_super_admin = Permission::create(['name' => 'delete super admins']);


        // Standard user

        // Editor
        $editor->givePermissionTo($admin_access);

        $editor->givePermissionTo($article_view);
        $editor->givePermissionTo($article_create);

        $editor->givePermissionTo($page_view);

        $editor->givePermissionTo($media_view);
        $editor->givePermissionTo($media_create);
        $editor->givePermissionTo($media_edit);
        $editor->givePermissionTo($media_delete);


        // Administrator
        $admin->givePermissionTo($admin_access);

        $admin->givePermissionTo($article_view);
        $admin->givePermissionTo($article_create);
        $admin->givePermissionTo($article_edit);
        $admin->givePermissionTo($article_delete);

        $admin->givePermissionTo($page_view);
        $admin->givePermissionTo($page_create);
        $admin->givePermissionTo($page_edit);
        $admin->givePermissionTo($page_delete);

        $admin->givePermissionTo($media_view);
        $admin->givePermissionTo($media_create);
        $admin->givePermissionTo($media_edit);
        $admin->givePermissionTo($media_delete);

        $admin->givePermissionTo($user_view);

        $admin->givePermissionTo($create_standard);
        $admin->givePermissionTo($create_editor);

        $admin->givePermissionTo($edit_standard);
        $admin->givePermissionTo($edit_editor);

        $admin->givePermissionTo($delete_standard);
        $admin->givePermissionTo($delete_editor);

        $admin->givePermissionTo($edit_menu);

        // Super admin
        $super_admin->givePermissionTo($admin_access);

        $super_admin->givePermissionTo($article_view);
        $super_admin->givePermissionTo($article_create);
        $super_admin->givePermissionTo($article_edit);
        $super_admin->givePermissionTo($article_delete);

        $super_admin->givePermissionTo($page_view);
        $super_admin->givePermissionTo($page_create);
        $super_admin->givePermissionTo($page_edit);
        $super_admin->givePermissionTo($page_delete);

        $super_admin->givePermissionTo($media_view);
        $super_admin->givePermissionTo($media_create);
        $super_admin->givePermissionTo($media_edit);
        $super_admin->givePermissionTo($media_delete);

        $super_admin->givePermissionTo($user_view);

        $super_admin->givePermissionTo($create_standard);
        $super_admin->givePermissionTo($create_editor);
        $super_admin->givePermissionTo($create_admin);

        $super_admin->givePermissionTo($edit_standard);
        $super_admin->givePermissionTo($edit_editor);
        $super_admin->givePermissionTo($edit_admin);

        $super_admin->givePermissionTo($delete_standard);
        $super_admin->givePermissionTo($delete_editor);
        $super_admin->givePermissionTo($delete_admin);

        $super_admin->givePermissionTo($edit_menu);
        $super_admin->givePermissionTo($edit_settings);

        // Owner
        $owner->givePermissionTo($admin_access);

        $owner->givePermissionTo($article_view);
        $owner->givePermissionTo($article_create);
        $owner->givePermissionTo($article_edit);
        $owner->givePermissionTo($article_delete);

        $owner->givePermissionTo($page_view);
        $owner->givePermissionTo($page_create);
        $owner->givePermissionTo($page_edit);
        $owner->givePermissionTo($page_delete);

        $owner->givePermissionTo($media_view);
        $owner->givePermissionTo($media_create);
        $owner->givePermissionTo($media_edit);
        $owner->givePermissionTo($media_delete);

        $owner->givePermissionTo($user_view);

        $owner->givePermissionTo($create_standard);
        $owner->givePermissionTo($create_editor);
        $owner->givePermissionTo($create_admin);
        $owner->givePermissionTo($create_super_admin);

        $owner->givePermissionTo($edit_standard);
        $owner->givePermissionTo($edit_editor);
        $owner->givePermissionTo($edit_admin);
        $owner->givePermissionTo($edit_super_admin);

        $owner->givePermissionTo($delete_standard);
        $owner->givePermissionTo($delete_editor);
        $owner->givePermissionTo($delete_admin);
        $owner->givePermissionTo($delete_super_admin);

        $owner->givePermissionTo($edit_menu);
        $owner->givePermissionTo($edit_settings);

    }
}
