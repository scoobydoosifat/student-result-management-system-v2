<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enrollment_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->unsignedTinyInteger('mid_marks');
            $table->unsignedTinyInteger('final_marks');
            $table->unsignedTinyInteger('assignment_marks');
            $table->unsignedTinyInteger('attendance_marks');
            $table->unsignedTinyInteger('total_marks');
            $table->string('letter_grade', 2);
            $table->decimal('grade_point', 3, 2);
            $table->decimal('gpa', 3, 2);
            $table->timestamps();
            $table->unique('enrollment_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};
