<?php

namespace App\Http\Controllers;

use App\Http\Resources\JobPostsResource;
use App\Models\JobPost;
use App\Http\Requests\StoreJobPostRequest;
use App\Http\Requests\UpdateJobPostRequest;
use Exception;
use Illuminate\Support\Facades\Log;

class JobPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = JobPost::with('company','category','skill')->get();
        return JobPostsResource::collection($jobs);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobPostRequest $request)
    {
        try {
//            $validated = $request->validated();
//            if (!$validated) {
//                return response()->json([
//                    'data' => '',
//                    'message' => $request->errors()->all(),
//                    'status' => 422,
//                ]);
//            }
            $jobPost = JobPost::create([

                'company_id' => $request->company_id,
                'category_id' => $request->category_id,

                'title' => $request->title,
                'description' => $request->description,
                'job_requirement' => $request->job_requirement,
                'address' => $request->address,

                'gender' => $request->gender,
                'min_age' => $request->min_age,
                'max_age' => $request->max_age,

                'scientific_level' => $request->scientific_level,
                'job_type' => $request->job_type,
                'experience_years' => $request->experience_years,
                'min_salary' => $request->min_salary,
                'max_salary' => $request->max_salary,

            ]);
        } catch (Exception $e) {
            Log::error('Error creating job post :' . $e->getMessage());
            return response()->json([
                'data' => '',
                'message' => 'An error occurred while creating the job post ',
                'status' => 500,
            ], 500);
        }
        return response()->json([
            'data' =>  new JobPostsResource($jobPost->load(['company','category','skill'])),
            'message' => ' job post post created successfully',
            'status' => 200,
        ],200);

    }

    /**
     * Display the specified resource.
     */
    public function show(JobPost $jobPost)
    {
        return new JobPostsResource($jobPost->load(['company','category','skill']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobPost $jobPost)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobPostRequest $request, JobPost $jobPost)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobPost $jobPost)
    {
        //
    }
}
