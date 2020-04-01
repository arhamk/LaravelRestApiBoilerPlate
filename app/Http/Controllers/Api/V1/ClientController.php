<?php

namespace App\Http\Controllers\Api\V1;

use App\Client;
use App\Http\Controllers\Controller;
use Dingo\Api\Http\Request;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'host' => 'required',
            'number' => 'required'
        ]);

        try{
            $client = Client::create([
                'host' => $request->host,
                'number' => $request->number,
                'api_key' => md5(time()),
                'uuid' => Str::uuid(),
            ]);

            return response()->json([
                'code' => 201,
                'data' => ['client' => [
                    'id' => $client->id
                ]]
            ]);
        }catch (\Illuminate\Database\QueryException $ex){
            throw new \Exception($ex->getMessage());
        }
    }
}
