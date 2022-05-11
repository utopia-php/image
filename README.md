# Utopia Image

[![Build Status](https://travis-ci.org/utopia-php/ab.svg?branch=master)](https://travis-ci.com/utopia-php/image)
![Total Downloads](https://img.shields.io/packagist/dt/utopia-php/image.svg)
[![Discord](https://img.shields.io/discord/564160730845151244?label=discord)](https://appwrite.io/discord)

Utopia Image library isLite &amp; fast micro PHP library for creating common image manipulations that is **easy to use**. This library is maintained by the [Appwrite team](https://appwrite.io).


## Getting Started

Install using composer:
```bash
composer require utopia-php/image
```

```php
<?php

require_once '../vendor/autoload.php';

use Utopia\Image\Image;

//crop image
$image = new Image(\file_get_contents('image.jpg'));
$target = 'image_100x100.jpg';
$image->crop(100, 100, Image::GRAVITY_NORTHWEST);
$image->save($target, 'jpg', 100);

$image = new Image(\file_get_contents('image.jpg'));
$target = 'image_border.jpg';
$image->setBorder(2, "#ff0000"); //add border 2 px, red
$image->setRotation(45); //rotate 45 degree
$image->save($target, 'jpg', 100);


$image = new Image(\file_get_contents('image.jpg'));
$target = 'image_border.jpg';
$image->setOpacity(0.2); //set opacity
$image->save($target, 'png', 100);

```

## System Requirements

Utopia Image requires PHP 8.0 or later. We recommend using the latest PHP version whenever possible.

## Authors

**Damodar Lohani**

+ [https://twitter.com/lohanidamodar](https://twitter.com/lohanidamodar)
+ [https://github.com/lohanidamodar](https://github.com/lohanidamodar)

## Copyright and license

The MIT License (MIT) [http://www.opensource.org/licenses/mit-license.php](http://www.opensource.org/licenses/mit-license.php)
