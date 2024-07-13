<?php

namespace App\Http\Controllers;

use App\Http\Resources\SeekerResource;
use App\Models\Communication;
use App\Models\FreelancePost;
use App\Models\Locations;
use App\Models\Seeker;
use App\Http\Requests\StoreSeekerRequest;
use App\Http\Requests\UpdateSeekerRequest;
use App\Models\User;
use App\Models\Wallet;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SeekerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $seekers = Seeker::with('user', 'location', 'communication')->get();
        return SeekerResource::collection($seekers);
    }

    public function getMySeeker()
    {
        try {
            $user = Auth::user();
            $seeker = Seeker::where('user_id', $user->id)->first();

            if (!$seeker) {
                return response()->json([
                    'message' => 'Seeker profile not found for the current user',
                    'status' => 404
                ], 404);
            }
            $seeker->load(['user', 'location', 'communication']);
            return SeekerResource::collection(collect([$seeker]));
        } catch (\Exception $e) {
            Log::error('Error retrieving seeker: ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to retrieve seeker',
                'status' => 500
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
    public function store(StoreSeekerRequest $request)
    {
        $user = Auth::user();
        try {
            $validated = $request->validated();
            if (!$validated) {
                return response()->json([
                    'data' => '',
                    'message' => $request->errors()->all(),
                    'status' => 422,
                ]);
            }
            $existingSeeker = Seeker::where('user_id', $user->id)->first();
            if ($existingSeeker) {
                return response()->json([
                    'data' => '',
                    'message' => 'User already exist',
                    'status' => 500,
                ]);
            }
            try {
                $location = Locations::create([
                    'address' => $request->input('address', null),
                    'country' => $request->input('country', null),
                    'city' => $request->input('city', null),
                ]);
            } catch (Exception $e) {
                Log::error('Error creating location :' . $e->getMessage());
                return response()->json([
                    'data' => '',
                    'message' => 'An error occurred while creating the location',
                    'status' => 500,
                ]);
            }

            try {
                $communication = Communication::create([
                    'mobile_phone' => $request->input('mobile_phone', null),
                    'line_phone' => $request->input('line_phone', null),
                    'website' => $request->input('website', null),
                    'linkedin_account' => $request->input('linkedin_account', null),
                    'github_account' => $request->input('github_account', null),
                    'facebook_account' => $request->input('facebook_account', null),
                ]);
            } catch (\Exception $e) {
                Log::error('Error creating communication :' . $e->getMessage());
                return response()->json([
                    'data' => '',
                    'message' => 'An error occurred while creating the communication',
                    'status' => 500,
                ]);

            }
            $picture = $request->file('picture');
            if ($picture) {
                $pictureName = Str::random(32) . "." . $picture->getClientOriginalExtension();
                Storage::disk('public')->put($pictureName, file_get_contents($picture));
            } else {
                $pictureName = null;
            }

            $cv = $request->file('cv');
            if ($cv) {
                $cvName = Str::random(32) . "." . $cv->getClientOriginalExtension();
                Storage::disk('public')->put($cvName, file_get_contents($cv));
            } else {
                $cvName = null;
            }

            try {
                $seeker = Seeker::create([
                    'user_id' => $user->id,
                    'communication_id' => $communication->id,
                    'location_id' => $location->id,
                    'cv' => $cvName,
                    'level' => $request->input('level', 'Beginner'),
                    'picture' => $pictureName,
                    'bio' => $request->input('bio', null),
                    'gender' => $request->input('gender', 'Not_determined'),
                    'hourly_rate' => $request->input('hourly_rate', null),
                    'birth_date' => $request->input('birth_date', null),

                ]);
            } catch (Exception $e) {
                Log::error('Error creating seeker :' . $e->getMessage());
                return response()->json([
                    'data' => '',
                    'message' => 'An error occurred while creating the seeker',
                    'status' => 500,
                ], 500);
            }
            try {
                $wallet1 = Wallet::create([
                    'seeker_id' => $seeker->id,
                    'balance' => $request->input('balance', 0),
                    'type' => $request->input('type', 'Total'),
                ]);
                $wallet2 = Wallet::create([
                    'seeker_id' => $seeker->id,
                    'balance' => $request->input('balance', 0),
                    'type' => $request->input('type', 'Retractable'),
                ]);
            } catch (Exception $e) {
                Log::error('Error creating Wallet: ' . $e->getMessage());
                return response()->json([
                    'data' => '',
                    'message' => 'An error occurred while creating the Wallet',
                    'status' => 500
                ], 500);
            }
            $seeker->load(['user', 'location', 'communication']);
            return response()->json([
                'data' =>  SeekerResource::collection(collect([$seeker])),
                'message' => 'seeker registered successfully',
                'status' => 200,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'data' => '',
                'message' => $e->getMessage(),
                'status' => 404,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'data' => '',
                'message' => 'An error occurred while processing request',
                'status' => 500,
            ]);
        }

    }


    /**
     * Display the specified resource.
     */
    public function show(Seeker $seeker)
    {
        $seeker->load(['user', 'location', 'communication']);
        return SeekerResource::collection(collect([$seeker]));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Seeker $seeker)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSeekerRequest $request)
    {

       // $seeker = Seeker::findOrFail($seeker->id);

        $user = Auth::user();
        $seeker = Seeker::where('user_id', $user->id)->first();

        try {
            $this->authorize('update', $seeker);

            if ($request->hasAny(['address', 'city', 'country'])) {
                $seeker->location()->update($request->only(['address', 'city', 'country']));
            }

            if ($request->hasAny(['mobile_phone', 'line_phone', 'website', 'linkedin_account', 'github_account', 'facebook_account'])) {
                $seeker->communication()->update($request->only(['mobile_phone', 'line_phone', 'website', 'linkedin_account', 'github_account', 'facebook_account']));
            }

            $seeker->update($request->except(['user_id', 'location_id', 'communication_id']));

            $picture = $request->file('picture');
            if ($picture) {
                $pictureName = Str::random(32) . "." . $picture->getClientOriginalExtension();
                Storage::disk('public')->put($pictureName, file_get_contents($picture));

                if ($seeker->picture) {
                    Storage::disk('public')->delete($seeker->picture);
                }

                $seeker->picture = $pictureName;
            }
                $cv = $request->file('cv');
                if ($cv) {
                    $cvName = Str::random(32) . "." . $cv->getClientOriginalExtension();
                    Storage::disk('public')->put($cvName, file_get_contents($cv));

                    if ($seeker->cv) {
                        Storage::disk('public')->delete($seeker->cv);
                    }

                    $seeker->cv = $cvName;
                    $seeker->save();
                }
            $seeker->load(['user', 'location', 'communication']);
                return response()->json([
                    'data' => SeekerResource::collection(collect([$seeker])),
                    'message' => 'Seeker updated successfully',
                    'status' => 200
                ], 200);
            } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'status' => 403,
            ], 403);
        }
    }






    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        try {

            //$this->authorize('delete', $seeker);
            $user = Auth::user();
            $seeker = Seeker::where('user_id', $user->id)->first();

            $freelancePosts = FreelancePost::
                where('seeker_id', $seeker->id)
                ->get();
            foreach ($freelancePosts as $freelancePost){

                $freelancePost->skill()->detach();
                $freelancePost->delete();


            }

            if ($seeker->picture) {
                Storage::disk('public')->delete($seeker->picture);
            }

            $seeker->wallet()->delete();

            $seeker->location()->delete();

            $seeker->communication()->delete();

            $seeker->delete();

            return response()->json([
                'data' =>'',
                'message' => 'Seeker profile deleted successfully',
                'status' => 200
            ], 200);
        } catch (AuthorizationException $e) {
            return response()->json([
                'data' =>'',
                'message' => $e->getMessage(),
                'status' => 403
            ], 403);
        } catch (\Exception $e) {
            return response()->json([
                'data' =>'',
                'message' => 'Failed to delete this seeker profile. ' . $e->getMessage(),
                'status' => 500
            ], 500);
        }

    }

}
