<?php

namespace Kraken\_Unit\Framework\Console\Server\Provider;

use Kraken\Container\ServiceProvider;
use Kraken\Core\Core;
use Kraken\Root\Console\Server\Provider\ChannelProvider;
use Kraken\Root\Console\Server\Provider\CommandProvider;
use Kraken\Root\Console\Server\Provider\ProjectProvider;
use Kraken\Test\TUnit;

class ProviderAllTest extends TUnit
{
    /**
     * @dataProvider providerProvider
     * @param ServiceProvider $provider
     */
    public function testApiUnregister_UnregistersAllProvidedInterfaces($provider)
    {
        $core = $this->getMock(Core::class, [], [], '', false);
        $provides = $provider->getProvides();
        $unset = [];

        $core
            ->expects($this->any())
            ->method('remove')
            ->will($this->returnCallback(function($provided) use(&$unset) {
                $unset[] = $provided;
            }));

        $provider->unregisterProvider($core);

        $this->assertSame($provides, $unset);
    }

    /**
     *
     */
    public function providerProvider()
    {
        return [
            [ new ChannelProvider() ],
            [ new CommandProvider() ],
            [ new ProjectProvider() ]
        ];
    }
}
