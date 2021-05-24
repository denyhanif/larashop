<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::paginate(10);
        $filterKeyword = $request->get('keyword');      
        $status = $request->get('status'); 
        if($filterKeyword){
        if($status){
            $users = \App\Models\User::where('email', 'LIKE', "%$filterKeyword%")
                ->where('status', $status)
                ->paginate(10);
        } else {
            $users = \App\Models\User::where('email', 'LIKE', "%$filterKeyword%")
                    ->paginate(10);
        }
        }
        return view('users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("users.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = \Validator::make($request->all(),[
            "name"=> "required|min:5|max:100",
            "username" => "requirde|min:5|max:20|unique:users",
            "roles"=> "required|",
            "phone"=>"required|digits_between:10,12",
            "addres"=> "required|min:20|max:200",
            "avatar"=> "required",
            "email"=> "required|email|unique:users",
            "password"=> "required|email|unique:users",
            "password_confirmation"=> "required|same:password"
            
        ])->validate();

        $new_user = new User;

        $new_user->name = $request->get('name');
        $new_user->username = $request->get('username');
        $new_user->roles = json_encode($request->get('roles'));
        $new_user->name = $request->get('name');
        $new_user->address = $request->get('address');
        $new_user->phone = $request->get('phone');
        $new_user->email = $request->get('email');
        $new_user->password = \Hash::make($request->get('password'));
        //file foto
        if($request->file('avatar')){
        $file = $request->file('avatar')->store('avatars', 'public');
        $new_user->avatar = $file;
        }
        $new_user->save();
        return redirect()->route('users.create')->with('status', 'User successfully created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users.show', ['user' => $user]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('users.edit', ['user' => $user]);
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

         \Validator::make($request->all(), [
            "name"=>"required|min:5|max:100",
            "roles"=>"required",
            "phone"=>"required|digits_between:10,20",
            "address"=>"required|min:20|max:200",
        ])->validate();

        $user = User::findOrFail($id);

    $user->name = $request->get('name');
    $user->roles = json_encode($request->get('roles'));
    $user->address = $request->get('address');
    $user->phone = $request->get('phone');
    $user->status = $request->get('status');

    if($request->file('avatar')){
        if($user->avatar && file_exists(storage_path('app/public/' . $user->avatar))){
            \Storage::delete('public/'.$user->avatar);
        }
        $file = $request->file('avatar')->store('avatars', 'public');
        $user->avatar = $file;
    }

    $user->save();

    return redirect()->route('users.edit', [$id])->with('status', 'User succesfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Ingat bahwa request delete dikirimkan ke path users/1 dengan method delete alias named route users.destroy yang menggunakan UserController@destroy. Mari kita tangkap permintaan tersebut dan hapus user di database, pertama kita cari user yang akan dihapus berdasarkan route parameter id
        $user = User::findOrFail($id);
        //hapus user tersebu
        $user->delete();
        //redirect kembali ke halaman list user dengan pesan bahwa delete telah berhasil 
        return redirect()->route('users.index')->with('status', 'User successfully deleted');

    }
}
