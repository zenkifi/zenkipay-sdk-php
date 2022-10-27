<?php

declare(strict_types=1);

namespace Zenkipay\Tests;

use Zenkipay\ClientBuilder;
use Zenkipay\Options;
use Zenkipay\Sdk;
use Http\Mock\Client;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    protected Client $mockClient;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockClient = new Client();
    }

    protected function givenSdk(): Sdk
    {
        return new Sdk(
            new Options([
                'client_builder' => new ClientBuilder($this->mockClient),
            ])
        );
    }
}
