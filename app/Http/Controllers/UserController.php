<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $user = new User;
        $user->location = $request->location;
        $password = Hash::make($request->password);
        $user->name = $request->name;
        $user->password = $password;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->id_no = $request->id_no;
        $user->age = $request->age;
        $user->save();
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mechanics  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // return $request->all();
        $user = User::find($id);
        $password = Hash::make($request->password);
        $user->name = $request->name;
        $user->location = $request->location;
        $user->password = $password;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->id_no = $request->id_no;
        $user->age = $request->age;
        $user->save();
        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mechanics  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function getUsers()
    {
        // return json_decode(json_encode(User::all()), true);
        return User::all();
    }
    
    public function profile(Request $request, User $user, $id) {
        // return $request->all;
        $upload = User::find($request->id);
        if ($request->hasFile('image')) {
            $imagename = time() . $request->image->getClientOriginalName();
            $request->image->storeAs('public/profile', $imagename);
            // return response();
        }
        $image_name = '/storage/profile/' . $imagename;
        $upload->profile = $image_name;
        $upload->save();
    }

    public function userUpdate(Request $request, User $user)
    {
        $user = User::find(Auth::id());
        if ($request->location) {
            $location_new = $request->location;
            $location = serialize($location_new);
            $user->location = $location;
        }
        if ($request->password) {
            $password = Hash::make($request->user['password']);
            $user->password = $password;
        }
        $user->name = $request->user['name'];
        $user->email = $request->user['email'];
        $user->country = $request->user['country'];
        $user->city = $request->user['city'];
        $user->address = $request->user['address'];
        $user->county = $request->user['county'];
        $user->phone = $request->user['phone'];
        $user->id_no = $request->user['id_no'];
        $user->age = $request->user['age'];
        // $user->address = $request->address;
        // var_dump($location); die;
        $user->save();
        return $user;

    }
}
