<?php

namespace Prezent\FeatureFlagBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Prezent\FeatureFlagBundle\Repository\FeatureFlagRepository;

/**
 * @ORM\Entity(repositoryClass="Prezent\FeatureFlagBundle\Repository\FeatureFlagRepository")
 * @ORM\Table(name="feature_flag")
 */
#[ORM\Entity(repositoryClass: FeatureFlagRepository::class)]
#[ORM\Table(name: "feature_flag")]
class FeatureFlag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id", type="integer")
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "id", type: "integer")]
    private int $id;

    /**
     * @ORM\Column(name="feature", type="string", unique=true)
     */
    #[ORM\Column(name: "feature", type: "string", unique: true)]
    private string $feature;

    /**
     * @ORM\Column(name="enabled", type="boolean")
     */
    #[ORM\Column(name: "enabled", type: "boolean")]
    private bool $enabled;

    public function __construct(string $feature, ?bool $enabled = null)
    {
        $this->feature = $feature;
        if (null !== $enabled) {
            $this->enabled = $enabled;
        }
    }

    /**
     * Getter for id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
     * Getter for enabled
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * Setter for enabled
     *
     * @param bool $enabled
     * @return self
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }
}
