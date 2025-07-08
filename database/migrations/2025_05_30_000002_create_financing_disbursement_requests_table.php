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
        Schema::create('financing_disbursement_requests', function (Blueprint $table) {
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

            $table->float('disbursement_amount')->default(0);// Nominal Plafon
            $table->string('lcu')->default(0);               // LCU (Letter of Credit Unit)
            $table->string('number_lobc');              
            $table->boolean('is_done_transfer_to_airline')->default(true); // Pemindahbukuan ke Maskapai
            $table->jsonb('additional')->nullable()->comment('complex value');
            // addi -> travel_name, ticket_settlement_date
            $table->boolean('is_paid_off')->default(false); // ketika melakukan pelunasan 
            $table->string('status')->default('review'); // 'review', 'approved', 'rejected', 'sendback'
            $table->timestampTz('last_reminder_sent_at')->nullable();

            $xTable->timestamps(constrained: false);
            $xTable->softDeletes(constrained: false);

            $table->index([$xTable->partnerColumn, 'disbursement_amount', 'lcu', 'status'], 'financing_disbursement_requests_main_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financing_disbursement_requests');
    }
};
