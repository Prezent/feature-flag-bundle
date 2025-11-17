Usage
-----

You can declare feature requirements on controllers and methods, using  PHP Attributes.

  ```php
  use Prezent\FeatureFlagBundle\Attributes\FeatureFlag;

  #[FeatureFlag('my_feature')]
  class MyController { }
  ```

Multiple features and operators:

- All must be active (default AND):
  ```php
  #[FeatureFlag(['a', 'b'])]
  ```

- At least one must be active (OR):
  ```php
  #[FeatureFlag(['a', 'b'], 'or')]
  ```

You can apply these on a class and/or on individual controller methods. Repeatable attributes are supported, e.g.:

```php
#[FeatureFlag('a')]
#[FeatureFlag('b')]
public function index() {}
```
