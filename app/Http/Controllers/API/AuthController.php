<?php

namespace App\Http\Controllers\API;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\ResponseController as ResponseController;
use App\Http\Resources\User as UserResource;

class AuthController extends ResponseController
{
    //create user
    public function signup(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone_number' => 'required|regex:/(09)[0-9]{9}/|max:11|unique:users',
            'picture' => 'sometimes|image|required|max:10000',
            'password' => 'required|string|min:8|confirmed',
            //password_confirmation
            // 'confirm_password' => 'required|same:password'
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

        $input['password'] = Hash::make($input['password']);

        $picture = $request->file('picture');

        if ($picture) {
            $input['picture'] = $picture->store('profile_pictures');
        }

        $user = User::create($input);

        if ($user) {
            $success['token'] =  $user->createToken('token')->accessToken;
            $success['message'] = "Registration successfull..";
            return $this->sendResponse($success);
        } else {
            $error = "Sorry! Registration is not successfull.";
            return $this->sendError($error, 401);
        }
    }

    //login
    public function login(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'user_name' => 'required|string',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

        $user_name = $input['user_name'];
        $password = $input['password'];

        $user = User::where('phone_number', $user_name)->orWhere('email', $user_name)->first();

        if ($user && Hash::check($password, $user->password)) {
            $success['token'] =  $user->createToken('token')->accessToken;
            return $this->sendResponse($success);
        }

        $error = "Unauthorized";
        return $this->sendError($error, 401);
    }

    //logout
    public function logout(Request $request)
    {

        $isUser = $request->user()->token()->revoke();
        if ($isUser) {
            $success['message'] = "Successfully logged out.";
            return $this->sendResponse($success);
        } else {
            $error = "Something went wrong.";
            return $this->sendResponse($error);
        }
    }

    //getuser
    public function getUser(Request $request)
    {
        //$id = $request->user()->id;
        $user = $request->user();
        if ($user) {
            return $this->sendResponse(new UserResource($user));
        } else {
            $error = "user not found";
            return $this->sendResponse($error);
        }
    }
}
