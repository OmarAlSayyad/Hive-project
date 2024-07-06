<?php

namespace App\Http\Controllers;

use App\Http\Resources\FreelancePostsResource;
use App\Models\FreelancePost;
use App\Http\Requests\StoreFreelancePostRequest;
use App\Http\Requests\UpdateFreelancePostRequest;
use Exception;
use Illuminate\Support\Facades\Log;

class FreelancePostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $freelancePosts = FreelancePost::with('seeker','category','skill')->get();
        return FreelancePostsResource::collection($freelancePosts);
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
    public function store(StoreFreelancePostRequest $request)
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
        $freelancepost = FreelancePost::create([
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
            'data' =>  new FreelancePostsResource($freelancepost->load(['seeker','category','skill'])),
            'message' => ' freelance post created successfully',
            'status' => 200,
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(FreelancePost $freelancePost)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FreelancePost $freelancePost)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFreelancePostRequest $request, FreelancePost $freelancePost)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FreelancePost $freelancePost)
    {
        //
    }
}
