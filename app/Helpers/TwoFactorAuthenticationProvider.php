<?php

namespace App\Helpers;

use OTPHP\TOTP;

class TwoFactorAuthenticationProvider
{
    /**
     * Generate a new secret key.
     *
     * @return string
     */
    public static function generateSecretKey(): string
    {
        return TOTP::create()->getSecret();
    }

    /**
     * Get the two-factor authentication QR code URL.
     *
     * @param  string  $companyName
     * @param  string  $companyEmail
     * @param  string  $secret
     * @return string
     */
    public static function qrCodeUrl(string $companyName, string $companyEmail, string $secret): string
    {
        $totp = TOTP::create($secret);
        $totp->setLabel($companyEmail);
        $totp->setIssuer($companyName);

        return $totp->getProvisioningUri();
    }

    /**
     * Verify the given code.
     *
     * @param  string  $secret
     * @param  string  $code
     * @return bool
     */
    public static function verify(string $secret, string $code): bool
    {
        return TOTP::create($secret)->verify($code, null, 15);
    }
}
