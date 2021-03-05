<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Brand extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand', function (Blueprint $table) {
            $table->integer('id')->index();
            $table->string('title', 255);
            $table->string('alias', 255);
            $table->string('safe_title', 255);
            $table->tinyInteger('title', 3);;
            $table->string('image');
            $table->integer('sort', 3);
            $table->string('lang');
            $table->tinyInteger('type', 3);
            $table->string('description');
            $table->tinyInteger('is_home', 1);
            $table->integer('pid', 11);
            $table->string('title_seo');
            $table->string('description_seo', 255);
            $table->string('keywords', 255);
            $table->tinyInteger('robots', 1);
            $table->string('image_seo');
            $table->tinyInteger('removed', 1);
            $table->tinyInteger('is_sidebar', 1);
            $table->integer('limit_is_home');
            $table->integer('limit_is_sidebar');
            $table->string('image_icon');
            $table->tinyInteger('icon', 1);
            $table->longText('content');
         
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('brand');
    }
}
