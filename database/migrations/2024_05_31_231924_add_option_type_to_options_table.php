<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOptionTypeToOptionsTable extends Migration
{
    public function up()
    {
        Schema::table('options', function (Blueprint $table) {
            if (Schema::hasTable('options') && !Schema::hasColumn('options', 'option_type_id')) {
                $table->foreignId('option_type_id')->after('question_id')->constrained()->onDelete('cascade');
            }
        });
    }

    public function down()
    {
        Schema::table('options', function (Blueprint $table) {
            if (Schema::hasColumn('options', 'option_type_id')) {
                $table->dropForeign(['option_type_id']);
                $table->dropColumn('option_type_id');
            }
        });
    }
}
