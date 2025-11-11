<?php

declare(strict_types=1);

namespace Prezent\FeatureFlagBundle\Twig;

use Prezent\FeatureFlagBundle\Handler\HandlerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class FeatureFlagExtension extends AbstractExtension
{
    public function __construct(
        private HandlerInterface $handler
    ) {
    }

    /**
     * {@inheritDoc}
     * @return array<TwigFunction>
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('has_feature', [$this, 'checkFeature']),
        ];
    }

    /**
     * Check if the feature is activated
     */
    public function checkFeature(string $featureName): bool
    {
        return $this->handler->isActivated($featureName);
    }

    public function getName(): string
    {
        return 'prezent_feature_flag_extension';
    }
}
