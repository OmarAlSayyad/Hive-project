<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Required_Skill extends Model
{
    use HasFactory;
    protected $fillable = [
        'skill_id','job_post_id','freelance_post_id'
    ];
}
