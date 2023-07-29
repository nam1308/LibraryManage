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
        Schema::create('tag_book', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tags_id')->comment('Khóa ngoại với tags(id).');
            $table->unsignedBigInteger('book_id')->comment('Khóa ngoại với books(id).');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('tags_id')->references('id')->on('tags')->onDelete('cascade');
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
        Schema::dropIfExists('tag_book');
    }
};
