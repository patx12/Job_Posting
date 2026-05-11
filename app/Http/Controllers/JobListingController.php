<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class JobListingController extends Controller
{
    use AuthorizesRequests;

    // Public homepage — all open jobs
    public function browse(Request $request)
    {
        $jobs = JobListing::open()
            ->when($request->search,   fn($q) => $q->search($request->search))
            ->when($request->type,     fn($q) => $q->where('type', $request->type))
            ->when($request->location, fn($q) => $q->where('location', 'like', "%{$request->location}%"))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('jobs.index', compact('jobs'));
    }

    // Employer dashboard
    public function index(Request $request)
    {
        $query = JobListing::where('user_id', Auth::id())
            ->withCount('applications')
            ->latest();

        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $jobs = $query->paginate(5)->withQueryString();

        return view('employer.dashboard', compact('jobs'));
    }

    // View applicants for a specific job
    public function applications(JobListing $jobListing)
    {
        $this->authorize('update', $jobListing);

        $applications = $jobListing->applications()
            ->with('applicant')
            ->latest()
            ->paginate(10);

        return view('employer.applications', compact('jobListing', 'applications'));
    }

    // Single job page
    public function show(JobListing $jobListing)
    {
        $hasApplied = auth()->check()
            ? $jobListing->applications()->where('user_id', auth()->id())->exists()
            : false;

        return view('jobs.show', compact('jobListing', 'hasApplied'));
    }

    // Show create form
    public function create()
    {
        return view('jobs.create');
    }

    // Store new job
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'company'      => 'required|string|max:255',
            'location'     => 'required|string|max:255',
            'type'         => 'required|in:full-time,part-time,contract,internship',
            'description'  => 'required|string',
            'requirements' => 'required|string',
            'salary_min'   => 'nullable|numeric|min:0',
            'salary_max'   => 'nullable|numeric|min:0',
            'deadline'     => 'required|date|after:today',
        ]);

        auth()->user()->jobListings()->create($data);

        return redirect()->route('employer.dashboard')
            ->with('success', 'Job posted successfully!');
    }

    // Show edit form
    public function edit(JobListing $jobListing)
    {
        $this->authorize('update', $jobListing);
        return view('jobs.edit', compact('jobListing'));
    }

    // Update job
    public function update(Request $request, JobListing $jobListing)
    {
        $this->authorize('update', $jobListing);

        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'company'      => 'required|string|max:255',
            'location'     => 'required|string|max:255',
            'type'         => 'required|in:full-time,part-time,contract,internship',
            'description'  => 'required|string',
            'requirements' => 'required|string',
            'salary_min'   => 'nullable|numeric|min:0',
            'salary_max'   => 'nullable|numeric|min:0',
            'deadline'     => 'required|date',
            'status'       => 'required|in:open,closed',
        ]);

        $jobListing->update($data);

        return redirect()->route('employer.dashboard')
            ->with('success', 'Job updated!');
    }

    // Delete job
    public function destroy(JobListing $jobListing)
    {
        $this->authorize('delete', $jobListing);
        $jobListing->delete();

        return redirect()->route('employer.dashboard')
            ->with('success', 'Job deleted.');
    }
}