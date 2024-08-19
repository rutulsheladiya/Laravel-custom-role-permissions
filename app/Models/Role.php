<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'created_by'];
    
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission','role_id','permission_id');
    }

    public function users()
    {        
        return $this->belongsToMany(User::class, 'role_user');
    }

    public function hasPermission($permissionName)
    {
        return $this->permissions()->where('name', $permissionName)->exists();
    }

    public function givePermission($permission)
    {
        if (!$this->hasPermission($permission->name)) {
            $this->permissions()->attach($permission, [
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }

    public function syncPermissions($permissions)
    {
        $this->permissions()->sync($permissions);
    }
}
