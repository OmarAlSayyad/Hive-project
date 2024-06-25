<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;
    protected $fillable = [
      'name'
    ];





    public function seeker()
    {
        return $this->belongsToMany(Seeker::class,'seeker_language');
    }
    public function job_post()
    {
        return $this->belongsToMany(Job_Post::class,'required_languages');
    }
    public function freelance_post()
    {
        return $this->belongsToMany(Freelance_Post::class,'required_languages');
    }
}
