<?php

declare(strict_types=1);

namespace Prezent\FeatureFlagBundle\Annotations\Driver;

use Doctrine\Common\Annotations\Reader;
use Prezent\FeatureFlagBundle\Annotations;
use Prezent\FeatureFlagBundle\Driver\FeatureFlagAccessTrait;
use Prezent\FeatureFlagBundle\Handler\HandlerInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;

class AnnotationDriver
{
    use FeatureFlagAccessTrait;

    public function __construct(
        private Reader $reader,
        private HandlerInterface $featureFlagHandler
    ) {
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

        // 1) check all class annotations (Doctrine)
        foreach ($this->reader->getClassAnnotations($object) as $annotation) {
            $this->checkAnnotation($annotation);
        }

        // 2) check all method annotations (Doctrine)
        foreach ($this->reader->getMethodAnnotations($method) as $annotation) {
            $this->checkAnnotation($annotation);
        }
    }

    /**
     * Check if the annotation is a FF declaration, and check the FF if applicable
     *
     * @param mixed $annotation
     */
    private function checkAnnotation($annotation): void
    {
        if (!($annotation instanceof Annotations\FeatureFlag)) {
            return;
        }

        $access = $this->evaluateAccess($annotation->getFeatures(), $annotation->getOperator());
        $this->enforceAccess($access);
    }
}
