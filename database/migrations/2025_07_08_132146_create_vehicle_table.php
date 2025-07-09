<?php

use App\Core\Database\Eloquent\XBlueprint;
use App\Enums\VehicleType;
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
            $table->string('type', 50)->default(VehicleType::FREIGHTTRANSPORT);
            $table->string('status')->default('owned'); // milik perusahaan (owned) , rental
            $table->text('value')->nullable()->comment('main value');
            $table->jsonb('additional')->nullable()->comment('optional information'); // nama perusahaan persewaan, nomor perusahaan persewaan
            $table->unsignedBigInteger('total_vehicles')->default(0); // total kendaraan yang ready
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
            $table->string('code')->unique();
            $table->foreignId('vehicle_id')->nullable()
                ->constrained('vehicles')
                ->cascadeOnUpdate();
            $table->foreignId('mine_location_id')->nullable()
                ->constrained('mine')
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

            $table->string('status')->default('review'); // 'review', 'approved', 'rejected', 'return'
            $table->jsonb('additional')->nullable()->comment('optional information'); // keterangan rejected, keterangan review, keterangan aprrover, keterngan return
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
            $table->jsonb('additional')->nullable()->comment('optional information'); // keterangan service, service cost
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
                
            $table->date('date_fuel_consumption')->nullable(); // tanggal pengisian bahan bakar
            $table->float('fuel_consumption')->default(0); // konsumsi bahan bakar
            $table->float('fuel_cost')->default(0); // biaya bahan bakar
            $table->string('fuel_type')->nullable(); // jenis bahan bakar
            $table->jsonb('additional')->nullable()->comment('optional information'); // keterangan service
            $xTable->timestamps(constrained: false);
            $xTable->softDeletes(constrained: false);
        });
    }
};
