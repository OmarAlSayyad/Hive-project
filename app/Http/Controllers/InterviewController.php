<?php

namespace App\Http\Controllers;

use App\Http\Resources\InterviewResource;
use App\Models\Company;
use App\Models\Interview;
use App\Http\Requests\StoreInterviewRequest;
use App\Http\Requests\UpdateInterviewRequest;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class InterviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $interviews= Interview::all();
        return InterviewResource::collection($interviews);
    }


    public function seekerAcceptInterview(Request $request ,Interview $interview)
    {
        try
        {
            $interview = Interview::findOrFail($interview->id);
            $interview->update($request->only(['result']));


        } catch (AuthorizationException $e)
        {
            return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
            ], 403);
        }
            return response()->json([
                'data' => InterviewResource::collection(collect([$interview])),
                'message' => ' Interview updated successfully',
                'status' => 200,
            ], 200);


    }


    public function companyInterview(Company $company)
    {
        try {

            //Log::info('Received company ID: ' . $company);

            $interviews = Interview::where('company_id', $company->id)->get();

            if ($interviews->isEmpty()) {
                return response()->json([
                    'data' => [],
                    'message' => 'No interview found for this company',
                    'status' => 404,
                ], 404);
            }

            return response()->json([
                'data' => InterviewResource::collection($interviews),
                'message' => ' Interview retrieved successfully',
                'status' => 200,
            ], 200);

        } catch (Exception $e) {
            Log::error('Error retrieving company job posts: ' . $e->getMessage());
            return response()->json([
                'data' => [],
                'message' => 'An error occurred while retrieving interview',
                'status' => 500,
            ], 500);
        }
    }
    public function getMyInterview()
    {
        try {
            // $this->authorize('view', $company);
            $user = Auth::user();
            $company=Company::where('user_id', $user->id)->first();

            $interviews = Interview::where('company_id', $company->id)->get();

            if ($interviews->isEmpty()) {
                return response()->json([
                    'data' => [],
                    'message' => 'No interview found for this company',
                    'status' => 404,
                ], 404);
            }

            return response()->json([
                'data' => InterviewResource::collection($interviews),
                'message' => ' Interview retrieved successfully',
                'status' => 200,
            ], 200);

            } catch (Exception $e)
        {
            Log::error('Error retrieving company interview : ' . $e->getMessage());
            return response()->json([
                'data' => [],
                'message' => 'An error occurred while retrieving interview ',
                'status' => 500,
            ], 500);
        }
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
    public function store(StoreInterviewRequest $request)
    {
        try {
            $user = Auth::user();
            $company=Company::where('user_id', $user->id)->first();
            if($company)
            {
                $interview = Interview::create([
                    'company_id' => $company->id,
                    'seeker_id'=>$request->seeker_id,

                    'scheduled_at'=>$request->scheduled_at,
                    'started_at'=>$request->started_at,
                    'ended_at'=>$request->ended_at,
                    'address'=>$request->address,
                    'notes'=>$request->notes,
                ]);
            }
             } catch (Exception $e) {
            Log::error('Error creating interview :' . $e->getMessage());
            return response()->json([
                'data' => '',
                'message' => 'An error occurred while creating the interview ',
                'status' => 500,
            ], 500);
        } finally {
            return response()->json([
                'data' =>  InterviewResource::collection(collect([$interview])),
                'message' => ' interview created successfully',
                'status' => 200,
            ],200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Interview $interview)
    {
        return InterviewResource::collection(collect([$interview]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Interview $interview)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInterviewRequest $request, Interview $interview)
    {
        try {
        $interview = Interview::findOrFail($interview->id);

       // $this->authorize('update', $interview);

        $interview->update($request->only(['seeker_id','scheduled_at',
            'started_at','ended_at','address', 'notes']));


        } catch (AuthorizationException $e) {
            return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
            ], 403);
        }
            return response()->json([
                'data' => InterviewResource::collection(collect([$interview])),
                'message' => ' Interview updated successfully',
                'status' => 200,
            ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Interview $interview)
    {
        try {
            $interview->delete();

            return response()->json([
                'data' => '',
                'message' => ' Interview deleted successfully',
                'status' => 200,
            ], 200);

        } catch (Exception $e) {
            Log::error('Error deleting interview : ' . $e->getMessage());
            return response()->json([
                'data' => '',
                'message' => 'An error occurred while deleting the interview',
                'status' => 500,
            ], 500);
        }
    }
}
