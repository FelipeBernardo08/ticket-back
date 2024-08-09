<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfileProductorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_productors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('fone');
            $table->string('account_bank')->nullable();
            $table->string('account_name')->nullable();
            $table->string('pix_key')->nullable();
            $table->string('type_pix_key')->nullable();
            $table->string('cnpj', 14)->unique();
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users');
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
        Schema::dropIfExists('profile_productors');
    }
}
