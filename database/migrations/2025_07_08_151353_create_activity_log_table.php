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
        $this->activityLog();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_log');
    }

    private function activityLog()
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            // Morph to "causer" (siapa yang melakukan)
            $table->nullableMorphs('causer'); // causer_type, causer_id

            // Morph to "subject" (apa yang dilog)
            $table->nullableMorphs('subject'); // subject_type, subject_id

            $table->string('event'); // created, updated, deleted, etc.
            $table->text('description')->nullable(); // Keterangan
        });
    }
};
