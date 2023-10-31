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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->char('title', 255);
            $table->text('description');
            $table->integer('status')->default(1);
            $table->unsignedBigInteger('created_user_id');
            $table->foreign('created_user_id')->references('id')->on('users');
            $table->unsignedBigInteger('updated_user_id');
            $table->foreign('updated_user_id')->references('id')->on('users');
            // $table->foreignId('created_user_id')->nullable()->references('id')->on('users')->onDelete('cascade');
            // $table->foreignId('updated_user_id')->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->unique(['created_user_id', 'title']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
