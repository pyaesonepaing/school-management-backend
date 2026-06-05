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
        Schema::create('meetings', function (Blueprint $table) {

            $table->id();

            $table->foreignId('batch_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->enum('platform', [
                'google_meet',
                'zoom',
                'microsoft_teams'
            ])->default('google_meet');

            $table->string('title');

            $table->string('meeting_link');

            $table->text('description')->nullable();

            $table->boolean('is_active')
                ->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
};
