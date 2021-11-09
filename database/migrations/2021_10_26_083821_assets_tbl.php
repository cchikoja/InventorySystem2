<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AssetsTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets_tbl', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('asset')->nullable(false);
            $table->string('serial_no')->nullable(false)->unique();
            $table->string('model')->nullable(false);
            $table->date('bought')->nullable();
            $table->date('expires')->nullable(false);
            $table->double('value')->nullable(true);
            $table->unsignedBigInteger('recorder')->nullable(false);

            $table->foreign('recorder')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assets_tbl');
    }
}
