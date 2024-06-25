<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Communication extends Model
{
    use HasFactory;


    protected $fillable = [
         'mobile_phone', 'line_phone', 'website', 'linkedin_account', 'github_account','facebook_account'
    ];


    public function company()
    {
        return $this->hasOne(Company::class);
    }
    public function seeker()
    {
        return $this->hasOne(Seeker::class);
    }
}
