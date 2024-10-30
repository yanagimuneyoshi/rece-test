<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
  public function up()
{
    Schema::create('reviews', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('shop_id')->constrained()->onDelete('cascade');
        $table->text('comment')->nullable(false)->comment('400文字以内の口コミ内容');
        $table->tinyInteger('rating')->unsigned()->comment('星評価1〜5');
        $table->string('image_path')->nullable()->comment('口コミ画像URL');
        $table->timestamps();
    });
}


  public function down()
  {
    Schema::dropIfExists('reviews');
  }
}
