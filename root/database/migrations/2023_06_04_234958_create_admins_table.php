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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id',20);
            $table->string('email',100);
            $table->string('password',255);
            $table->string('name',255);
            $table->enum('status',[-1,0,1])->default(0)->comment('0:active || 1:inactive || -1:block.');
            $table->tinyInteger('department_id')->comment('1:BOD || 2:BOM || 3:DX || 4:D3 || 5:QA || 6:BO.');
            $table->string('remember_token',100)->nullable()->comment('Token lưu trạng thái đăng nhập.');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
};
