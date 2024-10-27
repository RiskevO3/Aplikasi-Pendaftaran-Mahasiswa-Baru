<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegisterFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('register_forms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Add this line
            $table->string('full_name');
            $table->string('ktp_address');
            $table->string('current_address');
            $table->string('kecamatan');
            $table->unsignedBigInteger('provinces_and_cities_id');
            $table->string('telephone_number', 16);
            $table->string('phone_number', 16);
            $table->string('email')->unique();
            $table->enum('citizenship', ['WNI Asli', 'WNI Keturunan', 'WNA']);
            $table->string('citizen_origin')->default('Indonesia');
            $table->date('birth_date');
            $table->string('birth_place');
            $table->string('birth_provinces');
            $table->string('birth_cities');
            $table->enum('gender', ['L', 'P']);
            $table->enum('marriage_status', ['N', 'Y', 'O']);
            $table->enum('religion', ['Islam', 'Kristen Protestan', 'Kristen Katolik', 'Kristen Ortodoks', 'Katolok', 'Hindu', 'Budha', 'Khong Hu Ciu']);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Add this line
            $table->foreign('provinces_and_cities_id')->references('id')->on('provinces_and_cities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('register_forms');
    }
}