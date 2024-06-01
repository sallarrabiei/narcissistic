<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOptionTypeToOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('options', function (Blueprint $table) {
            $table->unsignedBigInteger('option_type_id')->after('question_id');
            $table->foreign('option_type_id')->references('id')->on('option_types')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('options', function (Blueprint $table) {
            $table->dropForeign(['option_type_id']);
            $table->dropColumn('option_type_id');
        });
    }
}
