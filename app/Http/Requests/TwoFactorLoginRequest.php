<?php

namespace App\Http\Requests;

use App\Helpers\Results\ResponseResult;
use App\Helpers\TwoFactorAuthenticationProvider;
use App\Helpers\TwoFactorSessionKeyNames;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use JetBrains\PhpStorm\ArrayShape;
use JsonException;

class TwoFactorLoginRequest extends FormRequest
{
    /**
     * The user attempting the two factor challenge.
     *
     * @var mixed
     */
    protected User $challengedUser;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth('sanctum')->guest();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    #[ArrayShape(['code' => 'string', 'recovery_code' => 'string'])]
    public function rules(): array
    {
        return [
            'code' => 'nullable|string',
            'recovery_code' => 'nullable|string',
        ];
    }

    /**
     * Determine if the request has a valid two-factor code.
     *
     * @return bool
     */
    public function hasValidCode(): bool
    {
        return $this->code && tap(
            TwoFactorAuthenticationProvider::verify(
                decrypt($this->challengedUser()->two_factor_secret),
                $this->code
            ),
            function ($result) {
                if ($result) {
                    $this->session()->forget(TwoFactorSessionKeyNames::LOGIN_ATTEMPT->value);
                }
            }
        );
    }

    /**
     * Get the valid recovery code if one exists on the request.
     *
     * @return string|null
     *
     * @throws JsonException
     */
    public function validRecoveryCode(): ?string
    {
        if (! $this->recovery_code) {
            return null;
        }

        return tap(
            collect($this->challengedUser()->getRecoveryCodes())->first(function ($code) {
                return hash_equals($this->recovery_code, $code) ? $code : null;
            }),
            function ($code) {
                if ($code) {
                    $this->session()->forget(TwoFactorSessionKeyNames::LOGIN_ATTEMPT->value);
                }
            }
        );
    }

    /**
     * Determine if there is a challenged user in the current session.
     *
     * @return bool
     */
    public function hasChallengedUser(): bool
    {
        if (isset($this->challengedUser)) {
            return true;
        }

        return $this->session()->has(TwoFactorSessionKeyNames::LOGIN_ATTEMPT->value) &&
            User::find($this->session()->get(TwoFactorSessionKeyNames::LOGIN_ATTEMPT->value));
    }

    /**
     * Get the user that is attempting the two factor challenge.
     *
     * @return User
     */
    public function challengedUser(): User
    {
        if (isset($this->challengedUser)) {
            return $this->challengedUser;
        }

        if (! $this->session()->has(TwoFactorSessionKeyNames::LOGIN_ATTEMPT->value) ||
            ! $user = User::find($this->session()->get(TwoFactorSessionKeyNames::LOGIN_ATTEMPT->value))) {
            throw new HttpResponseException(
                ResponseResult::error(
                    ['code' => ['The provided two factor authentication code was invalid.']],
                    Response::HTTP_UNAUTHORIZED
                )
            );
        }

        return $this->challengedUser = $user;
    }
}
