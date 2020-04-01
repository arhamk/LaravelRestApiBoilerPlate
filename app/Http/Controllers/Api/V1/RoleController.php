<?php

namespace App\Http\Controllers\Api\V1;

use App\Client;
use App\Http\Controllers\Controller;
use App\Role;
use Dingo\Api\Http\Request;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            //'client_id' => 'required|numeric|exists:clients,id'
            'client_id' => 'required|numeric'
        ]);

        try{
            $role = Role::create([
                'name' => $request->name,
                'description' => $request->description,
                'client_id' => $request->client_id,
            ]);

            return response()->json([
                'code' => 200,
                'data' => ['role' => [
                    'id' => $role->id
                ]]
            ]);
        }catch (\Illuminate\Database\QueryException $ex){
            throw new \Exception($ex->getMessage());
        }
    }

    public function show(Request $request)
    {
        $this->validate($request, [
            'limit' => 'required|numeric',
            'page' => 'required|numeric',
        ]);

        $results = Role::orderBy('id', 'asc')->paginate($request->limit, ["*"], 'page');

        return response()->json([
            'code' => 200,
            'data' => [
                'list' => $results->items(),
                'totalItems' => $results->total(),
                'totalPages' => $results->total(),
                'page' => $results->currentPage(),
                'limit' => $results->perPage(),
            ]
        ], 200);
    }
}
