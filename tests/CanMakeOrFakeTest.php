<?php

use Illuminate\Support\Facades\App;
use Mockery\MockInterface;
use SettleUp\CanMakeOrFake\Tests\Fixtures\ExampleService;

it('resolves a new instance from the container using make', function () {
    $instance = ExampleService::make();

    expect($instance)->toBeInstanceOf(ExampleService::class);
});

it('resolves the same singleton when bound as a singleton', function () {
    App::singleton(ExampleService::class);

    $first = ExampleService::make();
    $second = ExampleService::make();

    expect($first)->toBe($second);
});

it('replaces the container binding with a mock using fake', function () {
    ExampleService::fake(function (MockInterface $mock) {
        $mock->shouldReceive('greet')->andReturn('faked');
    });

    $resolved = ExampleService::make();

    expect($resolved->greet())->toBe('faked');
});

it('returns a partial mock from fake so real methods still work', function () {
    ExampleService::fake(function (MockInterface $mock) {
        $mock->shouldReceive('greet')->andReturn('faked');
    });

    $resolved = ExampleService::make();

    expect($resolved->greet())->toBe('faked')
        ->and($resolved->farewell())->toBe('goodbye');
});

it('returns the mock instance from fake', function () {
    $mock = ExampleService::fake(function (MockInterface $mock) {
        //
    });

    expect($mock)->toBeInstanceOf(MockInterface::class);
});

it('supports conditionable via when', function () {
    $instance = ExampleService::make();

    $result = $instance->when(true, fn (ExampleService $service) => $service->greet());

    expect($result)->toBe('hello');
});

it('supports conditionable via unless', function () {
    $instance = ExampleService::make();

    $result = $instance->unless(false, fn (ExampleService $service) => $service->greet());

    expect($result)->toBe('hello');
});
