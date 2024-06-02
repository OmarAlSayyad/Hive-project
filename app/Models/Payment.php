<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payer_id', 'payee_id', 'freelance_id', 'amount', 'status'
    ];

    public function payer()
    {
        return $this->belongsTo(Company::class, 'payer_id');
    }

    public function payee()
    {
        return $this->belongsTo(Seeker::class, 'payee_id');
    }

    public function freelancePost()
    {
        return $this->belongsTo(FreelancePost::class, 'freelance_id');
    }


}
