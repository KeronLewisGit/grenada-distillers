<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * Every web request (tour booking, trade enquiry, job application, contact message)
 * is one row in leads. Names stay short and avoid MySQL reserved words, and foreign
 * keys use Laravel's default names, all well under MySQL's 64-character limit.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('reference', 20)->unique();
            $table->string('type', 16)->index();
            $table->string('status', 16)->default('new')->index();
            $table->string('name', 120);
            $table->string('phone', 30)->nullable();
            $table->string('phone_digits', 20)->nullable()->index();
            $table->string('email');
            $table->string('contact_pref', 10)->default('email');
            $table->string('country', 80)->nullable();
            // Trade enquiries: the importer, distributor or venue.
            $table->string('organisation', 160)->nullable();
            // Job applications: the vacancy (null for a general application).
            $table->foreignId('job_posting_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            // Tour bookings: the slot and the party.
            $table->date('visit_date')->nullable()->index();
            $table->string('visit_time', 5)->nullable();
            $table->unsignedSmallInteger('guests')->nullable();
            // Type-specific answers (business type, volumes, experience, group type …).
            $table->json('details')->nullable();
            $table->text('message')->nullable();
            $table->timestamp('consented_at')->nullable();
            $table->string('source_url', 300)->nullable();
            $table->timestamp('first_contacted_at')->nullable();
            $table->timestamp('status_changed_at')->nullable();
            $table->timestamps();
            $table->index(['status', 'created_at']);
            $table->index(['visit_date', 'visit_time']);
        });

        Schema::create('lead_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            // note | status | assign | system
            $table->string('kind', 12)->default('note');
            $table->text('body');
            $table->timestamps();
        });

        Schema::create('lead_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained()->cascadeOnDelete();
            // cv (job applications)
            $table->string('kind', 12);
            // Always the private "local" disk; streamed to authorised staff only.
            $table->string('path');
            $table->string('original_name', 200);
            $table->string('mime', 100)->nullable();
            $table->unsignedInteger('size')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lead_files');
        Schema::dropIfExists('lead_notes');
        Schema::dropIfExists('leads');
    }
};
