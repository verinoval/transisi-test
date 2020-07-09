<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;

use Validator;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        $inputs = $request->all();
        $rules = [
            'name'      => 'required|string',
            'level_id'  => 'required',
            'email'     => 'required|string|email|unique:users',
            'password'  => 'required|string|confirmed'
        ];

        $messages = [
            'name.required'         => 'Nama harus diisi!',
            'name.string'           => 'Format nama salah!',
            'level_id.required'     => 'Level harus diisi!',
            'email.required'        => 'Email harus diisi!',
            'email.string'          => 'Format email salah!',
            'email.email'           => 'Format email salah!',
            'email.unique'          => 'Email sudah didaftarkan!',
            'password.required'     => 'Password harus diisi!',
            'password.string'       => 'Format password salah!',
            'password.confirmed'    => 'Konfirmasi password salah!'
        ];
        
        $validator = Validator::make($inputs,$rules,$messages);

        if ($validator->fails()) {
            $res['success'] = false;
            $res['message'] = $validator->errors()->all();
            return response($res);
        }

        $user = new User([
            'name'      => $request->name,
            'level_id'  => $request->level_id,
            'email'     => $request->email,
            'password'  => bcrypt($request->password)
        ]);

        $user->save();

        return response()->json([
            'message' => 'Sukses insert user!',
            'success' => true
        ], 201);
    }

    public function login(Request $request)
    {
        $inputs = $request->all();
        $rules = [
            'email'         => 'required|string|email',
            'password'      => 'required|string',
            'remember_me'   => 'boolean'
        ];

        $messages = [
            'email.required'    => 'Email harus diisi!',
            'email.string'      => 'Format email salah!',
            'email.email'       => 'Email tidak terdaftar!',
            'password.required' => 'Password harus diisi!',
            'password.string'   => 'Format password salah!'
        ];

        $validator = Validator::make($inputs,$rules,$messages);

        if ($validator->fails()) {
            $res['success'] = false;
            $res['message'] = $validator->errors()->all();
            return response($res);
        }

        $credentials = request(['email', 'password']);

        if(!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);

        $user = $request->user();

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);

        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
