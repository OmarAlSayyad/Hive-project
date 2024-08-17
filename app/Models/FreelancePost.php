<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class FreelancePost extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id','seeker_id','category_id','title', 'description', 'delivery_date', 'min_budget','max_budget','post_status'
    ];


    public function scopeAutoSeekerFreelancePosts(Builder $query, Seeker $seeker)
    {
        $query->where(function ($q) use ($seeker) {

            $q->where(function ($q) use ($seeker) {
                $seeker->education->each(function ($education) use ($q) {
                    $q->where('title', 'like', '%' . $education->field_of_study . '%')
                        ->orWhere('description', $education->scientific_level);
                });
            });

            $q->orWhere(function ($q) use ($seeker) {
                $seeker->experience->each(function ($experience) use ($q) {
                    $q->where('title', $experience->job_title)
                        ->orWhere('description', 'like', '%' . $experience->job_description . '%');
                });
            });

            // OR Filter by category and seeker skill
            $q->orWhereHas('categorySkills', function ($query) use ($seeker) {
                $query->whereIn('skills.id', $seeker->skill->pluck('id')->toArray());
            });
        });
        return $query;
    }
    public function scopeAutoCompanyFreelancePosts(Builder $query, Company $company)
    {
        Log::info('Filtering freelance posts for company:', ['company_id' => $company->id, 'industry' => $company->industry, 'description' => $company->description]);

        $query->where(function ($q) use ($company) {
            // Filter by the company's industry in the freelance post's title or description
            $q->where(function ($q) use ($company) {
                $q->where('title', 'like', '%' . $company->industry . '%')
                    ->orWhere('description', 'like', '%' . $company->industry . '%');
            });

            // Filter by the company's description in the freelance post's title or description
            $q->orWhere(function ($q) use ($company) {
                $q->where('title', 'like', '%' . $company->description . '%')
                    ->orWhere('description', 'like', '%' . $company->description . '%');
            });

            // Filter by the company's description and industry in the related category's skills
            $q->orWhereHas('categorySkills', function ($query) use ($company) {
                $query->where('skills.name', 'like', '%' . $company->description . '%')
                    ->orWhere('skills.name', 'like', '%' . $company->industry . '%');
            });
        });

        return $query;
    }

    public function categorySkills()
    {
        return $this->hasManyThrough(Skill::class, Category::class, 'id', 'category_id', 'category_id', 'id');
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function seeker()
    {
        return $this->belongsTo(Seeker::class);
    }

    public function skill()
    {
        return $this->belongsToMany(Skill::class, 'required_skills', 'freelance_post_id', 'skill_id');
    }



    public function language()
    {
        return $this->belongsToMany(Language::class,'required_languages');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    public function contract()
    {
        return $this->hasMany(Contract::class);
    }



    public function favorite()
    {
        return $this->hasMany(Favorite::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function applicants_freelance_post(){
        return $this->hasMany(ApplicantsFreelancePost::class);
    }


}
