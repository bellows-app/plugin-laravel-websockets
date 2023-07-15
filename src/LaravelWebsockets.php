<?php

namespace Bellows\Plugins;

use Bellows\PluginSdk\Contracts\Deployable;
use Bellows\PluginSdk\Contracts\Installable;
use Bellows\PluginSdk\Facades\Deployment;
use Bellows\PluginSdk\Plugin;
use Bellows\PluginSdk\PluginResults\CanBeDeployed;
use Bellows\PluginSdk\PluginResults\CanBeInstalled;
use Bellows\PluginSdk\PluginResults\DeploymentResult;
use Bellows\PluginSdk\PluginResults\InstallationResult;

class LaravelWebsockets extends Plugin implements Deployable, Installable
{
    use CanBeDeployed, CanBeInstalled;

    protected const BROADCAST_DRIVER = 'pusher';

    public function install(): ?InstallationResult
    {
        return InstallationResult::create();
    }

    public function deploy(): ?DeploymentResult
    {
        return DeploymentResult::create()->environmentVariable(
            'BROADCAST_DRIVER',
            self::BROADCAST_DRIVER,
        );
    }

    public function requiredComposerPackages(): array
    {
        return [
            'beyondcode/laravel-websockets',
        ];
    }

    public function shouldDeploy(): bool
    {
        return Deployment::site()->env()->get('BROADCAST_DRIVER') !== self::BROADCAST_DRIVER;
    }

    public function confirmDeploy(): bool
    {
        return Deployment::confirmChangeValueTo(
            Deployment::site()->env()->get('BROADCAST_DRIVER'),
            self::BROADCAST_DRIVER,
            'Change broadcast driver to Laravel Websockets'
        );
    }
}
