<?php
namespace App\Http\Controllers;

use App\Models\JobListing;
use App\Models\Application;
use App\Models\User;

class DashboardController extends Controller {

    public function employer() {
        $jobs = auth()->user()->jobListings()
            ->withCount('applications')->latest()->paginate(10);
        return view('dashboard.employer', compact('jobs'));
    }

    public function jobseeker() {
        $applications = auth()->user()->applications()
            ->with('jobListing')->latest()->paginate(10);
        return view('dashboard.jobseeker', compact('applications'));
    }

    public function admin() {
        $stats = [
            'total_jobs'  => JobListing::count(),
            'open_jobs'   => JobListing::where('status', 'open')->count(),
            'total_users' => User::count(),
            'total_apps'  => Application::count(),
        ];
        $recentJobs = JobListing::with('employer')->latest()->take(5)->get();
        $recentApps = Application::with(['applicant', 'jobListing'])->latest()->take(5)->get();
        return view('dashboard.admin', compact('stats', 'recentJobs', 'recentApps'));
    }
}