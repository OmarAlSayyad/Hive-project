<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;


    protected $fillable = [
        'title', 'description', 'start_date', 'end_date', 'value'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function seeker()
    {
        return $this->belongsTo(Seeker::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
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
