<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantsJobPost extends Model
{
    use HasFactory;

    protected $fillable =['freelance_post_id' , 'seeker_id','Accepted'];

    public function job_post(){
        return $this->belongsTo(JobPost::class);
    }

}
