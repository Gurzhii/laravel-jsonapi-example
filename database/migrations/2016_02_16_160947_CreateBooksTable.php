<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('preview');
            $table->integer('author_id')->unsigned()->nullable();
            $table->timestamps();
        });

        Schema::table('books', function($table) {
            $table->foreign('author_id')->references('id')->on('authors');
        });
    }

    public function down()
    {
        Schema::drop('books');
    }
}
