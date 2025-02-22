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
        Schema::create('students', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('student_names', 255);
            $table->string('phone', 15);
            $table->unsignedTinyInteger('math');
            $table->unsignedTinyInteger('physics');
            $table->unsignedTinyInteger('chemistry');
            $table->enum('grade', ['A', 'A+', 'B', 'B+', 'C', 'D', 'F']);
            $table->text('comment')->nullable();
            $table->string('student_address', 500);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
