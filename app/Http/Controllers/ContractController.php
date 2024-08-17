<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContractResource;
use App\Models\Company;
use App\Models\Contract;
use App\Http\Requests\StoreContractRequest;
use App\Http\Requests\UpdateContractRequest;
use App\Models\Experience;
use App\Models\FreelancePost;
use App\Models\Seeker;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
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

    public function automaticExperience(Contract $contract){

        try {


            $user = Auth::user();
            $seeker = Seeker::where('user_id', $user->id)->first();

            $freelancePost = FreelancePost::findOrFail($contract->freelance_id);

            $existingExperience = Experience::where('seeker_id', $seeker->id)
                ->where('job_title',$freelancePost->title)
                ->first();

            if ($existingExperience) {
                $message="This work experience already exist";
                return $message;
            }

            if ($freelancePost->seeker_id === null) {
                $company = Company::where('id',$freelancePost->company_id)->first();
                $user = User::where('id',$company->user_id)->first();
                $experience = Experience::create([
                    'seeker_id' => $seeker->id,
                    'job_title' => $freelancePost->title,
                    'company_name' => $user->name,
                    'job_description' => $freelancePost->description,
                    'start_date' => $contract->start_date,
                    'end_date' => $contract->end_date,
                ]);
               return $message="This work experience has been  added automatically";
            } elseif ($freelancePost->company_id === null) {
                $seeker = Seeker::where('id',$freelancePost->seeker_id)->first();
               $user = User::where('id',$seeker->user_id)->first();
                $experience = Experience::create([
                    'seeker_id' => $seeker->id,
                    'job_title' => $freelancePost->title,
                    'company_name' => $user->name,
                    'job_description' => $freelancePost->description,
                    'start_date' => $contract->start_date,
                    'end_date' => $contract->end_date,
                ]);
               return $message="This work experience has been  added automatically";
            }

        }catch (Exception $e) {
            Log::error('Error updating experience: ' . $e->getMessage(), ['exception' => $e]);

            return response()->json([
                'data' => '',
                'message' => 'An error occurred while adding  experience for this work',
                'status' => 500,
            ], 500);
        }

    }

    public function delivered(Request $request, Contract $contract)
    {
        try {
            $deliveredDate = Carbon::parse($request->delivered_date);
            $endDate = Carbon::parse($contract->end_date);

            $deliveredOnTime = $deliveredDate->lessThanOrEqualTo($endDate);

            $contract->update([
                'delivered_date' => $request->delivered_date,
                'delivered_on_time' => $deliveredOnTime,
            ]);

            $message="This work experience is not added ";
            if($contract->delivered_date!=null){
                $message= $this->automaticExperience($contract);

            }

            $this->updateSeekerOnTimePercentage($contract->freelancer_id);

            return response()->json([
                'data' => ContractResource::collection(collect([$contract])),
                'message' => 'Contract updated successfully',
                'Experience status'=>$message,
                'status' => 200,
            ], 200);
        } catch (Exception $e) {
            Log::error('Error updating Contract: ' . $e->getMessage(), ['exception' => $e]);

            return response()->json([
                'data' => '',
                'message' => 'An error occurred while updating the Contract',
                'status' => 500,
            ], 500);
        }
    }

    protected function updateSeekerOnTimePercentage($seekerId)
    {
        $seeker = Seeker::findOrFail($seekerId);

        $totalContracts = Contract::where('freelancer_id', $seekerId)->count();
        $onTimeContracts = Contract::where('freelancer_id', $seekerId)->where('delivered_on_time', true)->count();

        $onTimePercentage = $totalContracts > 0 ? ($onTimeContracts / $totalContracts) * 100 : 0;

        // Update the on_time_percentage in the seekers table
        $seeker->update([
            'on_time_percentage' => $onTimePercentage,
        ]);
    }


    public function acceptContract(Request $request, Contract $contract)
    {
        try {
            // Validate that the status is a boolean value
            $request->validate([
                'status' => 'required|boolean',
            ]);

            // Update only the status field of the contract
            $contract->update([
                'status' => $request->input('status'),
            ]);

            return response()->json([
                'data' => new ContractResource($contract),
                'message' => 'Contract status updated successfully',
                'status' => 200,
            ], 200);
        } catch (Exception $e) {
            Log::error('Error updating contract status: ' . $e->getMessage(), ['exception' => $e]);

            return response()->json([
                'data' => '',
                'message' => 'An error occurred while updating the contract status',
                'status' => 500,
            ], 500);
        }
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
                //'status' => $request->status,//->input('status', $contract->status),
            ]);


            return response()->json([
                'data' => new ContractResource($contract),
                'message' => 'Contract updated successfully ',
                'status' => 200,
            ], 200);
        } catch (Exception $e) {
            Log::error('Error updating Contract: ' . $e->getMessage(), ['exception' => $e]);

            return response()->json([
                'data' => '',
                'message' => 'An error occurred while updating the Contract',
                'status' => 500,
            ], 500);
        }

    }

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
