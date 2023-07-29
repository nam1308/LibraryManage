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
        Schema::create('borrowers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('Khóa ngoại với bảng users(id)');
            $table->unsignedBigInteger('book_id')->comment('Khóa ngoại với bảng books(id)');
            $table->timestamp('from_date');
            $table->timestamp('to_date')->nullable();
            $table->integer('quantity')->default(1);
            $table->enum('status',[-1,0,1])->default(0)->comment('0: đang mượn || -1: gia hạn || 1: đã trả.');
            $table->text('note')->nullable();
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
        Schema::dropIfExists('borrowers');
    }
};
