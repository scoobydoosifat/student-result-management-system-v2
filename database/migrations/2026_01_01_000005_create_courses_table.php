<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('course_code')->unique();
            $table->string('course_title');
            $table->unsignedTinyInteger('credit_hours');
            $table->foreignId('department_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('teacher_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->timestamps();
            $table->index(['course_code', 'department_id', 'teacher_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
