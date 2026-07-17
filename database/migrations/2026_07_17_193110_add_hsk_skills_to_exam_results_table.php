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
        Schema::table('exam_results', function (Blueprint $table) {
            $table->decimal('listening_marks', 5, 2)->nullable()->before('marks_obtained');
            $table->decimal('reading_marks', 5, 2)->nullable()->before('marks_obtained');
            $table->decimal('writing_marks', 5, 2)->nullable()->before('marks_obtained');
            $table->decimal('speaking_marks', 5, 2)->nullable()->before('marks_obtained');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exam_results', function (Blueprint $table) {
            $table->dropColumn(['listening_marks', 'reading_marks', 'writing_marks', 'speaking_marks']);
        });
    }
};
