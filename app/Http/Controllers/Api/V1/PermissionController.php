<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function viewPermissionGroups($permissionId)
    {
        $roles = \App\Role::whereHas('permissions', function($q) use ($permissionId){
            $q->where('permissions.id', '=', $permissionId);
        })->whereEnabled(true)->select(['name', 'description'])->get();

        return response()->json([
            'code' => 200,
            'data' => ['roles'=>$roles],
        ],200);
    }
}
