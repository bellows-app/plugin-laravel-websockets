<?php

use Bellows\Plugins\LaravelWebsockets;

it('can set the env variable', function () {
    $result = $this->plugin(LaravelWebsockets::class)->deploy();

    expect($result->getEnvironmentVariables())->toEqual([
        'BROADCAST_DRIVER' => 'pusher',
    ]);
});
