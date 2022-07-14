<?php

namespace App\Services;

use OTPHP\TOTP;

class TwoFactorAuthenticationProvider
{
    /**
     * The underlying library providing two-factor authentication helper services.
     *
     * @var TOTP
     */
    protected TOTP $engine;

    /**
     * Create a new two-factor authentication provider instance.
     *
     * @param  TOTP  $engine
     */
    public function __construct(TOTP $engine)
    {
        $this->engine = $engine;
    }

    /**
     * Generate a new secret key.
     *
     * @return string
     */
    public function generateSecretKey(): string
    {
        return $this->engine::create()->getSecret();
    }

    /**
     * Get the two-factor authentication QR code URL.
     *
     * @param  string  $companyName
     * @param  string  $companyEmail
     * @param  string  $secret
     * @return string
     */
    public function qrCodeUrl(string $companyName, string $companyEmail, string $secret): string
    {
        return $this->engine::create($secret)
            ->setLabel($companyEmail)
            ->setIssuer($companyName)
            ->getProvisioningUri();
    }

    /**
     * Verify the given code.
     *
     * @param  string  $secret
     * @param  string  $code
     * @return bool
     */
    public function verify(string $secret, string $code): bool
    {
        return $this->engine::create($secret)->verify($code, window: 30);
    }
}
