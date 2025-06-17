<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('status')->default(0);
            $table->integer('total_applications')->default(0);
            $table->foreignId('student_id')->nullable()->constrained('users');
            $table->foreignId('moderator_id')->nullable()->constrained('users');
            $table->foreignId('supervisor_id')->nullable()->constrained('users');
            $table->foreignId('examiner_id')->nullable()->constrained('users');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
