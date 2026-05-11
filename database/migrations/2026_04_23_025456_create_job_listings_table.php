<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('job_listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('company');
            $table->string('location');
            $table->enum('type', ['full-time', 'part-time', 'contract', 'internship']);
            $table->text('description');
            $table->text('requirements');
            $table->decimal('salary_min', 10, 2)->nullable();
            $table->decimal('salary_max', 10, 2)->nullable();
            $table->date('deadline');
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('job_listings');
    }
};