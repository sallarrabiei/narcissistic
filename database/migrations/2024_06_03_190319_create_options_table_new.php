<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOptionsTableNew extends Migration
{
    public function up()
    {
        Schema::create('options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained()->onDelete('cascade');
            $table->foreignId('option_type_id')->constrained('option_types')->onDelete('cascade');
            $table->string('label');
            $table->integer('value');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('options', function (Blueprint $table) {
            $table->dropForeign(['question_id']);
            $table->dropForeign(['option_type_id']);
        });

        Schema::dropIfExists('options');
    }
}
