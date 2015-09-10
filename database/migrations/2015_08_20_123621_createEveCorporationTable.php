<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEveCorporationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eve_corporation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('corporationID');
            $table->string('corporationName', 100);
            $table->string('ticker', 6);
            $table->integer('allianceID')->nullable;
            $table->string('allianceName', 100)->nullable;
            $table->integer('taxRate');
            $table->integer('memberCount');
            $table->integer('ceoID');
            $table->string('ceoName', 100);
            $table->integer('stationID');
            $table->string('stationName');
            $table->text('url')->nullable;
            $table->text('description')->nullable;

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
        Schema::drop('eve_corporation');
    }
}


/*
 *   <result>
    <corporationID>150333466</corporationID>
    <corporationName>Marcus Corp</corporationName>
    <ticker>MATT2</ticker>
    <ceoID>150302299</ceoID>
    <ceoName>Marcus</ceoName>
    <stationID>60003469</stationID>
    <stationName>Jita IV - Caldari Business Tribunal Information Center</stationName>
    <description>Another Corp</description>
    <url />
    <allianceID>150382481</allianceID>
    <allianceName>Starbase Anchoring Alliance</allianceName>
    <taxRate>0</taxRate>
    <memberCount>1</memberCount>
    <shares>1000</shares>
    <logo>
      <graphicID>0</graphicID>
      <shape1>488</shape1>
      <shape2>0</shape2>
      <shape3>0</shape3>
      <color1>0</color1>
      <color2>0</color2>
      <color3>0</color3>
    </logo>
  </result>
 *
 * */
