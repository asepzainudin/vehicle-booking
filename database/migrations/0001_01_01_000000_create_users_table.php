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
        Schema::create('users', function (Blueprint $table) {
            $xTable = new XBlueprint($table);

            $table->id();
            $xTable->hashId();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('phone')->nullable()->unique();
            $table->string('email')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('status', 20)->default('active');
            $table->string('type')->default('general'); // Jenis Pengguna (spesialist, rm, pic pihk, etc.)
            $table->timestamp('last_login_at')->nullable();
            $table->string('last_login_ip')->nullable();
            $table->jsonb('options')->nullable();
            $table->string('identity_type')->default('ktp');
            $table->string('identity_number')->nullable();
            $table->string('locale')->default('id');
            $table->string('timezone')->nullable('Asia/Jakarta');
            $table->timestampsTz();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->softDeletesTz();
            $table->string('deleted_by')->nullable();

            $table->index(['username', 'phone', 'email', 'status'], 'users_main_index');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });


        // referencing actor
        $unconstrainedTable = [
            'geo_countries', 'geo_provinces', 'geo_cities',
            'geo_districts', 'geo_sub_districts',
            'defines', 'addresses', 'emails', 'phones',
            'tenants', 'tenant_meta',
            'notification_licenses', 'notification_logs',
        ];

        foreach ($unconstrainedTable as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                foreach (['created_by', 'updated_by', 'deleted_by'] as $column) {
                    if (Schema::hasColumn($tableName, $column)) {
                        $table->foreign($column)
                            ->references('id')
                            ->on('users')
                            ->onDelete('restrict');
                    }
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
