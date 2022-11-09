<?php

declare(strict_types=1);

namespace Prezent\FeatureFlagBundle\Handler;

/**
 * @author Robert-Jan Bijl <robert-jan@prezent.nl>
 */
interface HandlerInterface
{
    /**
     * Check if the feature is activated
     */
    public function isActivated(string $feature): bool;

    /**
     * Checks if the feature exists in the system
     */
    public function featureExists(string $feature): bool;

    /**
     * Get all the defined features
     *
     * @return array<string>
     */
    public function getFeatures(): array;

    /**
     * Get the full array of permission
     *
     * @return array<string, bool>
     */
    public function getPermissions(): array;

}
