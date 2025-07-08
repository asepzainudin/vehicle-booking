<?php

use App\Core\Database\Eloquent\XBlueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('travels', function (Blueprint $table) {
            $xTable = new XBlueprint($table);

            $table->id();
            $xTable->hashId();
            $xTable->partnerId();
            $table->uuid()->unique();
            $table->string('code', 50);
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->boolean('is_active')->default(true);
            $table->jsonb('additional')->nullable()->comment('complex value');
            $xTable->timestamps(constrained: false);
            $xTable->softDeletes(constrained: false);

            $table->index(['code', 'name', 'phone', 'email'], 'travel_main_index');
        });
        DB::commit();

        Schema::create('partner_travel', function (Blueprint $table) {
            $xTable = new XBlueprint($table);

            $xTable->partnerId();
            $table->foreignId('travel_id')->nullable()
                ->constrained('travels')
                ->cascadeOnUpdate();

            $xTable->timestamps(constrained: false);

            $table->unique(['partner_id', 'travel_id']); // mencegah duplikasi
        });
        DB::commit();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('travels');
    }
};
