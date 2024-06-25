<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    protected $fillable = [
        'seeker_id', 'certificate', 'field_of_study', 'institution_name', 'graduation_date', 'specialization', 'status', 'study_mode'
    ];

    public function seeker()
    {
        return $this->belongsTo(Seeker::class);
    }
}
