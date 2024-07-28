<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeekerSkill extends Model
{
    use HasFactory;

    protected $fillable = [
        'seeker_id', 'skill_id','level'
    ];

    public function seeker()
    {
        return $this->belongsTo(Seeker::class);
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }
}
