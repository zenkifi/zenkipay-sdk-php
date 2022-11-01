<?php

declare(strict_types=1);

namespace Zenkipay;

use Zenkipay\Auth;
use Zenkipay\Endpoint\Todos;
use Zenkipay\Endpoint\Disputes;
use Zenkipay\Endpoint\TrackingNumbers;
use Http\Client\Common\HttpMethodsClientInterface;
use Http\Client\Common\Plugin\BaseUriPlugin;
use Http\Client\Common\Plugin\HeaderDefaultsPlugin;

final class Sdk
{
    private ClientBuilder $clientBuilder;
    private string $public_key;
    private string $private_key;

    public function __construct(string $public_key, string $private_key, Options $options = null)
    {
        $this->public_key = $public_key;
        $this->private_key = $private_key;
        $options = $options ?? new Options();
        $access_token = $this->getAccessToken();

        $this->clientBuilder = $options->getClientBuilder();
        $this->clientBuilder->addPlugin(new BaseUriPlugin($options->getUri()));
        $this->clientBuilder->addPlugin(
            new HeaderDefaultsPlugin([
                'Authorization' => 'Bearer ' . $access_token,
                'User-Agent' => 'zenkipay-php',
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])
        );
    }

    public function getHttpClient(): HttpMethodsClientInterface
    {
        return $this->clientBuilder->getHttpClient();
    }

    public function getPublicKey(): string
    {
        return $this->public_key;
    }

    public function getPrivateKey(): string
    {
        return $this->private_key;
    }

    public function getAccessToken(): string
    {
        $access_token = Auth::getAccessToken($this->public_key);
        return $access_token['access_token'];
    }

    public function todos(): Todos
    {
        return new Endpoint\Todos($this);
    }

    public function disputes(): Disputes
    {
        return new Endpoint\Disputes($this);
    }

    public function trackingNumbers(): TrackingNumbers
    {
        return new Endpoint\TrackingNumbers($this);
    }
}
