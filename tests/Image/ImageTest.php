<?php

namespace Appwrite\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
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

    public function test_crop_gravity_preserves_aspect_ratio(): void
    {
        $source = new \Imagick;
        $source->newImage(2, 4, 'red', 'png');

        $draw = new \ImagickDraw;
        $draw->setFillColor('blue');
        $draw->rectangle(0, 2, 1, 3);
        $source->drawImage($draw);

        $image = new Image($source->getImageBlob());
        $image->crop(4, 2, Image::GRAVITY_TOP);

        $result = new \Imagick;
        $result->readImageBlob($image->output('png', 100) ?: '');
        $color = $result->getImagePixelColor(2, 1)->getColor();

        $this->assertGreaterThan($color['b'], $color['r']);
    }

    /**
     * @return array<string, array{string, bool, string}>
     */
    public static function gravityProvider(): array
    {
        return [
            'horizontal top-left' => [Image::GRAVITY_TOP_LEFT, true, 'r'],
            'horizontal top' => [Image::GRAVITY_TOP, true, 'g'],
            'horizontal top-right' => [Image::GRAVITY_TOP_RIGHT, true, 'b'],
            'horizontal left' => [Image::GRAVITY_LEFT, true, 'r'],
            'horizontal center' => [Image::GRAVITY_CENTER, true, 'g'],
            'horizontal right' => [Image::GRAVITY_RIGHT, true, 'b'],
            'horizontal bottom-left' => [Image::GRAVITY_BOTTOM_LEFT, true, 'r'],
            'horizontal bottom' => [Image::GRAVITY_BOTTOM, true, 'g'],
            'horizontal bottom-right' => [Image::GRAVITY_BOTTOM_RIGHT, true, 'b'],
            'vertical top-left' => [Image::GRAVITY_TOP_LEFT, false, 'r'],
            'vertical top' => [Image::GRAVITY_TOP, false, 'r'],
            'vertical top-right' => [Image::GRAVITY_TOP_RIGHT, false, 'r'],
            'vertical left' => [Image::GRAVITY_LEFT, false, 'g'],
            'vertical center' => [Image::GRAVITY_CENTER, false, 'g'],
            'vertical right' => [Image::GRAVITY_RIGHT, false, 'g'],
            'vertical bottom-left' => [Image::GRAVITY_BOTTOM_LEFT, false, 'b'],
            'vertical bottom' => [Image::GRAVITY_BOTTOM, false, 'b'],
            'vertical bottom-right' => [Image::GRAVITY_BOTTOM_RIGHT, false, 'b'],
        ];
    }

    #[DataProvider('gravityProvider')]
    public function test_crop_gravity_positions(string $gravity, bool $horizontal, string $expectedChannel): void
    {
        $source = new \Imagick;
        $source->newImage($horizontal ? 6 : 2, $horizontal ? 2 : 6, 'red', 'png');

        $draw = new \ImagickDraw;
        $draw->setFillColor('green');
        $draw->rectangle($horizontal ? 2 : 0, $horizontal ? 0 : 2, $horizontal ? 3 : 1, $horizontal ? 1 : 3);
        $draw->setFillColor('blue');
        $draw->rectangle($horizontal ? 4 : 0, $horizontal ? 0 : 4, $horizontal ? 5 : 1, $horizontal ? 1 : 5);
        $source->drawImage($draw);

        $image = new Image($source->getImageBlob());
        $image->crop(2, 2, $gravity);

        $result = new \Imagick;
        $result->readImageBlob($image->output('png', 100) ?: '');
        $color = $result->getImagePixelColor(1, 1)->getColor();

        $this->assertSame(2, $result->getImageWidth());
        $this->assertSame(2, $result->getImageHeight());
        $this->assertGreaterThan($color[match ($expectedChannel) {
            'r' => 'g',
            default => 'r',
        }], $color[$expectedChannel]);
        $this->assertGreaterThan($color[match ($expectedChannel) {
            'b' => 'g',
            default => 'b',
        }], $color[$expectedChannel]);
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

    public function test_webp_blob_output(): void
    {
        $image = new Image(\file_get_contents(__DIR__.'/../resources/disk-a/kitten-1.jpg') ?: '');

        $image->crop(100, 100);

        $blob = $image->output('webp', 75);

        $this->assertIsString($blob);
        $this->assertNotEmpty($blob);
        $this->assertSame('RIFF', \substr($blob, 0, 4));
        $this->assertSame('WEBP', \substr($blob, 8, 4));

        $probe = new \Imagick;
        $probe->readImageBlob($blob);
        $this->assertEquals(100, $probe->getImageWidth());
        $this->assertEquals(100, $probe->getImageHeight());
        $this->assertTrue(in_array($probe->getImageFormat(), ['PAM', 'WEBP']));
    }

    public function test_webp_from_webp_input(): void
    {
        $image = new Image(\file_get_contents(__DIR__.'/../resources/resize/100x100.webp') ?: '');
        $target = __DIR__.'/roundtrip.webp';

        $image->crop(50, 50);

        $image->save($target, 'webp', 75);

        $this->assertFileExists($target);
        $this->assertNotEmpty(\file_get_contents($target));

        $probe = new \Imagick($target);
        $this->assertEquals(50, $probe->getImageWidth());
        $this->assertEquals(50, $probe->getImageHeight());
        $this->assertTrue(in_array($probe->getImageFormat(), ['PAM', 'WEBP']));

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
        $this->assertEquals(8490, \filesize($target));
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

    /**
     * Animated WebP stores delta/partial frames. Cropping without coalesce
     * scales those fragments independently and produces ghosting artifacts.
     */
    public function test_crop_animated_webp_preserves_frames(): void
    {
        $source = __DIR__.'/../resources/disk-a/anim-delta.webp';
        $image = new Image(\file_get_contents($source) ?: '');
        $target = __DIR__.'/anim-delta-32x32.webp';

        $image->crop(32, 32);
        $image->save($target, 'webp', 100);

        $this->assertFileExists($target);
        $this->assertNotEmpty(\file_get_contents($target));

        $output = new \Imagick($target);
        $this->assertGreaterThan(1, $output->getNumberImages());
        $this->assertTrue(\in_array($output->getImageFormat(), ['PAM', 'WEBP'], true));

        $coalesced = $output->coalesceImages();
        foreach ($coalesced as $frame) {
            $this->assertEquals(32, $frame->getImageWidth());
            $this->assertEquals(32, $frame->getImageHeight());
        }

        // Frame 0 has a red square near the top-left; after a correct resize
        // that region must stay red — not blended with later frames.
        $coalesced->setFirstIterator();
        $pixel = $coalesced->getImagePixelColor(8, 8)->getColor();
        $this->assertGreaterThan(200, $pixel['r']);
        $this->assertLessThan(100, $pixel['g']);
        $this->assertLessThan(100, $pixel['b']);

        // Frame 1 replaces that region with green on a correct crop.
        $coalesced->nextImage();
        $pixel = $coalesced->getImagePixelColor(8, 8)->getColor();
        $this->assertLessThan(100, $pixel['r']);
        $this->assertGreaterThan(180, $pixel['g']);
        $this->assertLessThan(150, $pixel['b']);

        \unlink($target);
    }

    /**
     * Consecutive identical frames are hold/pause frames. Cropping must keep
     * total playback delay — deconstructImages() + WebP encode can zero it out.
     */
    public function test_crop_animated_webp_preserves_hold_frames(): void
    {
        $sequence = new \Imagick;
        foreach (['#ff0000', '#ff0000', '#0000ff'] as $color) {
            $frame = new \Imagick;
            $frame->newImage(40, 40, new \ImagickPixel($color));
            $frame->setImageDelay(40);
            $frame->setImageDispose(\Imagick::DISPOSE_NONE);
            $frame->setImageFormat('gif');
            $sequence->addImage($frame);
        }

        $blob = $sequence->getImagesBlob();
        $this->assertNotFalse($blob);

        $image = new Image($blob);
        $image->crop(20, 20);
        $outputBlob = $image->output('webp', 100);
        $this->assertNotFalse($outputBlob);
        $this->assertNotNull($outputBlob);

        $output = new \Imagick;
        $output->readImageBlob($outputBlob);

        $totalDelay = 0;
        foreach ($output as $frame) {
            $totalDelay += $frame->getImageDelay();
        }
        $this->assertEquals(120, $totalDelay);
        $this->assertGreaterThanOrEqual(2, $output->getNumberImages());

        $coalesced = $output->coalesceImages();
        foreach ($coalesced as $frame) {
            $this->assertEquals(20, $frame->getImageWidth());
            $this->assertEquals(20, $frame->getImageHeight());
        }
    }
}
