<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('name');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken()->nullable();
            $table->string('contact_no')->nullable();
            $table->string('images')->nullable();
            $table->string('email');
            $table->string('username')->nullable();
            $table->string('address')->nullable();
            $table->string('password');
            $table->string('response_time')->nullable();
            $table->string('response_rate')->nullable();
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
        Schema::dropIfExists('users');
    }
};
