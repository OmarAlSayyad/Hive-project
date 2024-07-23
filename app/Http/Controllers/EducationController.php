<?php

namespace App\Http\Controllers;

use App\Http\Resources\EducationResource;
use App\Models\Education;
use App\Http\Requests\StoreEducationRequest;
use App\Http\Requests\UpdateEducationRequest;
use App\Models\Seeker;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EducationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function getMyEducations(){
        try {
            $user=Auth::user();
            $seeker = Seeker::where('user_id', $user->id)->first();
            if ($seeker) {
                $education = Education::where('seeker_id', $seeker->id)->get();
            }

            if ($education->isEmpty()) {
                return response()->json([
                    'data' => [],
                    'message' => 'No education certificate was found for this seeker ',
                    'status' => 404,
                ], 404);
            }

            return response()->json([
                'data' => EducationResource::collection($education),
                'message' => 'Education certificate retrieved successfully',
                'status' => 200,
            ], 200);
        } catch (Exception $e) {
            Log::error('Error retrieving seeker  certificates: ' . $e->getMessage());
            return response()->json([
                'data' => [],
                'message' => 'An error occurred while retrieving education certificates',
                'status' => 500,
            ], 500);
        }
    }


    public function getEducationsById(Seeker $seeker)
    {
        try {

            $education= Education::where('seeker_id', $seeker->id)->get();
            if ($education->isEmpty()) {
                return response()->json([
                    'data' => [],
                    'message' => 'No education certificates found for this seeker',
                    'status' => 404,
                ], 404);
            }

            return response()->json([
                'data' => EducationResource::collection($education),
                'message' => 'education certificates retrieved successfully',
                'status' => 200,
            ], 200);

        } catch (Exception $e) {
            Log::error('Error retrieving seeker certificates: ' . $e->getMessage());
            return response()->json([
                'data' => [],
                'message' => 'An error occurred while retrieving education certificates',
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
    public function store(StoreEducationRequest $request)
    {

        try {
            $user=Auth::user();
            $seeker = Seeker::where('user_id', $user->id)->first();

            $education=Education::create([
                'seeker_id'=>$seeker->id,
                'institution_name'=> $request->institution_name,
                'field_of_study'=> $request->field_of_study,
                'start_date'=> $request->start_date,
                'graduation_date'=> $request->graduation_date,
                'graduation_degree'=> $request->graduation_degree,
                'scientific_level'=> $request->scientific_level,
            ]);
        } catch (Exception $e) {
            Log::error('Error while adding education certificate :' . $e->getMessage());
            return response()->json([
                'data' => '',
                'message' => 'An error occurred while adding education certificate',
                'status' => 500,
            ], 500);
        }

        return response()->json([
            'data' =>  EducationResource::make($education),
            'message' => ' education certificate added  successfully',
            'status' => 200,
        ],200);

    }

    /**
     * Display the specified resource.
     */
    public function show(Education $education)
    {
        return EducationResource::make($education);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Education $education)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEducationRequest $request, Education $education)
    {
        try {
            $this->authorize('update',$education);

            $education=Education::findOrFail($education->id);

            $education->update($request->except(['seeker_id']));

            $education->save();

        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 403);
        } catch (Exception $e) {
            Log::error('Error while updating  the education certificate :' . $e->getMessage());
            return response()->json([
                'data' => '',
                'message' => 'An error occurred while update the education certificate',
                'status' => 500,
            ], 500);
        }

        return response()->json([
            'data' => EducationResource::make($education),
            'message' => ' education certificate updated successfully',
            'status' => 200,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Education $education)
    {
        try {
            $this->authorize('delete',$education);

            $education->delete();

            return response()->json([
                'data' => '',
                'message' => 'education certificate deleted successfully',
                'status' => 200,
            ], 200);
        }
        catch (Exception $e) {
            Log::error('Error deleting education certificate: ' . $e->getMessage());
            return response()->json([
                'data' => '',
                'message' => 'An error occurred while deleting this education certificate',
                'status' => 500,
            ], 500);
        }
    }
}
