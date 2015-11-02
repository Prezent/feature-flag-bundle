<?php

namespace Prezent\FeatureFlagBundle\Repository;

use Doctrine\ORM\EntityRepository;

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
     * @param bool|true $useResultCache
     * @return array
     */
    public function getAll($useResultCache = true)
    {
        $query = $this->createQueryBuilder('f')
            ->getQuery();

        if ($useResultCache) {
            $query->useResultCache(true);
        }

        return $query->getResult();
    }
}