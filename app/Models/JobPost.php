<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPost extends Model
{
    use HasFactory;

   // protected $with = ['category','skill'];

    protected $fillable = [
        'company_id','category_id',  'title', 'description', 'job_requirement','address','gender','min_age','max_age','scientific_level',
        'job_type','experience_years','min_salary','max_salary','status'
    ];

    public function scopeFilter($query , array $filters)
    {
        $query->when($filters['title'] ?? false, fn ($query,$search)=> $query
            -> where('name','like','%'.$search.'%')
            ->orwhere('description','like','%'.$search.'%')
        );

    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function skill()
    {
        return $this->belongsToMany(Skill::class, 'required_skills','job_post_id','skill_id');
    }

    public function language()
    {
        return $this->belongsToMany(Language::class,'required_languages');
    }
    public function favorite()
    {
        return $this->hasMany(Favorite::class);
    }


    public function applicants_job_post(){
        return $this->hasMany(ApplicantsJobPost::class);
    }

}
