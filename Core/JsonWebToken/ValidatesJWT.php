<?php

declare(strict_types=1);


namespace Core\jsonWebToken\Jwt;

trait ValidatesJWT
{
    /**
     * Подбросьте, если входные параметры неверны.
     *
     * @codeCoverageIgnore
     */
    protected function validateConfig($key, string $algo, int $maxAge, int $leeway)
    {
        if (empty($key)) {
            throw new JWTException('Signing key cannot be empty', static::ERROR_KEY_EMPTY);
        }

        if (!isset($this->algos[$algo])) {
            throw new JWTException('Unsupported algo ' . $algo, static::ERROR_ALGO_UNSUPPORTED);
        }

        if ($maxAge < 1) {
            throw new JWTException('Invalid maxAge: Should be greater than 0', static::ERROR_INVALID_MAXAGE);
        }

        if ($leeway < 0 || $leeway > 120) {
            throw new JWTException('Invalid leeway: Should be between 0-120', static::ERROR_INVALID_LEEWAY);
        }
    }

    /**
     * Поднимите, если заголовок недействителен.
     */
    protected function validateHeader(array $header)
    {
        if (empty($header['alg'])) {
            throw new JWTException('Invalid token: Missing header algo', static::ERROR_ALGO_MISSING);
        }
        if (empty($this->algos[$header['alg']])) {
            throw new JWTException('Invalid token: Unsupported header algo', static::ERROR_ALGO_UNSUPPORTED);
        }

        $this->validateKid($header);
    }

    /**
     * Брось, если ребенок существует и недействителен
     */
    protected function validateKid(array $header)
    {
        if (!isset($header['kid'])) {
            return;
        }
        if (empty($this->keys[$header['kid']])) {
            throw new JWTException('Invalid token: Unknown key ID', static::ERROR_KID_UNKNOWN);
        }

        $this->key = $this->keys[$header['kid']];
    }

    /**
     * Поднимите, если отметки времени, такие как iat, exp, nbf, недопустимы.
     */
    protected function validateTimestamps(array $payload)
    {
        $timestamp = $this->timestamp ?: \time();
        $checks    = [
            ['exp', $this->leeway /*          */ , static::ERROR_TOKEN_EXPIRED, 'Expired'],
            ['iat', $this->maxAge - $this->leeway, static::ERROR_TOKEN_EXPIRED, 'Expired'],
            ['nbf', $this->maxAge - $this->leeway, static::ERROR_TOKEN_NOT_NOW, 'Not now'],
        ];

        foreach ($checks as list($key, $offset, $code, $error)) {
            if (isset($payload[$key])) {
                $offset += $payload[$key];
                $fail    = $key === 'nbf' ? $timestamp <= $offset : $timestamp >= $offset;

                if ($fail) {
                    throw new JWTException('Invalid token: ' . $error, $code);
                }
            }
        }
    }

    /**
     * Поднимите, если ключ не является ресурсом или путь к файлу для закрытого ключа.
     */
    protected function validateKey()
    {
        if (\is_string($key = $this->key)) {
            if (\substr($key, 0, 7) !== 'file://') {
                $key = 'file://' . $key;
            }

            $this->key = \openssl_get_privatekey($key, $this->passphrase ?: '');
        }

        if (!\is_resource($this->key)) {
            throw new JWTException('Invalid key: Should be resource of private key', static::ERROR_KEY_INVALID);
        }
    }

    /**
     * Поднимите, если последний json_encode / decode был неудачным.
     */
    protected function validateLastJson()
    {
        if (\JSON_ERROR_NONE === \json_last_error()) {
            return;
        }

        throw new JWTException('JSON failed: ' . \json_last_error_msg(), static::ERROR_JSON_FAILED);
    }
}
