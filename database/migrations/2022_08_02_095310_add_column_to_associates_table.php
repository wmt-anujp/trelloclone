<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToAssociatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('associates', function (Blueprint $table) {
            // $table->unsignedBigInteger('manager_id')->after('id')->nullable();
            // $table->foreign('manager_id')->references('id')->on('managers')->onDelete('cascade')->onUpdate('cascade');
            $table->boolean('manual_completion')->default(0)->after('check_in_status');
            $table->boolean('automatic_completion')->default(0)->after('manual_completion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('associates', function (Blueprint $table) {
            //
        });
    }
}
