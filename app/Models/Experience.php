<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    protected $fillable = [
         'seeker_id', 'job_title', 'company_name', 'job_description', 'start_date','end_date'
    ];

    public function seeker()
    {
        return $this->belongsTo(Seeker::class,'seeker_id');
    }
}
