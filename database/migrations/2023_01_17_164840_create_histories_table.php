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
        Schema::create('histories', function (Blueprint $table) {
            $table->id();
            $table->string('date');
            $table->integer('user_id');
            $table->integer('holidays_time')->default(0);
            $table->integer('delegation_time')->default(0);
            $table->integer('sick_leave')->default(0);
            $table->integer('work_time');
            $table->integer('completely_available_time');
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('remaining_hours');
            $table->dropColumn('completed_hours');
            $table->dropColumn('overtime');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('histories');
        Schema::table('users', function (Blueprint $table) {
            $table->integer('remaining_hours')->default(162);
            $table->integer('completed_hours')->default(0);
            $table->integer('overtime')->default(0);
        });
    }
};
