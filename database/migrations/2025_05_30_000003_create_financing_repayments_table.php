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
        Schema::create('financing_repayments', function (Blueprint $table) {
            $xTable = new XBlueprint($table);

            $table->id();
            $xTable->hashId();
            $xTable->partnerId();

            $table->foreignId('travel_id')->nullable()
                ->constrained('travels')
                ->cascadeOnUpdate();

            $table->foreignId('financing_plafon_id')->nullable()
                ->constrained('financing_plafons')
                ->cascadeOnUpdate();
            
            $table->foreignId('disbursement_id')
                ->constrained('financing_disbursement_requests')
                ->cascadeOnUpdate();

            $table->float('repayment_amount')->default(0); // Nominal pelunasan
            $table->string('lcu')->default(0);               // LCU (Letter of Credit Unit)
            $table->jsonb('additional')->nullable()->comment('complex value');
            // addi -> number_lobc
            $table->string('status')->default('review'); // 'review', 'approved', 'rejected', 'sendback'
            
            $table->timestampTz('trx_repayment_at')->nullable();
            $xTable->timestamps(constrained: false);
            $xTable->softDeletes(constrained: false);

            $table->index([$xTable->partnerColumn, 'repayment_amount', 'lcu', 'status'], 'financing_repayments_main_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financing_repayments');
    }
};
