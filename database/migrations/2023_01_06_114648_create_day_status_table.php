<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('day_id');
            $table->string('time_start')->nullable();
            $table->string('time_end')->nullable();
            $table->string('status')->default('workDay');
            $table->boolean('accepted')->default(false);
            $table->integer('accepted_user_id')->nullable();
            $table->integer('complety_time')->default(0);
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
        Schema::dropIfExists('statuses');
    }
};
