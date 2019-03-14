<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIndicatorForRegionsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indicator_for_regions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('region_id')->unsigned();
            $table->integer('year')->unsigned();
            $table->integer('if')->unsigned();
            $table->integer('p')->unsigned();
            $table->integer('as')->unsigned();
            $table->integer('i')->unsigned();
            $table->float('z');
            $table->float('ef_fin')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('region_id')->references('id')->on('regions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('indicator_for_regions');
    }
}
