<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyRating;
use App\Http\Requests\StoreCompanyRatingRequest;
use App\Http\Requests\UpdateCompanyRatingRequest;
use Exception;
use Illuminate\Support\Facades\Log;

class CompanyRatingController extends Controller
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
    public function store(StoreCompanyRatingRequest $request)
    {
        try {
            $existingRating = CompanyRating::where('company_id', $request->input('company_id'))
                ->where('rater_seeker_id', $request->input('rater_seeker_id'))
                ->first();

            if ($existingRating) {
                return response()->json([
                    'data' => '',
                    'message' => 'Seeker has already rated this company',
                    'status' => 400
                ], 400);
            }

            $companyRating = CompanyRating::create([
                'company_id' => $request->input('company_id'),
                'rater_seeker_id' => $request->input('rater_seeker_id'),
                'rating' => $request->input('rating'),
            ]);

            $companyId = $request->input('company_id');

            $averageRating = round(CompanyRating::where('company_id', $companyId)
                ->avg('rating'));

            Company::where('id', $companyId)->update(['rating' => $averageRating]);

            return response()->json([
                'rating' => $companyRating->rating,
                'data' => '',
                'message' => 'Rating created successfully',
                'status' => 200
            ], 200);

        } catch (Exception $e) {
            Log::error('Error creating rating: ' . $e->getMessage());
            return response()->json([
                'data' => '',
                'message' => 'An error occurred while creating the rating',
                'status' => 500
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(CompanyRating $companyRating)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CompanyRating $companyRating)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRatingRequest $request, CompanyRating $companyRating)
    {
        try {
            $companyRating->update([
                'rating' => $request->input('rating'),
            ]);

            // Calculate the average rating for the company
            $averageRating = round(CompanyRating::where('company_id', $companyRating->company_id)
                ->avg('rating'));

            // Update the company's rating
            Company::where('id', $companyRating->company_id)
                ->update(['rating' => $averageRating]);

            return response()->json([
                'id' => $companyRating->id,
                'rating' => $companyRating->rating,
                'data' => '',
                'message' => 'Rating updated successfully',
                'status' => 200
            ], 200);

        } catch (Exception $e) {
            Log::error('Error updating rating: ' . $e->getMessage());
            return response()->json([
                'data' => '',
                'message' => 'An error occurred while updating the rating',
                'status' => 500
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CompanyRating $companyRating)
    {
        try {

            if ($companyRating) {
                $companyId = $companyRating->company_id;
                $companyRating->delete();

                // Calculate the average rating for the company
                $averageRating = round(CompanyRating::where('company_id', $companyId)
                    ->avg('rating'));

                // Update the company's rating
                Company::where('id', $companyId)
                    ->update(['rating' => $averageRating]);

                return response()->json([
                    'rating' => $companyRating->rating,
                    'data' => '',
                    'message' => 'Rating deleted successfully',
                    'status' => 200
                ], 200);
            } else {
                return response()->json([
                    'data' => '',
                    'message' => 'Rating not found',
                    'status' => 404
                ], 404);
            }

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
