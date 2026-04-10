<?php

namespace SettleUp\CanMakeOrFake\Tests\Fixtures;

use SettleUp\CanMakeOrFake\CanMakeOrFake;

class ExampleService
{
    use CanMakeOrFake;

    public function greet(): string
    {
        return 'hello';
    }

    public function farewell(): string
    {
        return 'goodbye';
    }
}
