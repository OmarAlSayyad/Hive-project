<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Freelance_Post extends Model
{
    use HasFactory;


    protected $fillable = [
        'company_id','seeker_id','category_id','title', 'description', 'delivery_date', 'min_budget','max_budget','post_status'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function seeker()
    {
        return $this->belongsTo(Seeker::class);
    }

    public function skill()
    {
        return $this->belongsToMany(Skill::class, 'required_skills');
    }

    public function language()
    {
        return $this->belongsToMany(Language::class,'required_languages');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    public function contract()
    {
        return $this->hasMany(Contract::class);
    }



    public function favorite()
    {
        return $this->hasMany(Favorite::class);
    }
}
