<?php

namespace App\Models;

use App\Concerns\InteractWithEloquentTimestamp;
use App\Models\Model;
use App\Contracts\HasEloquentTimestamp;
use App\Enums\StatusType;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property string $from_status
 * @property string $to_status
 * @property float $note
 * @property string $changed_by
 * @property-read \Illuminate\Support\Carbon|null $created_at
 * @property-read \Illuminate\Support\Carbon|null $updated_at
 */
class StatusHistory extends Model implements HasEloquentTimestamp
{
    use InteractWithEloquentTimestamp;

    /** @inheritdoc */
    protected $table = 'status_histories';

    /** @inheritdoc */
    protected $fillable = [
        'from_status',
        'to_status',
        'note',
        'changed_by',
        'created_at',
        'updated_at'
    ];

     /** @inheritdoc */
    protected $attributes = [
        'from_status' => StatusType::REVIEW,
        'to_status' => StatusType::REVIEW,
    ];

    //== Accessor - Mutator

    protected function casts(): array
    {
        return [
            'from_status' => StatusType::class,
            'to_status' => StatusType::class,
        ];
    }
    // Tambahkan relasi atau method lain sesuai kebutuhan
    
    /**
     * Polymorphic relation to the model that owns the status change.
     */
    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * User who changed the status.
     */
    public function changer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}