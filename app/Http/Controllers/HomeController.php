<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\User;
//use App\Role;
use Auth;

use Spatie\Permission\Models\Role;
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
        $user = Auth::user();
        if ($user)
            {
            if (!$user->hasAnyRole(Role::all())) {
            $user->assignRole('visitor');
        }}
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function getUsers()
    {  
        $users = User::get();
       
        return view('admin')->with('users', $users);
    }

    public function createUser()
    {
        $roles = Role::get();
        return view('create-user', ['roles'=>$roles]);
    }

    public function editUser($id)
    {
       
        $roles = Role::get();
        //$user = User::where('id', $id)->first();
        $user = User::findOrFail($id);
        return view('edit-user', compact('roles', 'user', 'id'));
    }

    public function deleteUser($id)
    {
        $user = User::where('id', $id)->first();
        $user->delete();
        //return redirect()->route('dashboard')->with(['message' => 'Successfully deleted!']);
        return redirect()->route('admin');
    }

    public function addUser(Request $request)
    {
    
        $this->validate($request, [
            'name'=>'required|max:120',
            'email'=>'required|email|unique:users',
            'roles' =>'required',
            'password'=>'required|min:6',
            'password_confirmation'=>'required|min:6']
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
    
        return redirect()->route('admin'); 
    }

    public function getRoles()
    {
        $roles = Role::get();
        return view('roles')->with('roles', $roles);

    }

    public function updateUser($id)
    {
    
        return 'test';
    }

}
