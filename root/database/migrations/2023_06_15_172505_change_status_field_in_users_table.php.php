<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE users MODIFY status ENUM('0', '1', '2') DEFAULT '1' COMMENT '| 0: inactive || 1: active || 2: block'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE users MODIFY status ENUM('-1', '0', '1') DEFAULT '0' COMMENT '-1: block || 0: inactive || 1: active'");
    }
};
