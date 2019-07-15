<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('article_id')
                ->references('id')->on('articles')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('name');
            $table->string('slug');
            $table->boolean('publish');
            $table->string('image');
            $table->string('preview_text');
            $table->text('detail_text');
            $table->string('language');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_details');
    }
}
