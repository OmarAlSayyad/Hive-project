<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPost extends Model
{
    use HasFactory;

    // protected $with = ['category','skill'];

    protected $fillable = [
        'company_id', 'category_id', 'title', 'description', 'job_requirement', 'address', 'gender', 'min_age', 'max_age', 'scientific_level',
        'job_type', 'experience_years', 'min_salary', 'max_salary', 'status'
    ];

    // Filter by company ID
    public function scopeFilter(Builder $query, array $filters)
    {
        // Filter by title or description
        $query->when($filters['title'] ?? false, function ($query, $title) {
            $query->where(function ($query) use ($title) {
                $query->where('title', 'like', '%' . $title . '%');
//                    ->orWhere('description', 'like', '%' . $title . '%');
            });
        });

        // Filter by category ID
        $query->when($filters['category_id'] ?? false, function ($query, $categoryId) {
            $query->where('category_id', $categoryId);
        });

        // Filter by skills within the job post's category
        $query->when(isset($filters['skills']) && is_array($filters['skills']), function ($query) use ($filters) {
            $query->whereHas('category.skill', function ($query) use ($filters) {
                $query->whereIn('id', $filters['skills']);
            });
        });

        // Filter by address
        $query->when($filters['address'] ?? false, function ($query, $address) {
            $query->where('address', 'like', '%' . $address . '%');
        });

        // Filter by gender
        $query->when($filters['gender'] ?? false, function ($query, $gender) {
            $query->where('gender', $gender);
        });

        // Filter by scientific level
        $query->when($filters['scientific_level'] ?? false, function ($query, $scientificLevel) {
            $query->where('scientific_level', $scientificLevel);
        });

        // Filter by job type
        $query->when($filters['job_type'] ?? false, function ($query, $jobType) {
            $query->where('job_type', $jobType);
        });

        // Filter by experience years
        $query->when($filters['experience_years'] ?? false, function ($query, $experienceYears) {
            $query->where('experience_years', '>=', $experienceYears);
        });

        // Filter by age (between min_age and max_age)
        $query->when($filters['age'] ?? false, function ($query, $age) {
            $query->where('min_age', '<=', $age)
                ->where('max_age', '>=', $age);
        });

        // Filter by salary (between min_salary and max_salary)
        $query->when($filters['salary'] ?? false, function ($query, $salary) {
            $query->where('min_salary', '<=', $salary)
                ->where('max_salary', '>=', $salary);
        });

        return $query;
    }


    public function scopeAutoJobPosts(Builder $query, Seeker $seeker)
    {

        // Filter by job post address and seeker city/country
        $query->where(function ($q) use ($seeker) {
            $q->where('address', 'like', '%' . $seeker->location->city . '%')
                ->orWhere('address', 'like', '%' . $seeker->location->country . '%');
        });

        // Filter by gender (if specified in the job post)
        if ($seeker->gender != 'Not_determined') {
            $query->where(function ($q) use ($seeker) {
                $q->where('gender', $seeker->gender)
                    ->orWhere('gender', 'Undefined');
            });
        }

        $query->where(function ($q) use ($seeker) {
            // Filter by education
            $q->where(function ($q) use ($seeker) {
                $seeker->education->each(function ($education) use ($q) {
                    $q->where('job_requirement', 'like', '%' . $education->field_of_study . '%')
                        ->orWhere('scientific_level', $education->scientific_level);
                });
            });
            // OR Filter by experience
            $q->orWhere(function ($q) use ($seeker) {
                $seeker->experience->each(function ($experience) use ($q) {
                    $startDate = Carbon::parse($experience->start_date);
                    $endDate = Carbon::parse($experience->end_date);
                    $yearsOfExperience = $endDate->diffInYears($startDate);
                    $q->where('title', $experience->job_title)
                        ->orWhere('description', 'like', '%' . $experience->job_description . '%')
                        ->where('experience_years', '<=', $yearsOfExperience);
                });
            });

            // OR Filter by category and seeker skill
            $q->orWhereHas('categorySkills', function ($query) use ($seeker) {
                $query->whereIn('skills.id', $seeker->skill->pluck('id')->toArray());
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

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }


    public function skill()
    {
        return $this->belongsToMany(Skill::class, 'required_skills', 'job_post_id', 'skill_id');
    }

    public function language()
    {
        return $this->belongsToMany(Language::class, 'required_languages');
    }

    public function favorite()
    {
        return $this->hasMany(FavoriteJob::class);
    }


    public function applicants_job_post()
    {
        return $this->hasMany(ApplicantsJobPost::class);
    }

}
