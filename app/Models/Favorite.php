<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id', 'seeker_id','job_post_id','freelance_post_id'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function seeker()
    {
        return $this->belongsTo(Seeker::class);
    }
    public function job_post()
    {
        return $this->belongsTo(JobPost::class);
    }
    public function freelance_post()
    {
        return $this->belongsTo(FreelancePost::class);
    }


}
