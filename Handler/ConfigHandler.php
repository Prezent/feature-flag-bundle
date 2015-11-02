<?php

namespace Prezent\FeatureFlagBundle\Handler;

/**
 * Prezent\FeatureFlagBundle\Handler\ConfigHandler
 *
 * @author Robert-Jan Bijl <robert-jan@prezent.nl>
 */
class ConfigHandler extends Handler
{
    /**
     * @var
     */
    private $features;

    /**
     * @param array $features
     */
    public function __construct(array $features)
    {
        $this->features = $features;
    }

    /**
     * Convert the container configuration to the permissions array
     */
    public function initialize()
    {
        foreach ($this->features as $featureName => $featureValues) {
            $this->permissions[$featureName] = $featureValues['enabled'];
        }

        return true;
    }
}