<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\FreelancePostsResource;
use App\Models\FreelancePost;
use App\Http\Requests\StoreFreelancePostRequest;
use App\Http\Requests\UpdateFreelancePostRequest;
use App\Models\RequiredSkill;
use App\Models\Seeker;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Log;

class FreelancePostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $freelancePosts = FreelancePost::with('category','skill')->get();
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

            $freelancepost = FreelancePost::create([
                'seeker_id' => $request->seeker_id,
                'company_id' => $request->company_id,
                'category_id' => $request->category_id,
                'title' => $request->title,
                'description' => $request->description,
                'delivery_date' => $request->delivery_date,
                'min_budget' => $request->min_budget,
                'max_budget' => $request->max_budget,
            ]);

            if ($request->has('skill_ids') && is_array($request->skill_ids)) {
                foreach ($request->skill_ids as $skill_id) {
                    RequiredSkill::create([
                        'freelance_post_id' => $freelancepost->id,
                        'skill_id' => $skill_id,
                    ]);
                }
            }
           } catch (Exception $e) {
             Log::error('Error creating freelance :' . $e->getMessage());
           return response()->json([
             'data' => '',
           'message' => 'An error occurred while creating the freelance post',
         'status' => 500,
        ], 500);
         }
        $freelancepost->load([ 'category', 'skill']);
        return response()->json([
            'data' => new FreelancePostsResource($freelancepost),
            'message' => ' freelance post created successfully',
            'status' => 200,
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(FreelancePost $freelancePost)
    {
        return new FreelancePostsResource($freelancePost->load(['category','skill']));
    }

    public function getFreelancePosts(Seeker $seeker)
    {
        try {
            try {
                $this->authorize('view', $seeker);

            }catch (AuthorizationException $e){
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                ], 403);
            }
            $freelancePost = FreelancePost::with(['category', 'skill'])
                ->where('seeker_id', $seeker->id)
                ->get();
            if ($freelancePost->isEmpty()) {
                return response()->json([
                    'data' => [],
                    'message' => 'No freelance posts found for this seeker',
                    'status' => 404,
                ], 404);
            }

            return response()->json([
                'data' => FreelancePostsResource::collection($freelancePost),
                'message' => 'Freelance posts retrieved successfully',
                'status' => 200,
            ], 200);
        } catch (Exception $e) {
            Log::error('Error retrieving seeker freelance posts: ' . $e->getMessage());
            return response()->json([
                'data' => [],
                'message' => 'An error occurred while retrieving freelance posts',
                'status' => 500,
            ], 500);
        }
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

      $freelancePost = FreelancePost::findOrFail($freelancePost->id);
      try {
              try {
                  $this->authorize('update', $freelancePost);

              }catch (AuthorizationException $e){
                  return response()->json([
                      'success' => false,
                      'message' => $e->getMessage(),
                  ], 403);
              }

        $validated = $request->validated();
        if (!$validated) {
            return response()->json([
                'data' => '',
                'message' => $request->errors()->all(),
                'status' => 422,
            ]);
        }

        $freelancePost->update($request->except(['seeker_id', 'company_id']));

        if ($request->has('skill_ids') && is_array($request->skill_ids)) {

            $freelancePost->skill()->detach();

            foreach ($request->skill_ids as $skill_id) {
                $freelancePost->skill()->attach($skill_id);
            }
        }
        $freelancePost->save();

        }catch (Exception $e) {
               Log::error('Error while updating  freelance :' . $e->getMessage());
               return response()->json([
                   'data' => '',
                   'message' => 'An error occurred while update the freelance post',
                   'status' => 500,
               ], 500);
           }

        return response()->json([
            'data' => new FreelancePostsResource( $freelancePost->load(['category', 'skill'])),
            'message' => ' freelance post updated successfully',
            'status' => 200,
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FreelancePost $freelancePost)
    {
        try {
            $freelancePost->skill()->detach();

            $freelancePost->delete();

            return response()->json([
                'data' => '',
                'message' => 'Freelance post deleted successfully',
                'status' => 200,
            ], 200);

        } catch (Exception $e) {
            Log::error('Error deleting freelance post: ' . $e->getMessage());
            return response()->json([
                'data' => '',
                'message' => 'An error occurred while deleting the freelance post',
                'status' => 500,
            ], 500);
        }
    }
}
