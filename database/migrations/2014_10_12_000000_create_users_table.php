<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('public_id')->unique()->index();
            $table->string('customer_id')->unique()->index();
            $table->string('first_name')->index();
            $table->string('last_name')->index();
            $table->string('email')->unique()->index();
            $table->string('password');
            $table->string('title')->index();
            $table->string('company')->index();
            // $table->rememberToken();
            $table->unsignedBigInteger('email_verified_at')->index()->nullable();
            $table->unsignedBigInteger('created_at')->index()->nullable();
            $table->unsignedBigInteger('updated_at')->index()->nullable();
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
