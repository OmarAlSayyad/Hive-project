<?php

namespace App\Models;

use App\Http\Resources\SkillsResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequiredSkill extends Model
{
    use HasFactory;
    protected $table = 'required_skills';

    protected $fillable = [
        'skill_id','job_post_id','freelance_post_id'
    ];
//    public function job_post()
//    {
//        return $this->belongsTo(JobPost::class);
//    }
//    public function skill()
//    {
//        return $this->belongsTo(Skill::class);
//    }



}
