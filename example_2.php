<?php

// файл
$filename = 'image.png';

// задание максимальной ширины и высоты для вывода на экран
$width = 200;
$height = 100;

// тип содержимого
header('Content-Type: image/png');

// получение новых размеров изображения с сохранением пропорции:
list($width_orig, $height_orig) = getimagesize($filename);

$ratio_orig = $width_orig/$height_orig;

$width = $height*$ratio_orig;

// ресэмплирование
$image_p = imagecreatetruecolor($width, $height);
$image = imagecreatefrompng($filename);
imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

// вывод изображения на экран:;
imagepng($image_p);
