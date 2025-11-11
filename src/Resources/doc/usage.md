Usage
-----

You can declare feature requirements on controllers and methods, using either annotations or native PHP 8 Attributes.

- PHP 8 Attribute:
  ```php
  use Prezent\FeatureFlagBundle\Attributes\FeatureFlag;

  #[FeatureFlag('my_feature')]
  class MyController { }
  ```

- Annotation (BC):
  ```php
  use Prezent\FeatureFlagBundle\Annotations\FeatureFlag;

  /**
   * @FeatureFlag({"my_feature"})
   */
  class MyController { }
  ```

Multiple features and operators:

- All must be active (default AND):
  ```php
  #[FeatureFlag(['a', 'b'])]
  // or Annotation: @FeatureFlag({"a","b"})
  ```

- At least one must be active (OR):
  ```php
  #[FeatureFlag(['a', 'b'], 'or')]
  // or Annotation: @FeatureFlag({{"a","b"}, "or"})
  ```

You can apply these on a class and/or on individual controller methods. Repeatable attributes are supported, e.g.:

```php
#[FeatureFlag('a')]
#[FeatureFlag('b')]
public function index() {}
```
