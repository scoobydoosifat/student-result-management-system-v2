<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('result_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('result_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->unsignedTinyInteger('old_total_marks');
            $table->string('old_grade', 2);
            $table->timestamps();
            $table->index(['result_id', 'old_grade']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('result_histories');
    }
};
