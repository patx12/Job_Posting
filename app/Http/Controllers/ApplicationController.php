<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\JobListing;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function store(Request $request, JobListing $jobListing)
    {
        if ($jobListing->applications()->where('user_id', auth()->id())->exists()) {
            return back()->with('error', 'You have already applied for this job.');
        }

        $data = $request->validate([
            'cover_letter' => 'nullable|string|max:2000',
            'resume'       => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $resumePath = null;
        if ($request->hasFile('resume')) {
            $resumePath = $request->file('resume')->store('resumes', 'public');
        }

        Application::create([
            'user_id'        => auth()->id(),
            'job_listing_id' => $jobListing->id,
            'cover_letter'   => $data['cover_letter'] ?? null,
            'resume_path'    => $resumePath,
        ]);

        return redirect()->route('jobseeker.dashboard')
            ->with('success', 'Application submitted!');
    }

    public function updateStatus(Request $request, Application $application)
    {
        // Only the employer who owns the job can update status
        if ($application->jobListing->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,reviewed,accepted,rejected'
        ]);

        $application->update(['status' => $request->status]);

        return back()->with('success', 'Application status updated.');
    }
}