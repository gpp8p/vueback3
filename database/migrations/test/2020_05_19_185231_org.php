<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Org extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('org', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('org_label',32);
            $table->string('description', 255);
            $table->unsignedBigInteger('top_layout_id')->default(0);
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('org');
    }
}
