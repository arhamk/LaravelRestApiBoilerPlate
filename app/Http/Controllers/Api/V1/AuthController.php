<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Dingo\Api\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTFactory;
use JWTAuth;
use Request as LaravelRequest;


class AuthController extends Controller
{
    //Client Authenticate Using JwtApiKeyMiddleware
    public function clientAuthenticate(){
        $client = LaravelRequest::get('client');
        $newArray = [
            'id' => $client->id,
            'type'=>'client',
            'api_key'=>$client->api_key,
            'uuid'=>$client->uuid,
        ];
        $customClaims = JWTFactory::customClaims($newArray);
        $payload = JWTFactory::make($newArray);
        $token = JWTAuth::encode($payload);

        return response()->json([
            'code' => 200,
            'data' => ['token'=>$token->get()],
        ],200);
    }

    //Validate Client Request Using JwtClientTokenMiddleware, and proccess login
    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        $client = LaravelRequest::get('client');
        $credentials = $request->only(['username', 'password']);
        $credentials['enabled'] = true;
        //$credentials['client_id'] = $client['id'];
        try {
            $token = auth()->guard('api')->attempt($credentials);
            if(!$token) {
                throw new UnprocessableEntityHttpException('Invalid username or password');
            }
        } catch (JWTException $e) {
            throw new HttpException(500);
        }

        //Get ACL
        $userId = auth()->user()->id;
        $user = \App\User::with(['roles'=>function($q){
            $q->with(['permissions'=>function($q){

            }]);
        }])->find($userId);

        $userPermission = $user->roles->mapWithKeys(function($role) {
            return $role->permissions;
        });

        $permissionRuleSet = $userPermission->mapWithKeys(function ($permission){
            return json_decode($permission->rule_set);
        });

        $permissionRuleSet = $permissionRuleSet->map(function ($permissionRuleSet) use ($userPermission){
            return $userPermission[0]->method .':'.$permissionRuleSet;
        });

        return response()
            ->json([
                'code' => 200,
                'data' => [
                    'token' => $token,
                    'user' => auth()->user()->only('id', 'number', 'email', 'enabled'),
                    'acl' => $permissionRuleSet
                ],
            ],200);
    }

    //Current Login User
    public function user(Request $request)
    {
        return response()->json([
            'code'=>200,
            'data' => [
                'user' => auth()->user()->only('id', 'number', 'email', 'enabled'),
            ]
        ]);
    }
}
