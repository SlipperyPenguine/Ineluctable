<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompletedJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('completed_jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('jobid');
            $table->string('queue', 100);
            $table->string('command', 200);
            $table->dateTime('started');
            $table->dateTime('ended');
            $table->integer('duration');
            $table->longText('params')->nullable();

            $table->index(['queue']);
            $table->index(['command']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('completed_jobs');
    }
}
