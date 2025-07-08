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
       Schema::create('partner_travels', function (Blueprint $table) {
            $xTable = new XBlueprint($table);
            $table->foreignId('partner_id')->nullable()
                ->constrained('travels')
                ->onDelete('cascade');
            $table->foreignId('travel_id')->nullable()
                ->constrained('travels')
                ->onDelete('cascade');
            $xTable->timestamps(constrained: false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
