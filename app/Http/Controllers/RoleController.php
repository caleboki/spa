<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
        
        
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();

        return view('roles.index')->with('roles', $roles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::get();
        return view('roles.create', ['permissions'=>$permissions]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=>'required|max:10',
            
            'permissions' =>'required',
            ]
        );

        $name = $request['name'];
        $role = new Role();
        $role->name = $name;

        $permissions[] = $request['permissions'];

        
        $role->save();

        foreach ($permissions[0] as $permission) {
            $p = Permission::where('id', '=', $permission)->firstOrFail();
            $role = Role::where('name', '=', $name)->first();
        
        
            $role->givePermissionTo($p);
        }
    
        return redirect('roles'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        $permissions = Permission::get();
        return view('roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $role = Role::findOrFail($id);


        $this->validate($request, [
            'name'=>'required|max:10',
            
            'permissions' =>'required',
            ]
        );

        $input = $request->except(['permissions']);

        $permissions[] = $request['permissions'];

        $role->fill($input)->save();

        $p_all = Permission::all();
        foreach ($p_all as $p) {
            $role->revokePermissionTo($p);
        }
        
        
        foreach ($permissions[0] as $permission) {
            $p = Permission::where('id', '=', $permission)->firstOrFail(); //Get corresponding form permission in db
  
            
            $role->givePermissionTo($p);
            
        }

        return redirect('roles'); 
        
        
        

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        $role->delete();
        return redirect('roles');
    }
}
