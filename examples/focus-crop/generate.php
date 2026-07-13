<?php

require __DIR__.'/../../vendor/autoload.php';

use Utopia\Image\Image;

final class ExampleImage extends Image
{
    /**
     * @var list<array{xmin: float, ymin: float, xmax: float, ymax: float, score: float}>
     */
    public array $regions = [];

    protected function detectFocus(string $focus): array
    {
        return $this->regions = parent::detectFocus($focus);
    }
}

$cases = [
    ['astronaut-face-landscape', 'astronaut.png', 'human face', 320, 180],
    ['astronaut-face-portrait', 'astronaut.png', 'human face', 180, 320],
    ['astronaut-helmet-square', 'astronaut.png', 'helmet', 240, 240],
    ['astronaut-flag-portrait', 'astronaut.png', 'american flag', 180, 320],
    ['beach-hat-square', 'beach.png', 'straw hat', 240, 240],
    ['beach-sunglasses-landscape', 'beach.png', 'sunglasses', 320, 180],
    ['beach-book-portrait', 'beach.png', 'book', 180, 320],
    ['beach-camera-square', 'beach.png', 'camera', 240, 240],
    ['bus-landscape', 'bus.jpg', 'bus', 320, 180],
    ['bus-people-portrait', 'bus.jpg', 'person', 180, 320],
    ['bus-sunglasses-square', 'bus.jpg', 'man wearing sunglasses', 240, 240],
    ['bus-building-landscape', 'bus.jpg', 'building', 320, 180],
    ['players-suit-landscape', 'players.jpg', 'black suit', 320, 180],
    ['players-faces-landscape', 'players.jpg', 'human face', 320, 180],
    ['players-faces-portrait', 'players.jpg', 'human face', 180, 320],
    ['players-faces-square', 'players.jpg', 'human face', 240, 240],
];

$sourceDir = __DIR__.'/sources';
$outputDir = __DIR__.'/generated';
$fontPath = match (true) {
    file_exists('/System/Library/Fonts/Supplemental/Arial.ttf') => '/System/Library/Fonts/Supplemental/Arial.ttf',
    file_exists('/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf') => '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf',
    default => throw new RuntimeException('No supported font found'),
};
$panels = [];
$manifest = [];

foreach ($cases as [$id, $sourceName, $focus, $width, $height]) {
    $sourcePath = $sourceDir.'/'.$sourceName;
    $sourceData = file_get_contents($sourcePath);
    if ($sourceData === false) {
        throw new RuntimeException('Unable to read '.$sourcePath);
    }

    $image = new ExampleImage($sourceData);
    $image->crop($width, $height, focus: $focus);
    $output = $image->output('jpg', 92);
    if (! is_string($output)) {
        throw new RuntimeException('Unable to generate '.$id);
    }

    $outputPath = $outputDir.'/'.$id.'.jpg';
    file_put_contents($outputPath, $output, LOCK_EX);

    $before = new Imagick($sourcePath);
    $beforeWidth = $before->getImageWidth();
    $beforeHeight = $before->getImageHeight();

    $boxes = new ImagickDraw;
    $boxes->setFillOpacity(0);
    $boxes->setStrokeColor('#ff3b30');
    $boxes->setStrokeWidth(max(3, (int) round(min($beforeWidth, $beforeHeight) / 120)));
    foreach ($image->regions as $region) {
        $boxes->rectangle(
            $region['xmin'] * $beforeWidth,
            $region['ymin'] * $beforeHeight,
            $region['xmax'] * $beforeWidth,
            $region['ymax'] * $beforeHeight
        );
    }
    $before->drawImage($boxes);

    $after = new Imagick;
    $after->readImageBlob($output);

    $panel = new Imagick;
    $panel->newImage(760, 350, '#f4f1ea', 'jpg');

    $title = new ImagickDraw;
    $title->setFont($fontPath);
    $title->setFillColor('#171717');
    $title->setFontSize(20);
    $title->annotation(20, 28, $focus.' -> '.$width.'x'.$height);
    $title->setFillColor($image->regions === [] ? '#b42318' : '#4a5568');
    $title->setFontSize(13);
    $title->annotation(20, 50, count($image->regions).' detection(s)');
    $title->setFillColor('#4a5568');
    $title->annotation(20, 336, 'BEFORE');
    $title->annotation(400, 336, 'AFTER');
    $panel->drawImage($title);

    fitAndComposite($panel, $before, 20, 65, 340, 250);
    fitAndComposite($panel, $after, 400, 65, 340, 250);
    $panel->setImageCompressionQuality(90);
    $panel->writeImage(__DIR__.'/comparisons/'.$id.'.jpg');

    $panels[] = $panel;
    $manifest[] = [
        'id' => $id,
        'source' => 'sources/'.$sourceName,
        'focus' => $focus,
        'output' => 'generated/'.$id.'.jpg',
        'size' => [$width, $height],
        'detections' => $image->regions,
    ];

    fwrite(STDOUT, sprintf("%-34s %d detection(s)\n", $id, count($image->regions)));
}

$columns = 2;
$rows = (int) ceil(count($panels) / $columns);
$gallery = new Imagick;
$gallery->newImage(1540, ($rows * 370) + 20, '#252525', 'jpg');
foreach ($panels as $index => $panel) {
    $x = 10 + (($index % $columns) * 770);
    $y = 10 + ((int) floor($index / $columns) * 370);
    $gallery->compositeImage($panel, Imagick::COMPOSITE_DEFAULT, $x, $y);
}
$gallery->setImageCompressionQuality(90);
$gallery->writeImage(__DIR__.'/gallery.jpg');

file_put_contents(
    __DIR__.'/manifest.json',
    json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)."\n",
    LOCK_EX
);

function fitAndComposite(Imagick $canvas, Imagick $image, int $x, int $y, int $width, int $height): void
{
    $image = clone $image;
    $image->thumbnailImage($width, $height, true);
    $offsetX = $x + (int) floor(($width - $image->getImageWidth()) / 2);
    $offsetY = $y + (int) floor(($height - $image->getImageHeight()) / 2);
    $canvas->compositeImage($image, Imagick::COMPOSITE_DEFAULT, $offsetX, $offsetY);
}
