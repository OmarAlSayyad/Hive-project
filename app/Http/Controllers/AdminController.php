<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\JobPost;
use App\Models\Company;
use App\Models\Category;
use App\Models\Seeker;
use App\Models\Interview;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        // Get the current month's new user count
        $currentMonthUsers = User::where('created_at', '>=', Carbon::now()->startOfMonth())->count();
        
        // Get the previous month's new user count
        $previousMonthUsers = User::whereBetween('created_at', [
            Carbon::now()->subMonth()->startOfMonth(),
            Carbon::now()->subMonth()->endOfMonth()
        ])->count();

        // Calculate the growth percentage
        if ($previousMonthUsers > 0) {
            $growthPercentage = (($currentMonthUsers - $previousMonthUsers) / $previousMonthUsers) * 100;
        } else {
            $growthPercentage = $currentMonthUsers > 0 ? 100 : 0; // Handle division by zero
        }
        $currentMonthJobs = JobPost::where('created_at', '>=', Carbon::now()->startOfMonth())->count();
        
        // Get the previous month's job post count
        $previousMonthJobs = JobPost::whereBetween('created_at', [
            Carbon::now()->subMonth()->startOfMonth(),
            Carbon::now()->subMonth()->endOfMonth()
        ])->count();

        // Calculate the growth percentage
        if ($previousMonthJobs > 0) {
            $growthPercentageJ = (($currentMonthJobs - $previousMonthJobs) / $previousMonthJobs) * 100;
        } else {
            $growthPercentageJ = $currentMonthJobs > 0 ? 100 : 0; // Handle division by zero
        }
        $totalJobs = JobPost::count();
        $totalCompanies = Company::count();
        $totalSeekers = Seeker::count();
        $totalInterviews = Interview::count();

        return view('welcome2', [
            'plus'=> //$plus 
            23,
            'sucess'=> //$totalInterviews
            345,
            'seekers' => //$totalSeekers
           1000 ,
            'company' =>//$totalCompanies
            2000,
            'total'=> //$totalJobs
            10000,
            'Posts' => //$currentMonthJobs
            5000,
            'growthPercentageJ' => //$growthPercentageJ
            72,
            'newUsers' => //$currentMonthUsers
            300,
            'growthPercentage' => //$growthPercentage 
            46
        ]);
    }
    public function notifications(){
        return view('account.sittings.notifications');
    }
    public function create()
    {
        return view('admin.add');
    }

    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'permissions' => 'required|array',
        ]);
    
        // Create the user (assuming $user is defined somewhere above this)
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')), // Always hash passwords!
            'role' => 'admin'
        ]);
    
        // Assign permissions
        $permissions = $request->input('permissions', []);
        $user->permissions()->sync($permissions);
    
        return redirect()->route('admin.create')->with('success', 'Admin created successfully.');
    }
     }

