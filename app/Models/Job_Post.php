<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job_Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id', 'skill_id', 'location_id', 'title', 'description', 'salary'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
