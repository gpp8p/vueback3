<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstanceParamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instance_params', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('parameter_key', 32);
            $table->string('parameter_value',512);
            $table->unsignedBigInteger("card_instance_id");
            $table->boolean('isCss')->default(false);
            $table->foreign('card_instance_id')->references('id')->on('card_instance');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('instance_params');
    }
}
