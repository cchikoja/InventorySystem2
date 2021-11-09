<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AllocationsTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allocations_tbl', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('asset_id')->nullable(false);
            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->date('date')->nullable(false);
            $table->enum('status', ['active', 'cancelled', 'expired'])->nullable(false)->default('active');
            $table->unsignedBigInteger('allocator')->nullable(false);

            $table->foreign('asset_id')->references('id')->on('assets_tbl');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('allocator')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('allocations_tbl');
    }
}
