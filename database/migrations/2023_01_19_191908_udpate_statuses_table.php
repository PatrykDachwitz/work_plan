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
        Schema::table('statuses', function (Blueprint $table) {
            $table->dropColumn('time_start');
            $table->dropColumn('time_end');
            $table->string('hour_start')->nullable();
            $table->string('hour_end')->nullable();
            $table->string('date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('statuses', function (Blueprint $table) {
            if (Schema::hasColumn('statuses', 'time_start')) {
                $table->string('time_start');
            }
            if (Schema::hasColumn('statuses', 'time_end')) {
                $table->string('time_end');
            }

            if (Schema::hasColumn('statuses', 'hour_start')) {
                $table->dropColumn('hour_start');
            }
            if (Schema::hasColumn('statuses', 'hour_end')) {
                $table->dropColumn('hour_end');
            }
            if (Schema::hasColumn('statuses', 'date')) {
                $table->dropColumn('date');
            }

        });
    }
};
