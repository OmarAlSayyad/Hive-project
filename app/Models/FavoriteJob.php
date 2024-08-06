<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteJob extends Model
{
    use HasFactory;
    protected $fillable = [
         'seeker_id','job_post_id'
    ];

    public function seeker()
    {
        return $this->belongsTo(Seeker::class);
    }
    public function job_post()
    {
        return $this->belongsTo(JobPost::class);
    }
}
