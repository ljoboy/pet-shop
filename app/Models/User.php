<?php

declare(strict_types=1);

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

/**
 * @mixin IdeHelperUser
 */
final class User extends Authenticatable implements JWTSubject
{
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'last_login_at',
        'is_admin',
        'is_marketing',
        'address',
        'phone_number',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'id',
        'is_admin',
        'last_login_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
        'is_marketing' => 'boolean',
    ];

    protected static function boot(): void
    {
        parent::boot();
        User::creating(function ($model): void {
            $model->id = static::max('id') + 1;
            $model->uuid = Str::uuid()->toString();
            $model->password = Hash::make($model->password);
        });
    }

    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    #[ArrayShape(['user_uuid' => 'mixed|string'])]
    public function getJWTCustomClaims(): array
    {
        return [
            'user_uuid' => $this->uuid,
        ];
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @param  string|null  $field
     * @return Model|null
     */
    public function resolveRouteBinding($value, $field = null): ?Model
    {
        return $this->where('uuid', $value)->firstOrFail();
    }
}
