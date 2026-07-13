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
$image->crop(100, 100, Image::GRAVITY_TOP_LEFT);
$image->save($target, 'jpg', 100);

//crop around subjects described with natural language
$image = new Image(\file_get_contents('image.jpg'));
$image->crop(400, 300, focus: 'person holding a phone');
$image->save('focused.jpg', 'jpg', 100);

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

### Focus Cropping

The optional `focus` argument uses zero-shot object detection to position the crop around matching subjects:

```php
$image->crop(400, 300, focus: 'person');
$image->crop(400, 300, focus: 'red car');
```

When multiple subjects match, the crop keeps all of them when possible and otherwise prioritizes the strongest detections. If nothing matches, the supplied gravity is used as a fallback:

```php
$image->crop(400, 300, Image::GRAVITY_TOP, focus: 'red car');
```

Focus cropping requires PHP FFI. The platform-specific inference runtime is installed through Composer, which requires allowing its reviewed installer plugin:

```bash
composer config allow-plugins.codewithkyrian/platform-package-installer true
```

The prebuilt Linux inference runtime targets glibc. Alpine and other musl-based images require a musl-compatible ONNX Runtime build.

The quantized model is cached on first use. Production deployments should download it during the build instead of during an image request:

```bash
./vendor/bin/transformers download Xenova/owlvit-base-patch32 zero-shot-object-detection
```

## System Requirements

Utopia Image requires PHP 8.1 or later with the Imagick, GD, and FFI extensions. We recommend using the latest PHP version whenever possible.

## Copyright and license

The MIT License (MIT) [http://www.opensource.org/licenses/mit-license.php](http://www.opensource.org/licenses/mit-license.php)
