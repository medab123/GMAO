<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use App\Models\User;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        /*$this->middleware('permission:user-list|user-create|user-edit|user-delete|user-search', ['only' => ['index', 'show']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);*/
    }
    public function index(Request $request)
    {
        $roles = Role::pluck('name','name')->all();
        $data = User::orderBy('id','DESC')->get();
        //dd($data);

        return view('users.index',['data' => $data,"roles"=>$roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$sites = Site::pluck('name','id')->all();
        $roles = Role::pluck('name','name')->all();
        return view('users.create',compact('roles'));
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required',
            //'ville_id'=> 'required',
            'type_inv_ids' => 'required',
        ]);

        $input = $request->all();
        $input['ville_id'] = 1;
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')->with('success','User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show',compact('user'));
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
       
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        return response()->json(["data"=>$user]);
        return view('users.edit',compact('user','roles','userRole'));
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
        //dd($request);
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required',
            //'ville_id'=> 'required',
            'type_inv_ids' => 'required',
        ]);

        $input = $request->all();
        $input['ville_id'] = 1;
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();

        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return response()->json(["status"=>"success"]);
    }
    public function refreshTable(){
        $data = User::leftJoin('villes','users.ville_id','villes.id')
        ->select('users.*','villes.name as ville')
        //->with('TypeInv')
        ->orderBy('id','DESC')->paginate(5);
        
        return view("users.table",compact("data"));
    }
    public function updatePassword(Request $request)
    {
        $currentPassword = auth()->user()->password;
        $validation =  Validator::make($request->all(), [
           // 'password' => "required|min:7",
            'new_password' => 'required|min:7|same:password_confirmation',
        ]);
        if (!Hash::check($request->input("password"), $currentPassword)) return back()->withErrors(["error" => "The password and old password must match."]);
        if ($validation->fails()) {
            $errors = $validation->errors();
            return back()->withErrors(["error" => $errors->first()]);
        } else {
            $user = User::find(auth()->user()->id);
            $user->password = Hash::make($request->input("new_password"));
            $user->save();
            return back()->withSuccess("Mot de passe modifié avec succès");
        }
    }
}
