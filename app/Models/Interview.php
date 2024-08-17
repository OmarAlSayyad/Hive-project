<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id', 'seeker_id', 'scheduled_at', 'started_at', 'ended_at', 'address', 'notes', 'interview_link','status','result'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function seeker()
    {
        return $this->belongsTo(Seeker::class);
    }
}
