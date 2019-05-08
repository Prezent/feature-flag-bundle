<?php

namespace Prezent\FeatureFlagBundle\Handler;

/**
 * Prezent\FeatureFlagBundle\Handler\Handler
 *
 * @author Robert-Jan Bijl <robert-jan@prezent.nl>
 */
abstract class Handler implements HandlerInterface
{
    /**
     * The default permission, i.e. what to return if the feature is not defined
     *
     * @var bool
     */
    protected $defaultPermission;

    /**
     * The computed permissions
     *
     * @var array
     */
    protected $permissions = [];

    /**
     * {@inheritDoc}
     */
    public function isActivated($featureName)
    {
        $key = strtolower($featureName);
        if (!isset($this->permissions[$key])) {
            return $this->getDefaultPermission();
        }

        return $this->permissions[$key];
    }

    /**
     * Getter for defaultPermission
     *
     * @return boolean
     */
    public function getDefaultPermission()
    {
        return $this->defaultPermission;
    }

    /**
     * Setter for defaultPermission
     *
     * @param boolean $defaultPermission
     * @return self
     */
    public function setDefaultPermission($defaultPermission)
    {
        $this->defaultPermission = $defaultPermission;
        return $this;
    }
}