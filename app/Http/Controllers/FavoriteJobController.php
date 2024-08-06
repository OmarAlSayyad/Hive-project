<?php

namespace App\Http\Controllers;

use App\Http\Resources\FavoriteJobResource;
use App\Models\FavoriteJob;
use App\Http\Requests\StoreFavoriteJobRequest;
use App\Http\Requests\UpdateFavoriteJobRequest;
use App\Models\Seeker;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FavoriteJobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function getMyFavoriteJobs()
    {
        try {
            $user = Auth::user();
            $seeker = Seeker::where('user_id', $user->id)->first();



            if ($seeker){
                $favorites=FavoriteJob::with(['job_post'])
                    ->where('seeker_id', $seeker->id)
                    ->get();
            }

            if ($favorites->isEmpty()) {
                return response()->json([
                    'data' => [],
                    'message' => 'No favorite jobs  was found ',
                    'status' => 404,
                ], 404);
            }

            return response()->json([
                'data' => FavoriteJobResource::collection($favorites),
                'message' => 'favorite jobs retrieved successfully',
                'status' => 200,
            ], 200);

        } catch (Exception $e) {
            Log::error('Error retrieving seeker favorite jobs: ' . $e->getMessage());
            return response()->json([
                'data' => [],
                'message' => 'An error occurred while retrieving favorite jobs',
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
    public function store(StoreFavoriteJobRequest $request)
    {
        try {
            $user=Auth::user();
            $seeker = Seeker::where('user_id', $user->id)->first();

            $existingFavorite = FavoriteJob::where('seeker_id', $seeker->id)
                ->where('job_post_id', $request->job_post_id)
                ->first();

            if ($existingFavorite) {
                return response()->json([
                    'data' => [],
                    'message' => 'You have already added this job post',
                    'status' => 409,
                ], 409);
            }


            $favorite= FavoriteJob::create([
                'seeker_id'=>$seeker->id,
                'job_post_id'=>$request->job_post_id,
            ]);

        } catch (Exception $e) {
            Log::error('Error while adding job post to favorite :' . $e->getMessage());
            return response()->json([
                'data' => '',
                'message' => 'An error occurred while adding job post to favorite',
                'status' => 500,
            ], 500);
        }
        $favorite->load(['job_post']);
        return response()->json([
            'data' =>  FavoriteJobResource::collection(collect([$favorite])),
            'message' => ' job post added  successfully',
            'status' => 200,
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(FavoriteJob $favoriteJob)
    {
        $favoriteJob=FavoriteJob::findOrFail($favoriteJob->id);
        $favoriteJob->load(['job_post']);
        return FavoriteJobResource::collection([$favoriteJob]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FavoriteJob $favoriteJob)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFavoriteJobRequest $request, FavoriteJob $favoriteJob)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FavoriteJob $favoriteJob)
    {
        try {


            $this->authorize('delete',$favoriteJob);
            $favoriteJob=FavoriteJob::findOrFail($favoriteJob->id);

            if ($favoriteJob) {
                $favoriteJob->delete();
                return response()->json([
                    'data' => '',
                    'message' => 'this post  deleted successfully',
                    'status' => 200,
                ], 200);
            }
        }
        catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 403);
        }
        catch (Exception $e) {
            Log::error('Error deleting favorite job: ' . $e->getMessage());
            return response()->json([
                'data' => '',
                'message' => 'An error occurred while deleting this post',
                'status' => 500,
            ], 500);
        }



    }
}
