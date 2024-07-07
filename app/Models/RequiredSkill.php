<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequiredSkill extends Model
{
    use HasFactory;
    protected $fillable = [
        'skill_id','job_post_id','freelance_post_id'
    ];

//    public function  skills()
//    {
//        return $this->hasMany(Skill::class);
//    }
//    public function skillss()
//    {
//        return $this->hasMany(FreelancePost::class);
//    }
}
