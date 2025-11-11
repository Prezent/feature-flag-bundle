<?php

declare(strict_types=1);

namespace Prezent\FeatureFlagBundle\Handler;

class ConfigHandler extends Handler
{
    /**
     * @param array<string, bool> $features
     */
    public function __construct(
        private array $features
    ) {
    }

    /**
     * Convert the container configuration to the permissions array
     */
    public function initialize(): void
    {
        foreach ($this->features as $featureName => $featureValue) {
            $this->permissions[$featureName] = $featureValue;
        }
    }
}
