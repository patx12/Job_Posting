<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\JobListing;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    // Store feedback from jobseeker
    public function store(Request $request, JobListing $jobListing)
    {
        // Only jobseekers who applied can leave feedback
        $hasApplied = $jobListing->applications()
            ->where('user_id', auth()->id())
            ->exists();

        if (!$hasApplied) {
            return back()->with('error', 'You can only leave feedback for jobs you applied to.');
        }

        // One feedback per job
        $existing = Feedback::where('user_id', auth()->id())
            ->where('job_listing_id', $jobListing->id)
            ->first();

        if ($existing) {
            return back()->with('error', 'You have already left feedback for this job.');
        }

        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Feedback::create([
            'user_id'        => auth()->id(),
            'job_listing_id' => $jobListing->id,
            'rating'         => $request->rating,
            'comment'        => $request->comment,
        ]);

        return back()->with('success', 'Feedback submitted. Thank you!');
    }

    // Employer views feedback for their job
    public function index(JobListing $jobListing)
    {
        abort_if($jobListing->user_id !== auth()->id(), 403);

        $feedbacks = $jobListing->feedbacks()
            ->with('user')
            ->latest()
            ->paginate(10);

        $avgRating = $jobListing->feedbacks()->avg('rating');

        return view('employer.feedback', compact('jobListing', 'feedbacks', 'avgRating'));
    }
}