<?php

namespace App\Models;

use Illuminate\Database\ClassMorphViolationException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id','seeker_id', 'balance','type'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function seeker()
    {
        return $this->belongsTo(Seeker::class);
    }
    public function fillWallet($amount)
    {
        if ($amount <= 0) {
            throw new \InvalidArgumentException('Amount must be positive.');
        }
        $this->balance += $amount;
        $this->save();
    }
}
