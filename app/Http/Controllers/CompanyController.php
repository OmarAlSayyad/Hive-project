<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompanyResource;
use App\Models\Communication;
use App\Models\Company;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Locations;
use App\Models\User;
use App\Models\Wallet;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CompanyController extends Controller
{


  //  protected $locationsController;
   // protected $communicationController;

//    public function __construct(CommunicationController $communicationController)
//    {
//        $this->communicationController = $communicationController;
//    }
//    public function __construct(LocationsController $locationsController)
//    {
//        $this->locationsController = $locationsController;
//    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::with('user','location', 'communication')->get();
        return response($companies);
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
                    'address' => $request->input('address',null),
                    'country' => $request->input('country',null),
                    'city' => $request->input('city',null),
                ]);
            }catch (Exception $e) {
                Log::error('Error creating location: ' . $e->getMessage());
                return response()->json([
                    'data' => '',
                    'message' => 'An error occurred while creating the location',
                    'status' => 500
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
            } catch (Exception $e) {
                Log::error('Error creating communication: ' . $e->getMessage());
                return response()->json([
                    'data' => '',
                    'message' => 'An error occurred while creating the communication',
                    'status' => 500
                ],500);
            }


            $picture = $request->file('picture');
            if ($picture) {
                $pictureName = Str::random(32) . "." . $picture->getClientOriginalExtension();
                Storage::disk('public')->put($pictureName, file_get_contents($picture));
            } else {
                $pictureName = null;
            }
            try {
                $company = Company::create([
                    'user_id' =>$user->id,
                    'location_id' => $location->id,
                    'communication_id' => $communication->id,
                    'picture' => $pictureName,
                    'rating' =>$request->input('rating',1),
                    'approved' =>$request->input('approved',false),
                    'industry' => $request->industry,
                    'description' => $request->description,
                ]);
            } catch (Exception $e) {
                Log::error('Error creating company: ' . $e->getMessage());
                return response()->json([
                    'data' => '',
                    'message' => 'An error occurred while creating the company',
                    'status' => 500
                ]);
            }
            try {
                $wallet = Wallet::create([
                    'company_id' => $company->id,
                    'balance' => $request->input('balance', 0),
                    'type' => $request->input('type', 'Total'),
                ]);
            } catch (Exception $e) {
                Log::error('Error creating Wallet: ' . $e->getMessage());
                return response()->json([
                    'data' => '',
                    'message' => 'An error occurred while creating the Wallet',
                    'status' => 500
                ],500);
            }
            return response()->json([
                'data' => new CompanyResource($company->load(['user', 'location', 'communication'])),
                'message' => 'Company registered successfully',
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
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        return new CompanyResource($company->load(['user', 'location', 'communication']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */


    public function update(UpdateCompanyRequest $request, Company $company)
    {
        // Start a database transaction
        DB::beginTransaction();
        try {
//            $validated = $request->validated();
//            if (!$validated) {
//                return response()->json([
//                    'data' => '',
//                    'message' => $request->getMessages(),
//                    'status' => 422
//                ], 422);
//            }

            try {
                $company->update([
                    'industry' => $request->input('industry'),
                    'description' => $request->input('description'),
                ]);
                $company->save();
            } catch (Exception $e) {
                Log::error('Error updating company: ' . $e->getMessage());
                return response()->json([
                    'data' => '',
                    'message' => 'An error occurred while updating the company',
                    'status' => 500
                ]);
            }

            try {
                $company->communication()->update([
                    'mobile_phone' => $request->input('mobile_phone'),
                    'line_phone' => $request->input('line_phone'),
                    'website' => $request->input('website'),
                    'linkedin_account' => $request->input('linkedin_account'),
                    'github_account' => $request->input('github_account'),
                    'facebook_account' => $request->input('facebook_account'),
                ]);
                $company->communication()->save();
            } catch (Exception $e) {
                Log::error('Error updating location: ' . $e->getMessage());
                return response()->json([
                    'data' => '',
                    'message' => 'An error occurred while updating the location',
                    'status' => 500
                ]);
            }

            try {
                $company->location()->update([
                    'address' => $request->input('address'),
                    'country' => $request->input('country'),
                    'city' => $request->input('city'),
                ]);
                $company->location()->save();
            } catch (Exception $e) {
                Log::error('Error updating location: ' . $e->getMessage());
                return response()->json([
                    'data' => '',
                    'message' => 'An error occurred while updating the location',
                    'status' => 500
                ]);
            }

            if ($request->hasFile('picture')) {
                $picture = $request->file('picture');
                $pictureName = Str::random(32) . "." . $picture->getClientOriginalExtension();
                Storage::disk('public')->put($pictureName, file_get_contents($picture));

                $company->update(['picture' => $pictureName]);
            }

            // Commit the database transaction
            DB::commit();

            return response()->json([
                'data' => $company->fresh(),
                'message' => 'Company updated successfully',
                'status' => 200
            ], 200);
        } catch (ValidationException $e) {
            // Rollback the database transaction on validation error
            DB::rollBack();
            return response()->json([
                'data' => '',
                'message' => $e->errors(),
                'status' => 422
            ], 422);
        } catch (Exception $e) {
            // Rollback the database transaction on any other exception
            DB::rollBack();
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
    public function destroy(Company $company)
    {
        //
    }
}
