<?php

namespace Prezent\FeatureFlagBundle\Twig;

use Prezent\FeatureFlagBundle\Handler\HandlerInterface;

/**
 * Prezent\FeatureFlagsBundle\Twig\FeatureFlagExtension
 *
 * @author Robert-Jan Bijl <robert-jan@prezent.nl>
 */
class FeatureFlagExtension extends \Twig_Extension
{
    /**
     * @var HandlerInterface
     */
    private $handler;

    /**
     * Constructor
     *
     * @param HandlerInterface $handler
     */
    public function __construct(HandlerInterface $handler)
    {
        $this->handler = $handler;
    }

    /**
     * {@inheritDoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('has_feature', [$this, 'checkFeature']),
        ];
    }

    /**
     * Check if the feature is activated
     *
     * @param string $featureName
     * @return bool
     */
    public function checkFeature($featureName)
    {
        return $this->handler->isActivated($featureName);
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'prezent_feature_flag_extension';
    }
}