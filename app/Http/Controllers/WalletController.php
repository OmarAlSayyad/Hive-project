<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Http\Requests\StoreWalletRequest;
use App\Http\Requests\UpdateWalletRequest;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }
    public function fillWallet(Request $request)
    {
        $request->validate([
            'wallet_id' => 'required|exists:wallets,id',
            'amount' => 'required|numeric|min:0.01',
        ]);

        $wallet = Wallet::findOrFail($request->input('wallet_id'));
        $amount = $request->input('amount');

        try {
            $wallet->fillWallet($amount);
            return response()->json(['message' => 'Wallet successfully filled.', 'balance' => $wallet->balance], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to fill wallet.'], 500);
        }
    }

    // Method to handle automatic payments (you might call this method via a scheduled command)
    public function processAutomaticPayments()
    {
        // Retrieve companies with a payment amount specified
        $companies = Company::where('payment_amount', '>', 0)
                            ->get();
    
        $frequency = env('PAYMENT_SCHEDULING_FREQUENCY', 'daily');
    
        foreach ($companies as $company) {
            // Retrieve the wallet for the company
            $wallet = Wallet::where('company_id', $company->id)->first();
    
            // Ensure the wallet exists and has sufficient balance
            if ($wallet) {
                if ($wallet->balance >= $company->payment_amount) {
                    
                        // Process the payment
                        $wallet->balance -= $company->payment_amount;
                        $wallet->save();
    
               
            }}
        
    
    
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
    public function store(StoreWalletRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Wallet $wallet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Wallet $wallet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWalletRequest $request, Wallet $wallet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wallet $wallet)
    {
        //
    }
}
