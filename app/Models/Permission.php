<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description'];
    protected $table = 'permissions';
    /**
     * The users that belong to the permission.
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}