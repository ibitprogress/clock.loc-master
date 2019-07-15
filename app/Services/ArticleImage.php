<?php


namespace App\Services;

use Image;


class ArticleImage
{
    public static function loadImage($file){
        $image = Image::make($file);
        $height = $image->height();
        $width = $image->width();
        if ($height < 265 || $width < 265){
            return response()->json(['error' => 'Недостатній розмір зображення. Мінімальна ширина і висота повинна бути більшою 265px.'], 415);
        } elseif ($height > 10000 || $width > 10000) {
            return response()->json(['error' => 'Перевищено максимальний розмір зображення. Максимальна ширина або висота повинна бути меншою 10000px.'], 415);
        }
        $name = str_random(8).".jpg";
        $size = 265;
        $path = storage_path('app/public/logos/');
        Image::make($file)->resize($size, $size)->encode('jpg', 75)->save($path.$name)->save();
        return $name;
    }
}