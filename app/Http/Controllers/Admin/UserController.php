<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UserResource::collection(User::all());

        // $users = User::all();
        // return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'name'=>'required',
        //     'email'=>'required|email',
        //     'password'=>'required',
        //  ]);

        $user= User::create([
            'name'=> $request->name,
            'birthday'=> $request->birthday,
            'gender'=> $request->gender,
            'phone'=> $request->phone,
            'post'=> $request->post,
            'service'=> $request->service,
            'email'=> $request->email,
            'password'=> bcrypt($request->password)
        ]);

        if ($request->has('role')) {
             $user->assignRole($request->role['name']);
        }

        if ($request->has('permissions')) {
             $user->givePermissionTo(collect($request->permissions)->pluck('id')->toArray());
        }

        // $user = new User();
        // $user->name = $request->name;
        // $user->email = $request->email;
        // $user->password =  bcrypt($request->password);
        // $user->save();

        return response(['message'=>'User Created', 'user'=>$user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        // $request->validate([
        //     'name'=>'required',
        //     'email'=>'required|email',
        // ]);

        $user->update([
            'name'=> $request->name,
            'birthday'=> $request->birthday,
            'gender'=> $request->gender,
            'phone'=> $request->phone,
            'post'=> $request->post,
            'service'=> $request->service,
            'email'=> $request->email,
            'email'=> $request->email,

        ]);

        if ($request->has('role')) {
            $user->syncRoles($request->role['name']);
        }

        if ($request->has('permissions')) {
            $user->syncPermissions(collect($request->permissions)->pluck('id')->toArray());
        }

        return response(['message'=>'User Updated', 'user'=>$user]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return User::destroy($id);
    }
}
