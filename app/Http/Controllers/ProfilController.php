<?php

namespace App\Http\Controllers;
use App\Models\Profil;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use DB;
use Auth;
use Storage;

use Illuminate\Http\Request;

class ProfilController extends Controller
{
    //
    public function index(){
        $user_id = Auth::user()->id;
        $profil = profil::find($user_id);

        return view('profil.profile',compact('profil'));
    }
    public function store(Request $request){
        // dd($request->all());
        $userid = Auth::user()->id;
        if(!empty($request->name)){
            $request->validate([
                'name' => 'string',
            ]);
            DB::table('users')
            ->select('name')->where('id',$userid)
            ->update(['name'=> $request->name]);

        }

        if(!empty($request->email)){
            $request->validate([
                'email'=>'email|unique:users,email,' . $userid,
            ]);
            DB::table('users')
            ->select('email')->where('id',$userid)
            ->update(['email'=>$request->email]);

        }

        if(!empty($request->password)){
            $request->validate([
                'password' => ['string', 'min:8', 'confirmed'],
            ]);
            DB::table('users')
            ->select('password')->where('id',$userid)
            ->update(['password'=> Hash::make($request->password)]);
        }
        if(!empty($request->username)){
            $request->validate([
                'username'=> 'string',
            ]);
            DB::table('profils')
            ->select('username')->where('user_id',$userid)
            ->update(['username' => $request->username]);
        }
        if(!empty($request->github)){
            $request->validate([
                'github'=> 'string',
            ]);
            DB::table('profils')
            ->select('github')->where('user_id',$userid)
            ->update(['github' => $request->github]);
        }
        if(!empty($request->twitter)){
            $request->validate([
                'twitter'=> 'string',
            ]);
            DB::table('profils')
            ->select('twitter')->where('user_id',$userid)
            ->update(['twitter' => $request->twitter]);
        }
        if(!empty($request->linkedin)){
            $request->validate([
                'linkedin'=> 'string',
            ]);
            DB::table('profils')
            ->select('linkedin')->where('user_id',$userid)
            ->update(['linkedin' => $request->linkedin]);
        }
        if(!empty($request->facebook)){
            $request->validate([
                'facebook'=> 'string',
            ]);
            DB::table('profils')
            ->select('facebook')->where('user_id',$userid)
            ->update(['facebook' => $request->facebook]);
        }
        if(!empty($request->description)){
            $request->validate([
                'description'=> 'string',
            ]);
            DB::table('profils')
            ->select('description')->where('user_id',$userid)
            ->update(['description' => $request->description]);
        }

        return redirect()->back()->with('profil','تم تعديل الملف الشخصي بنجاح');
    }

    public function set_img(Request $request){
        // dd($request->all());
        $user_id = Auth::user()->id;
        $request->validate([
            'image' => 'required|mimes:jpeg,png,jpg',
        ]);

        $file = $request->file('image');
        $file_name = time() . $file->getClientOriginalName();
        $request->image->move(public_path('users_images/' . $user_id), $file_name);
        DB::table('profils')
        ->select('image_path')->where('user_id', $user_id)
        ->update(['image_path' => 'users_images/' . $user_id ."/". $file_name]);

        return redirect()->back();




    }
}

