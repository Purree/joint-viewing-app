<?php

namespace App\Helpers;

use BaconQrCode\Renderer\Color\Rgb;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\Fill;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use OTPHP\TOTP;

class TwoFactorAuthenticationProvider
{
    public static function generateSecretKey(): string
    {
        return TOTP::create()->getSecret();
    }

    protected static function createQrCodeUrl(string $companyName, string $companyEmail, string $secret): string
    {
        $totp = TOTP::create($secret);
        $totp->setLabel($companyEmail);
        $totp->setIssuer($companyName);

        return $totp->getProvisioningUri();
    }

    protected static function createQrCodeSvg(string $qrCodeUri): string
    {
        $svg = (new Writer(
            new ImageRenderer(
                new RendererStyle(192, 1, fill: Fill::uniformColor(new Rgb(255, 255, 255), new Rgb(45, 55, 72))),
                new SvgImageBackEnd
            )
        ))->writeString($qrCodeUri);

        return trim(substr($svg, strpos($svg, "\n") + 1));
    }

    public static function getQrCode($username, $twoFactorSecret): array
    {
        $qrCodeUri = self::createQrCodeUrl(config('app.name'), $username, $twoFactorSecret);
        $qrCodeSvg = self::createQrCodeSvg($qrCodeUri);

        return [
            'svg' => $qrCodeSvg,
            'url' => $qrCodeUri,
        ];
    }

    public static function verify(string $secret, string $code): bool
    {
        return TOTP::create($secret)->verify($code, null, 15);
    }
}
