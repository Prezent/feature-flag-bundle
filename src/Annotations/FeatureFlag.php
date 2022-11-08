<?php

declare(strict_types=1);

namespace Prezent\FeatureFlagBundle\Annotations;

/**
 * @Annotation
 * @author Robert-Jan Bijl <robert-jan@prezent.nl>
 */
final class FeatureFlag
{
    private string $feature;

    /**
     * @param string|array<string> $feature
     */
    public function __construct($feature)
    {
        if (is_array($feature)) {
            $feature = reset($feature);
        }

        $this->feature = $feature;
    }

    /**
     * Getter for feature
     *
     * @return string
     */
    public function getFeature(): string
    {
        return $this->feature;
    }

    /**
     * Setter for feature
     */
    public function setFeature(string $feature): self
    {
        $this->feature = $feature;

        return $this;
    }
}
