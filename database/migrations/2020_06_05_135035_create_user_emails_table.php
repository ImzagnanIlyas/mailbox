<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_emails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('email_id');
            $table->text('user_type'); // User_Type = Sender | Receiver | CC
            $table->text('state'); // State = Draft | Sent | Received | Read
            $table->boolean('important')->default(0);
            $table->boolean('archived')->default(0);
            $table->boolean('trashed')->default(0);
            $table->boolean('deleted')->default(0);
            $table->unsignedBigInteger('category_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('email_id')->references('id')->on('emails');
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_emails');
    }
}
