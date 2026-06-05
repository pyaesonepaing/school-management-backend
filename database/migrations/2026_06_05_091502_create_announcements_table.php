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
    Schema::create('announcements', function (Blueprint $table) {

        $table->id();

        $table->foreignId('user_id')
            ->constrained()
            ->cascadeOnDelete();

        $table->string('title');

        $table->text('message');

        $table->enum('sender_role', [
            'super_admin',
            'teacher'
        ]);

        $table->boolean('is_published')
            ->default(true);

        $table->timestamp('publish_at')
            ->nullable();

        $table->timestamp('expire_at')
            ->nullable();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
