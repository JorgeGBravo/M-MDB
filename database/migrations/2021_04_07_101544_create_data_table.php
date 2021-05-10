<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data', function (Blueprint $table) {
            $table->id('idData');
            $table->longText('json')->nullable();
            $table->bigInteger('idPlatform')->unique()->nullable();
            $table->string('platform');
            $table->string('name');
            $table->string('originalTitle')->nullable();
            $table->string('image')->nullable();
            $table->string('imageBackground')->nullable();
            $table->longText('description')->nullable();
            $table->longText('urlLinks')->nullable();
            $table->longText('creators')->nullable();
            $table->longText('charComics')->nullable();
            $table->longText('dateComics')->nullable();
            $table->string('diamondCode')->nullable();
            $table->float('vote_average')->nullable();
            $table->bigInteger('vote_count')->nullable();
            $table->longText('release_date')->nullable();
            $table->longText('charSeries')->nullable();
            //$table->longText('searchQuery')->nullable();
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
        Schema::dropIfExists('data');
    }
}
