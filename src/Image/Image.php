<?php

namespace Utopia\Image;

use Exception;
use Imagick;
use ImagickDraw;
use ImagickPixel;

class Image
{
    const GRAVITY_CENTER = 'center';

    const GRAVITY_TOP_LEFT = 'top-left';

    const GRAVITY_TOP = 'top';

    const GRAVITY_TOP_RIGHT = 'top-right';

    const GRAVITY_LEFT = 'left';

    const GRAVITY_RIGHT = 'right';

    const GRAVITY_BOTTOM_LEFT = 'bottom-left';

    const GRAVITY_BOTTOM = 'bottom';

    const GRAVITY_BOTTOM_RIGHT = 'bottom-right';

    private Imagick $image;

    private int $width;

    private int $height;

    private int $cornerRadius = 0;

    private int $borderWidth = 0;

    private String $borderColor = '';

    private int $rotation = 0;

    /**
     * @param  string  $data
     *
     * @throws \ImagickException
     */
    public function __construct(string $data)
    {
        $this->image = new Imagick();

        $this->image->readImageBlob($data);

        // Solve formats such as GIF. Otherwise width&height would be from last frame (wrong)
        $this->image->setFirstIterator();

        $this->width = $this->image->getImageWidth();
        $this->height = $this->image->getImageHeight();

        // Use metadata to fetch rotation. Will be perform right before exporting
        $orientationType = $this->image->getImageProperties()['exif:Orientation'] ?? null;

        // Reference: https://docs.imgix.com/apis/rendering/rotation/orient
        // Mirror rotations are ignored, because we don't support mirroring
        if (! empty($orientationType)) {
            switch ($orientationType) {
                case '3':
                    $this->rotation = 180;
                    break;

                case '6':
                    $this->rotation = 90;
                    break;

                case '8':
                    $this->rotation = -90;
                    break;
            }
        }
    }

    /**
     * @return array<string>
     */
    public static function getGravityTypes(): array
    {
        return [
            Image::GRAVITY_CENTER,
            Image::GRAVITY_TOP_LEFT,
            Image::GRAVITY_TOP,
            Image::GRAVITY_TOP_RIGHT,
            Image::GRAVITY_LEFT,
            Image::GRAVITY_RIGHT,
            Image::GRAVITY_BOTTOM_LEFT,
            Image::GRAVITY_BOTTOM,
            Image::GRAVITY_BOTTOM_RIGHT,
        ];
    }

    /**
     * @param  int  $width
     * @param  int  $height
     * @param  string  $gravity
     * @return Image
     *
     * @throws \Throwable
     */
    public function crop(int $width, int $height, string $gravity = Image::GRAVITY_CENTER): self
    {
        // if no changes to Gravity, Width or Height, don't process image
        if ($gravity === Image::GRAVITY_CENTER &&
            (
                (! empty($width) && ! empty($height)) &&
                ($width == $this->width && $height == $this->height)
            )) {
            return $this;
        }

        $originalAspect = $this->width / $this->height;

        if (empty($width)) {
            $width = intval($height * $originalAspect);
        }

        if (empty($height)) {
            $height = intval($width / $originalAspect);
        }

        if (empty($height) && empty($width)) {
            $height = $this->height;
            $width = $this->width;
        }

        $resizeWidth = $this->width;
        $resizeHeight = $this->height;
        if ($gravity !== Image::GRAVITY_CENTER) {
            if ($width > $height) {
                $resizeWidth = $width;
                $resizeHeight = intval($width * $originalAspect);
            } else {
                $resizeWidth = intval($height * $originalAspect);
                $resizeHeight = $height;
            }
        }

        $x = $y = 0;
        switch ($gravity) {
            case self::GRAVITY_TOP_LEFT:
                $x = 0;
                $y = 0;
                break;
            case self::GRAVITY_TOP:
                $x = ($resizeWidth / 2) - ($width / 2);
                break;
            case self::GRAVITY_TOP_RIGHT:
                $x = $resizeWidth - $width;
                break;
            case self::GRAVITY_LEFT:
                $y = ($resizeHeight / 2) - ($height / 2);
                break;
            case self::GRAVITY_RIGHT:
                $x = $resizeWidth - $width;
                $y = ($resizeHeight / 2) - ($height / 2);
                break;
            case self::GRAVITY_BOTTOM_LEFT:
                $x = 0;
                $y = $resizeHeight - $height;
                break;
            case self::GRAVITY_BOTTOM:
                $x = ($resizeWidth / 2) - ($width / 2);
                $y = $resizeHeight - $height;
                break;
            case self::GRAVITY_BOTTOM_RIGHT:
                $x = $resizeWidth - $width;
                $y = $resizeHeight - $height;
                break;
            default:
                $x = ($resizeWidth / 2) - ($width / 2);
                $y = ($resizeHeight / 2) - ($height / 2);
                break;
        }
        $x = intval($x);
        $y = intval($y);

        if ($this->image->getImageFormat() == 'GIF') {
            $this->image = $this->image->coalesceImages();

            foreach ($this->image as $frame) {
                if ($gravity === self::GRAVITY_CENTER) {
                    $frame->cropThumbnailImage($width, $height);
                } else {
                    $frame->scaleImage($resizeWidth, $resizeHeight, false);
                    $frame->cropImage($width, $height, $x, $y);
                    $frame->thumbnailImage($width, $height);
                }
            }

            $this->image->deconstructImages();
        } else {
            foreach ($this->image as $frame) {
                if ($gravity === self::GRAVITY_CENTER) {
                    $this->image->cropThumbnailImage($width, $height);
                } else {
                    $this->image->scaleImage($resizeWidth, $resizeHeight, false);
                    $this->image->cropImage($width, $height, $x, $y);
                }
            }
        }
        $this->height = $height;
        $this->width = $width;

        return $this;
    }

    /**
     * @param  int  $borderWidth The size of the border in pixels
     * @param  string  $borderColor The color of the border in hex format
     * @return Image
     *
     * @throws \ImagickException
     */
    public function setBorder(int $borderWidth, string $borderColor): self
    {
        $this->borderWidth = $borderWidth;
        $this->borderColor = $borderColor;

        if (! empty($this->cornerRadius)) {
            return $this;
        }
        $this->image->borderImage($borderColor, $borderWidth, $borderWidth);

        return $this;
    }

    /**
     * Applies rounded corners, background to an image
     *
     * @param  int  $cornerRadius: The radius for the corners
     * @return Image $image: The processed image
     *
     * @throws \ImagickException
     */
    public function setBorderRadius(int $cornerRadius): self
    {
        $mask = new Imagick();
        $mask->newImage($this->width, $this->height, new ImagickPixel('transparent'), 'png');

        $rectwidth = ($this->borderWidth > 0 ? ($this->width - ($this->borderWidth + 1)) : $this->width - 1);
        $rectheight = ($this->borderWidth > 0 ? ($this->height - ($this->borderWidth + 1)) : $this->height - 1);

        $shape = new ImagickDraw();
        $shape->setFillColor(new ImagickPixel('black'));
        $shape->roundRectangle($this->borderWidth, $this->borderWidth, $rectwidth, $rectheight, $cornerRadius, $cornerRadius);

        $mask->drawImage($shape);
        $this->image->compositeImage($mask, Imagick::COMPOSITE_DSTIN, 0, 0);

        if ($this->borderWidth > 0) {
            $bc = new ImagickPixel();
            $bc->setColor($this->borderColor);

            $strokeCanvas = new Imagick();
            $strokeCanvas->newImage($this->width, $this->height, new ImagickPixel('transparent'), 'png');

            $shape2 = new ImagickDraw();
            $shape2->setFillColor(new ImagickPixel('transparent'));
            $shape2->setStrokeWidth($this->borderWidth);
            $shape2->setStrokeColor($bc);
            $shape2->roundRectangle($this->borderWidth, $this->borderWidth, $rectwidth, $rectheight, $cornerRadius, $cornerRadius);

            $strokeCanvas->drawImage($shape2);
            $strokeCanvas->compositeImage($this->image, Imagick::COMPOSITE_DEFAULT, 0, 0);

            $this->image = $strokeCanvas;
        }

        return $this;
    }

    /**
     * @param  float  $opacity The opacity of the image
     * @return Image
     *
     * @throws \ImagickException
     */
    public function setOpacity(float $opacity): self
    {
        if ($opacity == 1) {
            return $this;
        }
        $this->image->setImageAlpha($opacity);

        return $this;
    }

    /**
     * Rotates an image to $degree degree
     *
     * @param  int  $degree: The amount to rotate in degrees
     * @return Image $image: The rotated image
     *
     * @throws \ImagickException
     */
    public function setRotation(int $degree): self
    {
        if ($degree == 0) {
            return $this;
        }

        $this->image->rotateImage('transparent', $degree);

        return $this;
    }

    /**
     * @param  mixed  $color
     * @return Image
     *
     * @throws \Throwable
     */
    public function setBackground($color)
    {
        $this->image->setImageBackgroundColor($color);
        $this->image = $this->image->mergeImageLayers(Imagick::LAYERMETHOD_FLATTEN);

        return $this;
    }

    /**
     * Output.
     *
     * Prints manipulated image.
     *
     * @param  string  $type
     * @param  int  $quality
     * @return false|null|string
     *
     * @throws Exception
     */
    public function output(string $type, int $quality = 75)
    {
        return $this->save(null, $type, $quality);
    }

    /**
     * @param  string  $path
     * @param  string  $type
     * @param  int  $quality
     * @return ($path is null ? string|false : void)
     *
     * @throws Exception
     */
    public function save(?string $path = null, string $type = '', int $quality = 75)
    {
        // Create directory with write permissions
        if (null !== $path && ! \file_exists(\dirname($path))) {
            if (! @\mkdir(\dirname($path), 0755, true)) {
                throw new Exception('Can\'t create directory '.\dirname($path));
            }
        }

        // Apply original metadata rotation
        if ($this->rotation != 0) {
            $this->image->rotateImage('transparent', $this->rotation);
        }

        switch ($type) {
            case 'jpg':
            case 'jpeg':
                if ($quality >= 0) {
                    $this->image->setImageCompressionQuality($quality);
                }

                $this->image->setImageFormat('jpg');
                break;

            case 'gif':
                $this->image->setImageFormat('gif');
                break;

            case 'avif':
            case 'heic':
                $signature = $this->image->getImageSignature();

                $temp = tempnam(sys_get_temp_dir(), 'temp-'.$signature);
                if ($temp === false) {
                    throw new Exception('Failed to create temporary file');
                }

                $output = tempnam(sys_get_temp_dir(), 'output-'.$signature);
                if ($output === false) {
                    \unlink($temp);
                    throw new Exception('Failed to create output file');
                }

                $temp .= '.'.\strtolower($this->image->getImageFormat());
                $output .= '.'.$type;

                try {
                    // save temp
                    $this->image->writeImages($temp, true);

                    // convert temp
                    $command = ['magick convert', \escapeshellarg($temp)];

                    $quality = (int) $quality;
                    if ($quality >= 0) {
                        $command = [...$command, '-quality', $quality];
                    }

                    $command = [
                        ...$command, \escapeshellarg($output), '2>&1', // 2>&1 redirect stderr to stdout
                    ];

                    \exec(implode(' ', $command), $outputArray, $returnCode);

                    if ($returnCode !== 0) {
                        throw new Exception("Image conversion failed with status {$returnCode}: ".implode("\n", $outputArray));
                    }

                    $data = \file_get_contents($output);

                    // save to path
                    if (! empty($path)) {
                        \file_put_contents($path, $data, LOCK_EX);

                        return;
                    }

                    return $data;
                } finally {
                    if (file_exists($temp)) {
                        \unlink($temp);
                    }
                    if (file_exists($output)) {
                        \unlink($output);
                    }

                    $this->image->clear();
                    $this->image->destroy();
                }

            case 'webp':
                $temp = null;
                $output = null;
                try {
                    if ($quality >= 0) {
                        $this->image->setImageCompressionQuality($quality);
                    }
                    $this->image->setImageFormat('webp');

                    if (empty($path)) {
                        return $this->image->getImagesBlob();
                    } else {
                        $this->image->writeImages($path, true);
                    }
                } catch (\Throwable) {
                    $signature = $this->image->getImageSignature();

                    $temp = tempnam(sys_get_temp_dir(), 'temp-'.$signature);
                    if ($temp === false) {
                        throw new Exception('Failed to create temporary file');
                    }

                    $output = tempnam(sys_get_temp_dir(), 'output-'.$signature);
                    if ($output === false) {
                        \unlink($temp);
                        throw new Exception('Failed to create output file');
                    }

                    $temp .= '.'.\strtolower($this->image->getImageFormat());
                    $output .= '.'.$type;

                    // save temp
                    $this->image->writeImages($temp, true);

                    // convert temp
                    $quality = (int) $quality;
                    $command = \sprintf(
                        'cwebp -quiet -metadata none -q %d %s -o %s',
                        $quality,
                        \escapeshellarg($temp),
                        \escapeshellarg($output)
                    );
                    \exec($command, $outputArray, $returnCode);

                    if ($returnCode !== 0) {
                        throw new Exception('Image conversion failed');
                    }

                    $data = \file_get_contents($output);

                    // save to path
                    if (! empty($path)) {
                        \file_put_contents($path, $data, LOCK_EX);

                        return;
                    }

                    return $data;
                } finally {
                    if (is_string($temp) && file_exists($temp)) {
                        \unlink($temp);
                    }
                    if (is_string($output) && file_exists($output)) {
                        \unlink($output);
                    }

                    $this->image->clear();
                    $this->image->destroy();
                }

                return;

            case 'png':
                if ($quality >= 0) {
                    /* Scale quality from 0-100 to 0-9 */
                    $scaleQuality = \round(($quality / 100) * 9);
                    /* Invert quality setting as 0 is best, not 9 */
                    $invertScaleQuality = intval(9 - $scaleQuality);
                    $this->image->setImageCompressionQuality($invertScaleQuality);
                }
                $this->image->setImageFormat('png');
                break;

            default:
                throw new Exception('Invalid output type given');
        }

        if (empty($path)) {
            return $this->image->getImagesBlob();
        } else {
            $this->image->writeImages($path, true);
        }

        $this->image->clear();
        $this->image->destroy();
    }

    /**
     * @param  int  $newHeight
     * @return int
     */
    protected function getSizeByFixedHeight(int $newHeight): int
    {
        $ratio = $this->width / $this->height;
        $newWidth = $newHeight * $ratio;

        return intval($newWidth);
    }

    /**
     * @param  int  $newWidth
     * @return int
     */
    protected function getSizeByFixedWidth(int $newWidth): int
    {
        $ratio = $this->height / $this->width;
        $newHeight = $newWidth * $ratio;

        return intval($newHeight);
    }

    public static function setResourceLimit(string $type, int $value): void
    {
        match ($type) {
            'area' => Imagick::setResourceLimit(Imagick::RESOURCETYPE_AREA, $value),
            'disk' => Imagick::setResourceLimit(Imagick::RESOURCETYPE_DISK, $value),
            'file' => Imagick::setResourceLimit(Imagick::RESOURCETYPE_FILE, $value),
            'map' => Imagick::setResourceLimit(Imagick::RESOURCETYPE_MAP, $value),
            'memory' => Imagick::setResourceLimit(Imagick::RESOURCETYPE_MEMORY, $value),
            'thread' => Imagick::setResourceLimit(Imagick::RESOURCETYPE_THREAD, $value),
            default => null,
        };
    }
}
