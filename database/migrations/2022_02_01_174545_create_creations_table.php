<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('creations', function (Blueprint $table) {
            $table->id();
            $table-> string('name');
            $table-> string('description')->nullable();
            $table-> string('estructura',10001)->nullable();
            $table-> decimal('latitude',30,25);
            $table-> decimal('longitude',30,25);
            $table->integer('likes');
            $table->integer('looks')->default(0);
            $table->unsignedBigInteger('user_id');
            $table-> string('name_user')->nullable();
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('creations');
    }
}
