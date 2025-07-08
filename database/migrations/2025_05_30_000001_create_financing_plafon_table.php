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
        Schema::create('financing_plafons', function (Blueprint $table) {
            $xTable = new XBlueprint($table);

            $table->id();
            $xTable->hashId();
            $xTable->partnerId();

            $table->foreignId('travel_id')
                ->constrained('travels')
                ->cascadeOnUpdate();

            $table->foreignId('rm_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate();

            $table->foreignId('specialist_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate();

            $table->foreignId('pic_pihk_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate();

            $table->string('ol_number')->nullable();          // Nomor OL
            $table->float('plafon_amount')->default(0);// Nominal Plafon
            $table->float('plafon_remaining')->default(0);// Sisa Nominal Plafon
            $table->string('status')->default('review'); // 'review', 'approved', 'rejected', 'sendback'
            $table->jsonb('additional')->nullable()->comment('complex value');
            // addi ->'pull_relief', 'flagging_revolving'
            $table->timestampTz('due_date')->nullable();
            $xTable->timestamps(constrained: false);
            $xTable->softDeletes(constrained: false);

            $table->index([$xTable->partnerColumn, 'travel_id', 'ol_number', 'plafon_amount'], 'financing_plafons_main_index');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financing_plafons');
    }
};
