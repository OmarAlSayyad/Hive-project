<?php

namespace App\Http\Controllers;

use App\Http\Resources\SeekerResource;
use App\Models\Freelance_Post;
use App\Http\Requests\StoreFreelance_PostRequest;
use App\Http\Requests\UpdateFreelance_PostRequest;
use Exception;
use Illuminate\Support\Facades\Log;

class FreelancePostController extends Controller
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

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFreelance_PostRequest $request)
    {
        try {
            $validated = $request->validated();
            if (!$validated) {
                return response()->json([
                    'data' => '',
                    'message' => $request->errors()->all(),
                    'status' => 422,
                ]);
            }
            $freelancepost = Freelance_Post::create([
                'seeker_id' => $request->seeker_id,
                'company_id'=>$request->company_id,
                'category_id' => $request->category_id,
                'title' => $request->title,
                'description' => $request->description,
                'delivery_date' => $request->delivery_date,
                'min_budget' => $request->min_budget,
                'max_budget' => $request->max_budget,

            ]);
        } catch (Exception $e) {
            Log::error('Error creating freelance :' . $e->getMessage());
            return response()->json([
                'data' => '',
                'message' => 'An error occurred while creating the freelance post',
                'status' => 500,
            ], 500);
        }
        return response()->json([
           // 'data' =>  new SeekerResource($seeker->load(['user', 'location', 'communication'])),
            'message' => ' freelance post created successfully',
            'status' => 200,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Freelance_Post $freelance_Post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Freelance_Post $freelance_Post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFreelance_PostRequest $request, Freelance_Post $freelance_Post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Freelance_Post $freelance_Post)
    {
        //
    }
}
