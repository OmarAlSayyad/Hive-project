<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'location_id', 'communications_id', 'picture', 'industry', 'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function communication()
    {
        return $this->belongsTo(Communication::class, 'communications_id');
    }

    public function jobPosts()
    {
        return $this->hasMany(JobPost::class);
    }

    public function interviews()
    {
        return $this->hasMany(Interview::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class, 'hire_id');
    }
}
