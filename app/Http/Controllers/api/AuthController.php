<?php 

namespace App\Http\Controllers\api;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller 
{
    public function login(LoginRequest $request)  
    {
        $data = $request->validated();

        if(!Auth::attempt($data)){
            return response([
                'message' => 'Email ou mot de passe incorrects'
            ]);
        }

        $user = Auth::user();

        $token = $user->createToken('main')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
        
    }
    public function register(RegisterRequest $request)  
    {
        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        $token = $user->createToken('main')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
 
    }
    public function logout(Request $request)  
    {
        $user = $request->user(); 

        $user->currentAccessToken()->delete();

        return response('', 204);
        
    }
    
}