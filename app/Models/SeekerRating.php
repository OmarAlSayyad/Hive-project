<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeekerRating extends Model
{
    use HasFactory;
    protected $fillable = ['seeker_id', 'rater_company_id','rater_seeker_id', 'rating'];

    public function seeker()
    {
        return $this->belongsTo(Seeker::class);
    }
}
