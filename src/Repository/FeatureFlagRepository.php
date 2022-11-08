<?php

declare(strict_types=1);

namespace Prezent\FeatureFlagBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Prezent\FeatureFlagBundle\Entity\FeatureFlag;

/**
 * Prezent\FeatureFlagBundle\Repository\FeatureFlagRepository
 *
 * @author Robert-Jan Bijl <robert-jan@prezent.nl>
 */
class FeatureFlagRepository extends EntityRepository
{
    /**
     * Get all feature flags, use resultcache if prompted
     *
     * @return array<FeatureFlag>
     */
    public function getAll(bool $useResultCache = true): array
    {
        $query = $this->createQueryBuilder('f')
            ->getQuery();

        if ($useResultCache) {
            $query->useResultCache(true);
        }

        return $query->getResult();
    }
}
