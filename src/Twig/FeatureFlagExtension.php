<?php

declare(strict_types=1);

namespace Prezent\FeatureFlagBundle\Twig;

use Prezent\FeatureFlagBundle\Handler\HandlerInterface;
use Twig\Attribute\AsTwigFunction;
use Twig\Extension\AbstractExtension;

final class FeatureFlagExtension extends AbstractExtension
{
    public function __construct(
        private HandlerInterface $handler
    ) {
    }

    /**
     * Check if the feature is activated
     */
    #[AsTwigFunction('has_feature')]
    public function checkFeature(string $featureName): bool
    {
        return $this->handler->isActivated($featureName);
    }

    public function getName(): string
    {
        return 'prezent_feature_flag_extension';
    }
}
