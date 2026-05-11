<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use App\Models\User;
use App\Models\Application;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $stats = [
            'total_jobs'  => JobListing::count(),
            'open_jobs'   => JobListing::where('status', 'open')->count(),
            'total_users' => User::count(),
            'total_apps'  => Application::count(),
        ];

        $recentJobs = JobListing::with('employer')->latest()->take(5)->get();
        $recentApps = Application::with(['applicant', 'jobListing'])->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentJobs', 'recentApps'));
    }

    // All jobs
    public function jobs(Request $request)
    {
        $jobs = JobListing::with('employer')
            ->withCount('applications')
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->search, fn($q) => $q->where('title', 'like', "%{$request->search}%")
                                                   ->orWhere('company', 'like', "%{$request->search}%"))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.jobs', compact('jobs'));
    }

    // Delete any job
    public function deleteJob(JobListing $jobListing)
    {
        $jobListing->delete();
        return redirect()->back()->with('success', 'Job deleted.');
    }

    // Toggle job open/closed
    public function toggleJob(JobListing $jobListing)
    {
        $jobListing->update([
            'status' => $jobListing->status === 'open' ? 'closed' : 'open'
        ]);
        return redirect()->back()->with('success', 'Job status updated.');
    }

    // All users
    public function users(Request $request)
    {
        $users = User::withCount(['jobListings', 'applications'])
            ->when($request->role, fn($q) => $q->where('role', $request->role))
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%")
                                                   ->orWhere('email', 'like', "%{$request->search}%"))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.users', compact('users'));
    }

    // Delete user
    public function deleteUser(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'User deleted.');
    }

    // Update role
    public function updateRole(User $user, Request $request)
    {
        $request->validate(['role' => 'required|in:admin,employer,jobseeker']);
        $user->update(['role' => $request->role]);
        return redirect()->back()->with('success', 'Role updated.');
    }

    // All applications
    public function applications(Request $request)
    {
        $applications = Application::with(['applicant', 'jobListing'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->search, fn($q) => $q->whereHas('applicant', fn($u) =>
                $u->where('name', 'like', "%{$request->search}%")))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.applications', compact('applications'));
    }

    // Delete application
    public function deleteApplication(Application $application)
    {
        $application->delete();
        return redirect()->back()->with('success', 'Application deleted.');
    }
}