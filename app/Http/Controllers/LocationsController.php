<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Models\Locations;
use App\Http\Requests\StoreLocationsRequest;
use App\Http\Requests\UpdateLocationsRequest;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class LocationsController extends Controller
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
    public function store(StoreCompanyRequest $request)
    {
//        $location =Locations::create([
//            'address' => $request->input('address',null),
//            'country' => $request->input('country',null),
//            'city' => $request->input('city',null),
//        ]);
//        return $location;
    }

    /**
     * Display the specified resource.
     */
    public function show(Locations $locations)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Locations $locations)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLocationsRequest $request, Locations $locations)
    {
        try {
            $validated = $request->validated();
            if (!$validated) {
                return response()->json([
                    'data' => '',
                    'message' => $request->errors()->all(),
                    'status' => 422
                ]);
            }
            $user = User::findOrFail($request->user_id);

            try {
            $location =Locations::create([
                'address' => $request->address,
                'country' => $request->country,
                'city' => $request->city,
            ]);
        }catch (Exception $e) {
            Log::error('Error creating location: ' . $e->getMessage());
            return response()->json([
                'data' => '',
                'message' => 'An error occurred while creating the location',
                'status' => 500
            ]);
        }
            return response()->json([
                'data' => $location,
                'message' => 'location created successfully',
                'status' => 201
            ]);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'data' => '',
                'message' => 'User not found',
                'status' => 404
            ], 404);
        } catch (Exception $e) {
            Log::error('Error processing request: ' . $e->getMessage());
            return response()->json([
                'data' => '',
                'message' => 'An error occurred while processing the request',
                'status' => 500
            ], 500);
        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Locations $locations)
    {
        //
    }
}
