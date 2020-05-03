<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    protected $fillable = [
        'id',
        'name',
        'description',
        'client_id',
        'enabled',
        'displayed',
    ];

    public function permissions(){
        return $this->belongsToMany(Permission::class, 'role_permissions', 'permission_id', 'role_id');
    }

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }


}
