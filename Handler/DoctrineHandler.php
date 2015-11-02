<?php

namespace Prezent\FeatureFlagBundle\Handler;

use Doctrine\ORM\EntityManager;
use Prezent\FeatureFlagBundle\Entity\FeatureFlag;

/**
 * Prezent\FeatureFlagBundle\Handler\DoctrineHandler
 *
 * @author Robert-Jan Bijl <robert-jan@prezent.nl>
 */
class DoctrineHandler extends Handler
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * {@inheritDoc}
     */
    public function initialize()
    {
        /** @var FeatureFlag $featureFlag */
        foreach ($this->em->getRepository(FeatureFlag::class)->getAll() as $featureFlag) {
            $this->permissions[$featureFlag->getFeature()] = $featureFlag->isEnabled();
        }

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function isActivated($featureName)
    {
        if (!isset($this->permissions[$featureName])) {
            return $this->getDefaultPermission();
        }

        return $this->permissions[$featureName];
    }
}