<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id', 'seeker_id'
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
