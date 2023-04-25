<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesan', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('buyer_id')->unsigned();
            $table->bigInteger('freelancer_id')->unsigned();
            $table->bigInteger('service_id')->unsigned();
            $table->longText('file')->nullable();
            $table->longText('note')->nullable();
            $table->date('expired')->nullable();
            $table->bigInteger('pesan_status_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('buyer_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('freelancer_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('service_id')->references('id')->on('service')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('pesan_status_id')->references('id')->on('pesan_status')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pesan');
    }
}
