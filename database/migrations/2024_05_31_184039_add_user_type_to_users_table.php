<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserTypeToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->integer('user_type')->default(3); // 3: Default User, 2: Admin, 1: Superadmin
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('user_type');
    });
}

}
