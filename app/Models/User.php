<?php

namespace App\Models;

use App\Exceptions\InvalidArgumentException;
use App\Exceptions\UserAlreadyInRoomException;
use App\Helpers\Secrets\TwoFactorSecret;
use App\Helpers\TwoFactorAuthenticationProvider;
use App\Http\Resources\RoomResource;
use BaconQrCode\Renderer\Color\Rgb;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\Fill;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Hash;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use JsonException;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'secret',
        'two_factor_recovery_codes',
        'two_factor_secret',
        'current_room_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $with = ['sessions'];

    public function sessions(): HasMany
    {
        return $this->hasMany(Session::class);
    }

    public function hasEnabledTwoFactorAuthentication(): bool
    {
        return ! is_null($this->two_factor_secret);
    }

    /**
     * @throws JsonException
     */
    public function getRecoveryCodes(): null|array
    {
        return json_decode(decrypt($this->two_factor_recovery_codes), true, 512, JSON_THROW_ON_ERROR);
    }

    public function replaceRecoveryCode($code): void
    {
        $this->forceFill([
            'two_factor_recovery_codes' => encrypt(
                str_replace(
                    $code,
                    TwoFactorSecret::create()['phrase'],
                    decrypt($this->two_factor_recovery_codes)
                )
            ),
        ])->save();
    }

    public function disableTwoFactor(): void
    {
        $this->forceFill([
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
        ])->save();
    }

    public function currentRoom(): HasOne
    {
        return $this->hasOne(Room::class, 'id', 'current_room_id');
    }

    public function createdRoom(): HasOne
    {
        return $this->hasOne(Room::class, 'owner_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    /**
     * @throws UserAlreadyInRoomException
     * @throws InvalidArgumentException
     */
    public function join(Room $room, ?string $password = null): RoomResource
    {
        if ($this->currentRoom || $this->createdRoom) {
            throw new UserAlreadyInRoomException('You are already in a room.');
        }

        if ($room->is_closed && ! Hash::check($password, $room->password)) {
            throw new InvalidArgumentException('Incorrect password.');
        }

        $this->current_room_id = $room->id;
        $this->save();

        return new RoomResource($room);
    }
}
