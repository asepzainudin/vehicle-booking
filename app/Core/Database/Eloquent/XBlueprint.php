<?php

namespace App\Core\Database\Eloquent;

use Illuminate\Database\Schema\{Blueprint, ColumnDefinition};
use Illuminate\Support\Facades\Schema;

class XBlueprint
{
    /** @var string */
    public string $hashColumn = 'hash_id';

    /** @var string */
    public string $appColumn = 'app_id';

    /** @var string */
    public string $partnerColumn = 'partner_id';

    /**
     * XBlueprint instance
     *
     * @param Blueprint $table
     */
    public function __construct(private readonly Blueprint $table)
    {
        //
    }

    /**
     * @param string|null $column
     * @param int $length
     * @return void
     */
    public function hashId(
        string|null $column = 'hash_id',
        int $length = 50
    ): void {
        $this->hashColumn = $column;
        $this->table->string($column, $length)
            ->nullable()
            ->index();
    }

    /**
     * @param string|null $column
     * @param bool $nullable
     * @return void
     */
    public function appId(
        string|null $column = 'app_id',
        bool $nullable = true
    ): void {
        $this->appColumn = $column;
        $this->table->foreignId($column)->nullable($nullable)
            ->constrained('apps')
            ->cascadeOnUpdate()
            ->restrictOnDelete();
    }

    /**
     * @param string|null $column
     * @param bool $nullable
     * @return void
     */
    public function partnerId(
        string|null $column = null,
        bool $nullable = true
    ): void {
        if (! empty($column)) {
            $this->partnerColumn = $column;
        }
        $this->table->foreignId($this->partnerColumn)->nullable($nullable)
            ->constrained('partners')
            ->cascadeOnUpdate()
            ->restrictOnDelete();
    }

    /**
     * @param string|null $column
     * @param bool $nullable
     * @return void
     */
    public function userId(
        string|null $column = 'user_id',
        bool $nullable = false
    ): void {
        $this->table->foreignId($column)->nullable($nullable)
            ->constrained('users')
            ->cascadeOnUpdate()
            ->restrictOnDelete();
    }

    /**
     * @param string $column
     * @param int $precision
     * @return ColumnDefinition
     */
    public function timestamp(
        string $column,
        int $precision = 0
    ): ColumnDefinition {
        return $this->table->timestampTz(column: $column, precision: $precision);
    }

    /**
     * @param int $precision
     * @param bool $constrained
     * @return void
     */
    public function timestamps(
        int $precision = 0,
        bool $constrained = true
    ): void {
        $this->table->timestampsTz(precision: $precision);
        if ($constrained) {
            $this->table->foreignId('created_by')->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $this->table->foreignId('updated_by')->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        } else {
            $this->table->unsignedBigInteger('created_by')->nullable();
            $this->table->unsignedBigInteger('updated_by')->nullable();
        }
    }

    /**
     * @param string $column
     * @param int $precision
     * @param bool $constrained
     * @return ColumnDefinition
     */
    public function softDeletes(
        string $column = 'deleted_at',
        int $precision = 0,
        bool $constrained = true
    ): ColumnDefinition {
        $table = $this->table->softDeletesTz($column, precision: $precision);
        if ($constrained) {
            $this->table->foreignId('deleted_by')->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        } else {
            $this->table->unsignedBigInteger('deleted_by')->nullable();
        }
        return $table;
    }

    /**
     * @param bool $nullable
     * @return void
     */
    public function locale(bool $nullable = false): void
    {
        $lc = $this->table->string('locale', 100);
        $tz = $this->table->string('timezone', 100);

        if ($nullable) {
            $lc->nullable();
            $tz->nullable();
        } else {
            $lc->default('id_ID');
            $tz->default('Asia/Jakarta');
        }
    }

    /**
     * @param string|null ...$types
     * @return void
     */
    public function geo(string|null ...$types): void
    {
        if (! $types) {
            $types = ['country', 'province', 'city', 'district', 'sub_district', 'postal', 'location'];
        }

        if (in_array('country', $types)) {
            $this->table->foreignId('country_id')->nullable()
                ->constrained('geo_countries')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $this->table->string('country_name')->nullable();
        }
        if (in_array('province', $types)) {
            $this->table->foreignId('province_id')->nullable()
                ->constrained('geo_provinces')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $this->table->string('province_name')->nullable();
        }
        if (in_array('city', $types)) {
            $this->table->foreignId('city_id')->nullable()
                ->constrained('geo_cities')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $this->table->string('city_name')->nullable();
        }
        if (in_array('district', $types)) {
            $this->table->foreignId('district_id')->nullable()
                ->constrained('geo_districts')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $this->table->string('district_name')->nullable();
        }
        if (in_array('sub_district', $types)) {
            $this->table->foreignId('sub_district_id')->nullable()
                ->constrained('geo_sub_districts')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $this->table->string('sub_district_name')->nullable();
        }
        if (in_array('postal', $types)) {
            $this->table->string('postal_code')->nullable();
        }
        if (in_array('location', $types)) {
            $this->table->string('longitude')->nullable();
            $this->table->string('latitude')->nullable();
            $this->table->string('altitude')->nullable();
        }
    }

    public static function archiveTable(string $name): void
    {
        Schema::create('arch_'.$name, function (Blueprint $table) {
            $xTable = new self($table);

            $table->uuid('id')->primary();
            $xTable->userId('archived_by', nullable: true);
            $xTable->timestamp('archived_at')->nullable();
            $xTable->timestamp('archived_until')->nullable();
            $table->jsonb('data')->nullable();
            $xTable->userId('data_creator', nullable: true);
            $xTable->userId('data_updater', nullable: true);
        });
    }
}
