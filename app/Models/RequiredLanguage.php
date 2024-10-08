<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequiredLanguage extends Model
{
    use HasFactory;

    protected $fillable = [
        'language_id','job_post_id','freelance_post_id'
    ];
}
