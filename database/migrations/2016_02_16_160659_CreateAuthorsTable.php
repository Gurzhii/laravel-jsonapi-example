<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthorsTable extends Migration
{
    public function up()
    {
        Schema::create('authors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name')->nullable();
            $table->string('second_name')->nullable();
            $table->string('books_total')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('authors');
    }
}
