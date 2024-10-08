<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;


    protected $fillable = [
        'name', 'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function seeker_skill()
    {
        return $this->belongsToMany(Seeker::class, 'seeker_skills');
    }

    public function job_post()
    {
        return $this->belongsToMany(JobPost::class, 'required_skills','skill_id','job_post_id');
    }

    public function freelance_post()
    {
        return $this->belongsToMany(FreelancePost::class, 'required_skills');
    }

}
