<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_postings', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title', 120);
            // Production, Warehouse, Finance, Sales … (free text, shown as a label)
            $table->string('department', 60);
            $table->string('employment_type', 20);
            $table->string('status', 10)->default('draft')->index();
            $table->string('location', 120)->default('Woodlands, St George');
            $table->date('closes_on')->nullable();
            $table->text('summary');
            $table->text('duties')->nullable();
            $table->text('requirements')->nullable();
            // Shown on sample postings seeded for the demo; never set for real ones.
            $table->boolean('is_demo')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_postings');
    }
};
