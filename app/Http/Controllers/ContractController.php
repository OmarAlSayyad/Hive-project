<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContractResource;
use App\Models\Company;
use App\Models\Contract;
use App\Http\Requests\StoreContractRequest;
use App\Http\Requests\UpdateContractRequest;
use App\Models\Seeker;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contract = Contract::all();
        return ContractResource::collection($contract);
    }

    public function companyContract(Company $company)
    {
        try {
            $contract = Contract::where('company_hire_id', $company->id)->get();
            if ($contract->isEmpty()) {
                return response()->json([
                    'data' => [],
                    'message' => 'No contracts found for this company',
                    'status' => 404,
                ], 404);
            }

            return response()->json([
                'data' => ContractResource::collection($contract),
                'message' => ' Contracts retrieved successfully',
                'status' => 200,
            ], 200);

        } catch (Exception $e) {
            Log::error('Error retrieving company contracts: ' . $e->getMessage());
            return response()->json([
                'data' => [],
                'message' => 'An error occurred while retrieving contracts',
                'status' => 500,
            ], 500);
        }
    }

    public function myCompanyContract()
    {
        try {
            // $this->authorize('view', $company);
            $user = Auth::user();
            $company = Company::where('user_id', $user->id)->first();

            $contract = Contract::where('company_hire_id', $company->id)->get();

            if ($contract->isEmpty()) {
                return response()->json([
                    'data' => [],
                    'message' => 'No contracts found for this company',
                    'status' => 404,
                ], 404);
            }

            return response()->json([
                'data' => ContractResource::collection($contract),
                'message' => ' Contracts retrieved successfully',
                'status' => 200,
            ], 200);

        } catch (Exception $e) {
            Log::error('Error retrieving company Contracts : ' . $e->getMessage());
            return response()->json([
                'data' => [],
                'message' => 'An error occurred while retrieving Contracts ',
                'status' => 500,
            ], 500);
        }
    }


    public function seekerContract(Seeker $seeker)
    {
        try {
            $contract = Contract::where('seeker_hire_id', $seeker->id)->get();
            if ($contract->isEmpty()) {
                return response()->json([
                    'data' => [],
                    'message' => 'No contracts found for this seeker',
                    'status' => 404,
                ], 404);
            }

            return response()->json([
                'data' => ContractResource::collection($contract),
                'message' => ' Contracts retrieved successfully',
                'status' => 200,
            ], 200);

        } catch (Exception $e) {
            Log::error('Error retrieving seeker contracts: ' . $e->getMessage());
            return response()->json([
                'data' => [],
                'message' => 'An error occurred while retrieving contracts',
                'status' => 500,
            ], 500);
        }
    }

    public function mySeekerContract()
    {
        try {
            // $this->authorize('view', $company);
            $user = Auth::user();
            $seeker = Seeker::where('user_id', $user->id)->first();

            $contract = Contract::where('seeker_hire_id', $seeker->id)->get();

            if ($contract->isEmpty()) {
                return response()->json([
                    'data' => [],
                    'message' => 'No contracts found for this seeker',
                    'status' => 404,
                ], 404);
            }

            return response()->json([
                'data' => ContractResource::collection($contract),
                'message' => ' Contracts retrieved successfully',
                'status' => 200,
            ], 200);

        } catch (Exception $e) {
            Log::error('Error retrieving seeker Contracts : ' . $e->getMessage());
            return response()->json([
                'data' => [],
                'message' => 'An error occurred while retrieving Contracts ',
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
    public function store(StoreContractRequest $request)
    {
        try {
            $user = Auth::user();
            $seeker = Seeker::where('user_id', $user->id)->first();
            $company = Company::where('user_id', $user->id)->first();

            if ($company) {
                $contract = Contract::create([
                    'company_hire_id' => $company->id,
                    'freelancer_id' => $request->freelancer_id,
                    'freelance_id' => $request->freelance_id,
                    'terms' => $request->terms,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'status' => $request->input('status', false),
                ]);
            } elseif ($seeker) {
                $contract = Contract::create([
                    'seeker_hire_id' => $seeker->id,
                    'freelancer_id' => $request->freelancer_id,
                    'freelance_id' => $request->freelance_id,
                    'terms' => $request->terms,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'status' => $request->input('status', false),
                ]);
            } else {
                return response()->json([
                    'data' => '',
                    'message' => 'User must be associated with either a company or a seeker',
                    'status' => 400,
                ], 400);
            }
            return response()->json([
                'data' =>     ContractResource::collection(collect([$contract])),
                'message' => 'Contract created successfully',
                'status' => 200,
            ], 200);

        } catch (Exception $e) {
            Log::error('Error creating Contract: ' . $e->getMessage(), ['exception' => $e]);

            return response()->json([
                'data' => '',
                'message' => 'An error occurred while creating the Contract',
                'status' => 500,
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Contract $contract)
    {
        return ContractResource::collection(collect([$contract]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contract $contract)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContractRequest $request, Contract $contract)
    {
        try {
            $contract->update([
                'company_hire_id' => $request->company_hire_id ?? $contract->company_hire_id,
                'seeker_hire_id' => $request->seeker_hire_id ?? $contract->seeker_hire_id,
                'freelancer_id' => $request->freelancer_id,
                'freelance_id' => $request->freelance_id,
                'terms' => $request->terms,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'status' => $request->input('status', $contract->status),
            ]);

            return response()->json([
                'data' => new ContractResource($contract),
                'message' => 'Contract updated successfully',
                'status' => 200,
            ], 200);
        } catch (Exception $e) {
            Log::error('Error updating Contract: ' . $e->getMessage(), ['exception' => $e]);

            return response()->json([
                'data' => '',
                'message' => 'An error occurred while updating the Contract',
                'status' => 500,
            ], 500);
        }    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contract $contract)
    {
        try {
            $contract->delete();

            return response()->json([
                'data' => '',
                'message' => 'Contract deleted successfully',
                'status' => 200,
            ], 200);
        } catch (Exception $e) {
            Log::error('Error deleting Contract: ' . $e->getMessage(), ['exception' => $e]);

            return response()->json([
                'data' => '',
                'message' => 'An error occurred while deleting the Contract',
                'status' => 500,
            ], 500);
        }
    }
}
