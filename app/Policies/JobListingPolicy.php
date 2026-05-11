<?php
namespace App\Policies;

use App\Models\JobListing;
use App\Models\User;

class JobListingPolicy {
    public function update(User $user, JobListing $jobListing): bool {
        return $user->id === $jobListing->user_id || $user->isAdmin();
    }
    public function delete(User $user, JobListing $jobListing): bool {
        return $user->id === $jobListing->user_id || $user->isAdmin();
    }
}