<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApplicantjobPostResource;
use App\Models\ApplicantsJobPost;
use App\Http\Requests\StoreApplicantsJobPostRequest;
use App\Http\Requests\UpdateApplicantsJobPostRequest;
use App\Models\Seeker;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ApplicantsJobPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreApplicantsJobPostRequest $request)
    {
        //try {
        $user=Auth::user();
        $seeker = Seeker::where('user_id', $user->id)->first();

        $applicant= ApplicantsJobPost::create([
            'seeker_id'=>$seeker->id,
            'job_post_id'=>$request->job_post_id,
        ]);

        //} catch (Exception $e) {
        //    Log::error('Error while applicant on job post :' . $e->getMessage());
        //    return response()->json([
        //        'data' => '',
        //        'message' => 'An error occurred while applicant on job post',
        //        'status' => 500,
        //    ], 500);
        //}

        return response()->json([
            'data' =>  $applicant,//ApplicantjobPostResource::make($applicant->load(['job_post'])),
            'message' => ' applicant on job post added  successfully',
            'status' => 200,
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(ApplicantsJobPost $applicantsJobPost)
    {
        $applicantsJobPost = ApplicantsJobPost::findOrFail($applicantsJobPost->id);
        $applicantsJobPost->load(['job_post']);
        return ApplicantjobPostResource::collection([$applicantsJobPost]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ApplicantsJobPost $applicantsJobPost)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApplicantsJobPostRequest $request, ApplicantsJobPost $applicantsJobPost)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ApplicantsJobPost $applicantsJobPost)
    {
        try{


            $this->authorize('delete',$applicantsJobPost);

            $applicantsJobPost->delete();

            return response()->json([
                'data' => '',
                'message' => 'applicants deleted successfully',
                'status' => 200,
            ], 200);
        }
        catch (Exception $e) {
            Log::error('Error deleting applicant: ' . $e->getMessage());
            return response()->json([
                'data' => '',
                'message' => 'An error occurred while deleting this applicants',
                'status' => 500,
            ], 500);
        }

    }
}
