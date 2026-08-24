# Utopia Image

> [!IMPORTANT]
> This repository is a read-only mirror of the [utopia-php monorepo](https://github.com/utopia-php/monorepo). Development happens in [`packages/image`](https://github.com/utopia-php/monorepo/tree/main/packages/image) — please open issues and pull requests there.

![Total Downloads](https://img.shields.io/packagist/dt/utopia-php/image.svg)
[![Discord](https://img.shields.io/discord/564160730845151244?label=discord)](https://appwrite.io/discord)

Utopia Image is a lightweight PHP library for common image manipulations. It is maintained by the [Appwrite team](https://appwrite.io).

## Getting started

Install using Composer:

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

//automatically keep salient subjects in frame
$image = new Image(\file_get_contents('image.jpg'));
$image->crop(400, 300, Image::GRAVITY_AUTO);
$image->save('automatic.jpg', 'jpg', 100);

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

### Automatic Cropping

Use `Image::GRAVITY_AUTO` to position the crop around the most visually salient parts of an image:

```php
$image->crop(400, 300, Image::GRAVITY_AUTO);
```

Automatic cropping uses the bundled full U2NET saliency model. Empty or uniform saliency maps fall back to a centered crop. Applications do not need to download or configure a model.

Detection can run separately in a worker and be stored as JSON. The result contains the normalized saliency mask and its dimensions. Passing it to `crop()` skips model inference in the image worker:

```php
// Detection worker
$image = new Image(\file_get_contents('image.jpg'));
$detectionJson = json_encode($image->detect(), JSON_THROW_ON_ERROR);
// Store $detectionJson in the database.

// Image worker
$image = new Image(\file_get_contents('image.jpg'));
$detection = json_decode($detectionJson, true, flags: JSON_THROW_ON_ERROR);
$image->crop(400, 300, Image::GRAVITY_AUTO, $detection);
```

ONNX Runtime is installed per platform. Add its verified download hook to the root `composer.json` of the application using this library:

```json
{
    "scripts": {
        "post-install-cmd": "OnnxRuntime\\Vendor::check",
        "post-update-cmd": "OnnxRuntime\\Vendor::check"
    }
}
```

Then run:

```bash
composer install
```

The provided Linux runtime targets glibc. Alpine and other musl-based systems require a compatible custom ONNX Runtime library.

## System requirements

Utopia Image requires PHP 8.1 or later with the Imagick, GD, and FFI extensions. We recommend using the latest PHP version whenever possible.

## Copyright and license

The MIT License (MIT) [http://www.opensource.org/licenses/mit-license.php](http://www.opensource.org/licenses/mit-license.php)
