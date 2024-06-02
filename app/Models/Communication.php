<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Communication extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'mobile_phone', 'line_phone', 'website', 'linkedin_account', 'github_account'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
