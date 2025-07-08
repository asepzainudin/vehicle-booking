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
        Schema::create('parking_data_users', function (Blueprint $table) {
            $xTable = new XBlueprint($table);

            $table->id();
            $xTable->hashId();
            $xTable->partnerId();

            $table->foreignId('travel_id')->nullable()
                ->constrained('travels')
                ->cascadeOnUpdate();

            $table->string('name')->nullable(0);               
            $table->string('phone')->nullable(0);               // Nomor Telepon
            $table->string('email')->nullable(0);               // Alamat Email
            $table->string('type')->default('user'); // Jenis Pengguna (spesialist, pic pihk, etc.)
            $table->string('status')->default('active'); // Status Pengguna (active, inactive, etc.)
            $table->jsonb('additional')->nullable()->comment('complex value');
            $table->timestampTz('transferred_user_at')->nullable();

            $xTable->timestamps(constrained: false);
            $xTable->softDeletes(constrained: false);

            $table->index([$xTable->partnerColumn, 'name', 'phone', 'email'], 'parking_data_users_main_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parking_data_users');
    }
};
