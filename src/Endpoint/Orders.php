<?php

declare(strict_types=1);

namespace Zenkipay\Endpoint;

use Zenkipay\HttpClient\Message\ResponseMediator;
use Zenkipay\Sdk;

final class Orders
{
    private Sdk $sdk;

    public function __construct(Sdk $sdk)
    {
        $this->sdk = $sdk;
    }

    public function create(array $data): object
    {
        return ResponseMediator::getContent($this->sdk->getHttpClient()->post('/v1/pay/orders', [], json_encode($data)));
    }
}