<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Resources\User as UserResource;
use Illuminate\Http\Request;

class UserController extends ResponseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::select('id', 'name')->get();
        return $this->sendResponse($users);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $this->sendResponse(new UserResource($user));
    }
}
