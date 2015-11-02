<?php

namespace Prezent\FeatureFlagBundle\Handler;

/**
 * Prezent\FeatureFlagBundle\Handler\HandlerInterface
 *
 * @author Robert-Jan Bijl <robert-jan@prezent.nl>
 */
interface HandlerInterface
{
    /**
     * Check if the feature is activated
     *
     * @param $featureName
     * @return mixed
     */
    public function isActivated($featureName);
}