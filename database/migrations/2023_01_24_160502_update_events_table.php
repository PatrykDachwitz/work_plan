<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('date');
            $table->string('hour');
        });
        Schema::table('events', function (Blueprint $table) {
            $table->string('date')->nullable();
        });
    }

    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('date');
            $table->dropColumn('hour');
        });
        Schema::table('events', function (Blueprint $table) {
            $table->timestamp('date')->nullable();
        });

    }
};
