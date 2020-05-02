<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\User;
use Spatie\Permission\Models\Permission;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Role::create(['name'=>'admin']);
        // Role::create(['name'=>'doctor']);
        // Role::create(['name'=>'nurse']);
        // Role::create(['name'=>'reception']);
        // Role::create(['name'=>'patient']);
        // Role::create(['name'=>'admin']);
        // Permission::create(['name'=>'write appointment']);
        // Permission::create(['name'=>'edit appointment']);
        // Permission::create(['name'=>'delete appointment']);
        // Permission::create(['name'=>'publish appointment']);
        // Permission::create(['name'=>'write patient']);
        // Permission::create(['name'=>'edit patient']);
        // Permission::create(['name'=>'delete patient']);
        // Permission::create(['name'=>'publish patient']);

        // $role = Role::findById(1);
        // $permission = Permission::findById(1);
        // $role->givePermissionTo($permission);
        // $permission = Permission::findById(2);
        // $role->givePermissionTo($permission);        
        // $permission = Permission::findById(3);
        // $role->givePermissionTo($permission);       
        // $permission = Permission::findById(4);
        // $role->givePermissionTo($permission);       
        // $permission = Permission::findById(5);
        // $role->givePermissionTo($permission);
        // $permission = Permission::findById(6);
        // $role->givePermissionTo($permission);
        // $permission = Permission::findById(7);
        // $role->givePermissionTo($permission);
        // $permission = Permission::findById(8);
        // $role->givePermissionTo($permission);
        // $role = Role::findById(2);
        // $permission = Permission::findById(4);
        // $role->givePermissionTo($permission);

        // $role = Role::findById(5);
        // $permission = Permission::findById(1);
        // $role->givePermissionTo($permission);
        // $permission = Permission::findById(2);
        // $role->givePermissionTo($permission);
        // $permission = Permission::findById(3);
        // $role->givePermissionTo($permission);
        // $permission = Permission::findById(4);
        // $role->givePermissionTo($permission);

        // auth()->user()->assignRole('admin');
        //auth()->user()->givePermissionTo('write appointment');
        // auth()->user()->givePermissionTo('edit appointment');
        // auth()->user()->givePermissionTo('delete appointment');
        // auth()->user()->givePermissionTo('publish appointment');
        // auth()->user()->givePermissionTo('write patient');
        // auth()->user()->givePermissionTo('edit patient');
        // auth()->user()->givePermissionTo('delete patient');
        // auth()->user()->givePermissionTo('publish patient');
        // auth()->user()->assignRole('doctor');
        // auth()->user()->givePermissionTo('publish appointment');
        //auth()->user()->assignRole('nurse');
        //auth()->user()->givePermissionTo('publish appointment');
        //auth()->user()->assignRole('reception');
        //auth()->user()->givePermissionTo('publish appointment');
        //auth()->user()->assignRole('patient');
        //auth()->user()->givePermissionTo('publish appointment');

        //return auth()->user()->getPermissionNames();//?????*****
        //return auth()->user()->getRoleNames();//?????*****
        //return auth()->user()->permissions;
        //return auth()->user()->getDirectPermissions();
        //return auth()->user()->getPermissionsViaRoles();
        //return auth()->user()->getAllPermissions();
        //return User::role('admin')->get();
        //return User::permission('write appointment')->get();

        //Role::create(['name'=>'admin']);
        //Permission::create(['name'=>'write appointment']);
        // $role = Role::findById(1);
        // $permission = Permission::findById(1);
        // $role->givePermissionTo($permission);

        // $permission = Permission::create(['name'=>'edit appointment']);
        // $role = Role::findById(1);
        // $role->givePermissionTo($permission);

        // $role = Role::findById(1);
        // $permission = Permission::findById(2);
        // $permission->removeRole($role);

        // $role = Role::findById(1);
        // $permission = Permission::findById(1);
        // $role->revokePermissionTo($permission);

        return view('home');
    }
}
