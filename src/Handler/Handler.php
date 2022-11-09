<?php

declare(strict_types=1);

namespace Prezent\FeatureFlagBundle\Handler;

/**
 * @author Robert-Jan Bijl <robert-jan@prezent.nl>
 */
abstract class Handler implements HandlerInterface
{
    /**
     * The default permission, i.e. what to return if the feature is not defined
     */
    protected bool $defaultPermission;

    /**
     * The computed permissions
     *
     * @var array<string, bool>
     */
    protected array $permissions = [];

    /**
     * {@inheritDoc}
     */
    public function isActivated(string $feature): bool
    {
        $feature = strtolower($feature);
        foreach ($this->permissions as $key => $permission) {
            if (strtolower($feature) === $key) {
                return $permission;
            }
        }

        return $this->getDefaultPermission();
    }

    public function featureExists(string $feature): bool
    {
        $feature = strtolower($feature);
        foreach ($this->permissions as $key => $permission) {
            if (strtolower($feature) === $key) {
                return true;
            }
        }

        return false;
    }

    /**
     * Getter for defaultPermission
     */
    public function getDefaultPermission(): bool
    {
        return $this->defaultPermission;
    }

    /**
     * Setter for defaultPermission
     */
    public function setDefaultPermission(bool $defaultPermission): self
    {
        $this->defaultPermission = $defaultPermission;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getFeatures(): array
    {
        return array_keys($this->permissions);
    }

    /**
     * {@inheritDoc}
     */
    public function getPermissions(): array
    {
        return $this->permissions;
    }
}
