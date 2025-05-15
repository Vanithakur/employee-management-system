<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Department; 
use App\Models\Role; 

class Employee extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'email', 'phone', 'profile_photo', 'department_id', 'role_id'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
