# JSON to Entity
[![pipeline status](https://gitlab.com/niko9911/php-json-to-entity/badges/master/pipeline.svg)](https://gitlab.com/niko9911/php-json-to-entity/commits/master)
[![coverage report](https://gitlab.com/niko9911/php-json-to-entity/badges/master/coverage.svg)](https://gitlab.com/niko9911/php-json-to-entity/commits/master)

Map json into entity. This allows you to easily validate payload json
and map it automatically into entity class. This class can be
for example ORM class, when you can directly save it into the DB.

This is pretty nice, if you're lazy and need just to develop fast, 
but if you need high performance application, please map json and
validate json manually. Comes with performance strike, but saves time.

## Install

Via [composer](http://getcomposer.org):

```shell
composer require niko9911/json-to-entity
```

## Usage


```php
<?php
declare(strict_types=1);

// Declare entity where to map.
final class Basic
{
    /**
     * @var string
     */
    private $bar;
    /**
     * @var int|null
     */
    private $foo;
    /**
     * @var array
     */
    private $fooBar;

    /**
     * BasicUnitTestEntity constructor.
     *
     * @param string $bar
     * @param int    $foo
     * @param array  $fooBar
     */
    public function __construct(string $bar, ?int $foo, array $fooBar)
    {
        $this->bar = $bar;
        $this->foo = $foo;
        $this->fooBar = $fooBar;
    }

    /**
     * @return string
     */
    public function getBar(): string
    {
        return $this->bar;
    }

    /**
     * @return int|null
     */
    public function getFoo(): ?int
    {
        return $this->foo;
    }

    /**
     * @return array
     */
    public function getFooBar(): array
    {
        return $this->fooBar;
    }
}

// JSON
$json = <<<JSON
{
  "bar": "Some_Bar",
  "foo": 10,
  "fooBar": ["a", "b", "c"]
}
JSON;

$mapper = new \Niko9911\JsonToEntity\Mapper();
$entity = $mapper->map(\json_decode($json), Basic::class);
var_dump($entity);
//class Basic#25 (3) {
//  private $bar =>
//  string(8) "Some_Bar"
//  private $foo =>
//  int(10)
//  private $fooBar =>
//  array(3) {
//    [0] =>
//    string(1) "a"
//    [1] =>
//    string(1) "b"
//    [2] =>
//    string(1) "c"
//  }
//}


```

## License

Licensed under the [MIT license](http://opensource.org/licenses/MIT).
