<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();         // jobseeker
            $table->foreignId('job_listing_id')->constrained()->cascadeOnDelete();  // which job
            $table->tinyInteger('rating');                                           // 1-5
            $table->text('comment')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'job_listing_id']); // one feedback per job
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};