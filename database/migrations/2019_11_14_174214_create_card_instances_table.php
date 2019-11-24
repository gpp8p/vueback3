<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardInstancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_instances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->integer('col');
            $table->integer('row');
            $table->integer('height');
            $table->integer('width');
            $table->unsignedBigInteger('layout_id')->default(0);
            $table->unsignedBigInteger('view_type_id')->default(0);
            $table->string('card_component', 32);

            $table->foreign('layout_id')->references('id')->on('layout');
            $table->foreign('view_type_id')->references('id')->on('view_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('card_instances');
    }
}
