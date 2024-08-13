<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;


    protected $fillable = [
        'company_hire_id','seeker_hire_id','freelancer_id','freelance_id','terms', 'description', 'start_date', 'end_date','delivered_date', 'status'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function seeker()
    {
        return $this->belongsTo(Seeker::class);
    }


    public function scopeActive($query)
    {
        return $query->where('end_date', '>=', date('Y-m-d'));
    }

    public function scopeExpired($query)
    {
        return $query->where('end_date', '<', date('Y-m-d'));
    }
}
