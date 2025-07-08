<?php

use App\Core\Database\Eloquent\XBlueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private string $tableLog = 'notification_logs';
    private string $tableLic = 'notification_licenses';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->tableLicense();
        $this->tableLog();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists($this->tableLog);
        Schema::dropIfExists($this->tableLic);
    }

    private function tableLicense(): void
    {
        Schema::create($this->tableLic, function (Blueprint $table) {
            $xTable = new XBlueprint($table);

            $table->id();
            $xTable->partnerId();

            $table->string('type');
            $table->string('name');
            $table->string('license');
            $table->string('token');
            $table->unsignedInteger('limit_per_hour')->default(0);
            $xTable->timestamp('next_run')->nullable();
            $xTable->timestamp('expires_at')->nullable();
            $table->string('status', 100)->default('active');

            $xTable->timestamps(constrained: false);
            $xTable->softDeletes(constrained: false);

            $table->unique(['type', 'token'], "{$this->tableLic}_main_unique");
            // $table->index(['type', 'name', 'license', 'token', 'expires_at'], "{$this->tableLic}_main_index");
        });
        DB::commit();
    }

    private function tableLog(): void
    {
        Schema::create($this->tableLog, function (Blueprint $table) {
            $xTable = new XBlueprint($table);

            $table->uuid('id')->primary();
            $table->foreignId('license_id')->nullable()
                ->constrained($this->tableLic)->cascadeOnUpdate()->restrictOnDelete();
            $table->uuid('process_id')->comment('notification process id');
            $xTable->partnerId();

            $table->string('channel', 50)->comment('woowa, telegram, fcm');
            $table->string('source', 100)->comment('notif dikirim dari');
            $table->string('sender', 100);
            $table->string('receiver', 100);
            $table->string('status', 100)->nullable();
            $table->text('content');
            $table->jsonb('attachments')->nullable();
            $table->string('sent_endpoint')->nullable();
            $table->string('sent_status', 20)->default('pending')->comment('pending, ok, rto');
            $table->string('resp_status')->default('pending')->comment('ok, failed, pending');
            $table->string('resp_id', 100)->nullable();
            $table->string('channel_status', 50)->nullable();
            $table->string('type', 50)->default('system')->comment('system, manual');
            $table->timestamp('requested_at', precision: 6)->nullable()->comment('timestamp ketika msnotif request ke channel');
            $table->boolean("is_group")->default(false);
            $table->jsonb('tags')->nullable();

            $table->string('request_id')->nullable();
            $table->string('sender_request_id')->nullable();
            $table->jsonb('raw_response')->nullable();

            $xTable->timestamps(constrained: false);
            $xTable->softDeletes(constrained: false);

            $table->index(
                [$xTable->partnerColumn, 'process_id', 'channel', 'sender', 'type', 'status', 'resp_id'],
                "{$this->tableLog}_main_index"
            );
            $table->index(
                ['source', 'receiver', 'content', 'is_group', 'requested_at', 'created_at'],
                "{$this->tableLog}_content_index"
            );
        });
        DB::commit();
    }
};
