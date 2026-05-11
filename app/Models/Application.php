<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Application extends Model {
    use HasFactory;

    protected $fillable = [
        'user_id', 'job_listing_id', 'cover_letter', 'resume_path', 'status'
    ];

    public function applicant() { return $this->belongsTo(User::class, 'user_id'); }
    public function jobListing() { return $this->belongsTo(JobListing::class); }
}