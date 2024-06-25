<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Console\Output\NullOutput;

class Company extends Model
{
    use HasFactory;


   protected $with = [ 'location','communication','user'];

    protected $fillable = [
        'user_id', 'location_id', 'communication_id','rating','picture', 'industry', 'description','approved'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function location()
    {
        return $this->belongsTo(Locations::class);
    }

    public function communication()
    {
        return $this->belongsTo(Communication::class);
    }

    public function job_post()
    {
        return $this->hasMany(Job_Post::class);
    }
    public function freelance_post()
    {
        return $this->hasMany(Freelance_Post::class);
    }

    public function interview()
    {
        return $this->hasMany(Interview::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }
    public function wallet()
    {
        return $this->hasMany(Wallet::class);
    }
    public function payment()
    {
        return $this->hasMany(Payment::class);
    }

    public function notification()
    {
        return $this->hasMany(Notification::class);
    }
    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }


}
