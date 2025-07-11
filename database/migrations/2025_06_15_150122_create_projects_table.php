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
            $table->string('file')->nullable();
            $table->tinyInteger('project_type')->default(0);
            $table->tinyInteger('major')->default(0);
            $table->integer('supervisor_marks')->default(0);
            $table->integer('moderator_marks')->default(0);
            $table->integer('total_marks')->default(0);
            $table->char('grade')->nullable();
            $table->year('year');
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
