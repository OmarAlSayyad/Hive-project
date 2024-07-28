<?php

namespace App\Http\Controllers;

use App\Http\Resources\SeekerSkillResource;
use App\Http\Resources\SkillsResource;
use App\Models\Seeker;
use App\Models\SeekerSkill;
use App\Http\Requests\StoreSeekerSkillRequest;
use App\Http\Requests\UpdateSeekerSkillRequest;
use App\Models\Skill;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SeekerSkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function getMySkills(){
        try {
            $user=Auth::user();
            $seeker = Seeker::where('user_id', $user->id)->first();
            if ($seeker) {
                $seekerSkill = SeekerSkill::where('seeker_id',$seeker->id)->get();
                //  $seekerSkill->name=Skill::where('id',$seekerSkill->skill_id)->first();

            }
            // return $seekerSkill;

            if ($seekerSkill->isEmpty()) {
                return response()->json([
                    'data' => [],
                    'message' => 'No skills was found for this seeker ',
                    'status' => 404,
                ], 404);
            }

            return response()->json([
                'data' => SeekerSkillResource::collection($seekerSkill),
                'message' => 'Skills retrieved successfully',
                'status' => 200,
            ], 200);
        } catch (Exception $e) {
            Log::error('Error retrieving seeker skills: ' . $e->getMessage());
            return response()->json([
                'data' => [],
                'message' => 'An error occurred while retrieving skills',
                'status' => 500,
            ], 500);
        }
    }


    public function getSkillsById(Seeker $seeker)
    {
        try {

            $seekerSkills= SeekerSkill::where('seeker_id', $seeker->id)->get();
            if ($seekerSkills->isEmpty()) {
                return response()->json([
                    'data' => [],
                    'message' => 'No skills found for this seeker',
                    'status' => 404,
                ], 404);
            }
            //$seekerSkills->name=Skill::where('id',$seekerSkills->skill_id)->get();

            return response()->json([
                'data' => SeekerSkillResource::collection($seekerSkills),
                'message' => 'Skills retrieved successfully',
                'status' => 200,
            ], 200);

        } catch (Exception $e) {
            Log::error('Error retrieving seeker skills: ' . $e->getMessage());
            return response()->json([
                'data' => [],
                'message' => 'An error occurred while retrieving skills',
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
    public function store(StoreSeekerSkillRequest $request)
    {
        try {
            $user = Auth::user();
            $seeker = Seeker::where('user_id', $user->id)->first();
            if ($seeker) {

                $skill= SeekerSkill::create([
                    'seeker_id' => $seeker->id,
                    'skill_id' => $request->skill_id,
                ]);
            }
            $skill->name=Skill::where('id',$skill->skill_id)->first();
        }
        catch (Exception $e) {
            Log::error('Error while adding skill:' . $e->getMessage());
            return response()->json([
                'data' => '',
                'message' => 'An error occurred while adding skill ',
                'status' => 500,
            ], 500);
        }

        return response()->json([
            'data' =>  SeekerSkillResource::collection(collect([$skill])),
            'message' => ' skill adding successfully',
            'status' => 200,
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(SeekerSkill $seekerSkill)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SeekerSkill $seekerSkill)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSeekerSkillRequest $request, SeekerSkill $seekerSkill)
    {
        // Ensure we find and load the SeekerSkill with its relationship
        $seekerSkill = SeekerSkill::with('skill')->findOrFail($seekerSkill->id);

        // Log the SeekerSkill and its relationship to debug
        Log::info('Updating SeekerSkill:', ['seekerSkill' => $seekerSkill, 'skill' => $seekerSkill->skill]);

        // Update the SeekerSkill
        $seekerSkill->update($request->except(['seeker_id']));

        // Reload the relationship
        $seekerSkill->load('skill');

        // Return the response using SeekerSkillResource
        return response()->json([
            'data' => new SeekerSkillResource($seekerSkill),
            'message' => 'Seeker skill updated successfully',
            'status' => 200,
        ], 200);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SeekerSkill $seekerSkill)
    {
        //try {
        // $seeker=Seeker::where('id',$seekerSkill->seeker_id)->first();


        // $seekerSkill = SeekerSkill::where('id',$seekerSkill->id)->first();
        $seekerSkill->delete();
        //  if($seekerSkill) {
        //$seekerSkill->delete();


        //  }

        return response()->json([
            'data' => '',
            'message' => 'seeker skill deleted successfully',
            'status' => 200,
        ], 200);

//        } catch (Exception $e) {
//            Log::error('Error deleting seeker skill: ' . $e->getMessage());
//            return response()->json([
//                'data' => '',
//                'message' => 'An error occurred while deleting seeker skill',
//                'status' => 500,
//            ], 500);
//        }
    }
}
