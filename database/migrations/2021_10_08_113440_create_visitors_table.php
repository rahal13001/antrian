<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->integer('no_urut', false);
            $table->string('nama', 100);
            $table->string('no_hp', 20);
            $table->string('lokasi', 30);
            $table->string('email', 50)->nullable();
            $table->date('tanggal');
            $table->time('jam');
            $table->string('status', 10)->default('antri')->nullable();
            $table->string('keperluan', 20);
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
        Schema::dropIfExists('visitors');
    }
}
