<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteFreelance extends Model
{
    use HasFactory;
    protected $fillable = [
        'seeker_id','freelance_post_id'
    ];

    public function seeker()
    {
        return $this->belongsTo(Seeker::class);
    }

    public function freelance_post()
    {
        return $this->belongsTo(FreelancePost::class);
    }


}
