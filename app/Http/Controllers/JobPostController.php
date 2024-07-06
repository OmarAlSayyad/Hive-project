<?php

namespace App\Http\Controllers;

use App\Http\Resources\JobPostsResource;
use App\Models\JobPost;
use App\Http\Requests\StoreJob_PostRequest;
use App\Http\Requests\UpdateJob_PostRequest;

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
    public function store(StoreJob_PostRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(JobPost $job_Post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobPost $job_Post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJob_PostRequest $request, JobPost $job_Post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobPost $job_Post)
    {
        //
    }
}
