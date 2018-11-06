<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use App\User;

class RegisterController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }
    
    public function store(Request $request)
    {
        $user = new User();

        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        
        if($request->file('avatar')){
            
            $avatar_path = time().$request->file('avatar')->getClientOriginalName();

            Storage::disk('avatars')->put($avatar_path, File::get($request->file('avatar')));

            $user->avatar = $avatar_path;
        }else{
            $faker = \Faker\Factory::create();

            $user->avatar = $faker->hexcolor;
        }

        $user->save();

        Auth::loginUsingId($user->id);

        return redirect()->route('video.index');
    }

    public function getAvatar($avatar_path){
        $avatar = Storage::disk('avatars')->get($avatar_path)        ;

        return $avatar;
    }
}
