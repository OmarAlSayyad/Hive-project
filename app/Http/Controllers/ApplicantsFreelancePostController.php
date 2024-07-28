<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApplicantFreelancePostResource;
use App\Http\Resources\ExperienceResource;
use App\Http\Resources\FreelancePostsResource;
use App\Models\ApplicantsFreelancePost;
use App\Http\Requests\StoreApplicantsFreelancePostRequest;
use App\Http\Requests\UpdateApplicantsFreelancePostRequest;
use App\Models\FreelancePost;
use App\Models\Seeker;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ApplicantsFreelancePostController extends Controller
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
                $applicants=ApplicantsFreelancePost::with(['freelance_post'])
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
                'data' => ApplicantFreelancePostResource::collection($applicants),
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


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApplicantsFreelancePostRequest $request)
    {
        try {
            $user=Auth::user();
            $seeker = Seeker::where('user_id', $user->id)->first();

            $applicant= ApplicantsFreelancePost::create([
                'seeker_id'=>$seeker->id,
                'freelance_post_id'=>$request->freelance_post_id,
            ]);

        } catch (Exception $e) {
            Log::error('Error while applicant on freelance post :' . $e->getMessage());
            return response()->json([
                'data' => '',
                'message' => 'An error occurred while applicant on freelance post',
                'status' => 500,
            ], 500);
        }
        $applicant->load(['freelance_post']);
        return response()->json([
            'data' =>  ApplicantFreelancePostResource::collection(collect([$applicant])),
            'message' => ' applicant on freelance post added  successfully',
            'status' => 200,
        ],200);

    }

    /**
     * Display the specified resource.
     */
    public function show(ApplicantsFreelancePost $applicantsFreelancePost)
    {
        $applicantsFreelancePost->load(['freelance_post']);
        return ApplicantFreelancePostResource::collection(collect([$applicantsFreelancePost]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ApplicantsFreelancePost $applicantsFreelancePost)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApplicantsFreelancePostRequest $request, ApplicantsFreelancePost $applicantsFreelancePost)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ApplicantsFreelancePost $applicantsFreelancePost)
    {
        try {


            // $this->authorize('delete',$applicantsFreelancePost);
            $freelance=FreelancePost::where('id',$applicantsFreelancePost->freelance_post_id)->first();
            $freelance->applicants_freelance_post()->detach();

            if ($applicantsFreelancePost->delete()) {

                return response()->json([
                    'data' => '',
                    'message' => 'applicants deleted successfully',
                    'status' => 200,
                ], 200);
            }
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
