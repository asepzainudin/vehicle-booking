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
        $this->officeRegion();
        $this->mineLocation();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('office_regions');
        Schema::dropIfExists('mine');
    }

    private function officeRegion(): void
    {
        Schema::create('office_regions', function (Blueprint $table) {
            $xTable = new XBlueprint($table);

            $table->id();
            $xTable->hashId();
            $table->string('code')->unique()->nullable();
            $table->string('name');
            $table->text('value')->nullable()->comment('main value');
            $table->jsonb('additional')->nullable()->comment('optional information');
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort')->default(0);
            $xTable->timestamps(constrained: false);
            $xTable->softDeletes(constrained: false);

        });
    }
    
    private function mineLocation(): void
    {
        Schema::create('mine', function (Blueprint $table) {
            $xTable = new XBlueprint($table);

            $table->id();
            $xTable->hashId();
            $table->foreignId('office_region_id')->nullable()
                ->constrained('office_regions')
                ->cascadeOnUpdate();
            $table->string('code')->unique()->nullable();
            $table->string('name');
            $table->text('value')->nullable()->comment('main value');
            $table->jsonb('additional')->nullable()->comment('optional information'); // lokasi tambang
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort')->default(0);
            $xTable->timestamps(constrained: false);
            $xTable->softDeletes(constrained: false);

        });
    }
};
