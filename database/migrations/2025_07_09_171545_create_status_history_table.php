<?php

use App\Core\Database\Eloquent\XBlueprint;
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
        Schema::create('status_histories', function (Blueprint $table) {
            $xTable = new XBlueprint($table);

            $table->id();
            $table->morphs('model'); // Bisa order
            $table->string('from_status')->nullable();
            $table->string('to_status');
            $table->text('note')->nullable(); 
            $table->foreignId('changed_by')->nullable()
                ->constrained('users');

            $xTable->timestamps(constrained: false);

            $table->index(['from_status', 'to_status', 'changed_by'], 'status_histories_main_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_histories');
    }
};