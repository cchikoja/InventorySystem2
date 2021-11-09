<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ContractsTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts_tbl', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('start_date')->nullable(false);
            $table->date('expiry_date')->nullable(false);
            $table->string('path')->nullable(false);
            $table->enum('status',['active','cancelled','processed']);
            $table->unsignedBigInteger('uploader')->nullable(false);

            $table->foreign('uploader')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contracts_tbl');
    }
}
