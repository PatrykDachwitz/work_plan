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
        Schema::table('users', function (Blueprint $table){
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('group_id');
            $table->string('role_id')->default(0);
            $table->integer('number_phone')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('city')->nullable();
            $table->string('street')->nullable();
            $table->string('email_private')->nullable();
            $table->string('email_company')->nullable();
            $table->integer('remaining_hours')->default(162);
            $table->integer('completed_hours')->default(0);
            $table->integer('overtime')->default(0);
            if (Schema::hasColumn('users', 'name')) {
                $table->dropColumn('name');
            }
            if (Schema::hasColumn('users', 'email')) {
                $table->dropIndex('users_email_unique');
                $table->dropColumn('email');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table){
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('group_id');
            $table->dropColumn('role_id');
            $table->dropColumn('number_phone');
            $table->dropColumn('zip_code');
            $table->dropColumn('city');
            $table->dropColumn('street');
            $table->dropColumn('email_private');
            $table->dropColumn('email_company');

            if (Schema::hasColumn('users', 'remaining_hours')) {
                $table->dropColumn('remaining_hours');
            }
            if (Schema::hasColumn('users', 'completed_hours')) {
                $table->dropColumn('completed_hours');
            }
            if (Schema::hasColumn('users', 'overtime')) {
                $table->dropColumn('overtime');
            }

            if (Schema::hasColumn('users', 'name')) {
                $table->string('name');
            }
            if (Schema::hasColumn('users', 'email')) {
                $table->string('email');
            }

        });
    }
};
