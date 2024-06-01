<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShortDescriptionToSurveysTable extends Migration
{
    public function up()
    {
        Schema::table('surveys', function (Blueprint $table) {
            $table->string('short_description')->nullable()->after('description');
        });
    }

    public function down()
    {
        Schema::table('surveys', function (Blueprint $table) {
            $table->dropColumn('short_description');
        });
    }
}

