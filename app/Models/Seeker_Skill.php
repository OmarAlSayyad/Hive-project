<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seeker_Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'seeker_id', 'skill_id'
    ];


}
