<?php

namespace App\Http\Controllers;

use App\Models\Communication;
use App\Http\Requests\StoreCommunicationRequest;
use App\Http\Requests\UpdateCommunicationRequest;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class CommunicationController extends Controller
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
    public function store(StoreCommunicationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Communication $communication)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Communication $communication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommunicationRequest $request,$userId)
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

            $location = Location::create([
                'user_id' => $userId,
                'country' => $request->country,
                'city' => $request->city,
                'address' => $request->address,
            ]);

            return response()->json([
                'data' => $location,
                'message' => 'Locations created successfully',
                'status' => 201
            ]);
        } catch (Exception $e) {
            Log::error('Error creating location: ' . $e->getMessage());
            return response()->json([
                'data' => '',
                'message' => 'An error occurred while creating the location',
                'status' => 500
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Communication $communication)
    {
        //
    }
}
