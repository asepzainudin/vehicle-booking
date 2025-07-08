<?php

namespace App\Models\Base;

use App\Concerns\Tenant\InteractWithTenant;
use App\Contracts\Base\HasSetting;
use App\Contracts\Tenant\HasTenant;
use App\Models\Model;
use App\Vendor\LaravelHashId\Eloquent\HashableId;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Fluent;

/**
 * @property int $id
 * @property string $hash_id
 * @property string $hash
 * @property string $type
 * @property string $key
 * @property string $value
 * @property string $value_type
 * @property array $complex
 * @property bool $is_active
 */
class Setting extends Model implements HasSetting, HasTenant
{
    use SoftDeletes;
    use HashableId;
    use InteractWithTenant;

    /** @inheritdoc */
    protected $table = 'settings';

    /** @inheritdoc */
    protected $fillable = [
        'type', 'key',
        'value', 'value_type', 'complex', 'is_active',
    ];

    //== Accessor - Mutator

    protected function casts(): array
    {
        return [
            'complex' => 'array',
            'is_active' => 'boolean',
        ];
    }

    //== Relationships

    //== Methods

    /**
     * @param  HasSetting|null  $setting
     *
     * @return Fluent
     */
    public static function mapSetting(HasSetting|null $setting): Fluent
    {
        $mappedSetting = [];
        if ($setting instanceof HasSetting) {
            $value = match ($setting->value_type) {
                'bool',
                'boolean' => in_array($setting->value, ['true', '1']),
                'int',
                'integer' => (int) $setting->value,
                default => $setting->value,
            };

            $mappedSetting = [
                'type' => $setting->type,
                'value' => $value,
                'complex' => $setting->complex,
            ];
        }

        return new Fluent($mappedSetting);
    }
}
