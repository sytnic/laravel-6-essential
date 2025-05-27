<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRoomTypePictures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Добавление столбца picture в таблицу room_types
        Schema::table('room_types', function(Blueprint $table){
            $table->longText('picture')->comment('The picture file path')
            ->after('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Удаление столбца picture из таблицы room_types
        Schema::table('room_types', function(Blueprint $table){
            $table->dropColumn('picture');
        });
    }
}
