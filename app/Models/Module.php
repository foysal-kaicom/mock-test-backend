<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $guarded=[];

    public function Permissions()
    {
        return $this->hasMany(Permission::class, 'module_id');
        
    }
}
