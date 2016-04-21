<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;

use Auth;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
        
        $user = Auth::user();
        
        if ($user)
            {
           
            if (!$user->hasAnyRole(Role::all())) {
            $user->assignRole('visitor');
        }}
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return view('users.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::get();
        return view('users.create', ['roles'=>$roles]);


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
            'name'=>'required|max:120',
            'email'=>'required|email|unique:users',
            'roles' =>'required',
            'password'=>'required|min:6',
            'password_confirmation'=>'required|same:password']
        );

        
        $email = $request['email'];
        $name = $request['name'];
        $password = bcrypt($request['password']);

        $user = new User();
        $user->email = $email;
        $user->name = $name;
        $user->password = $password;

        $roles[] = $request['roles'];

        
        $user->save();

        
        foreach ($roles[0] as $role) {
            $role_r = Role::where('id', '=', $role)->firstOrFail();
            $user = User::where('email', '=', $email)->first();
        
        
            $user->assignRole($role_r);
        }

        \Session::flash('flash_message','User successfully added.');
    
        return redirect('users'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       return redirect('users'); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        $roles = Role::get();

        return view('users.edit', compact('user', 'roles'));
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
        $user = User::findOrFail($id);


        $this->validate($request, [
            'name'=>'required|max:120',
            'email'=>'required|email|unique:users,email,'.$id,
            'roles' =>'required',
            'password'=>'required|min:6',
            'password_confirmation'=>'required|same:password']
        );


        $input = $request->only(['name', bcrypt('password')]);
        

        $roles[] = $request['roles'];

        $user->fill($input)->save();

        $r_all = Role::all();

        foreach ($r_all as $r) {
            $user->removeRole($r);
        }

        foreach ($roles[0] as $role) {
            $role_r = Role::where('id', '=', $role)->firstOrFail();
            
        
            
            $user->assignRole($role_r);
        }

        \Session::flash('flash_message','User successfully edited.');

        return redirect('users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();
        return redirect('users');
    }
}
