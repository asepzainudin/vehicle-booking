<?php

use App\Core\Database\Eloquent\XBlueprint;
use App\Enums\PartnerType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::create('partners', function (Blueprint $table) {
            $xTable = new XBlueprint($table);

            $table->id();
            $xTable->hashId();
            $table->uuid()->unique();
            $table->string('type', 50)->default(PartnerType::AIRLINE);
            $table->string('code')->unique();
            $table->string('name');
            $table->string('status', 50)->default('active');
            $table->string('domain')->nullable();
            $table->string('domain_status', 50)->default('pending');
            $xTable->timestamp('domain_last_check')->nullable();
            $table->string('address')->nullable();
            $xTable->geo();
            $xTable->timestamps(constrained: false);
            $xTable->softDeletes(constrained: false);

            $table->index(['code', 'name', 'domain'], 'partner_main_index');
        });

        Schema::create('partner_meta', function (Blueprint $table) {
            $xTable = new XBlueprint($table);

            $table->uuid('id')->primary();
            $xTable->partnerId();
            $table->string('key');
            $table->text('value')->nullable()->comment('main value');
            $table->jsonb('options')->nullable()->comment('optional information');
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort')->default(0);
            $xTable->timestamps(constrained: false);
            $xTable->softDeletes(constrained: false);

            $table->index([$xTable->partnerColumn, 'key', 'is_active'], 'partner_meta_main_index');
        });

        Schema::create('partner_action', function (Blueprint $table) {
            $xTable = new XBlueprint($table);

            $table->uuid('id')->primary();
            $xTable->partnerId(nullable: false);
            $table->string('actionable_type');
            $table->unsignedBigInteger('actionable_id')->nullable();
            $table->uuid('actionable_uuid')->nullable();
            $table->string('type');
            $table->jsonb('action')->nullable();
            $xTable->timestamps(constrained: false);
            $xTable->softDeletes(constrained: false);

            $table->index([$xTable->partnerColumn, 'type'], 'partner_action_main_index');
            $table->index([$xTable->partnerColumn, 'actionable_type', 'actionable_id', 'actionable_uuid'], 'partner_action_morph_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('partner_meta');
        Schema::dropIfExists('partners');
    }
};
