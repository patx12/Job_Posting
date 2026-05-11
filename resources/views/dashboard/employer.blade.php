<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class JobListingController extends Controller
{
    use AuthorizesRequests;

    // Show employer dashboard (list of jobs)
    public function index()
    {
        $jobs = JobListing::where('user_id', Auth::id())
            ->latest()
            ->withCount('applications')
            ->paginate(5);

        return view('employer.dashboard', compact('jobs'));
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
            'title' => 'required|string|max:255',
            'description' => 'required',
            'location' => 'required|string|max:255',
            'type' => 'required|string',
            'deadline' => 'required|date',
        ]);

        $data['user_id'] = Auth::id();
        $data['status'] = 'open';

        JobListing::create($data);

        return redirect()->route('employer.dashboard')
            ->with('success', 'Job posted successfully!');
    }

    // Show edit form
    public function edit(JobListing $jobListing)
    {
        $this->authorize('update', $jobListing); // optional but good

        return view('jobs.edit', compact('jobListing'));
    }

    // Update job
    public function update(Request $request, JobListing $jobListing)
    {
        $this->authorize('update', $jobListing);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'location' => 'required|string|max:255',
            'type' => 'required|string',
            'deadline' => 'required|date',
        ]);

        $jobListing->update($data);

        return redirect()->route('employer.dashboard')
            ->with('success', 'Job updated!');
    }

    // DELETE job (THIS IS WHERE YOUR ERROR WAS)
    public function destroy(JobListing $jobListing)
    {
        $this->authorize('delete', $jobListing);

        $jobListing->delete();

        return redirect()->route('employer.dashboard')
            ->with('success', 'Job deleted.');
    }
}