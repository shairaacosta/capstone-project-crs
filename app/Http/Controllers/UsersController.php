<?php
namespace App\Http\Controllers;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Maatwebsite\Excel\Facades\Excel;

class UsersController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::latest()->get();
        return view('users.index', compact('users'));
    }
    public function create()
    {
        $roles = Role::get();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'roles' => 'required'
        ]);

        $user = User::create($request->except('roles'));
        $rolesArr = [];

        if($request->roles <> ''){
            $rolesArr[] = $request->roles;
            $user->roles()->attach($rolesArr);
        }
        return redirect()->route('users.index')->with('success','User has been created');

    }

    public function edit($id) {
        $user = User::findOrFail($id);
        $roles = Role::get();
        return view('users.edit', compact('user', 'roles'));
    }

    public function importUsers(Request $request){
        $request->validate([
//            'file' => 'required|max:10000|mimes:xlsx,xls',
            'file' => 'required|max:10000',
        ]);

        $importFile = $request->file('file');

        Excel::import(new UsersImport(), $importFile);

        return ['status'=>'success'];
    }

    public function exportUsersTemplate(){
        return Excel::download(new UsersExport(), 'users.xlsx');
    }

    public function changePassword(){
        return view('student.user_profile.change-password');
    }

    public function storeNewPassword(Request $request){
        $this->validate($request, [
            'password'=>'required|confirmed|max:120',
        ]);
        $user_id = auth()->user()->id;

        $user = User::findOrFail($user_id);
        $user->password = $request->password;
        if($user->save()){
            return redirect()->back()->with('success','Successfully changed password.');
        }
    }

    public function update(Request $request, $id) {
        $user = User::findOrFail($id);
        $this->validate($request, [
            'name'=>'required|max:120',
            'email'=>'required|email|unique:users,email,'.$id,
            'password'=>'required|min:6|confirmed'
        ]);
        $input = $request->except('roles');
        $user->fill($input)->save();
                $rolesArr = [];
        if ($request->roles <> '') {
            $rolesArr[] = $request->roles;
            $user->roles()->sync($rolesArr);
        }
        else {
            $user->roles()->detach();
        }
        return redirect()->route('users.index')->with('success',
            'User successfully updated.');
    }
    public function destroy($id) {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success',
            'User successfully deleted.');
    }
}
