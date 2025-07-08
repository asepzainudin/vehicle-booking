<?php

use App\Core\Database\Eloquent\XBlueprint;
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
        $this->definesTable();
        $this->settingsTable();
        $this->referenceTable();
        $this->addressTable();
        $this->emailsTable();
        $this->phonesTable();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('defines');
        Schema::dropIfExists('settings');
        Schema::dropIfExists('references');
        Schema::dropIfExists('addresses');
        Schema::dropIfExists('emails');
        Schema::dropIfExists('phones');
        Schema::enableForeignKeyConstraints();
    }

    private function definesTable(): void
    {
        Schema::create('defines', function (Blueprint $table) {
            $xTable = new XBlueprint($table);

            $table->id();
            $xTable->hashId();
            $xTable->partnerId();
            $table->string('type', 50)->default('general');
            $table->string('key');
            $table->text('value')->nullable()->comment('main value');
            $table->jsonb('options')->nullable()->comment('optional information');
            $table->boolean('is_require')->default(false);
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort')->default(0);
            $xTable->timestamps(constrained: false);
            $xTable->softDeletes(constrained: false);

            $table->unique([$xTable->partnerColumn, 'type', 'key'], 'defines_main_unique');
            // $table->fullText('value');
        });
    }

    private function settingsTable(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $xTable = new XBlueprint($table);

            $table->id();
            $xTable->hashId();
            $xTable->partnerId();
            $table->string('type', 50)->default('general');
            $table->string('key');
            $table->string('value')->nullable()->comment('main value');
            $table->string('value_type')->default('string')->comment('string, int, boolean, dll');
            $table->jsonb('complex')->nullable()->comment('complex value');
            $table->boolean('is_active')->default(true);
            $xTable->timestamps(constrained: false);
            $xTable->softDeletes(constrained: false);

            $table->unique([$xTable->partnerColumn, 'type', 'key'], 'settings_main_unique');
            // $table->fullText('value');
        });
    }

    private function referenceTable(): void
    {
        Schema::create('references', function (Blueprint $table) {
            $xTable = new XBlueprint($table);

            $table->uuid('id')->primary();
            $table->string('refable_type')->nullable();
            $table->unsignedBigInteger('refable_id')->nullable();
            $table->uuid('refable_uuid')->nullable();
            $table->string('value')->nullable()->comment('main value');
            $table->jsonb('complex')->nullable()->comment('complex value');
            $xTable->timestamps(constrained: false);
            $xTable->softDeletes(constrained: false);

            $table->index(['refable_type', 'refable_id', 'refable_uuid'], 'references_morph_index');
            // $table->fullText('value');
        });
    }

    private function addressTable(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $xTable = new XBlueprint($table);

            $table->id();
            $xTable->hashId();
            $xTable->partnerId();
            $table->morphs('model');
            $table->boolean('is_primary')->default(false);
            $table->string('name')->default('home')->comment('label');
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('rt_rw')->nullable();
            $xTable->timestamps(constrained: false);
            $xTable->softDeletes(constrained: false);

            $table->index([$xTable->partnerColumn, 'model_type', 'model_id'], 'addresses_main_index');
        });
    }

    private function emailsTable(): void
    {
        Schema::create('emails', function (Blueprint $table) {
            $xTable = new XBlueprint($table);

            $table->id();
            $xTable->hashId();
            $xTable->partnerId();
            $table->morphs('model');
            $table->boolean('is_primary')->default(false);
            $table->string('name')->default('Email Pribadi');
            $table->string('email');
            $xTable->timestamps(constrained: false);
            $xTable->softDeletes(constrained: false);

            $table->index([$xTable->partnerColumn, 'model_type', 'model_id'], 'emails_main_index');
        });
    }

    private function phonesTable(): void
    {
        Schema::create('phones', function (Blueprint $table) {
            $xTable = new XBlueprint($table);

            $table->id();
            $xTable->hashId();
            $xTable->partnerId();
            $table->morphs('model');
            $table->boolean('is_primary')->default(false);
            $table->string('name')->default('Mobile');
            $table->string('dial_code', 5)->default('62');
            $table->string('phone');
            $xTable->timestamps(constrained: false);
            $xTable->softDeletes(constrained: false);

            $table->index([$xTable->partnerColumn, 'model_type', 'model_id'], 'phones_main_index');
        });
    }
};
