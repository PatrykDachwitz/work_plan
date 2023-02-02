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
        Schema::table('days', function (Blueprint $table) {
            $table->dropColumn('date');
        });

        Schema::table('statuses', function (Blueprint $table) {
            $table->dropColumn('date');
        });

        Schema::table('days', function (Blueprint $table) {
            $table->date('date')->format('d-m-Y')->nullable();
            $table->string('month');
            $table->integer('day');
        });

        Schema::table('statuses', function (Blueprint $table) {
            $table->date('date')->format('d-m-Y')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('days', function (Blueprint $table) {
            if (Schema::hasColumn('days', 'date')) {
                $table->dropColumn('date');
            }

            if (Schema::hasColumn('days', 'month')) {
                $table->dropColumn('month');
            }

            if (Schema::hasColumn('days', 'day')) {
                $table->dropColumn('day');
            }
        });

        Schema::table('statuses', function (Blueprint $table) {
            if (Schema::hasColumn('statuses', 'date')) {
                $table->dropColumn('date');
            }
        });

        Schema::table('days', function (Blueprint $table) {
            $table->string('date')->nullable();
        });

        Schema::table('statuses', function (Blueprint $table) {
            $table->string('date')->nullable();
        });
    }
};
