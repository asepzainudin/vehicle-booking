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
        $this->vehicle();
        $this->vehicleOrder();
        $this->vehicleUsage();
        $this->vehicleService();
        $this->vehicleFuel();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle');
        Schema::dropIfExists('vehicle_orders');
        Schema::dropIfExists('vehicle_usages');
        Schema::dropIfExists('vehicle_services');
        Schema::dropIfExists('vehicle_fuels');
    }

    private function vehicle(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $xTable = new XBlueprint($table);

            $table->id();
            $xTable->hashId();
            $table->string('code')->unique()->nullable();
            $table->string('name');
            $table->string('type', 50)->default(VehicleType::PEOPLETRANSPORT);
            $table->string('status')->default('owned'); // milik perusahaan , rental
            $table->text('value')->nullable()->comment('main value');
            $table->jsonb('additional')->nullable()->comment('optional information'); // nama perusahaan persewaan, nomor perushaan persewaan
            $table->unsignedBigInteger('total_vehicles')->default(0); // total kendaraan yang ready
            $table->boolean('in_use')->default(true); // sedang di pakai true, ready false
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort')->default(0);
            $xTable->timestamps(constrained: false);
            $xTable->softDeletes(constrained: false);

        });
    }

    private function vehicleOrder(): void
    {
        Schema::create('vehicle_orders', function (Blueprint $table) {
            $xTable = new XBlueprint($table);

            $table->id();
            $xTable->hashId();
            $table->foreignId('vehicle_id')->nullable()
                ->constrained('vehicles')
                ->cascadeOnUpdate();
            $table->foreignId('driver_id')->nullable()
                ->constrained('users')
                ->cascadeOnUpdate();
            $table->foreignId('reviewer_id')->nullable()
                ->constrained('users')
                ->cascadeOnUpdate();
            $table->foreignId('approver_id')->nullable()
                ->constrained('users')
                ->cascadeOnUpdate();

            $table->string('status')->default('review'); // 'review', 'approved', 'rejected'
            $table->jsonb('additional')->nullable()->comment('optional information'); // keterangan kembali, keterangan review, keterangan aprrover
            $table->timestampTz('return_date')->nullable(); // tanggal kembali
            $table->boolean('is_active')->default(true); // menandakan mobil sedang di pakai
            $xTable->timestamps(constrained: false);
            $xTable->softDeletes(constrained: false);
        });
    }

    private function vehicleUsage(): void
    {
        Schema::create('vehicle_usages', function (Blueprint $table) {
            $xTable = new XBlueprint($table);

            $table->id();
            $xTable->hashId();
            $table->foreignId('vehicle_id')->nullable()
                ->constrained('vehicles')
                ->cascadeOnUpdate();
                
            $table->date('date_use')->nullable(); // tanggal pakai
            $xTable->timestamps(constrained: false);
            $xTable->softDeletes(constrained: false);
        });
    }

    private function vehicleService(): void
    {
        Schema::create('vehicle_services', function (Blueprint $table) {
            $xTable = new XBlueprint($table);

            $table->id();
            $xTable->hashId();
            $table->foreignId('vehicle_id')->nullable()
                ->constrained('vehicles')
                ->cascadeOnUpdate();
                
            $table->date('date_service')->nullable(); // tanggal service
            $table->jsonb('additional')->nullable()->comment('optional information'); // keterangan service
            $xTable->timestamps(constrained: false);
            $xTable->softDeletes(constrained: false);
        });
    }

    private function vehicleFuel(): void
    {
        Schema::create('vehicle_fuels', function (Blueprint $table) {
            $xTable = new XBlueprint($table);

            $table->id();
            $xTable->hashId();
            $table->foreignId('vehicle_id')->nullable()
                ->constrained('vehicles')
                ->cascadeOnUpdate();
                
            $table->date('date_fuel consumption')->nullable(); // tanggal service
            $table->float('petrol_price')->default(0);// harga bensin
            $table->string('amount_gasoline')->nullable();// jumlah bensin
            $table->jsonb('additional')->nullable()->comment('optional information'); // keterangan service
            $xTable->timestamps(constrained: false);
            $xTable->softDeletes(constrained: false);
        });
    }
};
