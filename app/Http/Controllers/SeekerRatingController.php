<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRatingRequest;
use App\Models\Company;
use App\Models\CompanyRating;
use App\Models\Seeker;
use App\Models\SeekerRating;
use App\Http\Requests\StoreSeekerRatingRequest;
use App\Http\Requests\UpdateSeekerRatingRequest;
use Exception;
use Illuminate\Support\Facades\Log;

class SeekerRatingController extends Controller
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
    public function store(StoreSeekerRatingRequest $request)
    {

        try {
            if ($request->has('rater_seeker_id')) {

                $existingRating = SeekerRating::where('seeker_id', $request->input('seeker_id'))
                    ->where('rater_seeker_id', $request->input('rater_seeker_id'))
                    ->first();
                if ($existingRating) {
                    return response()->json([
                        'data' => '',
                        'message' => 'you already rated this seeker',
                        'status' => 400
                    ], 400);
                }
                $seekerRating = SeekerRating::create([
                    'seeker_id' => $request->input('seeker_id'),
                    'rater_seeker_id' => $request->input('rater_seeker_id'),
                    'rating' => $request->input('rating'),
                ]);
                $seekerId = $request->input('seeker_id');

                $averageRating = round(SeekerRating::where('seeker_id', $seekerId)
                    ->avg('rating'));

                Seeker::where('id', $seekerId)->update(['rating' => $averageRating]);

                return response()->json([
                    'rating' => $seekerRating->rating,
                    'data' => '',
                    'message' => 'Seeker rated successfully',
                    'status' => 200
                ], 200);


            } elseif ($request->has('rater_company_id')) {
                $existingRating = SeekerRating::where('seeker_id', $request->input('seeker_id'))
                    ->where('rater_company_id', $request->input('rater_company_id'))
                    ->first();
                if ($existingRating) {
                    return response()->json([
                        'data' => '',
                        'message' => 'company has already rated this seeker',
                        'status' => 400
                    ], 400);
                }
                $seekerRating = SeekerRating::create([
                    'seeker_id' => $request->input('seeker_id'),
                    'rater_company_id' => $request->input('rater_company_id'),
                    'rating' => $request->input('rating'),
                ]);
                $seekerId = $request->input('seeker_id');

                $averageRating = round(SeekerRating::where('seeker_id', $seekerId)
                    ->avg('rating'));

                Seeker::where('id', $seekerId)->update(['rating' => $averageRating]);

                return response()->json([
                    'rating' => $seekerRating->rating,
                    'data' => '',
                    'message' => 'Seeker rated successfully',
                    'status' => 200
                ], 200);
            } else {
                return response()->json([
                    'data' => '',
                    'message' => 'No valid rater provided',
                    'status' => 400
                ], 400);
            }

        } catch (Exception $e) {
                $errorMessage = 'Error creating rating: ' . $e->getMessage();
                Log::error($errorMessage, ['trace' => $e->getTraceAsString()]);
                return response()->json([
                    'data' => '',
                    'message' => $errorMessage,
                    'status' => 500
                ], 500);
            }

    }

    /**
     * Display the specified resource.
     */
    public function show(SeekerRating $seekerRating)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SeekerRating $seekerRating)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSeekerRatingRequest $request, SeekerRating $seekerRating)
    {
        try {
                $seekerRating->update([
                    'rating' => $request->input('rating'),
                ]);
                    $seekerId = $request->input('seeker_id');
                    $averageRating = round(SeekerRating::where('seeker_id', $seekerId)->avg('rating'));

                    Seeker::where('id', $seekerId)->update(['rating' => $averageRating]);

                    return response()->json([
                        'rating' => $seekerRating->rating,
                        'data' => '',
                        'message' => 'Seeker rating updated successfully',
                        'status' => 200
                    ], 200);

        } catch (Exception $e) {
            Log::error('Error updating company: ' . $e->getMessage());
            return response()->json([
                'data' => '',
                'message' => 'An error occurred while updating the company',
                'status' => 500
            ], 500);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SeekerRating $seekerRating)
    {
        try {
             $seekerId = $seekerRating->seeker_id;
                $seekerRating->delete();

                // Calculate the average rating for the company
                $averageRating = round(SeekerRating::where('seeker_id', $seekerId)
                    ->avg('rating'));

                // Update the company's rating
                Seeker::where('id', $seekerId)
                    ->update(['rating' => $averageRating]);

                return response()->json([
                    'data' => '',
                    'message' => 'Rating deleted successfully',
                    'status' => 200
                ], 200);

        } catch (Exception $e) {
            Log::error('Error deleting rating: ' . $e->getMessage());
            return response()->json([
                'data' => '',
                'message' => 'An error occurred while deleting the rating',
                'status' => 500
            ], 500);
        }
    }
}
