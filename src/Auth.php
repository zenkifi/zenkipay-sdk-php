<?php

declare(strict_types=1);

namespace Zenkipay;

use Exception;

final class Auth
{
    public const GATEWAY_URL = 'https://prod-gateway.zenki.fi';

    /**
     * Get Zenkipay's access token
     *
     * @return array
     */
    public static function getAccessToken(string $public_key): array
    {
        $ch = curl_init();
        $url = self::GATEWAY_URL . '/public/v1/merchants/plugin/token';

        curl_setopt($ch, CURLOPT_POSTFIELDS, $public_key);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:text/plain']);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        $result = curl_exec($ch);

        if ($result === false) {
            throw new Exception('Cannot get the access token');
        }

        curl_close($ch);

        return json_decode($result, true);
    }
}
