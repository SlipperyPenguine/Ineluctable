<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEveCharacterAssets extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('character_assets', function(Blueprint $table)
		{
			$table->increments('id');

			$table->integer('characterID');

			$table->bigInteger('itemID')->unique();
			$table->bigInteger('locationID');
			$table->bigInteger('typeID');
			$table->integer('quantity');
			$table->integer('flag');
			$table->boolean('singleton');
			$table->integer('rawQuantity')->default(0);
			$table->bigInteger('parentItemID')->default(0);

			$table->index('characterID');
			$table->index('locationID');
			$table->index('typeID');
			$table->index('parentItemID');

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
		Schema::drop('character_assets');
	}

}
