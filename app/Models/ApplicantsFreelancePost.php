<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantsFreelancePost extends Model
{
    use HasFactory;

    protected $fillable =['freelance_post_id' , 'seeker_id','Accepted'];

    public function freelance_post(){
        return $this->belongsTo(FreelancePost::class);
    }

}
