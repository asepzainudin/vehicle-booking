<?php

namespace App\Concerns\Partner;

use App\Enums\ActionType;
use App\Models\Partner\Partner;
use App\Models\Partner\PartnerAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Fluent;
use Throwable;

trait InteractWithPartner
{
    use HasRelationships;

    /** @var string */
    public static string $partnerKey = 'partner_id';

    // /** @var string|null */
    // public string|null $partnerActionKey = null;

    /**
     * Trait initialize
     *
     * @return void
     */
    public function initializeInteractWithPartner(): void
    {
        $this->mergeFillable([static::$partnerKey]);
    }

    /**
     * @return string
     */
    public static function partnerKey(): string
    {
        return static::$partnerKey;
    }

    /**
     * @param  Builder  $query
     * @param  string|int  $partnerId
     * @param  bool  $allowNull
     * @param  string|null  $key
     *
     * @return void
     */
    public function scopeUsePartner(Builder $query, string|int|null $partnerId, bool $allowNull = false, string|null $key = null): void
    {
        if (!$partnerId && !$allowNull) {
            $query->whereNull('id');
            return;
        }

        if (is_string($partnerId)) {
            $partnerId = Partner::hashToId($partnerId);
        }

        // read from setting
        if ($allowNull) {
            try {
                $allowSetting = setting(key: 'allow_null_partner', partnerId: $partnerId);
            } catch (Throwable $e) {
                $allowSetting = new Fluent();
            }

            if (
                ! $allowSetting->get('value') ||
                ($key &&  ! $allowSetting->get('complex.'.$key))
            ) {
                $allowNull = false;
            }
        }

        $query->where(function (Builder $query) use ($partnerId, $allowNull) {
            $query->where(static::$partnerKey, $partnerId);
            if ($allowNull) {
                $query->orWhereNull(static::$partnerKey);
            }
        });
    }

    /**
     * @param  Builder  $query
     * @param  string|array|null  $action
     *
     * @return void
     */
    public function scopeWithoutAction(Builder $query, string|array|null $action = null): void
    {
        return;
        if (!$action) {
            $action = ActionType::DELETE;
        }
        $query->whereDoesntHave('action', function (Builder $qry) use ($action) {
            $qry->select(DB::raw(1));
            if (is_array($action)) {
                $qry->whereIn('type', $action);
            } else {
                $qry->where('type', $action);
            }
        });
    }

    /**
     * @return BelongsTo
     */
    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class, static::$partnerKey);
    }

    /**
     * @return HasMany
     */
    public function partners(): HasMany
    {
        return $this->hasMany(Partner::class, static::$partnerKey);
    }

    /**
     * @return MorphOne
     */
    public function action(): MorphOne
    {
        $key = $this->getKeyName();
        $partnerKey = static::$partnerKey;
        $partnerId = authPartnerId();
        $actionKey = $this->getActionKey();

        // return $this->morphOne(
        //     related: PartnerAction::class,
        //     name: 'actionable',
        //     id: is_int($this->$key) ? 'actionable_id' : 'actionable_uuid',
        // )->where($partnerKey, $this->$partnerKey);

        $instance = $this->newRelatedInstance(PartnerAction::class);
        // [$type, $id] = $this->getMorphs($name, $type, $id);
        $table = $instance->getTable();
        $query = $instance->newQuery()->where($partnerKey, $this->$partnerKey ?? $partnerId);

        return $this->newMorphOne(
            query: $query,
            parent: $this,
            type: $table.'.actionable_type',
            id: $table.$actionKey,
            localKey: $key
        );
    }

    /**
     * @return MorphMany
     */
    public function actions(): MorphMany
    {
        $key = $this->getKeyName();
        $partnerKey = static::$partnerKey;
        $partnerId = authPartnerId();
        $actionKey = $this->getActionKey();

        // return $this->morphMany(
        //     related: PartnerAction::class,
        //     name: 'actionable',
        //     id: is_int($this->$key) ? 'actionable_id' : 'actionable_uuid',
        // );

        $instance = $this->newRelatedInstance(PartnerAction::class);

        // [$type, $id] = $this->getMorphs($name, $type, $id);
        $table = $instance->getTable();
        $query = $instance->newQuery()->where($partnerKey, $this->$partnerKey ?? $partnerId);

        return $this->newMorphMany(
            query: $query,
            parent: $this,
            type: $table.'.actionable_type',
            id: $table.$actionKey,
            localKey: $key
        );
    }

    /**
     * @param  ActionType  $action
     *
     * @return bool
     * @throws Throwable
     */
    public function doAction(ActionType $action): bool
    {
        $partnerId = authPartnerId();
        if ($partnerId) {
            try {
                $this->action()->updateOrCreate([
                    static::partnerKey() => $partnerId,
                ], [
                    'type' => $action,
                ]);

                return true;
            } catch (\Exception $e) {
                throw_if(app()->hasDebugModeEnabled(), $e);
            }
        }
        return false;
    }

    private function getActionKey(): string
    {
        $key = $this->getKeyName();
        return property_exists($this, 'partnerActionKey') && in_array($this->partnerActionKey, ['actionable_id', 'actionable_uuid'])
            ? '.'.$this->partnerActionKey
            : (is_int($this->$key) ? '.actionable_id' : '.actionable_uuid');
    }
}
