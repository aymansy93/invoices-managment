<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Profil;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Validator;
use Auth;

class AuthController extends Controller
{
    //
    use ApiResponseTrait;

    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {

            return $this->apiresponse(null,422,[$validator->errors()]);
        }
        if (! $token = auth()->attempt($validator->validated())) {

            return $this->apiresponse(null,401,['error' => 'Unauthorized']);

        }
        return $this->createNewToken($token);
    }
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);
        if($validator->fails()){
            return $this->apiresponse(null,400,[$validator->errors()]);
        }
        $user =  User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status'=> 'مفعل',
            'roles_name'=> ['user']
        ]);
        $role = Role::select('id')->where('name','user')->first();
        $user->roles()->attach($role);

        $id = User::latest()->first()->id;
        $role = User::latest()->first()->roles_name;

        Profil::create([
            'user_id' => $id,
            'role' => $role['0'],
        ]);
        return $this->apiresponse($user,201,['User successfully registered']);

    }
    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();
        return $this->apiresponse(null,200,['User successfully signed out']);

    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function userProfile() {
        return response()->json(auth()->user()->profil()->first());
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
}
