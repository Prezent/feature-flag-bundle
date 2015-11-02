<?php

namespace Prezent\FeatureFlagBundle\Annotations;

/**
 *
 * Prezent\FeatureFlagBundle\Annotations\FeatureFlag
 *
 * @Annotation
 * @author Robert-Jan Bijl <robert-jan@prezent.nl>
 */
class FeatureFlag
{
    /**
     * @var string
     */
    private $feature;

    /**
     * Constructor
     *
     * @param $feature
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
    public function getFeature()
    {
        return $this->feature;
    }

    /**
     * Setter for feature
     *
     * @param string $feature
     * @return self
     */
    public function setFeature($feature)
    {
        $this->feature = $feature;
        return $this;
    }
}