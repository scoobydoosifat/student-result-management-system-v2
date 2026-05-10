<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('teacher_id')->unique();
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('designation');
            $table->string('phone', 20)->unique();
            $table->string('password');
            $table->foreignId('department_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->timestamps();
            $table->index(['teacher_id', 'department_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
