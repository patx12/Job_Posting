<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobListing extends Model {
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'company', 'location', 'type',
        'description', 'requirements', 'salary_min', 'salary_max',
        'deadline', 'status'
    ];

    protected $casts = ['deadline' => 'date'];

    public function employer() { return $this->belongsTo(User::class, 'user_id'); }
    public function applications() { return $this->hasMany(Application::class); }

    public function scopeOpen($query) {
        return $query->where('status', 'open')->where('deadline', '>=', now());
    }

    public function scopeSearch($query, $term) {
        return $query->where(function($q) use ($term) {
            $q->where('title', 'like', "%{$term}%")
              ->orWhere('company', 'like', "%{$term}%")
              ->orWhere('location', 'like', "%{$term}%");
        });
    }
}