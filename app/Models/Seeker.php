<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seeker extends Model
{
    use HasFactory;
   // protected $with = ['user', 'location', 'communication', 'wallet'];


    protected $fillable = [
        'user_id', 'communication_id', 'location_id', 'rating', 'cv', 'level','on_time_percentage', 'bio', 'gender', 'picture', 'hourly_rate', 'birth_date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function communication()
    {
        return $this->belongsTo(Communication::class);
    }

    public function location()
    {
        return $this->belongsTo(Locations::class);
    }
    public function freelance_post()
    {
        return $this->hasMany(FreelancePost::class);
    }

    public function skill()
    {
        return $this->belongsToMany(Skill::class, 'seeker_skills');
    }
    public function language()
    {
        return $this->belongsToMany(Language::class,'seeker_language');
    }

    public function education()
    {
        return $this->hasMany(Education::class);
    }

    public function interview()
    {
        return $this->hasMany(Interview::class);
    }

    public function favorite()
    {
        return $this->hasMany(Favorite::class);
    }

    public function contract()
    {
        return $this->hasMany(Contract::class);
    }

    public function experience()
    {
        return $this->hasMany(Experience::class);
    }
    public function wallet()
    {
        return $this->hasMany(Wallet::class);
    }

    public function payment()
    {
        return $this->hasMany(Payment::class);
    }
    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }




}
