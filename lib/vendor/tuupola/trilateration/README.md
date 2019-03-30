#  Trilateration

[![Latest Version](https://img.shields.io/packagist/v/tuupola/trilateration.svg?style=flat-square)](https://packagist.org/packages/tuupola/trilateration)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/tuupola/trilateration/master.svg?style=flat-square)](https://travis-ci.org/tuupola/trilateration)
[![Coverage](http://img.shields.io/codecov/c/github/tuupola/trilateration.svg?style=flat-square)](https://codecov.io/github/tuupola/trilateration)

PHP implementation of [Trilateration](https://en.wikipedia.org/wiki/Trilateration) algorithm. See [Wifi Trilateration With Three or More Points](https://appelsiini.net/2017/trilateration-with-n-points/) for walkthrough.

## Install

Install the library using [Composer](https://getcomposer.org/).

``` bash
$ composer require tuupola/trilateration
```

## Usage
### Pure PHP Version

Pure PHP implementation calculates the position by finding the intersection of three spheres using traditional algebra. If the spheres do not intersect algorithm enlarges the spheres until they do intersect.

```php
use Tuupola\Trilateration\Intersection;
use Tuupola\Trilateration\Sphere;

$sphere1 = new Sphere(60.1695, 24.9354, 81175);
$sphere2 = new Sphere(58.3806, 26.7251, 162311);
$sphere3 = new Sphere(58.3859, 24.4971, 116932);

$trilateration = new Intersection($sphere1, $sphere2, $sphere3);
$point = $trilateration->position();

print_r($point);

/*
Tuupola\Trilateration\Point Object
(
    [latitude:protected] => 59.418775152143
    [longitude:protected] => 24.753287172291
)
*/

$url = "https://appelsiini.net/circles/"
     . "?c={$sphere1}&c={$sphere2}&c={$sphere3}&m={$point}";

print '<a href="{$url}">Open in map</a>';
```
[Open in map](https://appelsiini.net/circles/?c=60.1695,24.9354,81175&c=58.3806,26.7251,162311&c=58.3859,24.4971,116932&m=59.418775152143,24.753287172291")

### Non Linear Least Squares Using R

R version uses [non linear least squares fitting](http://mathworld.wolfram.com/NonlinearLeastSquaresFitting.html). It can use three or more locations for the calculation and gives better results when given data is less accurate. Before using this version you must install the [R language](https://www.r-project.org/) and [geosphere](https://cran.r-project.org/web/packages/geosphere/index.html) package.

```
$ sudo yum -y install R
$ sudo su - -c "R -e \"install.packages('geosphere', repos='http://cran.rstudio.com/')\""
```

```php
use Tuupola\Trilateration\NonLinearLeastSquares;
use Tuupola\Trilateration\Sphere;

$sphere1 = new Sphere(60.1695, 24.9354, 81175);
$sphere2 = new Sphere(58.3806, 26.7251, 162311);
$sphere3 = new Sphere(58.3859, 24.4971, 116932);

$trilateration = new NonLinearLeastSquares($sphere1, $sphere2, $sphere3);
$point = $trilateration->position();

print_r($point);

/*
Tuupola\Trilateration\Point Object
(
    [latitude:protected] => 59.4355408765689
    [longitude:protected] => 24.7747644991839

)
*/

$url = "https://appelsiini.net/circles/"
     . "?c={$sphere1}&c={$sphere2}&c={$sphere3}&m={$point}";

print '<a href="{$url}">Open in map</a>';
```

[Open in map](https://appelsiini.net/circles/?c=60.1695,24.9354,81175&c=58.3806,26.7251,162311&c=58.3859,24.4971,116932&m=59.4355408765689,24.7747644991839)

## Testing

You can run tests either manually or automatically on every code change. Automatic tests require [entr](http://entrproject.org/) to work.

``` bash
$ make test
```
``` bash
$ brew install entr
$ make watch
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email tuupola@appelsiini.net instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
