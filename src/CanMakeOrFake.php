<?php

namespace SettleUp\CanMakeOrFake;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Traits\Conditionable;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;

trait CanMakeOrFake
{
    use Conditionable;

    public static function make(): static
    {
        return App::make(static::class);
    }

    public static function fake(\Closure $closure): MockInterface|LegacyMockInterface
    {
        $mock = \Mockery::mock(static::class, $closure)->makePartial();
        App::instance(static::class, $mock);

        return $mock;
    }
}
