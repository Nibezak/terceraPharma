<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDusersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dusers', function (Blueprint $table) {
            $table->id();
            $table->string('avatar')->nullable();
           $table->string('name');
           $table->string('username')->unique();
           $table->string('email')->unique();
           $table->text('about')->nullable();
           $table->boolean('is_Admin')->default(false)->nullable();
           $table->timestamp('email_verified_at')->nullable();
           $table->string('password');
           $table->string('otp_token');
           $table->string('mobile');
           $table->timestamp('mobile_verified_at')->nullable();
           $table->rememberToken();
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
        Schema::dropIfExists('dusers');
    }
}
