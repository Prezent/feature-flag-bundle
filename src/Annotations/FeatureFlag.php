<?php

declare(strict_types=1);

namespace Prezent\FeatureFlagBundle\Annotations;

/**
 * @Annotation
 */
final class FeatureFlag
{
    public const OPERATOR_AND = 'and';
    public const OPERATOR_OR = 'or';

    /**
     * @var array<string>
     */
    private array $features = [];

    private string $operator = self::OPERATOR_AND;

    /**
     * @param string|array<string> $values
     */
    public function __construct($values)
    {
        $values = reset($values);
        if (is_string($values)) {
            $this->features = [$values];
        } else {
            if (is_string($values[0])) {
                $this->features = $values;
            } else {
                $this->features = $values[0];

                if (isset($values[1])) {
                    $this->operator = strtolower($values[1]);
                }
            }
        }
    }

    public function getOperator(): string
    {
        return $this->operator;
    }

    /**
     * Getter for feature
     *
     * @return array<string>
     */
    public function getFeatures(): array
    {
        return $this->features;
    }
}
