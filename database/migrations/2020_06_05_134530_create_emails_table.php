<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->id();
            $table->json('receivers')->nullable();
            $table->json('cc')->nullable();
            $table->longText('content')->nullable();
            $table->json('files')->nullable();
            $table->timestamp('send')->nullable();
            $table->unsignedBigInteger('email_id')->nullable(); /* id de l'email parent si ce email est une réponse */
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
        Schema::dropIfExists('emails');
    }
}
