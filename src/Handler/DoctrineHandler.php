<?php

declare(strict_types=1);

namespace Prezent\FeatureFlagBundle\Handler;

use Doctrine\ORM\EntityManagerInterface;
use Prezent\FeatureFlagBundle\Entity\FeatureFlag;

/**
 * @author Robert-Jan Bijl <robert-jan@prezent.nl>
 */
class DoctrineHandler extends Handler
{
    private EntityManagerInterface $em;

    private string $cacheDir;

    public function __construct(EntityManagerInterface $em, string $cacheDir)
    {
        $this->em = $em;
        $this->cacheDir = $cacheDir;
    }

    public function initialize(): void
    {
        /** @var FeatureFlag $featureFlag */
        foreach ($this->em->getRepository(FeatureFlag::class)->getAll() as $featureFlag) {
            $this->permissions[$featureFlag->getFeature()] = $featureFlag->isEnabled();
        }
    }
}
