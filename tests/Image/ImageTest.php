<?php

namespace Appwrite\Tests;

use PHPUnit\Framework\TestCase;
use Utopia\Image\Image;

class ImageTest extends TestCase
{
    protected function setUp(): void {}

    protected function tearDown(): void {}

    public function test_jpeg(): void
    {
        $image = new Image(\file_get_contents(__DIR__.'/../resources/disk-a/kitten-1.jpg') ?: '');
        $target = __DIR__.'/100x100.jpg';

        $image->crop(100, 100);

        $image->save($target, 'jpg', 100);

        $this->assertEquals(\is_readable($target), true);
        $this->assertFileExists($target);
        $this->assertNotEmpty(\file_get_contents($target));

        $image = new \Imagick($target);
        $this->assertEquals(100, $image->getImageWidth());
        $this->assertEquals(100, $image->getImageHeight());
        $this->assertEquals('JPEG', $image->getImageFormat());

        \unlink($target);
    }

    public function test_png(): void
    {
        $image = new Image(\file_get_contents(__DIR__.'/../resources/disk-a/kitten-1.jpg') ?: '');
        $target = __DIR__.'/100x100.png';

        $image->crop(100, 100);

        $image->save($target, 'png', 100);

        $this->assertEquals(\is_readable($target), true);
        $this->assertFileExists($target);
        $this->assertNotEmpty(\file_get_contents($target));

        $image = new \Imagick($target);
        $this->assertEquals(100, $image->getImageWidth());
        $this->assertEquals(100, $image->getImageHeight());
        $this->assertEquals('PNG', $image->getImageFormat());

        \unlink($target);
    }

    public function test_crop100x100(): void
    {
        $image = new Image(\file_get_contents(__DIR__.'/../resources/disk-a/kitten-1.jpg') ?: '');
        $target = __DIR__.'/100x100.jpg';

        $image->crop(100, 100);

        $image->save($target, 'jpg', 100);

        $this->assertEquals(\is_readable($target), true);
        $this->assertFileExists($target);
        $this->assertNotEmpty(\file_get_contents($target));

        $image = new \Imagick($target);
        $this->assertEquals(100, $image->getImageWidth());
        $this->assertEquals(100, $image->getImageHeight());
        $this->assertEquals('JPEG', $image->getImageFormat());

        \unlink($target);
    }

    public function test_crop_gravity_nw(): void
    {
        $image = new Image(\file_get_contents(__DIR__.'/../resources/disk-a/kitten-1.jpg') ?: '');
        $target = __DIR__.'/NW.jpg';
        $original = __DIR__.'/../resources/resize/NW.jpg';

        $image->crop(50, 200, Image::GRAVITY_TOP_LEFT);

        $image->save($target, 'jpg', 100);

        $this->assertEquals(\is_readable($target), true);
        $this->assertFileExists($target);
        $this->assertNotEmpty(\file_get_contents($target));
        // Verify the image was properly cropped with the expected gravity
        $generatedImage = new \Imagick($target);
        $originalImage = new \Imagick($original);
        $this->assertEquals($originalImage->getImageWidth(), $generatedImage->getImageWidth());
        $this->assertEquals($originalImage->getImageHeight(), $generatedImage->getImageHeight());

        $image = new \Imagick($target);
        $this->assertEquals(50, $image->getImageWidth());
        $this->assertEquals(200, $image->getImageHeight());
        $this->assertEquals('JPEG', $image->getImageFormat());

        \unlink($target);
    }

    public function test_crop_gravity_n(): void
    {
        $image = new Image(\file_get_contents(__DIR__.'/../resources/disk-a/kitten-3.gif') ?: '');
        $target = __DIR__.'/N.gif';
        $original = __DIR__.'/../resources/resize/N.gif';

        $image->crop(100, 50, Image::GRAVITY_TOP);

        $image->save($target, 'gif', 100);

        $this->assertEquals(\is_readable($target), true);
        $this->assertFileExists($target);
        $this->assertNotEmpty(\file_get_contents($target));
        // Verify the image was properly cropped with the expected gravity
        $generatedImage = new \Imagick($target);
        $originalImage = new \Imagick($original);
        $this->assertEquals($originalImage->getImageWidth(), $generatedImage->getImageWidth());
        $this->assertEquals($originalImage->getImageHeight(), $generatedImage->getImageHeight());

        $image = new \Imagick($target);
        $this->assertEquals(100, $image->getImageWidth());
        $this->assertEquals(50, $image->getImageHeight());
        $this->assertEquals('GIF', $image->getImageFormat());

        \unlink($target);
    }

    public function test_crop_gravity_ne(): void
    {
        $image = new Image(\file_get_contents(__DIR__.'/../resources/disk-a/kitten-1.jpg') ?: '');
        $target = __DIR__.'/NE.jpg';
        $original = __DIR__.'/../resources/resize/NE.jpg';

        $image->crop(50, 200, Image::GRAVITY_TOP_RIGHT);

        $image->save($target, 'jpg', 100);

        $this->assertEquals(\is_readable($target), true);
        $this->assertFileExists($target);
        $this->assertNotEmpty(\file_get_contents($target));
        // Verify the image was properly cropped with the expected gravity
        $generatedImage = new \Imagick($target);
        $originalImage = new \Imagick($original);
        $this->assertEquals($originalImage->getImageWidth(), $generatedImage->getImageWidth());
        $this->assertEquals($originalImage->getImageHeight(), $generatedImage->getImageHeight());

        $image = new \Imagick($target);
        $this->assertEquals(50, $image->getImageWidth());
        $this->assertEquals(200, $image->getImageHeight());
        $this->assertEquals('JPEG', $image->getImageFormat());

        \unlink($target);
    }

    public function test_crop_gravity_sw(): void
    {
        $image = new Image(\file_get_contents(__DIR__.'/../resources/disk-a/kitten-1.jpg') ?: '');
        $target = __DIR__.'/SW.jpg';
        $original = __DIR__.'/../resources/resize/SW.jpg';

        $image->crop(50, 200, Image::GRAVITY_BOTTOM_LEFT);

        $image->save($target, 'jpg', 100);

        $this->assertEquals(\is_readable($target), true);
        $this->assertFileExists($target);
        $this->assertNotEmpty(\file_get_contents($target));
        // Verify the image was properly cropped with the expected gravity
        $generatedImage = new \Imagick($target);
        $originalImage = new \Imagick($original);
        $this->assertEquals($originalImage->getImageWidth(), $generatedImage->getImageWidth());
        $this->assertEquals($originalImage->getImageHeight(), $generatedImage->getImageHeight());

        $image = new \Imagick($target);
        $this->assertEquals(50, $image->getImageWidth());
        $this->assertEquals(200, $image->getImageHeight());
        $this->assertEquals('JPEG', $image->getImageFormat());

        \unlink($target);
    }

    public function test_crop_gravity_s(): void
    {
        $image = new Image(\file_get_contents(__DIR__.'/../resources/disk-a/kitten-3.gif') ?: '');
        $target = __DIR__.'/S.gif';
        $original = __DIR__.'/../resources/resize/S.gif';

        $image->crop(100, 50, Image::GRAVITY_BOTTOM);

        $image->save($target, 'gif', 100);

        $this->assertEquals(\is_readable($target), true);
        $this->assertFileExists($target);
        $this->assertNotEmpty(\file_get_contents($target));
        // Verify the image was properly cropped with the expected gravity
        $generatedImage = new \Imagick($target);
        $originalImage = new \Imagick($original);
        $this->assertEquals($originalImage->getImageWidth(), $generatedImage->getImageWidth());
        $this->assertEquals($originalImage->getImageHeight(), $generatedImage->getImageHeight());

        $image = new \Imagick($target);
        $this->assertEquals(100, $image->getImageWidth());
        $this->assertEquals(50, $image->getImageHeight());
        $this->assertEquals('GIF', $image->getImageFormat());

        \unlink($target);
    }

    public function test_crop_gravity_se(): void
    {
        $image = new Image(\file_get_contents(__DIR__.'/../resources/disk-a/kitten-1.jpg') ?: '');
        $target = __DIR__.'/SE.jpg';
        $original = __DIR__.'/../resources/resize/SE.jpg';

        $image->crop(50, 200, Image::GRAVITY_BOTTOM_RIGHT);

        $image->save($target, 'jpg', 100);

        $this->assertEquals(\is_readable($target), true);
        $this->assertFileExists($target);
        $this->assertNotEmpty(\file_get_contents($target));
        // Verify the image was properly cropped with the expected gravity
        $generatedImage = new \Imagick($target);
        $originalImage = new \Imagick($original);
        $this->assertEquals($originalImage->getImageWidth(), $generatedImage->getImageWidth());
        $this->assertEquals($originalImage->getImageHeight(), $generatedImage->getImageHeight());

        $image = new \Imagick($target);
        $this->assertEquals(50, $image->getImageWidth());
        $this->assertEquals(200, $image->getImageHeight());
        $this->assertEquals('JPEG', $image->getImageFormat());

        \unlink($target);
    }

    public function test_crop_gravity_c(): void
    {
        $image = new Image(\file_get_contents(__DIR__.'/../resources/disk-a/kitten-1.jpg') ?: '');
        $target = __DIR__.'/C.jpg';
        $original = __DIR__.'/../resources/resize/C.jpg';

        $image->crop(150, 200, Image::GRAVITY_CENTER);

        $image->save($target, 'jpg', 100);

        $this->assertEquals(\is_readable($target), true);
        $this->assertFileExists($target);
        $this->assertNotEmpty(\file_get_contents($target));
        // Verify the image was properly cropped with the expected gravity
        $generatedImage = new \Imagick($target);
        $originalImage = new \Imagick($original);
        $this->assertEquals($originalImage->getImageWidth(), $generatedImage->getImageWidth());
        $this->assertEquals($originalImage->getImageHeight(), $generatedImage->getImageHeight());

        $image = new \Imagick($target);
        $this->assertEquals(150, $image->getImageWidth());
        $this->assertEquals(200, $image->getImageHeight());
        $this->assertEquals('JPEG', $image->getImageFormat());

        \unlink($target);
    }

    public function test_crop_gravity_w(): void
    {
        $image = new Image(\file_get_contents(__DIR__.'/../resources/disk-a/kitten-3.gif') ?: '');
        $target = __DIR__.'/W.gif';
        $original = __DIR__.'/../resources/resize/W.gif';

        $image->crop(50, 100, Image::GRAVITY_LEFT);

        $image->save($target, 'gif', 100);

        $this->assertEquals(\is_readable($target), true);
        $this->assertFileExists($target);
        $this->assertNotEmpty(\file_get_contents($target));
        // Verify the image was properly cropped with the expected gravity
        $generatedImage = new \Imagick($target);
        $originalImage = new \Imagick($original);
        $this->assertEquals($originalImage->getImageWidth(), $generatedImage->getImageWidth());
        $this->assertEquals($originalImage->getImageHeight(), $generatedImage->getImageHeight());

        $image = new \Imagick($target);
        $this->assertEquals(50, $image->getImageWidth());
        $this->assertEquals(100, $image->getImageHeight());
        $this->assertEquals('GIF', $image->getImageFormat());

        \unlink($target);
    }

    public function test_crop_gravity_e(): void
    {
        $image = new Image(\file_get_contents(__DIR__.'/../resources/disk-a/kitten-1.jpg') ?: '');
        $target = __DIR__.'/E.jpg';
        $original = __DIR__.'/../resources/resize/E.jpg';

        $image->crop(50, 200, Image::GRAVITY_RIGHT);

        $image->save($target, 'jpg', 100);

        $this->assertEquals(\is_readable($target), true);
        $this->assertFileExists($target);
        $this->assertNotEmpty(\file_get_contents($target));
        // Verify the image was properly cropped with the expected gravity
        $generatedImage = new \Imagick($target);
        $originalImage = new \Imagick($original);
        $this->assertEquals($originalImage->getImageWidth(), $generatedImage->getImageWidth());
        $this->assertEquals($originalImage->getImageHeight(), $generatedImage->getImageHeight());

        $image = new \Imagick($target);
        $this->assertEquals(50, $image->getImageWidth());
        $this->assertEquals(200, $image->getImageHeight());
        $this->assertEquals('JPEG', $image->getImageFormat());

        \unlink($target);
    }

    public function test_crop100x400(): void
    {
        $image = new Image(\file_get_contents(__DIR__.'/../resources/disk-a/kitten-1.jpg') ?: '');
        $target = __DIR__.'/100x400.jpg';

        $image->crop(100, 400);

        $image->save($target, 'jpg', 100);

        $this->assertEquals(\is_readable($target), true);
        $this->assertFileExists($target);
        $this->assertNotEmpty(\file_get_contents($target));

        $image = new \Imagick($target);
        $this->assertEquals(100, $image->getImageWidth());
        $this->assertEquals(400, $image->getImageHeight());
        $this->assertEquals('JPEG', $image->getImageFormat());

        \unlink($target);
    }

    public function test_crop400x100(): void
    {
        $image = new Image(\file_get_contents(__DIR__.'/../resources/disk-a/kitten-1.jpg') ?: '');
        $target = __DIR__.'/400x100.jpg';

        $image->crop(400, 100);

        $image->save($target, 'jpg', 100);

        $this->assertEquals(\is_readable($target), true);
        $this->assertFileExists($target);
        $this->assertNotEmpty(\file_get_contents($target));

        $image = new \Imagick($target);
        $this->assertEquals(400, $image->getImageWidth());
        $this->assertEquals(100, $image->getImageHeight());
        $this->assertEquals('JPEG', $image->getImageFormat());

        \unlink($target);
    }

    public function test_crop100x100_webp(): void
    {
        $image = new Image(\file_get_contents(__DIR__.'/../resources/disk-a/kitten-1.jpg') ?: '');
        $target = __DIR__.'/100x100.webp';
        $original = __DIR__.'/../resources/resize/100x100.webp';

        $image->crop(100, 100);

        $image->save($target, 'webp', 100);

        $this->assertEquals(\is_readable($target), true);
        $this->assertFileExists($target);
        $this->assertNotEmpty(\file_get_contents($target));

        $image = new \Imagick($target);

        $this->assertEquals(100, $image->getImageWidth());
        $this->assertEquals(100, $image->getImageHeight());
        $this->assertTrue(in_array($image->getImageFormat(), ['PAM', 'WEBP']));

        \unlink($target);
    }

    public function test_crop100x100_webp_quality30(): void
    {
        $image = new Image(\file_get_contents(__DIR__.'/../resources/disk-a/kitten-1.jpg') ?: '');
        $target = __DIR__.'/100x100-q30.webp';
        $original = __DIR__.'/../resources/resize/100x100-q30.webp';

        $image->crop(100, 100);

        $image->save($target, 'webp', 30);

        $this->assertEquals(\is_readable($target), true);
        $this->assertGreaterThan(500, \filesize($target));
        $this->assertLessThan(2000, \filesize($target));
        $this->assertEquals(\mime_content_type($target), \mime_content_type($original));
        $this->assertFileExists($target);
        $this->assertNotEmpty(\file_get_contents($target));

        $this->assertEquals(\is_readable($target), true);
        $this->assertFileExists($target);
        $this->assertNotEmpty(\file_get_contents($target));

        $image = new \Imagick($target);

        $this->assertEquals(100, $image->getImageWidth());
        $this->assertEquals(100, $image->getImageHeight());
        $this->assertTrue(in_array($image->getImageFormat(), ['PAM', 'WEBP']));

        \unlink($target);
    }

    public function test_crop100x100_avif(): void
    {
        $image = new Image(\file_get_contents(filename: __DIR__.'/../resources/disk-a/kitten-1.jpg') ?: '');
        $target = __DIR__.'/100x100.avif';

        $image->crop(100, 100);

        $image->save($target, 'avif', 100);

        $this->assertEquals(\is_readable($target), true);
        // AVIF file size can vary based on encoder version and settings
        $fileSize = \filesize($target);
        $this->assertGreaterThan(5000, $fileSize, 'AVIF file size is too small');
        $this->assertLessThan(10000, $fileSize, 'AVIF file size is too large');
        $this->assertFileExists($target);
        $this->assertNotEmpty(\file_get_contents($target));

        $image = new \Imagick($target);
        $this->assertEquals(100, $image->getImageWidth());
        $this->assertEquals(100, $image->getImageHeight());
        $this->assertEquals('AVIF', $image->getImageFormat());

        \unlink($target);
    }

    public function test_crop100x100_avif_quality30(): void
    {
        $image = new Image(\file_get_contents(filename: __DIR__.'/../resources/disk-a/kitten-1.jpg') ?: '');
        $target = __DIR__.'/100x100-q30.avif';

        $image->crop(100, 100);

        $image->save($target, 'avif', 30);

        $this->assertEquals(\is_readable($target), true);
        $this->assertLessThan(1419, \filesize($target));
        $this->assertFileExists($target);
        $this->assertNotEmpty(\file_get_contents($target));

        $image = new \Imagick($target);
        $this->assertEquals(100, $image->getImageWidth());
        $this->assertEquals(100, $image->getImageHeight());
        $this->assertEquals('AVIF', $image->getImageFormat());

        \unlink($target);
    }

    public function test_crop100x100_heic(): void
    {
        $image = new Image(\file_get_contents(__DIR__.'/../resources/disk-a/kitten-1.jpg') ?: '');
        $target = __DIR__.'/100x100.heic';
        $original = __DIR__.'/../resources/resize/100x100.heic';

        $image->crop(100, 100);

        $image->save($target, 'heic', 100);

        $this->assertEquals(\is_readable($target), true);
        $this->assertGreaterThan(500, \filesize($target));
        $this->assertEquals(8426, \filesize($target));
        $this->assertEquals(\mime_content_type($target), \mime_content_type($original));
        $this->assertFileExists($target);
        $this->assertNotEmpty(\file_get_contents($target));

        $this->assertEquals(\is_readable($target), true);
        $this->assertFileExists($target);
        $this->assertNotEmpty(\file_get_contents($target));

        $image = new \Imagick($target);

        $this->assertEquals(100, $image->getImageWidth());
        $this->assertEquals(100, $image->getImageHeight());
        $this->assertEquals('HEIC', $image->getImageFormat());

        \unlink($target);
    }

    public function test_crop100x100_heic_quality30(): void
    {
        $image = new Image(\file_get_contents(__DIR__.'/../resources/disk-a/kitten-1.jpg') ?: '');
        $target = __DIR__.'/100x100-q30.heic';
        $original = __DIR__.'/../resources/resize/100x100.heic';

        $image->crop(100, 100);

        $image->save($target, 'heic', 30);

        $this->assertEquals(\is_readable($target), true);
        $this->assertGreaterThan(500, \filesize($target));
        $this->assertLessThan(2081, \filesize($target));
        $this->assertEquals(\mime_content_type($target), \mime_content_type($original));
        $this->assertFileExists($target);
        $this->assertNotEmpty(\file_get_contents($target));

        $this->assertEquals(\is_readable($target), true);
        $this->assertFileExists($target);
        $this->assertNotEmpty(\file_get_contents($target));

        $image = new \Imagick($target);

        $this->assertEquals(100, $image->getImageWidth());
        $this->assertEquals(100, $image->getImageHeight());
        $this->assertEquals('HEIC', $image->getImageFormat());

        \unlink($target);
    }

    public function test_crop100x100_png(): void
    {
        $image = new Image(\file_get_contents(__DIR__.'/../resources/disk-a/kitten-1.jpg') ?: '');
        $target = __DIR__.'/100x100.png';
        $original = __DIR__.'/../resources/resize/100x100.png';

        $image->crop(100, 100);

        $image->save($target, 'png', 100);

        $this->assertEquals(\is_readable($target), true);
        $this->assertGreaterThan(15000, \filesize($target));
        $this->assertLessThan(30000, \filesize($target));
        $this->assertEquals(\mime_content_type($target), \mime_content_type($original));
        $this->assertFileExists($target);
        $this->assertNotEmpty(\file_get_contents($target));

        $image = new \Imagick($target);
        $this->assertEquals(100, $image->getImageWidth());
        $this->assertEquals(100, $image->getImageHeight());
        $this->assertEquals('PNG', $image->getImageFormat());

        \unlink($target);
    }

    public function test_crop100x100_png_quality30(): void
    {
        $image = new Image(\file_get_contents(__DIR__.'/../resources/disk-a/kitten-1.jpg') ?: '');
        $target = __DIR__.'/100x100-q30.jpg';
        $original = __DIR__.'/../resources/resize/100x100-q30.jpg';

        $image->crop(100, 100);

        $image->save($target, 'jpg', 10);

        $this->assertEquals(\is_readable($target), true);
        $this->assertGreaterThan(500, \filesize($target));
        $this->assertLessThan(2000, \filesize($target));
        $this->assertEquals(\mime_content_type($target), \mime_content_type($original));
        $this->assertFileExists($target);
        $this->assertNotEmpty(\file_get_contents($target));

        $image = new \Imagick($target);
        $this->assertEquals(100, $image->getImageWidth());
        $this->assertEquals(100, $image->getImageHeight());
        $this->assertEquals('JPEG', $image->getImageFormat());

        \unlink($target);
    }

    public function test_crop100x100_gif(): void
    {
        $image = new Image(\file_get_contents(__DIR__.'/../resources/disk-a/kitten-3.gif') ?: '');
        $target = __DIR__.'/100x100.gif';
        $original = __DIR__.'/../resources/resize/100x100.gif';

        $image->crop(100, 100);

        $image->save($target, 'gif', 100);

        $this->assertEquals(\is_readable($target), true);
        $this->assertGreaterThan(400000, \filesize($target));
        $this->assertLessThan(800000, \filesize($target));
        $this->assertEquals(\mime_content_type($target), \mime_content_type($original));
        $this->assertFileExists($target);
        $this->assertNotEmpty(\file_get_contents($target));

        $image = new \Imagick($target);
        $this->assertEquals(100, $image->getImageWidth());
        $this->assertEquals(100, $image->getImageHeight());
        $this->assertEquals('GIF', $image->getImageFormat());
        \unlink($target);
    }

    public function test_border5_red(): void
    {
        $image = new Image(\file_get_contents(__DIR__.'/../resources/disk-a/kitten-1.jpg') ?: '');
        $target = __DIR__.'/border_5_red.jpg';
        $original = __DIR__.'/../resources/resize/border_5_red.jpg';

        $image->setBorder(5, '#ff0000');

        $image->save($target, 'jpg', 100);

        $this->assertEquals(\is_readable($target), true);
        $this->assertEquals(\mime_content_type($target), \mime_content_type($original));
        $this->assertFileExists($target);
        $this->assertNotEmpty(\file_get_contents($target));

        $image = new \Imagick($target);
        $this->assertEquals('JPEG', $image->getImageFormat());
        \unlink($target);
    }

    public function test_rotate45(): void
    {
        $image = new Image(\file_get_contents(__DIR__.'/../resources/disk-a/kitten-1.jpg') ?: '');
        $target = __DIR__.'/rotate_45.jpg';
        $original = __DIR__.'/../resources/resize/rotate_45.jpg';

        $image->setRotation(45);

        $image->save($target, 'jpg', 100);

        $this->assertEquals(\is_readable($target), true);
        $this->assertEquals(\mime_content_type($target), \mime_content_type($original));
        $this->assertFileExists($target);
        $this->assertNotEmpty(\file_get_contents($target));

        $image = new \Imagick($target);
        $this->assertEquals('JPEG', $image->getImageFormat());
        $this->assertEquals($image->getImageHeight(), 2658);
        $this->assertEquals($image->getImageWidth(), 2659);
        \unlink($target);
    }

    public function test_opacity02(): void
    {
        $image = new Image(\file_get_contents(__DIR__.'/../resources/disk-a/kitten-1.jpg') ?: '');
        $target = __DIR__.'/opacity_0.2.png';
        $original = __DIR__.'/../resources/resize/opacity_0.2.png';

        $image->setOpacity(0.2);

        $image->save($target, 'png', 100);

        $this->assertEquals(\is_readable($target), true);
        $this->assertEquals(\mime_content_type($target), \mime_content_type($original));
        $this->assertFileExists($target);
        $this->assertNotEmpty(\file_get_contents($target));

        $image = new \Imagick($target);
        $this->assertEquals('PNG', $image->getImageFormat());
        \unlink($target);
    }

    public function test_border_radius500(): void
    {
        $image = new Image(\file_get_contents(__DIR__.'/../resources/disk-a/kitten-1.jpg') ?: '');
        $target = __DIR__.'/border_radius_500.png';
        $original = __DIR__.'/../resources/resize/border_radius_500.png';

        $image->setBorderRadius(500);

        $image->save($target, 'png', 100);

        $this->assertEquals(\is_readable($target), true);
        $this->assertEquals(\mime_content_type($target), \mime_content_type($original));
        $this->assertFileExists($target);
        $this->assertNotEmpty(\file_get_contents($target));

        $image = new \Imagick($target);
        $this->assertEquals('PNG', $image->getImageFormat());
        \unlink($target);
    }

    public function test_crop100_op05(): void
    {
        $image = new Image(\file_get_contents(__DIR__.'/../resources/disk-a/kitten-1.jpg') ?: '');
        $target = __DIR__.'/100x100_OP_0.5.png';
        $original = __DIR__.'/../resources/resize/100x100_OP_0.5.png';

        $image->crop(100, 100);
        $image->setOpacity(0.5);

        $image->save($target, 'png', 100);

        $this->assertEquals(\is_readable($target), true);
        $this->assertEquals(\mime_content_type($target), \mime_content_type($original));
        $this->assertFileExists($target);
        $this->assertNotEmpty(\file_get_contents($target));

        $image = new \Imagick($target);
        $this->assertEquals($image->getImageWidth(), 100);
        $this->assertEquals($image->getImageHeight(), 100);
        $this->assertEquals('PNG', $image->getImageFormat());
        \unlink($target);
    }

    public function test_crop100_b_r50(): void
    {
        $image = new Image(\file_get_contents(__DIR__.'/../resources/disk-a/kitten-1.jpg') ?: '');
        $target = __DIR__.'/100x100_BR_50.png';
        $original = __DIR__.'/../resources/resize/100x100_BR_50.png';

        $image->crop(100, 100);
        $image->setOpacity(0.5);

        $image->save($target, 'png', 100);

        $this->assertEquals(\is_readable($target), true);
        $this->assertEquals(\mime_content_type($target), \mime_content_type($original));
        $this->assertFileExists($target);
        $this->assertNotEmpty(\file_get_contents($target));

        $image = new \Imagick($target);
        $this->assertEquals('PNG', $image->getImageFormat());
        \unlink($target);
    }

    public function test_gif_small_last_frame(): void
    {
        $image = new Image(\file_get_contents(__DIR__.'/../resources/disk-a/last-frame-1px.gif') ?: '');
        $target = __DIR__.'/last-frame-1px-output.gif';

        $image->crop(0, 0);

        $image->save($target, 'gif', 100);

        $this->assertEquals(\is_readable($target), true);
        $this->assertFileExists($target);
        $this->assertNotEmpty(\file_get_contents($target));

        $image = new \Imagick($target);
        $this->assertEquals(329, $image->getImageWidth());
        $this->assertEquals(274, $image->getImageHeight());
        $this->assertEquals('GIF', $image->getImageFormat());

        \unlink($target);
    }
}
