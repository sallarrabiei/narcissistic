<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('feature_image')->nullable();
            $table->text('content');
            $table->integer('reading_time')->nullable();
            $table->boolean('enable_comment')->default(false);
            $table->string('meta_description')->nullable();
            $table->string('slug')->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pages');
    }
}
