<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEveCharacterBookmarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('character_bookmarks', function (Blueprint $table) {
            $table->increments('id');

            // Id for the many to one relationship from class
            // EveEveCharacterInfo
            $table->integer('characterID');

            $table->integer('folderID');
            $table->string('folderName')->nullable();
            $table->integer('bookmarkID');
            $table->integer('creatorID');
            $table->dateTime('created');
            $table->integer('itemID');
            $table->integer('typeID');
            $table->integer('locationID');
            $table->decimal('x', 22, 4);
            $table->decimal('y', 22, 4);
            $table->decimal('z', 22, 4);
            $table->string('memo');
            $table->text('note')->nullable();

            $table->timestamps();

            // Indexes
            $table->index('characterID');
            $table->index('folderID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('character_bookmarks');
    }
}
