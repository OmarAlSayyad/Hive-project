<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\WalletController;
use App\Models\SchedulingPreference;

class ProcessAutomaticPayments extends Command
{
    protected $signature = 'payments:process';
    protected $description = 'Process automatic payments to companies';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $walletController = new WalletController();
        $walletController->processAutomaticPayments();
    }
}
