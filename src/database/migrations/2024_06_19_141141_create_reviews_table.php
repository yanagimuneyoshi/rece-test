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
      $table->foreignId('shop_id')->constrained()->onDelete('cascade');
      $table->foreignId('user_id')->constrained()->onDelete('cascade');
      $table->tinyInteger('rating')->unsigned()->comment('Rating from 1 to 5');
      $table->text('comment')->nullable();
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('reviews');
  }
}
