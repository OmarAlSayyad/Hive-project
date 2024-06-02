<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seeker extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'communication_id', 'location_id', 'rating', 'cv', 'level', 'bio', 'gender', 'picture', 'hourly_rate', 'birth_date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function communication()
    {
        return $this->belongsTo(Communication::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'seeker_skills');
    }

    public function education()
    {
        return $this->hasMany(Education::class);
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }
}
