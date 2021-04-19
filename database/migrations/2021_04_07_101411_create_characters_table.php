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
            $table->longText('json')->nullable();
            $table->bigInteger('idMarvel')->unique()->nullable();
            $table->bigInteger('idTmdb')->unique()->nullable();
            $table->string('platform');
            $table->string('charName');
            $table->string('original_title')->nullable();
            $table->string('charImage')->nullable();
            $table->string('charImageBackground')->nullable();
            $table->longText('charDescription')->nullable();
            $table->longText('urlLinks')->nullable();
            $table->longText('creators')->nullable();
            $table->longText('comics')->nullable();
            $table->longText('series')->nullable();
            $table->string('searchQuery')->nullable();
            $table->char('check')->nullable();
            $table->char('checkView')->nullable();
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
