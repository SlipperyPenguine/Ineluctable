<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEveCharacterMailRecipients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('character_mail_recipients', function(Blueprint $table)
        {
            $table->increments('id');

            $table->integer('characterID');
            $table->integer('messageID');

            $table->boolean('read')->default(false);
            $table->boolean('important')->default(false);
            $table->boolean('trash')->default(false);


            $table->timestamps();

            $table->index('characterID');
            $table->index('messageID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('character_mail_recipients');
    }
}
