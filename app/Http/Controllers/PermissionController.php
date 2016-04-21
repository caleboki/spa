<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isAdmin');
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         /*
         $user = Auth::user();
         if (!$user->hasPermissionTo('Administer permissions'))
            {
                abort(401);
            }; */
        $permissions = Permission::all();

        return view('permissions.index')->with('permissions', $permissions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::get();
        return view('permissions.create')->with('roles', $roles);
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
            'name'=>'required|max:40',

            //'roles'=>'required'
            
            ]
        );

        $name = $request['name'];
        $permission = new Permission();
        $permission->name = $name;

        $roles[]=$request['roles'];

        $permission->save();

        if (!$roles) {
        foreach ($roles[0] as $role) {
            $r = Role::where('id', '=', $role)->firstOrFail(); //Match input role to db record
             
            $permission = Permission::where('name', '=', $name)->first();   
            $r->givePermissionTo($permission);
            
        }}

        \Session::flash('flash_message','Permission'. $permission->name.' added!');

        return redirect('permissions'); 
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = Permission::find($id);
        
        return view('permissions.edit', compact('permission'));
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
        
        $permission = Permission::findOrFail($id);


        $this->validate($request, [
            'name'=>'required|max:40',
            
            ]
        );

        $input = $request->all();

        

        $permission->fill($input)->save();

        \Session::flash('flash_message','Permission '. $permission->name.' edited');

        return redirect('permissions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);

        $permission->delete();
        return redirect('permissions');
    }
}
