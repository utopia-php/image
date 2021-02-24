<?php

namespace Appwrite\Tests;

use Utopia\Image\Image;
use PHPUnit\Framework\TestCase;

class ImageTest extends TestCase
{
    public function setUp(): void
    {
    }

    public function tearDown(): void
    {
    }

    public function testCrop100x100()
    {
        $image = new Image(\file_get_contents(__DIR__ . '/../resources/disk-a/kitten-1.jpg'));
        $target = __DIR__.'/100x100.jpg';

        $image->crop(100, 100);

        $image->save($target, 'jpg', 100);

        $this->assertEquals(\is_readable($target), true);
        $this->assertNotEmpty(\md5(\file_get_contents($target)));

        $image = new \Imagick($target);
        $this->assertEquals(100, $image->getImageWidth());
        $this->assertEquals(100, $image->getImageHeight());
        $this->assertEquals('JPEG', $image->getImageFormat());

        \unlink($target);
    }

    public function testCrop100x400()
    {
        $image = new Image(\file_get_contents(__DIR__ . '/../resources/disk-a/kitten-1.jpg'));
        $target = __DIR__.'/100x400.jpg';

        $image->crop(100, 400);

        $image->save($target, 'jpg', 100);

        $this->assertEquals(\is_readable($target), true);
        $this->assertNotEmpty(\md5(\file_get_contents($target)));

        $image = new \Imagick($target);
        $this->assertEquals(100, $image->getImageWidth());
        $this->assertEquals(400, $image->getImageHeight());
        $this->assertEquals('JPEG', $image->getImageFormat());

        \unlink($target);
    }

    public function testCrop400x100()
    {
        $image = new Image(\file_get_contents(__DIR__ . '/../resources/disk-a/kitten-1.jpg'));
        $target = __DIR__.'/400x100.jpg';

        $image->crop(400, 100);

        $image->save($target, 'jpg', 100);

        $this->assertEquals(\is_readable($target), true);
        $this->assertNotEmpty(\md5(\file_get_contents($target)));

        $image = new \Imagick($target);
        $this->assertEquals(400, $image->getImageWidth());
        $this->assertEquals(100, $image->getImageHeight());
        $this->assertEquals('JPEG', $image->getImageFormat());

        \unlink($target);
    }

    public function testCrop100x100WEBP()
    {
        $image = new Image(\file_get_contents(__DIR__ . '/../resources/disk-a/kitten-1.jpg'));
        $target = __DIR__.'/100x100.webp';
        $original = __DIR__.'/../resources/resize/100x100.webp';

        $image->crop(100, 100);

        $image->save($target, 'webp', 100);

        $this->assertEquals(\is_readable($target), true);
        $this->assertNotEmpty(\md5(\file_get_contents($target)));

        $image = new \Imagick($target);

        $this->assertEquals(100, $image->getImageWidth());
        $this->assertEquals(100, $image->getImageHeight());
        $this->assertTrue(in_array($image->getImageFormat(), ['PAM', 'WEBP']));

        \unlink($target);
    }

    public function testCrop100x100PNG()
    {
        $image = new Image(\file_get_contents(__DIR__ . '/../resources/disk-a/kitten-1.jpg'));
        $target = __DIR__.'/100x100.png';
        $original = __DIR__.'/../resources/resize/100x100.png';

        $image->crop(100, 100);

        $image->save($target, 'png', 100);

        $this->assertEquals(\is_readable($target), true);
        $this->assertGreaterThan(15000, \filesize($target));
        $this->assertLessThan(30000, \filesize($target));
        $this->assertEquals(\mime_content_type($target), \mime_content_type($original));
        $this->assertNotEmpty(\md5(\file_get_contents($target)));

        $image = new \Imagick($target);
        $this->assertEquals(100, $image->getImageWidth());
        $this->assertEquals(100, $image->getImageHeight());
        $this->assertEquals('PNG', $image->getImageFormat());

        \unlink($target);
    }

    public function testCrop100x100PNGQuality30()
    {
        $image = new Image(\file_get_contents(__DIR__ . '/../resources/disk-a/kitten-1.jpg'));
        $target = __DIR__.'/100x100-q30.jpg';
        $original = __DIR__.'/../resources/resize/100x100-q30.jpg';

        $image->crop(100, 100);

        $image->save($target, 'jpg', 10);

        $this->assertEquals(\is_readable($target), true);
        $this->assertGreaterThan(500, \filesize($target));
        $this->assertLessThan(2000, \filesize($target));
        $this->assertEquals(\mime_content_type($target), \mime_content_type($original));
        $this->assertNotEmpty(\md5(\file_get_contents($target)));

        $image = new \Imagick($target);
        $this->assertEquals(100, $image->getImageWidth());
        $this->assertEquals(100, $image->getImageHeight());
        $this->assertEquals('JPEG', $image->getImageFormat());

        \unlink($target);
    }

    public function testCrop100x100GIF()
    {
        $image = new Image(\file_get_contents(__DIR__ . '/../resources/disk-a/kitten-3.gif'));
        $target = __DIR__.'/100x100.gif';
        $original = __DIR__.'/../resources/resize/100x100.gif';

        $image->crop(100, 100);

        $image->save($target, 'gif', 100);

        $this->assertEquals(\is_readable($target), true);
        $this->assertGreaterThan(400000, \filesize($target));
        $this->assertLessThan(800000, \filesize($target));
        $this->assertEquals(\mime_content_type($target), \mime_content_type($original));
        $this->assertNotEmpty(\md5(\file_get_contents($target)));

        $image = new \Imagick($target);
        $this->assertEquals(100, $image->getImageWidth());
        $this->assertEquals(100, $image->getImageHeight());
        $this->assertEquals('GIF', $image->getImageFormat());
        \unlink($target);
    }

    public function testBorder5Red()
    {
        $image = new Image(\file_get_contents(__DIR__ . '/../resources/disk-a/kitten-1.jpg'));
        $target = __DIR__.'/border_5_red.jpg';
        $original = __DIR__.'/../resources/resize/border_5_red.jpg';

        $image->setBorder(5, "#ff0000");

        $image->save($target, 'jpg', 100);

        $this->assertEquals(\is_readable($target), true);
        $this->assertEquals(\mime_content_type($target), \mime_content_type($original));
        $this->assertNotEmpty(\md5(\file_get_contents($target)));

        $image = new \Imagick($target);
        $this->assertEquals('JPEG', $image->getImageFormat());
        \unlink($target);
    }

    public function testRotate45()
    {
        $image = new Image(\file_get_contents(__DIR__ . '/../resources/disk-a/kitten-1.jpg'));
        $target = __DIR__.'/rotate_45.jpg';
        $original = __DIR__.'/../resources/resize/rotate_45.jpg';

        $image->setRotation(45);

        $image->save($target, 'jpg', 100);

        $this->assertEquals(\is_readable($target), true);
        $this->assertEquals(\mime_content_type($target), \mime_content_type($original));
        $this->assertNotEmpty(\md5(\file_get_contents($target)));

        $image = new \Imagick($target);
        $this->assertEquals('JPEG', $image->getImageFormat());
        \unlink($target);
    }

    public function testOpacity02()
    {
        $image = new Image(\file_get_contents(__DIR__ . '/../resources/disk-a/kitten-1.jpg'));
        $target = __DIR__.'/opacity_0.2.png';
        $original = __DIR__.'/../resources/resize/opacity_0.2.png';

        $image->setOpacity(0.2);

        $image->save($target, 'png', 100);

        $this->assertEquals(\is_readable($target), true);
        $this->assertEquals(\mime_content_type($target), \mime_content_type($original));
        $this->assertNotEmpty(\md5(\file_get_contents($target)));

        $image = new \Imagick($target);
        $this->assertEquals('PNG', $image->getImageFormat());
        \unlink($target);
    }

    public function testBorderRadius500()
    {
        $image = new Image(\file_get_contents(__DIR__ . '/../resources/disk-a/kitten-1.jpg'));
        $target = __DIR__.'/border_radius_500.png';
        $original = __DIR__.'/../resources/resize/border_radius_500.png';

        $image->setBorderRadius(500);

        $image->save($target, 'png', 100);

        $this->assertEquals(\is_readable($target), true);
        $this->assertEquals(\mime_content_type($target), \mime_content_type($original));
        $this->assertNotEmpty(\md5(\file_get_contents($target)));

        $image = new \Imagick($target);
        $this->assertEquals('PNG', $image->getImageFormat());
        \unlink($target);
    }

    public function testCrop100Op05()
    {
        $image = new Image(\file_get_contents(__DIR__ . '/../resources/disk-a/kitten-1.jpg'));
        $target = __DIR__.'/100x100_OP_0.5.png';
        $original = __DIR__.'/../resources/resize/100x100_OP_0.5.png';

        $image->crop(100,100);
        $image->setOpacity(0.5);

        $image->save($target, 'png', 100);

        $this->assertEquals(\is_readable($target), true);
        $this->assertEquals(\mime_content_type($target), \mime_content_type($original));
        $this->assertNotEmpty(\md5(\file_get_contents($target)));

        $image = new \Imagick($target);
        $this->assertEquals('PNG', $image->getImageFormat());
        \unlink($target);
    }

    public function testCrop100BR50()
    {
        $image = new Image(\file_get_contents(__DIR__ . '/../resources/disk-a/kitten-1.jpg'));
        $target = __DIR__.'/100x100_BR_50.png';
        $original = __DIR__.'/../resources/resize/100x100_BR_50.png';

        $image->crop(100,100);
        $image->setOpacity(0.5);

        $image->save($target, 'png', 100);

        $this->assertEquals(\is_readable($target), true);
        $this->assertEquals(\mime_content_type($target), \mime_content_type($original));
        $this->assertNotEmpty(\md5(\file_get_contents($target)));

        $image = new \Imagick($target);
        $this->assertEquals('PNG', $image->getImageFormat());
        \unlink($target);
    }

    
}
