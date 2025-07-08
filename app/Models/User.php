<?php

namespace App\Models;

use App\Concerns\Base\InteractWithAddress;
use App\Concerns\Partner\InteractWithPartner;
use App\Contracts\Base\HasAddress;
use App\Contracts\Partner\HasPartner;
use App\Enums\UserType;
use App\Models\Partner\Partner;
use App\Models\Travel\Travel;
use App\Vendor\LaravelHashId\Eloquent\HashableId;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail, HasPartner, HasMedia, HasAddress
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles, HashableId;
    use InteractWithPartner, InteractsWithMedia;
    use InteractWithAddress;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'partner_id', 'travel_id', 'name', 'username', 'phone', 'email',
        'identity_type', 'identity_number',
        'status', 'type', 'email_verified_at',
        'last_login_at', 'last_login_ip',
        'locale', 'timezone', 'option', 'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'option' => 'array',
            'type' => UserType::class,
        ];
    }

    public function getProfilePhotoUrlAttribute()
    {
        // if ($this->profile_photo_path) {
        //     return asset('storage/' . $this->profile_photo_path);
        // }
        //
        // return $this->profile_photo_path;
        return '#';
    }

    // public function addresses(): HasMany
    // {
    //     return $this->hasMany(Address::class);
    // }

    // public function getDefaultAddressAttribute()
    // {
    //     return $this->addresses?->first();
    // }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class, 'partner_id', 'id');
    }

    public function travel(): BelongsTo
    {
        return $this->belongsTo(Travel::class, 'travel_id', 'id');
    }
}
