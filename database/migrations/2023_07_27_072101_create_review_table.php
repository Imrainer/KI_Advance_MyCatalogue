<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id', 120);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('star')->nullable();
            $table->string('content')->nullable();
            $table->uuid('catalogue_id',120)->nullable();
            $table->foreign('catalogue_id')->references('id')->on('catalogue')->onDelete('cascade');
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
        Schema::dropIfExists('review');
    }
}
