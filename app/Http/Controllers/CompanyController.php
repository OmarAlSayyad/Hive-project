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
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
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
        // return CompanyResource::collection($companies);
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
            $user = Auth::user();
            $existingCompany= Company::where('user_id', $user->id)->first();

            if ($existingCompany )
            {
                return response()->json([
                    'data' => '',
                    'message' => 'User already exist',
                    'status' => 500,
                ],500);
            }
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
                ],500);
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
                ],500);
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

        $company = Company::findOrFail($company->id);

        try {
            $this->authorize('update', $company);

            if ($request->hasAny(['address', 'city', 'country'])) {
                $company->location()->update($request->only(['address', 'city', 'country']));
            }

            if ($request->hasAny(['mobile_phone', 'line_phone', 'website', 'linkedin_account', 'github_account', 'facebook_account'])) {
                $company->communication()->update($request->only(['mobile_phone', 'line_phone', 'website', 'linkedin_account', 'github_account', 'facebook_account']));
            }

            $company->update($request->except(['user_id', 'location_id', 'communication_id']));

            $picture = $request->file('picture');
            if ($picture) {
                $pictureName = Str::random(32) . "." . $picture->getClientOriginalExtension();
                Storage::disk('public')->put($pictureName, file_get_contents($picture));

                if ($company->picture) {
                    Storage::disk('public')->delete($company->picture);
                }

                $company->picture = $pictureName;
                $company->save();
            }

            return response()->json([
                'data' => new CompanyResource($company->load(['user', 'location', 'communication'])),
                'message' => 'Company updated successfully',
                'status' => 200
            ], 200);
        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 403);
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
