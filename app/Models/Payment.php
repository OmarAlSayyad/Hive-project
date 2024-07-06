<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_payer_id','seeker_payer_id', 'payee_id', 'freelance_id', 'amount', 'status'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_payer_id');
    }
    public function seeker()
    {
        return $this->belongsTo(Seeker::class);
    }


    public function freelance_post()
    {
        return $this->belongsTo(FreelancePost::class);
    }


}
