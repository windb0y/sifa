<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableCekdata extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cekdatas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sensor_id');
            $table->float('room_temperature');
            $table->integer('room_smoke');
            $table->timestamp('update_on');
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
        Schema::dropIfExists('cekdatas');
    }
}




