<?php

declare(strict_types=1);

namespace Prezent\FeatureFlagBundle\Attributes\Driver;

use Prezent\FeatureFlagBundle\Attributes\FeatureFlag as FeatureFlagAttribute;
use Prezent\FeatureFlagBundle\Driver\FeatureFlagAccessTrait;
use Prezent\FeatureFlagBundle\Handler\HandlerInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;

class AttributeDriver
{
    use FeatureFlagAccessTrait;

    private HandlerInterface $featureFlagHandler;

    public function __construct(HandlerInterface $featureFlagHandler)
    {
        $this->featureFlagHandler = $featureFlagHandler;
    }

    /**
     * This event will fire during any controller call
     */
    public function onKernelController(ControllerEvent $event): void
    {
        // return if there is no controller for this event
        if (!is_array($controller = $event->getController())) {
            return;
        }

        // get the controller
        $object = new \ReflectionObject($controller[0]);

        // get the specific method that has been called
        $method = $object->getMethod($controller[1]);

        // 1) check all class attributes
        foreach ($object->getAttributes(FeatureFlagAttribute::class) as $attribute) {
            $this->checkAttribute($attribute->newInstance());
        }

        // 2) check all method attributes
        foreach ($method->getAttributes(FeatureFlagAttribute::class) as $attribute) {
            $this->checkAttribute($attribute->newInstance());
        }
    }

    private function checkAttribute(object $attributeInstance): void
    {
        if (!($attributeInstance instanceof FeatureFlagAttribute)) {
            return;
        }

        $access = $this->evaluateAccess($attributeInstance->getFeatures(), $attributeInstance->getOperator());
        $this->enforceAccess($access);
    }
}
