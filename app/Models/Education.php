<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    protected $fillable = [
        'seeker_id','start_date', 'field_of_study', 'institution_name', 'graduation_date','graduation_degree', 'specialization', 'status', 'study_mode','scientific_level',
    ];

    public function seeker()
    {
        return $this->belongsTo(Seeker::class);
    }
}
