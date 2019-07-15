<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleDetail extends Model
{
    protected $fillable = ['name', 'slug', 'article_id', 'publish', 'image', 'preview_text', 'detail_text', 'language'];

    public function article(){
        return $this->belongsTo('App\Article');
    }
}
