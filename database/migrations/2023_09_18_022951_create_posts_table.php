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
            $table->foreignId('created_user_id')->references('id')->on('users');
            $table->foreignId('updated_user_id')->references('id')->on('users');
            // $table->foreignId('deleted_user_id')->nullable()->references('id')->on('users');
            $table->unique(['created_user_id', 'title']);
            // $table->softDeletes('deleted_at', 0);
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
