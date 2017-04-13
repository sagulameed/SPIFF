<?php

namespace App\Http\Controllers\AdminCMS;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use phpseclib\Crypt\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('role','admin')->get();


        return view('adminCMS/users/users',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adminCMS/users/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->input('username');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->name = $request->input('username');
        $user->role = 'admin';
        $user->save();

        $request->session()->flash('status', true);
        $request->session()->flash('mess', "User was stored successfully !!");

        return redirect()->back();

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
        //
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
        $validator = Validator::make($request->all(), [
            'name' => 'max:255',
            'password' => 'min:6|confirmed',
        ]);

        /*if($validator->errors()){

            return redirect()->back();
        }*/

        $user = User::find($id);

        if (!empty($request->input('name'))){
            $user->name = $request->input('name');
        }
        if (!empty($request->input('password'))){
            $user->password = bcrypt($request->input('password'));
        }
        $user->save();

        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request , $id)
    {
        $super = User::where('role','super')->first();
        $user = User::find($id);


        foreach ($user->products as $product) {
            $product->user_id = $super->id;
            $product->save();
        }
        $user->delete();
        $request->session()->flash('status', true);
        $request->session()->flash('mess', "User was deleted successfully !!");
        return redirect()->back();
    }
}
