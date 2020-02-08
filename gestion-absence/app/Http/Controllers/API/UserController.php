<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use Str;

class UserController extends Controller
{


    public function __construct(){
        #$this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::latest()->paginate(10);
        return $users;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request , [
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
            'CIN' => ['required', 'string', 'max:8'],
            'type' => ['required', 'string'],
            'image' => ['sometimes', 'string'],
        
        ]);

        $exploded = explode(',',$request['image']);
        $decoded = base64_decode($exploded[1]);

        $extension = Str::contains($exploded[0],'jpeg')? 'jpeg' :'png';
        $filename = Str::random().'.'.$extension;
        $path =  public_path().'/img/'.$filename;
        file_put_contents($path, $decoded); 

        return User::create([
            'name' => $request['name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'image' => $filename,
            'CIN' => $request['CIN'],
            'password' => Hash::make($request['password']),
            'type' =>$request['type']
        ]);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
       $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required','string','email','max:255','unique:users,email,'.$user->id],
            'password' => ['sometimes', 'string', 'min:6'],
            'CIN' => ['required', 'string', 'max:8'],
            'type' => ['required', 'string'],
            'image' => ['sometimes', 'string'],
        
        ]);
       $currentImage = $user->image;
        if($request->image != $currentImage){
        $exploded = explode(',',$request['image']);
        $decoded = base64_decode($exploded[1]);

        $extension = Str::contains($exploded[0],'jpeg')? 'jpeg' :'png';
        $filename = Str::random().'.'.$extension;
        $path =  public_path().'/img/'.$filename;
        file_put_contents($path, $decoded);
        $request->merge(['image' => $filename]);
        }
        $user->update($request->all());
        return ['message' => 'User updated successfully'];
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

        return ['message' => 'User deleted!'];
    }
}
