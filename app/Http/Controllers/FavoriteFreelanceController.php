<?php

namespace App\Http\Controllers;

use App\Http\Resources\FavoriteFreelanceResource;
use App\Models\FavoriteFreelance;
use App\Http\Requests\StoreFavoriteFreelanceRequest;
use App\Http\Requests\UpdateFavoriteFreelanceRequest;
use App\Models\Seeker;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FavoriteFreelanceController extends Controller
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

    public function getMyFavoriteFreelance()
    {
        try {
            $user = Auth::user();
            $seeker = Seeker::where('user_id', $user->id)->first();

            if ($seeker){
                $favorites=FavoriteFreelance::with(['freelance_post'])
                    ->where('seeker_id', $seeker->id)
                    ->get();
            }

            if ($favorites->isEmpty()) {
                return response()->json([
                    'data' => [],
                    'message' => 'No favorite freelances  was found ',
                    'status' => 404,
                ], 404);
            }

            return response()->json([
                'data' => FavoriteFreelanceResource::collection($favorites),
                'message' => 'favorite freelances retrieved successfully',
                'status' => 200,
            ], 200);

        } catch (Exception $e) {
            Log::error('Error retrieving seeker favorite freelances: ' . $e->getMessage());
            return response()->json([
                'data' => [],
                'message' => 'An error occurred while retrieving favorite freelances',
                'status' => 500,
            ], 500);
        }
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFavoriteFreelanceRequest $request)
    {
        try {
            $user=Auth::user();
            $seeker = Seeker::where('user_id', $user->id)->first();

            $existingFavorite = FavoriteFreelance::where('seeker_id', $seeker->id)
                ->where('freelance_post_id', $request->freelance_post_id)
                ->first();

            if ($existingFavorite) {
                return response()->json([
                    'data' => [],
                    'message' => 'You have already added this  freelance post',
                    'status' => 409,
                ], 409);
            }


            $favorite= FavoriteFreelance::create([
                'seeker_id'=>$seeker->id,
                'freelance_post_id'=>$request->freelance_post_id,
            ]);

        } catch (Exception $e) {
            Log::error('Error while adding freelance post to favorite :' . $e->getMessage());
            return response()->json([
                'data' => '',
                'message' => 'An error occurred while adding freelance post to favorite',
                'status' => 500,
            ], 500);
        }
        $favorite->load(['freelance_post']);
        return response()->json([
            'data' =>  FavoriteFreelanceResource::collection(collect([$favorite])),
            'message' => '  freelance post added  successfully',
            'status' => 200,
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(FavoriteFreelance $favoriteFreelance)
    {
        $favoriteFreelance=FavoriteFreelance::findOrFail($favoriteFreelance->id);
        $favoriteFreelance->load(['freelance_post']);
        return FavoriteFreelanceResource::collection([$favoriteFreelance]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FavoriteFreelance $favoriteFreelance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFavoriteFreelanceRequest $request, FavoriteFreelance $favoriteFreelance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FavoriteFreelance $favoriteFreelance)
    {
        try {


            $this->authorize('delete',$favoriteFreelance);
            $favoriteFreelance=FavoriteFreelance::findOrFail($favoriteFreelance->id);

            if ($favoriteFreelance) {
                $favoriteFreelance->delete();
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
            Log::error('Error deleting favorite freelance: ' . $e->getMessage());
            return response()->json([
                'data' => '',
                'message' => 'An error occurred while deleting this post',
                'status' => 500,
            ], 500);
        }



    }
}
