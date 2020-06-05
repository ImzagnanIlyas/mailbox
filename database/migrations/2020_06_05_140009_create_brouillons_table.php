<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrouillonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brouillons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_email_id');
            $table->timestamps();

            $table->foreign('user_email_id')->references('id')->on('user_emails');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('brouillons');
    }
}
