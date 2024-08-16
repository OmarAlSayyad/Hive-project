<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;


    protected $fillable = [
        'name', 'description'
    ];

    public function skill()
    {
        return $this->hasMany(Skill::class);
    }

    public function jobPost()
    {
        return $this->belongsTo(JobPost::class);
    }
    public function seeker()
    {
        return $this->belongsTo(Seeker::class);
    }


    public function freelancePost()
    {
        return $this->belongsTo(FreelancePost::class);
    }

}
