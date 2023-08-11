<?php

declare(strict_types=1);

namespace Prezent\FeatureFlagBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Prezent\FeatureFlagBundle\Entity\FeatureFlag;


class FeatureFlagRepository extends EntityRepository
{
    /**
     * Get all feature flags, use resultCache if prompted
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
