<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_id','seeker_id', 'receiver_id','freelance_id', 'coin_type', 'amount', 'status', 'payment_method',  'description'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function seeker()
    {
        return $this->belongsTo(Seeker::class);
    }
    public function freelance_post()
    {
        return $this->belongsTo(FreelancePost::class);
    }
    public function receiver()
    {
        return $this->belongsTo(Seeker::class, 'receiver_id');
    }
}
