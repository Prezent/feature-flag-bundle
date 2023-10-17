<?php

declare(strict_types=1);

namespace Prezent\FeatureFlagBundle\Handler;

use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Prezent\FeatureFlagBundle\Entity\FeatureFlag;

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
        try {
            /** @var FeatureFlag $featureFlag */
            foreach ($this->em->getRepository(FeatureFlag::class)->getAll() as $featureFlag) {
                $this->permissions[$featureFlag->getFeature()] = $featureFlag->isEnabled();
            }
        } catch (Exception $e) {
            return;
        }
    }

    public function addFeature(string $feature, ?bool $permission = null): bool
    {
        $permission = $permission ?? $this->getDefaultPermission();
        if ($this->featureExists($feature)) {
            throw new \RuntimeException(sprintf('Feature %s already exists', $feature));
        }

        try {
            $featureFlag = new FeatureFlag($feature, $permission);
            $this->em->persist($featureFlag);
            $this->em->flush($featureFlag);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
