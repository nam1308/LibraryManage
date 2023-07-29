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
        Schema::create('reflections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('Khóa ngoại với bảng users(id)');
            $table->unsignedBigInteger('book_id')->comment('Khóa ngoại với bảng books(id)');
            $table->integer('parent_id')->nullable();
            $table->text('content');
            $table->integer('vote')->default(0);
            $table->boolean('is_hidden')->default(false)->comment('True: ẩn || False: hiện.');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reflections');
    }
};
