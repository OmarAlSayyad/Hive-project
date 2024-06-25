<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locations extends Model
{
    use HasFactory;
    protected $fillable = ['address','country','city'];

    public function company()
    {
        return $this->hasOne(Company::class);
    }
    public function seeker()
    {
        return $this->hasOne(Seeker::class);
    }
}
