<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApplicantjobPostResource;
use App\Models\ApplicantsFreelancePost;
use App\Models\ApplicantsJobPost;
use App\Http\Requests\StoreApplicantsJobPostRequest;
use App\Http\Requests\UpdateApplicantsJobPostRequest;
use App\Models\JobPost;
use App\Models\Seeker;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
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

    public function getMyApplicants()
    {
        try {
            $user = Auth::user();
            $seeker = Seeker::where('user_id', $user->id)->first();

            if ($seeker){
                $applicants=ApplicantsJobPost::with(['job_post'])
                    ->where('seeker_id', $seeker->id)
                    ->get();
            }

            if ($applicants->isEmpty()) {
                return response()->json([
                    'data' => [],
                    'message' => 'No applicants was found ',
                    'status' => 404,
                ], 404);
            }

            return response()->json([
                'data' => ApplicantjobPostResource::collection($applicants),
                'message' => 'applicants retrieved successfully',
                'status' => 200,
            ], 200);

        } catch (Exception $e) {
            Log::error('Error retrieving seeker applicants: ' . $e->getMessage());
            return response()->json([
                'data' => [],
                'message' => 'An error occurred while retrieving applicants',
                'status' => 500,
            ], 500);
        }
    }

    public function getApplicantsByJobId(JobPost $jobPost)
    {
        try {

            if ($jobPost){
                $applicants=ApplicantsJobPost::with(['job_post'])
                    ->where('job_post_id', $jobPost->id)
                    ->get();
            }

            if ($applicants->isEmpty()) {
                return response()->json([
                    'data' => [],
                    'message' => 'No applicants was found for this job post',
                    'status' => 404,
                ], 404);
            }

            return response()->json([
                'data' => ApplicantjobPostResource::collection($applicants),
                'message' => 'applicants on this job post retrieved successfully',
                'status' => 200,
            ], 200);

        } catch (Exception $e) {
            Log::error('Error retrieving  applicants on this job post : ' . $e->getMessage());
            return response()->json([
                'data' => [],
                'message' => 'An error occurred while retrieving applicants on this job post ',
                'status' => 500,
            ], 500);
        }
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApplicantsJobPostRequest $request)
    {
        try {
        $user=Auth::user();
        $seeker = Seeker::where('user_id', $user->id)->first();

        $applicant= ApplicantsJobPost::create([
            'seeker_id'=>$seeker->id,
            'job_post_id'=>$request->job_post_id,
        ]);

        } catch (Exception $e) {
            Log::error('Error while applicant on job post :' . $e->getMessage());
            return response()->json([
                'data' => '',
                'message' => 'An error occurred while applicant on job post',
                'status' => 500,
            ], 500);
        }
            $applicant->load(['job_post']);
        return response()->json([
            'data' =>  ApplicantjobPostResource::collection(collect([$applicant])),
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

            $applicantsJobPost=ApplicantsJobPost::findOrFail($applicantsJobPost->id);

            if ($applicantsJobPost) {
                $applicantsJobPost->delete();
                return response()->json([
                    'data' => '',
                    'message' => 'applicants deleted successfully',
                    'status' => 200,
                ], 200);
            }
        }
        catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 403);
        }
        catch (Exception $e) {
            Log::error('Error deleting this applicant: ' . $e->getMessage());
            return response()->json([
                'data' => '',
                'message' => 'An error occurred while deleting this applicant',
                'status' => 500,
            ], 500);
        }

    }
}
