<?php

declare(strict_types=1);

namespace Prezent\FeatureFlagBundle\Driver;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Shared feature-flag access evaluation used by drivers.
 */
trait FeatureFlagAccessTrait
{
    /**
     * Evaluate access for a set of features using the provided operator.
     *
     * @param array<string> $features
     */
    private function evaluateAccess(array $features, string $operator): bool
    {
        $operator = strtolower($operator);

        if ($operator === 'or') {
            $access = false;
            foreach ($features as $feature) {
                $access = $access || $this->featureFlagHandler->isActivated($feature);
            }

            return $access;
        }

        // Default AND
        $access = true;
        foreach ($features as $feature) {
            $access = $access && $this->featureFlagHandler->isActivated($feature);
        }

        return $access;
    }

    private function enforceAccess(bool $access): void
    {
        if (!$access) {
            throw new AccessDeniedHttpException();
        }
    }
}
