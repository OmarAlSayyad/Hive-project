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
        return $this->belongsToMany(JobPost::class,'required_languages');
    }
    public function freelance_post()
    {
        return $this->belongsToMany(FreelancePost::class,'required_languages');
    }
}
