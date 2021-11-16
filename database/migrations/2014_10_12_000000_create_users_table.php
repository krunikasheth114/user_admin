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
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('status')->default(1);
            $table->string('profile');
            $table->integer('otp');
            $table->boolean('is_verify')->default(0 );
            // $table->foreignId('address_id')->constrained('user_addresses')->onUpdate('cascade')->onDelete('cascade');
            // $table->foreignId('country_id')->constrained('user_addresses')->onUpdate('cascade')->onDelete('cascade');
            // $table->foreignId('state_id')->constrained('user_addresses')->onUpdate('cascade')->onDelete('cascade');
            // $table->foreignId('city_id')->constrained('user_addresses')->onUpdate('cascade')->onDelete('cascade');

            $table->softDeletes();
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
        Schema::dropIfExists('users');
    }
}
