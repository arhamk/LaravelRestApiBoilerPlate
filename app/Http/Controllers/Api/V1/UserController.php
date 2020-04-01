<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'username' => 'required|alpha_dash|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'number' => 'required',
            'client_id' => 'required|numeric'
        ]);

        try{
            $user = User::create($request->only([
                'name', 'username', 'email', 'password', 'number', 'client_id'
            ]));

            return response()->json([
                'code' => 201,
                'data' => ['user' => [
                    'id' => $user->id
                ]]
            ]);
        }catch (\Illuminate\Database\QueryException $ex){
            throw new \Exception($ex->getMessage());
        }
    }
}
