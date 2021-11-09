<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ContractsRelationsTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts_relations_tbl', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('subject')->nullable(false);
            $table->unsignedBigInteger('object')->nullable(false);
            $table->boolean('status')->nullable(false)->default(true);

            $table->foreign('subject')->references('id')->on('contracts_tbl');
            $table->foreign('object')->references('id')->on('contracts_tbl');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contracts_relations_tbl');
    }
}
