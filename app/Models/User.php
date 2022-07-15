<?php

namespace App\Models;

use App\Http\Resources\UserResource;
use App\Services\Secrets\TwoFactorSecret;
use App\Services\TwoFactorAuthenticationProvider;
use BaconQrCode\Renderer\Color\Rgb;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\Fill;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Resources\Json\JsonResource;
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

    public function getValidatedData(): JsonResource
    {
        return new UserResource($this);
    }

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
    public function getRecoveryCodes(): null|string
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

    public function twoFactorQrCodeSvg(): string
    {
        $svg = (new Writer(
            new ImageRenderer(
                new RendererStyle(192, 0, null, null, Fill::uniformColor(new Rgb(255, 255, 255), new Rgb(45, 55, 72))),
                new SvgImageBackEnd
            )
        ))->writeString($this->twoFactorQrCodeUrl());

        return trim(substr($svg, strpos($svg, "\n") + 1));
    }

    public function twoFactorQrCodeUrl(): string
    {
        return TwoFactorAuthenticationProvider::qrCodeUrl(
            config('app.name'),
            $this->name,
            decrypt($this->two_factor_secret)
        );
    }
}
