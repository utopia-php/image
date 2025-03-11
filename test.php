<?php

require_once './vendor/autoload.php';

use Utopia\Image\Image;

// Use the test image that comes with the repo
$imagePath = __DIR__ . '/tests/resources/disk-a/kitten-1.jpg';

// Test 1: Crop image
$image = new Image(file_get_contents($imagePath));
$target = 'output/image_100x100.jpg';
$image->crop(100, 100); // Remove the GRAVITY_NORTHWEST constant
$image->save($target, 'jpg', 100);

// Test 2: Border and rotation
$image = new Image(file_get_contents($imagePath));
$target = 'output/image_border.jpg';
$image->setBorder(2, "#ff0000"); // add border 2 px, red
$image->setRotation(45); // rotate 45 degree
$image->save($target, 'jpg', 100);

// Test 3: Opacity
$image = new Image(file_get_contents($imagePath));
$target = 'output/image_opacity.png';
$image->setOpacity(0.2); // set opacity
$image->save($target, 'png', 100);

// Create output directory if it doesn't exist
if (!file_exists('output')) {
    mkdir('output');
}

echo "Images have been processed and saved to the 'output' directory\n";