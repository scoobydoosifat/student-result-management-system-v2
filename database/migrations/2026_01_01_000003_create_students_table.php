<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('student_id')->unique();
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('phone', 20)->unique();
            $table->string('batch');
            $table->date('enrollment_date');
            $table->string('password');
            $table->foreignId('department_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('semester_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->timestamps();
            $table->index(['student_id', 'department_id', 'semester_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
