<?php

declare(strict_types=1);

namespace Prezent\FeatureFlagBundle\Annotations\Driver;

use Doctrine\Common\Annotations\Reader;
use Prezent\FeatureFlagBundle\Annotations;
use Prezent\FeatureFlagBundle\Handler\HandlerInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Prezent\FeatureFlagBundle\Annotations\Driver\AnnotationDriver
 *
 * @author Robert-Jan Bijl <robert-jan@prezent.nl>
 */
class AnnotationDriver
{
    private Reader $reader;

    private HandlerInterface $featureFlagHandler;

    /**
     * Constructor
     *
     * @param Reader $reader
     * @param HandlerInterface $featureFlagHandler
     */
    public function __construct(Reader $reader, HandlerInterface $featureFlagHandler)
    {
        $this->reader = $reader;
        $this->featureFlagHandler = $featureFlagHandler;
    }

    /**
     * This event will fire during any controller call
     */
    public function onKernelController(FilterControllerEvent $event): void
    {
        // return if there is no controller for this event
        if (!is_array($controller = $event->getController())) {
            return;
        }

        // get the controller
        $object = new \ReflectionObject($controller[0]);

        // get the specific method that has been called
        $method = $object->getMethod($controller[1]);

        // check all class annotations
        foreach ($this->reader->getClassAnnotations($object) as $annotation) {
            $this->checkAnnotation($annotation);
        }

        // check all method annotations
        foreach ($this->reader->getMethodAnnotations($method)  as $annotation) {
            $this->checkAnnotation($annotation);
        }
    }

    /**
     * Check if the annotation is a FF annotation, and check the FF if applicable
     *
     * @param $annotation
     * @return bool
     */
    private function checkAnnotation($annotation): bool
    {
        // check if one of the annotations is about feature flags
        if ($annotation instanceof Annotations\FeatureFlag) {
            $features = $annotation->getFeatures();
            $access = false;

            switch ($annotation->getOperator()) {
                case Annotations\FeatureFlag::OPERATOR_OR:
                    $access = false;
                    foreach ($features as $feature) {
                        $access = $access || $this->featureFlagHandler->isActivated($feature);
                    }
                    break;

                case Annotations\FeatureFlag::OPERATOR_AND:
                default:
                    $access = true;
                    foreach ($features as $feature) {
                        $access = $access && $this->featureFlagHandler->isActivated($feature);
                    }
                    break;
            }

            // check the result, throw a 403 if the feature is not activated
            if (!$access) {
                throw new AccessDeniedHttpException();
            }
        }

        return true;
    }
}
