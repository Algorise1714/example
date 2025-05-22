<?php

$baseImage = imagecreatefromjpeg('gambar.jpg');
$watermark = imagecreatefrompng('Logo.png');

$wWidth = imagesx($watermark);
$wHeight = imagesy($watermark);

$imgWidth = imagesx($baseImage);
$imgHeight = imagesy($baseImage);

$newWidth = $imgWidth * 0.2;
$newHeight = ($wHeight / $wWidth) * $newWidth; 

$resizedWatermark = imagecreatetruecolor($newWidth, $newHeight);
imagealphablending($resizedWatermark, false);
imagesavealpha($resizedWatermark, true);

imagecopyresampled(
    $resizedWatermark, 
    $watermark, 
    0, 0, 
    0, 0, 
    $newWidth, $newHeight, 
    $wWidth, $wHeight
);

imagecopy(
    $baseImage, 
    $resizedWatermark, 
    $imgWidth - $newWidth - 10, 
    10,
    0, 0, 
    $newWidth, $newHeight
);

header('Content-Type: image/png');

imagepng($baseImage);

imagedestroy($baseImage);
imagedestroy($watermark);
imagedestroy($resizedWatermark);
?>
