<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Resources\User as UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends BaseController
{
    public function index(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
//            $success['token'] =  $user->createToken(config('app.name'))->plainTextToken;
            $success['token'] =  $user->createToken(config('app.name'))->accessToken;
            $success['name'] =  $user->name;

            return $this->sendResponse($success, 'User login successfully.');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

    public function user(Request $request)
    {
        $users = User::all();

        return $this->sendResponse(UserResource::collection($users), 'Users retrieved successfully.');
    }

    public function logout(Request $request)
    {
//        $request->user()->currentAccessToken()->delete();
        $request->user()->token()->revoke();
        return $this->sendResponse([], 'User logout successfully.');
    }
}
