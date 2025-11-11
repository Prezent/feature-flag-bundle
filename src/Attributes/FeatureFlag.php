<?php

declare(strict_types=1);

namespace Prezent\FeatureFlagBundle\Attributes;

use Attribute;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
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
     * Create a new FeatureFlag attribute.
     *
     * Accepts either a single string feature or an array of strings.
     * Operator can be 'and' (default) or 'or'.
     *
     * Examples:
     *  #[FeatureFlag('my_feature')]
     *  #[FeatureFlag(['a', 'b'], 'or')]
     * @param string|array<string> $features
     */
    public function __construct(string|array $features, ?string $operator = null)
    {
        if (is_string($features)) {
            $this->features = [$features];
        } else {
            $this->features = $features;
        }

        if ($operator !== null) {
            $this->operator = strtolower($operator);
        }
    }

    public function getOperator(): string
    {
        return $this->operator;
    }

    /**
     * @return array<string>
     */
    public function getFeatures(): array
    {
        return $this->features;
    }
}
