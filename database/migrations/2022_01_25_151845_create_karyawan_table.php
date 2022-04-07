<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKaryawanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('karyawan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('firstname');
            $table->string('lastname');
            $table->date('birth')->nullable();
            $table->string('no_hp', 16)->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->string('street')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('ktpnumber');
            $table->string('currentposition')->nullable();
            $table->string('banknumber')->nullable();
            $table->string('ktp_photo');
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
        Schema::dropIfExists('karyawan');
    }
}
