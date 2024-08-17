<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyRating extends Model
{
    use HasFactory;

    protected $fillable = ['company_id', 'rater_seeker_id', 'rating'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }




}
