<?php

namespace App\Http\Controllers;

use App\Services\ArticleImage;
use Illuminate\Http\Request;

class ArticleImageController extends Controller
{
    public function loadImage(Request $request){
            $file = $request->file('image');
            $data = ArticleImage::loadImage($file);
            return $data;
    }
}
