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

    public function seekers()
    {
        return $this->belongsToMany(Seeker::class, 'seeker_skills');
    }

    public function jobPosts()
    {
        return $this->hasMany(JobPost::class);
    }

    public function freelancePosts()
    {
        return $this->hasMany(FreelancePost::class);
    }
}
