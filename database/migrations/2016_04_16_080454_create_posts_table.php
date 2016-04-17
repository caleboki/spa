<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {

            $table->increments('id');

            $table->integer('createdby')->unsigned();
            
            $table->integer('updatedby')->unsigned();

            $table->string('title');

            $table->text('body');

            $table->timestamps();

            $table->foreign('createdby')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->foreign('updatedby')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('posts');
    }
}
