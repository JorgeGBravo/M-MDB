<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharactersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('characters', function (Blueprint $table) {
            $table->id('idChar');
            $table->json('json')->nullable();
            $table->bigInteger('idMarvel')->unique()->nullable();
            $table->bigInteger('idTmdb')->unique()->nullable();
            $table->string('platform');
            $table->string('charName');
            $table->string('original_title')->nullable();
            $table->string('charImage')->nullable();
            $table->string('charImageBackground')->nullable();
            $table->longText('charDescription')->nullable();
            $table->string('urlLinks')->nullable();
            $table->string('creators')->nullable();
            $table->string('comics')->nullable();
            $table->string('series')->nullable();
            $table->string('searchQuery')->nullable();
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
        Schema::dropIfExists('characters');
    }
}
