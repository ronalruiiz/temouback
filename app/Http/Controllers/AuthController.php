<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ResponseHelper;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    use ResponseHelper;
    /**
     * Login The User
     * @param Request $request
     * @return Response
     */
    public function login(Request $request): Response
    {
        try {
            $validator = Validator::make($request->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required'
                ]);

            if($validator->fails()){
                return $this->validationFailed($validator->errors());
            }

            if(!Auth::attempt($request->only(['email', 'password']))){
                return $this->errorResponse(['Password o email no valido']);
            }

            $user = User::where('email', $request->email)->first();

            $data = [
                'user' =>$user,
                'auth_token' => $user->createToken("API TOKEN")->plainTextToken ?? null,
            ];

            return $this->successResponse($data);
        } catch (\Throwable $th) {
            return $this->errorResponse([$th->getMessage()]);
        }
    }

    /**
     * Create User
     * @param Request $request
     * @return Response
     */
    public function register(Request $request): Response{
        try {
            //Validated
            $validator = Validator::make($request->all(),
                [
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email',
                    'password' => [
                        'required',
                        'confirmed',
                        Password::min(14)
                            ->mixedCase()
                            ->letters()
                            ->numbers()
                            ->symbols()
                            ->uncompromised(),]
                ]);

            if ($validator->fails()) {
                return $this->validationFailed($validator->errors());
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => \Hash::make($request->password),

            ]);

            $data = [
                'user' =>$user,
                'auth_token' => $user->createToken("API TOKEN")->plainTextToken ?? null,
            ];
            return $this->successResponse($data,201);

        } catch (\Throwable $th) {
            return $this->errorResponse([$th->getMessage()]);
        }
    }
}
