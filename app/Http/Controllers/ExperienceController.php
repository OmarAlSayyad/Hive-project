<?php

namespace App\Http\Controllers;

use App\Http\Resources\ExperienceResource;
use App\Models\Experience;
use App\Http\Requests\StoreExperienceRequest;
use App\Http\Requests\UpdateExperienceRequest;
use App\Models\Seeker;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ExperienceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $experiences = Experience::all();
        return ExperienceResource::collection($experiences);
    }

    public function getMyExperiences(){
        try {
            $user = Auth::user() ;
            $seeker = Seeker::where('user_id',$user->id)->first();
            if ($seeker)
            {
                $experience = Experience::where('seeker_id', $seeker->id)->get();
            }
            if ($experience->isEmpty())
            {
                return response()->json([
                    'data' => [],
                    'message' => 'No experiences was found for this seeker ',
                    'status' => 404,
                ], 404);
            }
            return response()->json([
                'data' => ExperienceResource::collection($experience),
                'message' => 'Experiences retrieved successfully',
                'status' => 200,
            ], 200);
        } catch (Exception $e) {
            Log::error('Error retrieving seeker experiences: ' . $e->getMessage());
            return response()->json([
                'data' => [],
                'message' => 'An error occurred while retrieving experiences',
                'status' => 500,
            ], 500);
        }
    }

    public function getExperiencesById(Seeker $seeker)
    {
        try {
            $experience= Experience::where('seeker_id', $seeker->id)->get();
            if ($experience->isEmpty()) {
                return response()->json([
                    'data' => [],
                    'message' => 'No experience found for this seeker',
                    'status' => 404,
                ], 404);
            }
            return response()->json([
                'data' => ExperienceResource::collection($experience),
                'message' => 'Experience retrieved successfully',
                'status' => 200,
            ], 200);
        } catch (Exception $e) {
            Log::error('Error retrieving seeker experience: ' . $e->getMessage());
            return response()->json([
                'data' => [],
                'message' => 'An error occurred while retrieving experiences',
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
    public function store(StoreExperienceRequest $request)
    {
        try
        {
            $user=Auth::user();
            $seeker = Seeker::where('user_id', $user->id)->first();

             $experience=Experience::create([
                'seeker_id'=>$seeker->id,
                'job_title'=>$request->job_title,
                'company_name'=>$request->company_name,
                'job_description'=>$request->job_description,
                'start_date'=>$request->start_date,
                'end_date'=>$request->end_date,
            ]);
        }catch (Exception $e) {
            Log::error('Error while adding experience :' . $e->getMessage());
            return response()->json([
                'data' => '',
                'message' => 'An error occurred while adding experience',
                'status' => 500,
            ], 500);
        }
        return response()->json([
            'data' =>  ExperienceResource::collection(collect([$experience])),
            'message' => ' experience added  successfully',
            'status' => 200,
            ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Experience $experience)
    {
        $experience = Experience::findOrFail($experience->id);
        return ExperienceResource::collection([$experience]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Experience $experience)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExperienceRequest $request, Experience $experience)
    {
        try {
        $this->authorize('update',$experience);

        $experience=Experience::findOrFail($experience->id);

        $experience->update($request->except(['seeker_id']));

        $experience->save();

        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 403);
        } catch (Exception $e) {
            Log::error('Error while updating  experience :' . $e->getMessage());
            return response()->json([
                'data' => '',
                'message' => 'An error occurred while update the experience',
                'status' => 500,
            ], 500);
        }
            return response()->json([
                'data' => ExperienceResource::collection(collect([$experience])),
                'message' => ' experience updated successfully',
                'status' => 200,
            ], 200);
        }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Experience $experience)
    {
        try {
            $this->authorize('delete',$experience);
            $experience->delete();
            return response()->json([
                'data' => '',
                'message' => 'experience deleted successfully',
                'status' => 200,
            ], 200);
        }
        catch (Exception $e) {
            Log::error('Error deleting experience: ' . $e->getMessage());
            return response()->json([
                'data' => '',
                'message' => 'An error occurred while deleting this experience',
                'status' => 500,
            ], 500);
        }
    }
}
