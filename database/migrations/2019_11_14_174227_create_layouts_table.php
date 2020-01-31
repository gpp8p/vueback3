<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLayoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('layouts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('menu_label',32);
            $table->string('description', 255);
            $table->integer('height');
            $table->integer('width');
            $table->char('backgroundType',1)->default('C');
            $table->string('backgroundColor',10)->nullable($value = true)->default('#DBDDD0');
            $table->string('backgrounUrl',80)->nullable($value = true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('layouts');
    }
}
