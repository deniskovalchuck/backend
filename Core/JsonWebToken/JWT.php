<?php

declare(strict_types=1);

namespace Core\JsonWebToken;

class JWT
{
    use ValidatesJWT;

    const ERROR_KEY_EMPTY        = 10;
    const ERROR_KEY_INVALID      = 12;
    const ERROR_ALGO_UNSUPPORTED = 20;
    const ERROR_ALGO_MISSING     = 22;
    const ERROR_INVALID_MAXAGE   = 30;
    const ERROR_INVALID_LEEWAY   = 32;
    const ERROR_JSON_FAILED      = 40;
    const ERROR_TOKEN_INVALID    = 50;
    const ERROR_TOKEN_EXPIRED    = 52;
    const ERROR_TOKEN_NOT_NOW    = 54;
    const ERROR_SIGNATURE_FAILED = 60;
    const ERROR_KID_UNKNOWN      = 70;

    /**
     * @var array Поддерживаемые алгоритмы подписи.
     */
    protected $algos = [
        'HS256' => 'sha256',
        'HS384' => 'sha384',
        'HS512' => 'sha512',
        'RS256' => \OPENSSL_ALGO_SHA256,
        'RS384' => \OPENSSL_ALGO_SHA384,
        'RS512' => \OPENSSL_ALGO_SHA512,
    ];

    /**
     * @var string|resource Ключ подписи.
     */
    protected $key;

    /**
     * @var array Список поддерживаемых ключей с идентификатором.
     */
    protected $keys = [];

    /**
     * @var int|null Используйте setTestTimestamp (), чтобы установить пользовательское значение для time ().
     * Полезно для тестируемости.
     */
    protected $timestamp = null;

    /**
     * @var string Алгоритм подписи JWT. По умолчанию HS256.
     */
    protected $algo = 'HS256';

    /**
     * @var int JWT TTL в секундах. По умолчанию 1 час.
     */
    protected $maxAge = 3600;

    /**
     * @var int Период отсрочки в секундах, чтобы учесть перекос часов. По умолчанию 0 секунд.
     */
    protected $leeway = 0;

    /**
     * @var string|null Пароль для подписи RSA (необязательно).
     */
    protected $passphrase;

    /**
     * Конструктор.
     *
     * @param string|resource $key   Ключ подписи. Для RS * это должен быть путь к файлу или ресурс закрытого ключа.
     * @param string          $algo   Алгоритм подписи / проверки токена.
     * @param int             $maxAge TTL токена, который будет использоваться для определения истечения срока действия, если заявка `iat 'присутствует.
     * Это также используется для предоставления заявки по умолчанию "exp" в случае, если она отсутствует.
     * @param int             $leeway Отставание для перекоса часов. Не должно быть более 2 минут (120 с).
     * @param string          $pass   Пароль (только для RS * algos).
     */
    public function __construct(
        $key,
        string $algo = 'HS256',
        int $maxAge = 3600,
        int $leeway = 0,
        string $pass = null
    ) {
        $this->validateConfig($key, $algo, $maxAge, $leeway);

        if (\is_array($key)) {
            $this->registerKeys($key);
            $key = \reset($key); // use first one!
        }

        $this->key        = $key;
        $this->algo       = $algo;
        $this->maxAge     = $maxAge;
        $this->leeway     = $leeway;
        $this->passphrase = $pass;
    }

    /**
     * Регистрация ключей для поддержки `kid`.
     *
     * @param array $keys Используйте формат: ['<kid>' => '<key data>', '<kid2>' => '<key data2>']
     *
     * @return self
     */
    public function registerKeys(array $keys): self
    {
        $this->keys = \array_merge($this->keys, $keys);

        return $this;
    }

    /**
     * Кодировать полезную нагрузку как токен JWT.
     *
     * @param array $payload
     * @param array $header  Дополнительный заголовок (если есть) для добавления.
     *
     * @return string URL безопасный токен JWT.
     */
    public function encode(array $payload, array $header = []): string
    {
        $header = ['typ' => 'JWT', 'alg' => $this->algo] + $header;

        $this->validateKid($header);

        if (!isset($payload['iat']) && !isset($payload['exp'])) {
            $payload['exp'] = ($this->timestamp ?: \time()) + $this->maxAge;
        }

        $header    = $this->urlSafeEncode($header);
        $payload   = $this->urlSafeEncode($payload);
        $signature = $this->urlSafeEncode($this->sign($header . '.' . $payload));

        return $header . '.' . $payload . '.' . $signature;
    }

    /**
     * Расшифруйте токен JWT и верните исходную полезную нагрузку.
     *
     * @param string $token
     *
     * @throws JWTException
     *
     * @return array
     */
    public function decode(string $token): array
    {
        if (\substr_count($token, '.') < 2) {
            throw new JWTException('Invalid token: Incomplete segments', static::ERROR_TOKEN_INVALID);
        }

        $token = \explode('.', $token, 3);
        $this->validateHeader((array) $this->urlSafeDecode($token[0]));

        // Validate signature.
        if (!$this->verify($token[0] . '.' . $token[1], $token[2])) {
            throw new JWTException('Invalid token: Signature failed', static::ERROR_SIGNATURE_FAILED);
        }

        $payload = (array) $this->urlSafeDecode($token[1]);

        $this->validateTimestamps($payload);

        return $payload;
    }

    /**
     * Поддельная текущая временная метка для тестирования.
     *
     * @param int|null $timestamp
     */
    public function setTestTimestamp(int $timestamp = null): self
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * Подпишите вход с настроенным ключом и верните подпись.
     *
     * @param string $input
     *
     * @return string
     */
    protected function sign(string $input): string
    {
        // HMAC SHA.
        if (\substr($this->algo, 0, 2) === 'HS') {
            return \hash_hmac($this->algos[$this->algo], $input, $this->key, true);
        }

        $this->validateKey();

        \openssl_sign($input, $signature, $this->key, $this->algos[$this->algo]);

        return $signature;
    }

    /**
     * Проверьте подпись данного ввода.
     *
     * @param string $input
     * @param string $signature
     *
     * @throws JWTException Когда ключ недействителен.
     *
     * @return bool
     */
    protected function verify(string $input, string $signature): bool
    {
        $algo = $this->algos[$this->algo];

        // HMAC SHA.
        if (\substr($this->algo, 0, 2) === 'HS') {
            return \hash_equals($this->urlSafeEncode(\hash_hmac($algo, $input, $this->key, true)), $signature);
        }

        $this->validateKey();

        $pubKey = \openssl_pkey_get_details($this->key)['key'];

        return \openssl_verify($input, $this->urlSafeDecode($signature, false), $pubKey, $algo) === 1;
    }

    /**
     * URL безопасное кодирование base64.
     *
     * Сначала сериализует полезную нагрузку как json, если это массив.
     *
     * @param array|string $data
     *
     * @throws JWTException Когда JSON кодировать не удается.
     *
     * @return string
     */
    protected function urlSafeEncode($data): string
    {
        if (\is_array($data)) {
            $data = \json_encode($data, \JSON_UNESCAPED_SLASHES);
            $this->validateLastJson();
        }

        return \rtrim(\strtr(\base64_encode($data), '+/', '-_'), '=');
    }

    /**
     * URL безопасное декодирование base64.
     *
     * @param array|string $data
     * @param bool         $asJson Анализировать ли как JSON (по умолчанию true).
     *
     * @throws JWTException Когда JSON кодировать не удается.
     *
     * @return array|\stdClass|string
     */
    protected function urlSafeDecode($data, bool $asJson = true)
    {
        if (!$asJson) {
            return \base64_decode(\strtr($data, '-_', '+/'));
        }

        $data = \json_decode(\base64_decode(\strtr($data, '-_', '+/')),true);
        $this->validateLastJson();

        return $data;
    }
}
